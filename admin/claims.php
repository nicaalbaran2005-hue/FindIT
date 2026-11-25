<?php
require_once __DIR__ . '/../includes/functions.php';
require_admin();
$inAdmin = true;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $claimId = (int) $_POST['claim_id'];
    $action  = $_POST['action'] ?? '';
    $notes   = trim($_POST['admin_notes'] ?? '');

    $stmt = $pdo->prepare(
        "SELECT cl.*, i.title, i.item_id, i.user_id AS finder_id FROM claims cl
         JOIN items i ON i.item_id = cl.item_id WHERE cl.claim_id = ?"
    );
    $stmt->execute([$claimId]);
    $claim = $stmt->fetch();

    if ($claim) {
        if ($action === 'verify') {
            $pdo->prepare("UPDATE claims SET status='verified', admin_notes=?, reviewed_at=NOW() WHERE claim_id=?")
                ->execute([$notes, $claimId]);
            notify($pdo, $claim['claimant_id'], "Your claim for \"{$claim['title']}\" has been verified and is pending final approval.", '../my_claims.php');
            flash('success', 'Claim marked as verified.');
        } elseif ($action === 'approve') {
            $pdo->prepare("UPDATE claims SET status='approved', admin_notes=?, reviewed_at=NOW() WHERE claim_id=?")
                ->execute([$notes, $claimId]);
            $pdo->prepare("UPDATE items SET status='claimed' WHERE item_id=?")->execute([$claim['item_id']]);
            notify($pdo, $claim['claimant_id'], "Your claim for \"{$claim['title']}\" has been approved! Please coordinate pickup.", '../my_claims.php');
            notify($pdo, $claim['finder_id'], "The item you found, \"{$claim['title']}\", has been claimed by its verified owner.", '../dashboard.php');
            flash('success', 'Claim approved and item marked as claimed.');
        } elseif ($action === 'reject') {
            $pdo->prepare("UPDATE claims SET status='rejected', admin_notes=?, reviewed_at=NOW() WHERE claim_id=?")
                ->execute([$notes, $claimId]);
            notify($pdo, $claim['claimant_id'], "Your claim for \"{$claim['title']}\" was not verified. Reason: " . ($notes ?: 'Not specified'), '../my_claims.php');
            flash('success', 'Claim rejected.');
        }
    }
    header('Location: claims.php');
    exit;
}

$filter = $_GET['status'] ?? 'pending';
$sql = "SELECT cl.*, i.title, i.location, i.item_date, i.item_type, i.user_id AS finder_id,
               u.full_name AS claimant_name, u.email AS claimant_email,
               f.full_name AS finder_name
        FROM claims cl
        JOIN items i ON i.item_id = cl.item_id
        JOIN users u ON u.user_id = cl.claimant_id
        JOIN users f ON f.user_id = i.user_id";
$params = [];
if (in_array($filter, ['pending','verified','approved','rejected'], true)) {
    $sql .= " WHERE cl.status = ?";
    $params[] = $filter;
}
$sql .= " ORDER BY cl.created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$claims = $stmt->fetchAll();

$pageTitle = 'Verify Claims';
include __DIR__ . '/../includes/header.php';
?>

<div class="section-head">
  <div>
    <span class="eyebrow">Administration</span>
    <h1 style="font-size:1.5rem; margin-top:4px;">Claim Verification</h1>
  </div>
</div>

<div class="filters panel">
  <?php foreach (['pending'=>'Pending','verified'=>'Verified','approved'=>'Approved','rejected'=>'Rejected','' =>'All'] as $val=>$label): ?>
    <a href="?status=<?= $val ?>" class="btn <?= $filter===$val?'btn-teal':'btn-outline' ?> btn-sm"><?= $label ?></a>
  <?php endforeach; ?>
</div>

<?php if (!$claims): ?>
  <div class="empty-state panel"><h3>No claims here</h3><p>Claims matching this filter will appear when submitted.</p></div>
<?php endif; ?>

<?php foreach ($claims as $c): ?>
  <div class="panel">
    <div class="section-head">
      <div>
        <h3 style="font-size:1.05rem;"><?= e($c['title']) ?> <span class="muted" style="font-weight:400; font-size:.85rem;">(Found item)</span></h3>
        <p class="muted" style="font-size:.82rem;">📍 <?= e($c['location']) ?> · 🗓 <?= date('M j, Y', strtotime($c['item_date'])) ?></p>
      </div>
      <span class="<?= badge_class($c['status']) ?>"><?= ucfirst($c['status']) ?></span>
    </div>

    <div class="grid grid-2" style="margin-bottom:14px;">
      <div>
        <div class="muted" style="font-size:.72rem; text-transform:uppercase;">Claimant</div>
        <div><?= e($c['claimant_name']) ?> · <?= e($c['claimant_email']) ?></div>
      </div>
      <div>
        <div class="muted" style="font-size:.72rem; text-transform:uppercase;">Reported by (Finder)</div>
        <div><?= e($c['finder_name']) ?></div>
      </div>
    </div>

    <div style="margin-bottom:14px;">
      <div class="muted" style="font-size:.72rem; text-transform:uppercase; margin-bottom:4px;">Proof of Ownership Provided</div>
      <p><?= nl2br(e($c['proof_details'])) ?></p>
    </div>

    <?php if ($c['match_score'] !== null): ?>
      <p class="score" style="margin-bottom:14px;">Computed match score vs. claimant's report: <?= $c['match_score'] ?>%</p>
    <?php endif; ?>

    <?php if ($c['status'] === 'pending' || $c['status'] === 'verified'): ?>
    <form method="post">
      <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
      <input type="hidden" name="claim_id" value="<?= $c['claim_id'] ?>">
      <div class="field">
        <label>Admin Notes</label>
        <textarea name="admin_notes" placeholder="Verification notes or rejection reason..."><?= e($c['admin_notes'] ?? '') ?></textarea>
      </div>
      <div style="display:flex; gap:10px; flex-wrap:wrap;">
        <?php if ($c['status'] === 'pending'): ?>
          <button type="submit" name="action" value="verify" class="btn btn-teal">Mark Verified</button>
        <?php endif; ?>
        <button type="submit" name="action" value="approve" class="btn btn-green">Approve Claim</button>
        <button type="submit" name="action" value="reject" class="btn btn-red">Reject Claim</button>
      </div>
    </form>
    <?php else: ?>
      <?php if ($c['admin_notes']): ?><p class="muted" style="font-size:.85rem;">Notes: <?= e($c['admin_notes']) ?></p><?php endif; ?>
    <?php endif; ?>
  </div>
<?php endforeach; ?>

<?php include __DIR__ . '/../includes/footer.php'; ?>
