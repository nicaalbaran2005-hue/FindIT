<?php
require_once __DIR__ . '/../includes/functions.php';
require_admin();
$inAdmin = true;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $userId = (int) $_POST['user_id'];
    if ($userId === current_user_id()) {
        flash('error', 'You cannot modify your own admin account here.');
    } elseif (isset($_POST['toggle_status'])) {
        $new = $_POST['toggle_status'] === 'active' ? 'active' : 'disabled';
        $pdo->prepare("UPDATE users SET status = ? WHERE user_id = ?")->execute([$new, $userId]);
        flash('success', 'User status updated.');
    } elseif (isset($_POST['delete_user'])) {
        $pdo->prepare("DELETE FROM users WHERE user_id = ?")->execute([$userId]);
        flash('success', 'User account deleted.');
    }
    header('Location: users.php');
    exit;
}

$users = $pdo->query(
    "SELECT u.*, 
      (SELECT COUNT(*) FROM items i WHERE i.user_id = u.user_id) AS item_count
     FROM users u WHERE u.role = 'user' ORDER BY u.created_at DESC"
)->fetchAll();

$pageTitle = 'Manage Users';
include __DIR__ . '/../includes/header.php';
?>

<div class="section-head">
  <div>
    <span class="eyebrow">Administration</span>
    <h1 style="font-size:1.5rem; margin-top:4px;">User Accounts</h1>
  </div>
</div>

<div class="panel" style="padding:0;">
  <table>
    <thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>Reports Filed</th><th>Status</th><th>Joined</th><th>Actions</th></tr></thead>
    <tbody>
    <?php foreach ($users as $u): ?>
      <tr>
        <td><?= e($u['full_name']) ?></td>
        <td><?= e($u['email']) ?></td>
        <td><?= e($u['phone'] ?: '—') ?></td>
        <td class="mono"><?= (int)$u['item_count'] ?></td>
        <td><span class="<?= $u['status']==='active' ? 'badge badge-green' : 'badge badge-red' ?>"><?= ucfirst($u['status']) ?></span></td>
        <td class="muted"><?= date('M j, Y', strtotime($u['created_at'])) ?></td>
        <td style="display:flex; gap:6px;">
          <form method="post">
            <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
            <input type="hidden" name="user_id" value="<?= $u['user_id'] ?>">
            <input type="hidden" name="toggle_status" value="<?= $u['status']==='active' ? 'disabled' : 'active' ?>">
            <button type="submit" class="btn btn-outline btn-sm"><?= $u['status']==='active' ? 'Disable' : 'Enable' ?></button>
          </form>
          <form method="post" onsubmit="return confirm('Delete this user account permanently?');">
            <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
            <input type="hidden" name="user_id" value="<?= $u['user_id'] ?>">
            <button type="submit" name="delete_user" class="btn btn-red btn-sm">Delete</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
