<?php
require_once __DIR__ . '/config/config.php';
require_login();
$role = $_SESSION['user']['role'];
$title = 'Dashboard';
if ($role === 'admin') {
    $stats = $pdo->query("SELECT status, COUNT(*) c FROM repair_requests GROUP BY status")->fetchAll();
    $map=[]; foreach($stats as $s)$map[$s['status']]=$s['c'];
    $total=(int)$pdo->query("SELECT COUNT(*) FROM repair_requests")->fetchColumn();
} elseif ($role === 'technician') {
    $id=$_SESSION['user']['id'];
    $st=$pdo->prepare("SELECT status,COUNT(*) c FROM repair_requests WHERE assigned_to=? GROUP BY status");$st->execute([$id]);
    $stats=$st->fetchAll();$map=[];foreach($stats as $s)$map[$s['status']]=$s['c'];
    $total=(int)$pdo->prepare("SELECT COUNT(*) FROM repair_requests WHERE assigned_to=?");
    $q=$pdo->prepare("SELECT COUNT(*) FROM repair_requests WHERE assigned_to=?");$q->execute([$id]);$total=(int)$q->fetchColumn();
} else {
    $q=$pdo->prepare("SELECT status,COUNT(*) c FROM repair_requests WHERE user_id=? GROUP BY status");$q->execute([$_SESSION['user']['id']]);
    $stats=$q->fetchAll();$map=[];foreach($stats as $s)$map[$s['status']]=$s['c'];
    $q=$pdo->prepare("SELECT COUNT(*) FROM repair_requests WHERE user_id=?");$q->execute([$_SESSION['user']['id']]);$total=(int)$q->fetchColumn();
}
include __DIR__ . '/includes/header.php';
?>
<h2 class="mb-4">Dashboard</h2>
<div class="row g-3">
<?php foreach([
['งานทั้งหมด',$total,'primary'],
['รอตรวจสอบ',$map['pending']??0,'warning'],
['กำลังดำเนินการ',$map['in_progress']??0,'info'],
['เสร็จแล้ว',$map['completed']??0,'success']
] as $s): ?>
<div class="col-md-3"><div class="card shadow-sm p-3 stat-card border-<?= $s[2] ?>"><div class="text-muted"><?= $s[0] ?></div><div class="display-6 fw-bold"><?= $s[1] ?></div></div></div>
<?php endforeach; ?>
</div>
<div class="card shadow-sm p-4 mt-4">
<h4>เมนูตามสิทธิ์</h4>
<?php if($role==='user'): ?><a class="btn btn-primary me-2" href="<?= BASE_URL ?>user/create.php">+ แจ้งซ่อมใหม่</a><a class="btn btn-outline-primary" href="<?= BASE_URL ?>user/list.php">ดูรายการของฉัน</a>
<?php elseif($role==='technician'): ?><a class="btn btn-primary" href="<?= BASE_URL ?>technician/list.php">ดูงานช่าง</a>
<?php else: ?><a class="btn btn-primary me-2" href="<?= BASE_URL ?>admin/repairs.php">ดูงานทั้งหมด</a><a class="btn btn-outline-primary" href="<?= BASE_URL ?>admin/users.php">จัดการผู้ใช้</a><?php endif; ?>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
