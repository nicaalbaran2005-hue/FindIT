<?php
require_once __DIR__ . '/includes/functions.php';
require_login();
if (is_admin()) { header('Location: admin/dashboard.php'); exit; }

$uid = current_user_id();
$pageTitle = 'Dashboard';

$myItems = $pdo->prepare(
    "SELECT i.*, c.name AS category_name FROM items i
     JOIN categories c ON c.category_id = i.category_id
     WHERE i.user_id = ? ORDER BY i.created_at DESC"
);
$myItems->execute([$uid]);
$myItems = $myItems->fetchAll();

$lostCount   = count(array_filter($myItems, fn($i) => $i['item_type'] === 'lost'));
$foundCount  = count(array_filter($myItems, fn($i) => $i['item_type'] === 'found'));
$claimedCount = count(array_filter($myItems, fn($i) => $i['status'] === 'claimed'));

$myClaims = $pdo->prepare(
    "SELECT COUNT(*) FROM claims WHERE claimant_id = ? AND status = 'pending'"
);
$myClaims->execute([$uid]);
$pendingClaims = $myClaims->fetchColumn();

include __DIR__ . '/includes/header.php';
?>

<div class="section-head">
  <div>
    <span class="eyebrow">Dashboard</span>
    <h1 style="font-size:1.6rem; margin-top:4px;">Welcome, <?= e($_SESSION['full_name']) ?></h1>
  </div>
  <div style="display:flex; gap:10px;">
    <a href="report_item.php" class="btn btn-primary">+ Report an Item</a>
  </div>
</div>

<div class="grid grid-4" style="margin-bottom:30px;">
  <div class="stat"><div class="num mono"><?= $lostCount ?></div><div class="label">Items You Lost</div></div>
  <div class="stat"><div class="num mono"><?= $foundCount ?></div><div class="label">Items You Found</div></div>
  <div class="stat"><div class="num mono"><?= $claimedCount ?></div><div class="label">Successfully Claimed</div></div>
  <div class="stat"><div class="num mono"><?= $pendingClaims ?></div><div class="label">Pending Claims</div></div>
</div>

<div class="section-head">
  <h2 style="font-size:1.15rem;">Your Reports</h2>
  <a href="items.php" class="btn btn-outline btn-sm">Browse All Items</a>
</div>

<?php if (!$myItems): ?>
  <div class="empty-state panel">
    <h3>No reports yet</h3>
    <p>File a lost or found report to start receiving match suggestions.</p>
    <a href="report_item.php" class="btn btn-primary" style="margin-top:14px;">Report an Item</a>
  </div>
<?php else: ?>
  <div class="grid grid-3">
    <?php foreach ($myItems as $it): ?>
      <div class="tag-card">
        <span class="kind kind-<?= $it['item_type'] ?>"><?= $it['item_type'] ?></span>
        <h3><?= e($it['title']) ?></h3>
        <p class="meta">📍 <?= e($it['location']) ?></p>
        <p class="meta">🗓 <?= date('M j, Y', strtotime($it['item_date'])) ?><?= $it['item_time'] ? ' · ' . date('g:i A', strtotime($it['item_time'])) : '' ?></p>
        <p class="meta"><?= e($it['category_name']) ?></p>
        <div class="stub">
          <span class="<?= badge_class($it['status']) ?>"><?= ucfirst($it['status']) ?></span>
          <a href="item_detail.php?id=<?= $it['item_id'] ?>" style="color: var(--brass-dark); font-weight:600;">View Matches →</a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>
