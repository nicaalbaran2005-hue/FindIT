<?php
require_once __DIR__ . '/includes/functions.php';
require_login();

$stmt = $pdo->prepare(
    "SELECT cl.*, i.title, i.location, i.item_date, i.item_type
     FROM claims cl JOIN items i ON i.item_id = cl.item_id
     WHERE cl.claimant_id = ? ORDER BY cl.created_at DESC"
);
$stmt->execute([current_user_id()]);
$claims = $stmt->fetchAll();

$pageTitle = 'My Claims';
include __DIR__ . '/includes/header.php';
?>

<div class="section-head">
  <div>
    <span class="eyebrow">Claims</span>
    <h1 style="font-size:1.5rem; margin-top:4px;">My Claim Requests</h1>
  </div>
</div>

<?php if (!$claims): ?>
  <div class="empty-state panel"><h3>No claims submitted yet</h3><p>Browse found items and submit a claim if one belongs to you.</p></div>
<?php else: ?>
  <div class="panel" style="padding:0;">
    <table>
      <thead><tr><th>Item</th><th>Location</th><th>Date Reported</th><th>Match Score</th><th>Status</th><th>Submitted</th></tr></thead>
      <tbody>
      <?php foreach ($claims as $c): ?>
        <tr>
          <td><a href="item_detail.php?id=<?= $c['item_id'] ?>" style="color:var(--brass);"><?= e($c['title']) ?></a></td>
          <td><?= e($c['location']) ?></td>
          <td><?= date('M j, Y', strtotime($c['item_date'])) ?></td>
          <td class="mono"><?= $c['match_score'] !== null ? $c['match_score'].'%' : '—' ?></td>
          <td><span class="<?= badge_class($c['status']) ?>"><?= ucfirst($c['status']) ?></span></td>
          <td class="muted"><?= date('M j, Y', strtotime($c['created_at'])) ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>
