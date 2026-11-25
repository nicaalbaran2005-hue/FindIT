<?php
require_once __DIR__ . '/includes/functions.php';
if (is_logged_in()) { header('Location: ' . (is_admin() ? 'admin/dashboard.php' : 'dashboard.php')); exit; }

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password_hash'])) {
        $errors[] = 'Incorrect email or password.';
    } elseif ($user['status'] === 'disabled') {
        $errors[] = 'This account has been disabled. Contact an administrator.';
    } else {
        $_SESSION['user_id']   = $user['user_id'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['role']      = $user['role'];
        header('Location: ' . ($user['role'] === 'admin' ? 'admin/dashboard.php' : 'dashboard.php'));
        exit;
    }
}

$pageTitle = 'Log In';
$narrow = true;
include __DIR__ . '/includes/header.php';
?>
<div class="auth-wrap" style="min-height:auto; padding:0;">
<div class="auth-card panel" style="width:100%;">
  <h2 style="text-align:center; font-size:1.4rem;">Welcome back</h2>
  <p class="muted center" style="font-size:.85rem; margin-bottom:22px;">Log in to your FindIT account.</p>

  <?php foreach ($errors as $err): ?>
    <div class="alert alert-error"><?= e($err) ?></div>
  <?php endforeach; ?>

  <form method="post" novalidate>
    <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
    <div class="field">
      <label>Email Address</label>
      <input type="email" name="email" value="<?= e($_POST['email'] ?? '') ?>" required autofocus>
    </div>
    <div class="field">
      <label>Password</label>
      <input type="password" name="password" required>
    </div>
    <button type="submit" class="btn btn-primary" style="width:100%;">Log In</button>
  </form>
  <p class="center muted" style="margin-top:18px; font-size:.85rem;">
    No account yet? <a href="register.php" style="color:var(--brass); font-weight:600;">Register here</a>
  </p>
  <p class="center muted" style="margin-top:8px; font-size:.75rem;">
    Admin demo login: admin@findit.local / Admin@123
  </p>
</div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
