<?php
session_start();
require_once __DIR__ . '/../config/db.php';

/* ---------------------------------------------------------
 * Auth helpers
 * ------------------------------------------------------- */
function is_logged_in(): bool {
    return isset($_SESSION['user_id']);
}

function is_admin(): bool {
    return is_logged_in() && ($_SESSION['role'] ?? '') === 'admin';
}

function require_login(): void {
    if (!is_logged_in()) {
        header('Location: login.php');
        exit;
    }
}

function require_admin(): void {
    if (!is_admin()) {
        header('Location: ../login.php');
        exit;
    }
}

function current_user_id(): ?int {
    return $_SESSION['user_id'] ?? null;
}

/* ---------------------------------------------------------
 * CSRF helpers
 * ------------------------------------------------------- */
function csrf_token(): string {
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrf_check(): void {
    $token = $_POST['csrf'] ?? '';
    if (!hash_equals($_SESSION['csrf'] ?? '', $token)) {
        die('Invalid session token. Please go back and try again.');
    }
}

/* ---------------------------------------------------------
 * Small utilities
 * ------------------------------------------------------- */
function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function flash(string $key, ?string $msg = null) {
    if ($msg !== null) {
        $_SESSION['flash'][$key] = $msg;
        return null;
    }
    $val = $_SESSION['flash'][$key] ?? null;
    unset($_SESSION['flash'][$key]);
    return $val;
}

function badge_class(string $status): string {
    return match ($status) {
        'open', 'pending'            => 'badge badge-amber',
        'matched', 'verified'        => 'badge badge-teal',
        'claimed', 'approved'        => 'badge badge-green',
        'closed', 'rejected'         => 'badge badge-red',
        default                      => 'badge',
    };
}

/* ---------------------------------------------------------
 * Notifications
 * ------------------------------------------------------- */
function notify(PDO $pdo, int $userId, string $message, ?string $link = null): void {
    $stmt = $pdo->prepare(
        "INSERT INTO notifications (user_id, message, link) VALUES (?, ?, ?)"
    );
    $stmt->execute([$userId, $message, $link]);
}

function unread_notification_count(PDO $pdo, int $userId): int {
    $stmt = $pdo->prepare(
        "SELECT COUNT(*) FROM notifications WHERE user_id = ? AND is_read = 0"
    );
    $stmt->execute([$userId]);
    return (int) $stmt->fetchColumn();
}

/* ---------------------------------------------------------
 * Matching Score Mechanism
 * Location 40% | Date & Time 30% | Category 30% (admin editable)
 * ------------------------------------------------------- */
function get_match_weights(PDO $pdo): array {
    $row = $pdo->query("SELECT * FROM match_settings ORDER BY setting_id LIMIT 1")->fetch();
    if (!$row) {
        return ['location_weight' => 40, 'datetime_weight' => 30, 'category_weight' => 30];
    }
    return $row;
}

/**
 * Compute a 0-100 match score between two items (one lost, one found).
 */
function compute_match_score(array $itemA, array $itemB, array $weights): float {
    // Location similarity (text closeness, case-insensitive)
    $locA = strtolower(trim($itemA['location']));
    $locB = strtolower(trim($itemB['location']));
    similar_text($locA, $locB, $locPercent);
    if (str_contains($locA, $locB) || str_contains($locB, $locA)) {
        $locPercent = max($locPercent, 85);
    }

    // Date/time closeness - score decays the further apart the dates are
    $dateA = new DateTime($itemA['item_date']);
    $dateB = new DateTime($itemB['item_date']);
    $diffDays = abs($dateA->diff($dateB)->days);
    $datePercent = max(0, 100 - ($diffDays * 10)); // -10 pts per day apart

    // Category match
    $catPercent = ($itemA['category_id'] == $itemB['category_id']) ? 100 : 0;

    $totalWeight = $weights['location_weight'] + $weights['datetime_weight'] + $weights['category_weight'];
    if ($totalWeight <= 0) $totalWeight = 100;

    $score = (
        ($locPercent  * $weights['location_weight']) +
        ($datePercent * $weights['datetime_weight']) +
        ($catPercent  * $weights['category_weight'])
    ) / $totalWeight;

    return round($score, 2);
}

/**
 * Find candidate matches (opposite type, open status) for a given item,
 * ranked by descending match score.
 */
function find_matches(PDO $pdo, array $item, float $minScore = 30.0): array {
    $oppositeType = $item['item_type'] === 'lost' ? 'found' : 'lost';
    $stmt = $pdo->prepare(
        "SELECT i.*, c.name AS category_name, u.full_name AS reporter_name
         FROM items i
         JOIN categories c ON c.category_id = i.category_id
         JOIN users u ON u.user_id = i.user_id
         WHERE i.item_type = ? AND i.status IN ('open','matched') AND i.item_id != ?"
    );
    $stmt->execute([$oppositeType, $item['item_id']]);
    $candidates = $stmt->fetchAll();

    $weights = get_match_weights($pdo);
    $results = [];
    foreach ($candidates as $c) {
        $score = compute_match_score($item, $c, $weights);
        if ($score >= $minScore) {
            $c['match_score'] = $score;
            $results[] = $c;
        }
    }
    usort($results, fn($a, $b) => $b['match_score'] <=> $a['match_score']);
    return $results;
}
