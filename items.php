<?php
require_once __DIR__ . '/includes/functions.php';
require_login();

$categories = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();

$type    = $_GET['type'] ?? '';
$catId   = $_GET['category'] ?? '';
$q       = trim($_GET['q'] ?? '');
$loc     = trim($_GET['location'] ?? '');

$sql = "SELECT i.*, c.name AS category_name FROM items i
        JOIN categories c ON c.category_id = i.category_id
        WHERE i.status IN ('open','matched')";
$params = [];

if (in_array($type, ['lost','found'], true)) { $sql .= " AND i.item_type = ?"; $params[] = $type; }
if ($catId !== '') { $sql .= " AND i.category_id = ?"; $params[] = $catId; }
if ($q !== '') { $sql .= " AND (i.title LIKE ? OR i.description LIKE ?)"; $params[] = "%$q%"; $params[] = "%$q%"; }
if ($loc !== '') { $sql .= " AND i.location LIKE ?"; $params[] = "%$loc%"; }

$sql .= " ORDER BY i.created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$items = $stmt->fetchAll();

$pageTitle = 'Browse Items';
include __DIR__ . '/includes/header.php';
?>

<div class="section-head">
  <div>
    <span class="eyebrow">Registry</span>
    <h1 style="font-size:1.5rem; margin-top:4px;">Browse Lost &amp; Found Items</h1>
  </div>
  <a href="report_item.php" class="btn btn-primary">+ Report an Item</a>
</div>

<form method="get" class="filters panel">
  <div class="field">
    <label>Search</label>
    <input type="text" name="q" placeholder="Title or description" value="<?= e($q) ?>">
  </div>
  <div class="field">
    <label>Type</label>
    <select name="type">
      <option value="">All</option>
      <option value="lost" <?= $type==='lost'?'selected':'' ?>>Lost</option>
      <option value="found" <?= $type==='found'?'selected':'' ?>>Found</option>
    </select>
  </div>
  <div class="field">
    <label>Category</label>
    <select name="category">
      <option value="">All Categories</option>
      <?php foreach ($categories as $c): ?>
        <option value="<?= $c['category_id'] ?>" <?= $catId==$c['category_id']?'selected':'' ?>><?= e($c['name']) ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="field">
    <label>Location</label>
    <input type="text" name="location" placeholder="e.g. Library" value="<?= e($loc) ?>">
  </div>
  <button type="submit" class="btn btn-teal">Filter</button>
  <a href="items.php" class="btn btn-outline">Reset</a>
</form>

<?php if (!$items): ?>
  <div class="empty-state panel">
    <h3>No items match your filters</h3>
    <p>Try adjusting your search or check back later.</p>
  </div>
<?php else: ?>
  <div class="grid grid-3">
    <?php foreach ($items as $it): ?>
      <div class="tag-card">
        <span class="kind kind-<?= $it['item_type'] ?>"><?= $it['item_type'] ?></span>
        <h3><?= e($it['title']) ?></h3>
        <p class="meta">📍 <?= e($it['location']) ?></p>
        <p class="meta">🗓 <?= date('M j, Y', strtotime($it['item_date'])) ?></p>
        <p class="meta"><?= e($it['category_name']) ?></p>
        <?php if ($it['description']): ?><p class="desc"><?= e(mb_strimwidth($it['description'], 0, 110, '…')) ?></p><?php endif; ?>
        <div class="stub">
          <span class="<?= badge_class($it['status']) ?>"><?= ucfirst($it['status']) ?></span>
          <a href="item_detail.php?id=<?= $it['item_id'] ?>" style="color: var(--brass-dark); font-weight:600;">View Details →</a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>
