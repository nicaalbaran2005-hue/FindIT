<?php
require_once __DIR__ . '/../includes/functions.php';
require_admin();
$inAdmin = true;

$byCategory = $pdo->query(
    "SELECT c.name, COUNT(i.item_id) AS cnt FROM categories c
     LEFT JOIN items i ON i.category_id = c.category_id
     GROUP BY c.category_id ORDER BY cnt DESC"
)->fetchAll();

$byStatus = $pdo->query("SELECT status, COUNT(*) AS cnt FROM items GROUP BY status")->fetchAll();
$claimStats = $pdo->query("SELECT status, COUNT(*) AS cnt FROM claims GROUP BY status")->fetchAll();

$monthly = $pdo->query(
    "SELECT DATE_FORMAT(created_at, '%Y-%m') AS ym, item_type, COUNT(*) AS cnt
     FROM items GROUP BY ym, item_type ORDER BY ym DESC LIMIT 12"
)->fetchAll();

$avgResolutionDays = $pdo->query(
    "SELECT AVG(DATEDIFF(reviewed_at, created_at)) FROM claims WHERE status='approved' AND reviewed_at IS NOT NULL"
)->fetchColumn();

$pageTitle = 'Reports';
include __DIR__ . '/../includes/header.php';
?>

<div class="section-head">
  <div>
    <span class="eyebrow">Administration</span>
    <h1 style="font-size:1.5rem; margin-top:4px;">Reports &amp; Insights</h1>
  </div>
</div>

<div class="grid grid-3" style="margin-bottom:26px;">
  <div class="stat"><div class="num mono"><?= array_sum(array_column($byStatus,'cnt')) ?></div><div class="label">Total Items Logged</div></div>
  <div class="stat"><div class="num mono"><?= array_sum(array_column($claimStats,'cnt')) ?></div><div class="label">Total Claims Filed</div></div>
  <div class="stat"><div class="num mono"><?= $avgResolutionDays !== null ? round($avgResolutionDays,1) : '—' ?></div><div class="label">Avg. Days to Resolve Claim</div></div>
</div>

<div class="grid grid-2">
  <div class="panel">
    <h3 style="font-size:1rem; margin-bottom:14px;">Items by Category</h3>
    <table>
      <thead><tr><th>Category</th><th>Reports</th></tr></thead>
      <tbody>
      <?php foreach ($byCategory as $row): ?>
        <tr><td><?= e($row['name']) ?></td><td class="mono"><?= (int)$row['cnt'] ?></td></tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="panel">
    <h3 style="font-size:1rem; margin-bottom:14px;">Items by Status</h3>
    <table>
      <thead><tr><th>Status</th><th>Count</th></tr></thead>
      <tbody>
      <?php foreach ($byStatus as $row): ?>
        <tr><td><span class="<?= badge_class($row['status']) ?>"><?= ucfirst($row['status']) ?></span></td><td class="mono"><?= (int)$row['cnt'] ?></td></tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<div class="panel" style="margin-top:20px;">
  <h3 style="font-size:1rem; margin-bottom:14px;">Claim Outcomes</h3>
  <table>
    <thead><tr><th>Status</th><th>Count</th></tr></thead>
    <tbody>
    <?php foreach ($claimStats as $row): ?>
      <tr><td><span class="<?= badge_class($row['status']) ?>"><?= ucfirst($row['status']) ?></span></td><td class="mono"><?= (int)$row['cnt'] ?></td></tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>

<div class="panel" style="margin-top:20px;">
  <h3 style="font-size:1rem; margin-bottom:14px;">Monthly Reports (Lost vs. Found)</h3>
  <table>
    <thead><tr><th>Month</th><th>Type</th><th>Count</th></tr></thead>
    <tbody>
    <?php foreach ($monthly as $row): ?>
      <tr><td><?= e($row['ym']) ?></td><td><span class="kind kind-<?= $row['item_type'] ?>"><?= $row['item_type'] ?></span></td><td class="mono"><?= (int)$row['cnt'] ?></td></tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
