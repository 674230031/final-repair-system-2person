<?php
require_once __DIR__ . '/../config/config.php';
require_role(['technician','admin']);
if($_SERVER['REQUEST_METHOD']==='POST'){
    $id=(int)$_POST['id'];$action=$_POST['action'];
    if($action==='accept') $pdo->prepare("UPDATE repair_requests SET assigned_to=?,status='accepted' WHERE id=? AND (assigned_to IS NULL OR assigned_to=?)")->execute([$_SESSION['user']['id'],$id,$_SESSION['user']['id']]);
    if($action==='start') $pdo->prepare("UPDATE repair_requests SET status='in_progress' WHERE id=? AND assigned_to=?")->execute([$id,$_SESSION['user']['id']]);
    if($action==='complete'){
        $pdo->prepare("UPDATE repair_requests SET status='completed',result=?,cost=?,completion_date=NOW() WHERE id=? AND assigned_to=?")->execute([trim($_POST['result']),max(0,(float)$_POST['cost']),$id,$_SESSION['user']['id']]);
    }
    flash('success','อัปเดตงานเรียบร้อย');redirect(BASE_URL.'technician/list.php');
}
if($_SESSION['user']['role']==='admin') $rows=$pdo->query("SELECT r.*,u.fullname requester,t.fullname tech FROM repair_requests r JOIN users u ON r.user_id=u.id LEFT JOIN users t ON r.assigned_to=t.id ORDER BY r.created_at DESC")->fetchAll();
else {$q=$pdo->prepare("SELECT r.*,u.fullname requester FROM repair_requests r JOIN users u ON r.user_id=u.id WHERE r.assigned_to=? OR r.assigned_to IS NULL ORDER BY r.created_at DESC");$q->execute([$_SESSION['user']['id']]);$rows=$q->fetchAll();}
$title='งานช่าง'; include __DIR__.'/../includes/header.php';
?>
<h3 class="mb-3">รายการงานช่าง</h3>
<div class="card shadow-sm"><div class="table-responsive"><table class="table table-hover mb-0"><thead><tr><th>เลขที่</th><th>ผู้แจ้ง</th><th>สถานะ</th><th>รายละเอียด</th><th>จัดการ</th></tr></thead><tbody>
<?php foreach($rows as $r): ?><tr><td><?=e($r['request_no'])?></td><td><?=e($r['requester'])?></td><td><?=e($r['status'])?></td><td><?=e(mb_strimwidth($r['description'],0,55,'...'))?></td><td>
<a class="btn btn-sm btn-outline-primary mb-1" href="<?=BASE_URL?>detail.php?id=<?=$r['id']?>">ดู</a>
<?php if($r['status']==='pending' && !$r['assigned_to']): ?><form method="post" class="d-inline"><input type="hidden" name="id" value="<?=$r['id']?>"><input type="hidden" name="action" value="accept"><button class="btn btn-sm btn-success">รับงาน</button></form><?php endif; ?>
<?php if($r['status']==='accepted' && ($r['assigned_to']==$_SESSION['user']['id'])): ?><form method="post" class="d-inline"><input type="hidden" name="id" value="<?=$r['id']?>"><input type="hidden" name="action" value="start"><button class="btn btn-sm btn-warning">เริ่มซ่อม</button></form><?php endif; ?>
</td></tr><?php endforeach; ?>
</tbody></table></div></div>
<?php include __DIR__.'/../includes/footer.php'; ?>
