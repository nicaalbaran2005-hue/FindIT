<?php
require_once __DIR__ . '/../includes/functions.php';
require_admin();
$inAdmin = true;

$totalUsers   = $pdo->query("SELECT COUNT(*) FROM users WHERE role='user'")->fetchColumn();
$totalItems   = $pdo->query("SELECT COUNT(*) FROM items")->fetchColumn();
$openLost     = $pdo->query("SELECT COUNT(*) FROM items WHERE item_type='lost' AND status IN ('open','matched')")->fetchColumn();
$openFound    = $pdo->query("SELECT COUNT(*) FROM items WHERE item_type='found' AND status IN ('open','matched')")->fetchColumn();
$pendingClaims= $pdo->query("SELECT COUNT(*) FROM claims WHERE status='pending'")->fetchColumn();
$claimedTotal = $pdo->query("SELECT COUNT(*) FROM items WHERE status='claimed'")->fetchColumn();

$recentItems = $pdo->query(
    "SELECT i.*, c.name AS category_name, u.full_name AS reporter_name
     FROM items i JOIN categories c ON c.category_id=i.category_id
     JOIN users u ON u.user_id = i.user_id
     ORDER BY i.created_at DESC LIMIT 6"
)->fetchAll();

$pageTitle = 'Admin Dashboard';
include __DIR__ . '/../includes/header.php';
?>

<div class="section-head">
  <div>
    <span class="eyebrow">Administration</span>
    <h1 style="font-size:1.6rem; margin-top:4px;">Registry Overview</h1>
  </div>
  <a href="match_settings.php" class="btn btn-outline">Match Settings</a>
</div>

<div class="grid grid-4" style="margin-bottom:30px;">
  <div class="stat"><div class="num mono"><?= (int)$totalUsers ?></div><div class="label">Registered Users</div></div>
  <div class="stat"><div class="num mono"><?= (int)$totalItems ?></div><div class="label">Total Item Reports</div></div>
  <div class="stat"><div class="num mono"><?= (int)$pendingClaims ?></div><div class="label">Pending Claims</div></div>
  <div class="stat"><div class="num mono"><?= (int)$claimedTotal ?></div><div class="label">Items Claimed</div></div>
</div>

<div class="grid grid-2" style="margin-bottom:30px;">
  <div class="stat"><div class="num mono"><?= (int)$openLost ?></div><div class="label">Active Lost Reports</div></div>
  <div class="stat"><div class="num mono"><?= (int)$openFound ?></div><div class="label">Active Found Reports</div></div>
</div>

<div class="section-head">
  <h2 style="font-size:1.15rem;">Recent Reports</h2>
  <a href="items.php" class="btn btn-outline btn-sm">Manage Item Records</a>
</div>

<div class="panel" style="padding:0;">
  <table>
    <thead><tr><th>Item</th><th>Type</th><th>Category</th><th>Reporter</th><th>Status</th><th>Reported</th></tr></thead>
    <tbody>
    <?php foreach ($recentItems as $it): ?>
      <tr>
        <td><a href="../item_detail.php?id=<?= $it['item_id'] ?>" style="color:var(--brass);"><?= e($it['title']) ?></a></td>
        <td><span class="kind kind-<?= $it['item_type'] ?>"><?= $it['item_type'] ?></span></td>
        <td><?= e($it['category_name']) ?></td>
        <td><?= e($it['reporter_name']) ?></td>
        <td><span class="<?= badge_class($it['status']) ?>"><?= ucfirst($it['status']) ?></span></td>
        <td class="muted"><?= date('M j, Y', strtotime($it['created_at'])) ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
