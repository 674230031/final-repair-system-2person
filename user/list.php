<?php
require_once __DIR__ . '/../config/config.php';
require_role(['user','admin']);
$stmt=$pdo->prepare("SELECT r.*,u.fullname tech FROM repair_requests r LEFT JOIN users u ON r.assigned_to=u.id WHERE r.user_id=? ORDER BY r.created_at DESC");
$stmt->execute([$_SESSION['user']['id']]);$rows=$stmt->fetchAll();
$title='รายการแจ้งซ่อมของฉัน'; include __DIR__.'/../includes/header.php';
?>
<div class="d-flex justify-content-between mb-3"><h3>รายการแจ้งซ่อมของฉัน</h3><a class="btn btn-primary" href="<?=BASE_URL?>user/create.php">+ แจ้งซ่อม</a></div>
<div class="card shadow-sm"><div class="table-responsive"><table class="table table-hover mb-0"><thead><tr><th>เลขที่</th><th>ปัญหา</th><th>ความเร่งด่วน</th><th>สถานะ</th><th>ช่าง</th><th></th></tr></thead><tbody>
<?php foreach($rows as $r): ?><tr><td><?=e($r['request_no'])?></td><td><?=e($r['description'])?></td><td><?=e($r['urgency'])?></td><td><span class="badge bg-secondary"><?=e($r['status'])?></span></td><td><?=e($r['tech']??'ยังไม่มอบหมาย')?></td><td><a class="btn btn-sm btn-outline-primary" href="<?=BASE_URL?>detail.php?id=<?=$r['id']?>">ดู</a></td></tr><?php endforeach; ?>
</tbody></table></div></div>
<?php include __DIR__.'/../includes/footer.php'; ?>
