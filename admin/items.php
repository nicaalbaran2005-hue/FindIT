<?php
require_once __DIR__ . '/../includes/functions.php';
require_admin();
$inAdmin = true;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $itemId = (int) $_POST['item_id'];
    if (isset($_POST['delete_item'])) {
        $pdo->prepare("DELETE FROM items WHERE item_id = ?")->execute([$itemId]);
        flash('success', 'Item record deleted.');
    } elseif (isset($_POST['set_status'])) {
        $status = $_POST['status'];
        if (in_array($status, ['open','matched','claimed','closed'], true)) {
            $pdo->prepare("UPDATE items SET status = ? WHERE item_id = ?")->execute([$status, $itemId]);
            flash('success', 'Item status updated.');
        }
    }
    header('Location: items.php');
    exit;
}

$type = $_GET['type'] ?? '';
$status = $_GET['status'] ?? '';
$sql = "SELECT i.*, c.name AS category_name, u.full_name AS reporter_name
        FROM items i JOIN categories c ON c.category_id = i.category_id
        JOIN users u ON u.user_id = i.user_id WHERE 1=1";
$params = [];
if (in_array($type, ['lost','found'], true)) { $sql .= " AND i.item_type = ?"; $params[] = $type; }
if (in_array($status, ['open','matched','claimed','closed'], true)) { $sql .= " AND i.status = ?"; $params[] = $status; }
$sql .= " ORDER BY i.created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$items = $stmt->fetchAll();

$pageTitle = 'Manage Items';
include __DIR__ . '/../includes/header.php';
?>

<div class="section-head">
  <div>
    <span class="eyebrow">Administration</span>
    <h1 style="font-size:1.5rem; margin-top:4px;">Item Records</h1>
  </div>
</div>

<form method="get" class="filters panel">
  <div class="field">
    <label>Type</label>
    <select name="type">
      <option value="">All</option>
      <option value="lost" <?= $type==='lost'?'selected':'' ?>>Lost</option>
      <option value="found" <?= $type==='found'?'selected':'' ?>>Found</option>
    </select>
  </div>
  <div class="field">
    <label>Status</label>
    <select name="status">
      <option value="">All</option>
      <?php foreach (['open','matched','claimed','closed'] as $s): ?>
        <option value="<?= $s ?>" <?= $status===$s?'selected':'' ?>><?= ucfirst($s) ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <button type="submit" class="btn btn-teal">Filter</button>
  <a href="items.php" class="btn btn-outline">Reset</a>
</form>

<div class="panel" style="padding:0;">
  <table>
    <thead><tr><th>Item</th><th>Type</th><th>Category</th><th>Reporter</th><th>Location</th><th>Status</th><th>Actions</th></tr></thead>
    <tbody>
    <?php foreach ($items as $it): ?>
      <tr>
        <td><a href="../item_detail.php?id=<?= $it['item_id'] ?>" style="color:var(--brass);"><?= e($it['title']) ?></a></td>
        <td><span class="kind kind-<?= $it['item_type'] ?>"><?= $it['item_type'] ?></span></td>
        <td><?= e($it['category_name']) ?></td>
        <td><?= e($it['reporter_name']) ?></td>
        <td><?= e($it['location']) ?></td>
        <td>
          <form method="post" style="display:flex; gap:6px; align-items:center;">
            <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
            <input type="hidden" name="item_id" value="<?= $it['item_id'] ?>">
            <select name="status" style="padding:6px 8px; font-size:.78rem;" onchange="this.form.submit()" data-set-status>
              <?php foreach (['open','matched','claimed','closed'] as $s): ?>
                <option value="<?= $s ?>" <?= $it['status']===$s?'selected':'' ?>><?= ucfirst($s) ?></option>
              <?php endforeach; ?>
            </select>
            <input type="hidden" name="set_status" value="1">
          </form>
        </td>
        <td>
          <form method="post" onsubmit="return confirm('Delete this item record permanently?');">
            <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
            <input type="hidden" name="item_id" value="<?= $it['item_id'] ?>">
            <button type="submit" name="delete_item" class="btn btn-red btn-sm">Delete</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
    <?php if (!$items): ?><tr><td colspan="7" class="muted center" style="padding:30px;">No item records found.</td></tr><?php endif; ?>
    </tbody>
  </table>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
