<?php
require_once __DIR__ . '/includes/functions.php';
if (is_logged_in()) {
    header('Location: ' . (is_admin() ? 'admin/dashboard.php' : 'dashboard.php'));
    exit;
}
$pageTitle = 'Home';

$openLost  = $pdo->query("SELECT COUNT(*) FROM items WHERE item_type='lost' AND status='open'")->fetchColumn();
$openFound = $pdo->query("SELECT COUNT(*) FROM items WHERE item_type='found' AND status='open'")->fetchColumn();
$claimed   = $pdo->query("SELECT COUNT(*) FROM items WHERE status='claimed'")->fetchColumn();

include __DIR__ . '/includes/header.php';
?>

<section class="panel" style="padding:48px; text-align:center;">
  <div class="section-head" style="justify-content:center; margin-bottom:10px;">
    <span class="eyebrow">Web-Based Lost &amp; Found Management System</span>
  </div>
  <h1 style="font-size:2.4rem; max-width:720px; margin:0 auto 14px;">Every lost item leaves a paper trail. FindIT follows it.</h1>
  <p class="muted" style="max-width:560px; margin:0 auto 26px; font-size:1.02rem;">
    Report what you've lost or found, and let our matching engine — weighing location, date &amp; time, and category — surface likely pairs automatically.
  </p>
  <div style="display:flex; gap:14px; justify-content:center; flex-wrap:wrap;">
    <a href="register.php" class="btn btn-primary">Get Started</a>
    <a href="login.php" class="btn btn-outline">Log In</a>
  </div>
</section>

<div class="grid grid-3" style="margin-top:24px;">
  <div class="stat"><div class="num mono"><?= (int)$openLost ?></div><div class="label">Open Lost Reports</div></div>
  <div class="stat"><div class="num mono"><?= (int)$openFound ?></div><div class="label">Open Found Reports</div></div>
  <div class="stat"><div class="num mono"><?= (int)$claimed ?></div><div class="label">Items Successfully Claimed</div></div>
</div>

<hr class="divider">

<div class="section-head">
  <h2 style="font-size:1.3rem;">How the registry works</h2>
</div>
<div class="grid grid-4">
  <div class="panel">
    <span class="badge badge-amber">01</span>
    <h3 style="font-size:1rem; margin-top:10px;">Register &amp; Report</h3>
    <p class="muted" style="font-size:.86rem;">Create an account and file a structured lost or found report — location, date/time, and category.</p>
  </div>
  <div class="panel">
    <span class="badge badge-teal">02</span>
    <h3 style="font-size:1rem; margin-top:10px;">Automatic Matching</h3>
    <p class="muted" style="font-size:.86rem;">Our scoring engine compares your report against the opposite list and ranks likely matches.</p>
  </div>
  <div class="panel">
    <span class="badge badge-green">03</span>
    <h3 style="font-size:1rem; margin-top:10px;">Submit a Claim</h3>
    <p class="muted" style="font-size:.86rem;">Found a probable match? Submit proof of ownership for an administrator to verify.</p>
  </div>
  <div class="panel">
    <span class="badge badge-red">04</span>
    <h3 style="font-size:1rem; margin-top:10px;">Get Notified</h3>
    <p class="muted" style="font-size:.86rem;">Once verified and approved, you're notified and the item is marked claimed.</p>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
