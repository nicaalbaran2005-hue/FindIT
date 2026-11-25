<?php
require_once __DIR__ . '/includes/functions.php';
require_login();

$id = (int) ($_GET['id'] ?? 0);
$stmt = $pdo->prepare(
    "SELECT i.*, c.name AS category_name, u.full_name AS reporter_name, u.user_id AS reporter_id
     FROM items i JOIN categories c ON c.category_id = i.category_id
     JOIN users u ON u.user_id = i.user_id WHERE i.item_id = ?"
);
$stmt->execute([$id]);
$item = $stmt->fetch();
if (!$item) { flash('error', 'Item not found.'); header('Location: items.php'); exit; }

$isOwner = $item['user_id'] == current_user_id();
$matches = find_matches($pdo, $item, 30.0);

// Handle claim submission (claiming a FOUND item as the person who lost it)
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_claim'])) {
    csrf_check();
    if ($item['item_type'] !== 'found') {
        $errors[] = 'Claims can only be submitted for found items.';
    } elseif ($isOwner) {
        $errors[] = 'You cannot claim an item you reported yourself.';
    } else {
        $proof = trim($_POST['proof_details'] ?? '');
        if ($proof === '') {
            $errors[] = 'Please describe proof of ownership.';
        } else {
            // score vs claimant's own lost reports, if any correspond
            $lostMatch = $pdo->prepare(
                "SELECT item_id FROM items WHERE user_id=? AND item_type='lost' ORDER BY created_at DESC LIMIT 1"
            );
            $lostMatch->execute([current_user_id()]);
            $lostId = $lostMatch->fetchColumn();
            $score = null;
            if ($lostId) {
                $lostItem = $pdo->prepare("SELECT * FROM items WHERE item_id=?");
                $lostItem->execute([$lostId]);
                $lostItem = $lostItem->fetch();
                $score = compute_match_score($lostItem, $item, get_match_weights($pdo));
            }
            $ins = $pdo->prepare(
                "INSERT INTO claims (item_id, claimant_id, proof_details, match_score) VALUES (?,?,?,?)"
            );
            $ins->execute([$item['item_id'], current_user_id(), $proof, $score]);
            notify($pdo, $item['user_id'], "Someone submitted a claim for your found item \"{$item['title']}\".", 'admin/claims.php');
            flash('success', 'Your claim request has been submitted for admin verification.');
            header('Location: item_detail.php?id=' . $item['item_id']);
            exit;
        }
    }
}

$pageTitle = $item['title'];
include __DIR__ . '/includes/header.php';
?>

<a href="items.php" class="muted" style="font-size:.85rem;">← Back to Browse</a>

<?php foreach ($errors as $err): ?><div class="alert alert-error"><?= e($err) ?></div><?php endforeach; ?>

<div class="panel" style="margin-top:16px;">
  <span class="kind kind-<?= $item['item_type'] ?>" style="display:inline-block;"><?= $item['item_type'] ?></span>
  <div class="section-head">
    <h1 style="font-size:1.5rem;"><?= e($item['title']) ?></h1>
    <span class="<?= badge_class($item['status']) ?>"><?= ucfirst($item['status']) ?></span>
  </div>
  <?php if ($item['photo_path']): ?>
    <img src="<?= e($item['photo_path']) ?>" alt="" style="border-radius:10px; max-height:320px; object-fit:cover; margin-bottom:18px;">
  <?php endif; ?>
  <div class="grid grid-3" style="margin-bottom:18px;">
    <div><div class="muted" style="font-size:.72rem; text-transform:uppercase;">Category</div><div><?= e($item['category_name']) ?></div></div>
    <div><div class="muted" style="font-size:.72rem; text-transform:uppercase;">Location</div><div><?= e($item['location']) ?></div></div>
    <div><div class="muted" style="font-size:.72rem; text-transform:uppercase;">Date / Time</div><div><?= date('M j, Y', strtotime($item['item_date'])) ?><?= $item['item_time'] ? ' · '.date('g:i A', strtotime($item['item_time'])) : '' ?></div></div>
  </div>
  <?php if ($item['description']): ?>
    <div><div class="muted" style="font-size:.72rem; text-transform:uppercase; margin-bottom:4px;">Description</div><p><?= nl2br(e($item['description'])) ?></p></div>
  <?php endif; ?>
  <p class="muted" style="font-size:.82rem; margin-top:14px;">Reported by <?= e($item['reporter_name']) ?> on <?= date('M j, Y', strtotime($item['created_at'])) ?></p>
</div>

<?php if ($item['item_type'] === 'found' && !$isOwner): ?>
<div class="panel">
  <h2 style="font-size:1.1rem;">Submit a Claim Request</h2>
  <p class="muted" style="font-size:.86rem; margin-bottom:16px;">Believe this is yours? Describe identifying details only the true owner would know. An administrator will verify before approving.</p>
  <form method="post">
    <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
    <div class="field">
      <textarea name="proof_details" placeholder="e.g. Serial number, contents, distinguishing marks..." required></textarea>
    </div>
    <button type="submit" name="submit_claim" class="btn btn-green">Submit Claim Request</button>
  </form>
</div>
<?php endif; ?>

<div class="section-head">
  <h2 style="font-size:1.15rem;">Possible Matches <span class="muted" style="font-weight:400;">(<?= count($matches) ?>)</span></h2>
</div>

<?php if (!$matches): ?>
  <div class="empty-state panel"><h3>No matches yet</h3><p>We'll notify you if a likely match is reported.</p></div>
<?php else: ?>
  <div class="grid grid-3">
    <?php foreach ($matches as $m): ?>
      <div class="tag-card">
        <span class="kind kind-<?= $m['item_type'] ?>"><?= $m['item_type'] ?></span>
        <h3><?= e($m['title']) ?></h3>
        <p class="meta">📍 <?= e($m['location']) ?></p>
        <p class="meta">🗓 <?= date('M j, Y', strtotime($m['item_date'])) ?></p>
        <p class="meta"><?= e($m['category_name']) ?></p>
        <div class="stub">
          <span class="score"><?= $m['match_score'] ?>% match</span>
          <a href="item_detail.php?id=<?= $m['item_id'] ?>" style="color: var(--brass-dark); font-weight:600;">View →</a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  
<?php endif; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>
