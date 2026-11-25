<?php
// Expects functions.php already required by the including page.
$__unread = is_logged_in() ? unread_notification_count($pdo, current_user_id()) : 0;
$__current = basename($_SERVER['PHP_SELF']);
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= isset($pageTitle) ? e($pageTitle) . ' · FindIT' : 'FindIT — Lost & Found Management System' ?></title>
<link rel="stylesheet" href="<?= isset($inAdmin) ? '../assets/css/style.css' : 'assets/css/style.css' ?>">
</head>
<body>
<header class="app-header">
  <div class="bar">
    <a href="<?= isset($inAdmin) ? '../index.php' : 'index.php' ?>" class="brand">
      <span class="tag-dot"></span>
      <span>FindIT<small>LOST &amp; FOUND REGISTRY</small></span>
    </a>
    <nav class="nav">
      <?php if (is_logged_in()): ?>
        <?php if (is_admin()): ?>
          <a href="<?= isset($inAdmin) ? 'dashboard.php' : 'admin/dashboard.php' ?>" class="<?= $__current==='dashboard.php'?'active':'' ?>">Admin Dashboard</a>
          <a href="<?= isset($inAdmin) ? 'items.php' : 'admin/items.php' ?>">Items</a>
          <a href="<?= isset($inAdmin) ? 'claims.php' : 'admin/claims.php' ?>">Claims</a>
          <a href="<?= isset($inAdmin) ? 'users.php' : 'admin/users.php' ?>">Users</a>
          <a href="<?= isset($inAdmin) ? 'reports.php' : 'admin/reports.php' ?>">Reports</a>
        <?php else: ?>
          <a href="<?= isset($inAdmin) ? '../dashboard.php' : 'dashboard.php' ?>" class="<?= $__current==='dashboard.php'?'active':'' ?>">Dashboard</a>
          <a href="<?= isset($inAdmin) ? '../items.php' : 'items.php' ?>">Browse Items</a>
          <a href="<?= isset($inAdmin) ? '../report_item.php' : 'report_item.php' ?>">Report Item</a>
          <a href="<?= isset($inAdmin) ? '../my_claims.php' : 'my_claims.php' ?>">My Claims</a>
        <?php endif; ?>
        <a href="<?= isset($inAdmin) ? '../notifications.php' : 'notifications.php' ?>" class="bell">Alerts<?php if ($__unread>0): ?><span class="count"><?= $__unread ?></span><?php endif; ?></a>
        <a href="<?= isset($inAdmin) ? '../logout.php' : 'logout.php' ?>" class="pill">Log Out</a>
      <?php else: ?>
        <a href="index.php">Home</a>
        <a href="login.php">Log In</a>
        <a href="register.php" class="pill">Register</a>
      <?php endif; ?>
    </nav>
  </div>
</header>
<main class="shell<?= isset($narrow) ? ' narrow' : '' ?>">
<?php if ($msg = flash('success')): ?><div class="alert alert-success"><?= e($msg) ?></div><?php endif; ?>
<?php if ($msg = flash('error')): ?><div class="alert alert-error"><?= e($msg) ?></div><?php endif; ?>
<?php if ($msg = flash('info')): ?><div class="alert alert-info"><?= e($msg) ?></div><?php endif; ?>
