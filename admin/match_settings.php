<?php
require_once __DIR__ . '/../includes/functions.php';
require_admin();
$inAdmin = true;

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $loc  = (int) $_POST['location_weight'];
    $date = (int) $_POST['datetime_weight'];
    $cat  = (int) $_POST['category_weight'];

    if ($loc + $date + $cat !== 100) {
        $errors[] = 'Weights must add up to exactly 100%.';
    } else {
        $exists = $pdo->query("SELECT setting_id FROM match_settings LIMIT 1")->fetchColumn();
        if ($exists) {
            $pdo->prepare("UPDATE match_settings SET location_weight=?, datetime_weight=?, category_weight=? WHERE setting_id=?")
                ->execute([$loc, $date, $cat, $exists]);
        } else {
            $pdo->prepare("INSERT INTO match_settings (location_weight, datetime_weight, category_weight) VALUES (?,?,?)")
                ->execute([$loc, $date, $cat]);
        }
        flash('success', 'Matching score weights updated.');
        header('Location: match_settings.php');
        exit;
    }
}

$weights = get_match_weights($pdo);

$pageTitle = 'Match Settings';
include __DIR__ . '/../includes/header.php';
?>

<div class="section-head">
  <div>
    <span class="eyebrow">Administration</span>
    <h1 style="font-size:1.5rem; margin-top:4px;">Matching Score Criteria</h1>
  </div>
</div>

<div class="panel" style="max-width:520px;">
  <p class="muted" style="font-size:.86rem; margin-bottom:20px;">
    Set how heavily each factor influences the automatic match score between lost and found reports. Values must total 100%.
  </p>

  <?php foreach ($errors as $err): ?><div class="alert alert-error"><?= e($err) ?></div><?php endforeach; ?>

  <form method="post">
    <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
    <div class="field">
      <label>Location Weight (%)</label>
      <input type="text" inputmode="numeric" name="location_weight" value="<?= (int)$weights['location_weight'] ?>">
    </div>
    <div class="field">
      <label>Date &amp; Time Weight (%)</label>
      <input type="text" inputmode="numeric" name="datetime_weight" value="<?= (int)$weights['datetime_weight'] ?>">
    </div>
    <div class="field">
      <label>Category Weight (%)</label>
      <input type="text" inputmode="numeric" name="category_weight" value="<?= (int)$weights['category_weight'] ?>">
    </div>
    <button type="submit" class="btn btn-primary" style="width:100%;">Save Weights</button>
  </form>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
