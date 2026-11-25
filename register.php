<?php
require_once __DIR__ . '/includes/functions.php';
if (is_logged_in()) { header('Location: dashboard.php'); exit; }

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $fullName = trim($_POST['full_name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $phone    = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    if ($fullName === '' || $email === '' || $password === '') $errors[] = 'Please fill in all required fields.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Please enter a valid email address.';
    if (strlen($password) < 8) $errors[] = 'Password must be at least 8 characters.';
    if ($password !== $confirm) $errors[] = 'Passwords do not match.';

    if (!$errors) {
        $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors[] = 'An account with that email already exists.';
        }
    }

    if (!$errors) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare(
            "INSERT INTO users (full_name, email, password_hash, phone, role) VALUES (?, ?, ?, ?, 'user')"
        );
        $stmt->execute([$fullName, $email, $hash, $phone]);
        flash('success', 'Account created successfully. Please log in.');
        header('Location: login.php');
        exit;
    }
}

$pageTitle = 'Register';
$narrow = true;
include __DIR__ . '/includes/header.php';
?>
<div class="auth-wrap" style="min-height:auto; padding:0;">
<div class="auth-card panel" style="width:100%;">
  <h2 style="text-align:center; font-size:1.4rem;">Create your account</h2>
  <p class="muted center" style="font-size:.85rem; margin-bottom:22px;">Register to report lost or found items.</p>

  <?php foreach ($errors as $err): ?>
    <div class="alert alert-error"><?= e($err) ?></div>
  <?php endforeach; ?>

  <form method="post" novalidate>
    <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
    <div class="field">
      <label>Full Name</label>
      <input type="text" name="full_name" value="<?= e($_POST['full_name'] ?? '') ?>" required>
    </div>
    <div class="field">
      <label>Email Address</label>
      <input type="email" name="email" value="<?= e($_POST['email'] ?? '') ?>" required>
    </div>
    <div class="field">
      <label>Phone Number <span class="muted">(optional)</span></label>
      <input type="tel" name="phone" value="<?= e($_POST['phone'] ?? '') ?>">
    </div>
    <div class="row-2">
      <div class="field">
        <label>Password</label>
        <input type="password" name="password" required>
        <div class="hint">At least 8 characters.</div>
      </div>
      <div class="field">
        <label>Confirm Password</label>
        <input type="password" name="confirm_password" required>
      </div>
    </div>
    <button type="submit" class="btn btn-primary" style="width:100%;">Create Account</button>
  </form>
  <p class="center muted" style="margin-top:18px; font-size:.85rem;">
    Already have an account? <a href="login.php" style="color:var(--brass); font-weight:600;">Log in</a>
  </p>
</div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
