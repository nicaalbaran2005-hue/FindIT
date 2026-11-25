<?php
require_once __DIR__ . '/includes/functions.php';
require_login();

$pdo->prepare("UPDATE notifications SET is_read = 1 WHERE user_id = ?")->execute([current_user_id()]);

$stmt = $pdo->prepare("SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([current_user_id()]);
$notes = $stmt->fetchAll();

$pageTitle = 'Notifications';
include __DIR__ . '/includes/header.php';
?>

<div class="section-head">
  <div>
    <span class="eyebrow">Alerts</span>
    <h1 style="font-size:1.5rem; margin-top:4px;">Notifications</h1>
  </div>
</div>

<?php if (!$notes): ?>
  <div class="empty-state panel"><h3>No notifications</h3><p>We'll let you know when a possible match or claim update arrives.</p></div>
<?php else: ?>
  <div class="panel" style="padding:8px 0;">
    <?php foreach ($notes as $n): ?>
      <div style="padding:16px 24px; border-bottom:1px solid var(--line); display:flex; justify-content:space-between; gap:16px; align-items:center;">
        <div>
          <div><?= e($n['message']) ?></div>
          <div class="muted mono" style="font-size:.72rem; margin-top:4px;"><?= date('M j, Y g:i A', strtotime($n['created_at'])) ?></div>
        </div>
        <?php if ($n['link']): ?><a href="<?= e($n['link']) ?>" class="btn btn-outline btn-sm">View</a><?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>
