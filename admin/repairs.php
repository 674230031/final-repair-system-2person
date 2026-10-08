<?php
require_once __DIR__ . '/../config/config.php';
require_role(['admin']);
$rows=$pdo->query("SELECT r.*,u.fullname requester,t.fullname tech FROM repair_requests r JOIN users u ON r.user_id=u.id LEFT JOIN users t ON r.assigned_to=t.id ORDER BY r.created_at DESC")->fetchAll();
$title='งานแจ้งซ่อมทั้งหมด';include __DIR__.'/../includes/header.php';
?>
<div class="d-flex justify-content-between mb-3"><h3>งานแจ้งซ่อมทั้งหมด</h3><button onclick="window.print()" class="btn btn-outline-secondary">พิมพ์รายงาน</button></div>
<div class="card shadow-sm"><div class="table-responsive"><table class="table table-hover"><thead><tr><th>เลขที่</th><th>ผู้แจ้ง</th><th>ประเภท</th><th>สถานะ</th><th>ช่าง</th><th>ค่าใช้จ่าย</th><th></th></tr></thead><tbody>
<?php foreach($rows as $r): ?><tr><td><?=e($r['request_no'])?></td><td><?=e($r['requester'])?></td><td><?=e($r['problem_type'])?></td><td><?=e($r['status'])?></td><td><?=e($r['tech']??'-')?></td><td><?=number_format((float)$r['cost'],2)?></td><td><a class="btn btn-sm btn-outline-primary" href="<?=BASE_URL?>detail.php?id=<?=$r['id']?>">รายละเอียด</a></td></tr><?php endforeach;?>
</tbody></table></div></div>
<?php include __DIR__.'/../includes/footer.php'; ?>
