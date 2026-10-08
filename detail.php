<?php
require_once __DIR__.'/config/config.php';
require_login();
$id=(int)($_GET['id']??0);
$q=$pdo->prepare("SELECT r.*,u.fullname requester,t.fullname tech FROM repair_requests r JOIN users u ON r.user_id=u.id LEFT JOIN users t ON r.assigned_to=t.id WHERE r.id=?");$q->execute([$id]);$r=$q->fetch();
if(!$r) exit('ไม่พบรายการ');
if($_SESSION['user']['role']==='user' && $r['user_id']!=$_SESSION['user']['id']) exit('ไม่มีสิทธิ์');
$im=$pdo->prepare("SELECT * FROM repair_images WHERE repair_id=? ORDER BY uploaded_at");$im->execute([$id]);$images=$im->fetchAll();
$title='รายละเอียดงาน';include __DIR__.'/includes/header.php';
?>
<div class="card shadow-sm p-4"><div class="d-flex justify-content-between"><h3><?=e($r['request_no'])?></h3><span class="badge bg-primary align-self-start"><?=e($r['status'])?></span></div>
<div class="row g-3 mt-1">
<div class="col-md-6"><b>ผู้แจ้ง:</b> <?=e($r['requester'])?></div><div class="col-md-6"><b>ช่าง:</b> <?=e($r['tech']??'ยังไม่มอบหมาย')?></div>
<div class="col-md-6"><b>อาคาร:</b> <?=e($r['building'])?></div><div class="col-md-6"><b>ห้อง:</b> <?=e($r['room'])?></div>
<div class="col-md-6"><b>ประเภท:</b> <?=e($r['problem_type'])?></div><div class="col-md-6"><b>ความเร่งด่วน:</b> <?=e($r['urgency'])?></div>
<div class="col-12"><b>รายละเอียด:</b><div class="bg-light p-3 rounded"><?=nl2br(e($r['description']))?></div></div>
<div class="col-md-6"><b>ผลการซ่อม:</b> <?=e($r['result']??'-')?></div><div class="col-md-6"><b>ค่าใช้จ่าย:</b> <?=number_format((float)$r['cost'],2)?> บาท</div>
</div>
<?php if($images): ?><hr><h5>รูปภาพ</h5><div class="row"><?php foreach($images as $img): ?><div class="col-md-3"><img class="img-fluid preview-img mb-2" src="<?=BASE_URL?>uploads/<?=e($img['image_path'])?>"><div class="small"><?=e($img['image_type'])?></div></div><?php endforeach;?></div><?php endif;?>
<?php if(in_array($_SESSION['user']['role'],['technician','admin'],true) && $r['status']==='in_progress'): ?><a class="btn btn-success mt-3" href="<?=BASE_URL?>technician/complete.php?id=<?=$r['id']?>">บันทึกผลและปิดงาน</a><?php endif;?>
</div>
<?php include __DIR__.'/includes/footer.php'; ?>
