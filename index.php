<?php
require_once __DIR__ . '/config/config.php';
if (is_logged_in()) redirect(BASE_URL . 'dashboard.php');
$title = APP_NAME;
include __DIR__ . '/includes/header.php';
?>
<div class="hero p-5 mb-4">
<h1 class="display-6 fw-bold">ระบบแจ้งซ่อมและติดตามงานซ่อมออนไลน์</h1>
<p class="lead">แจ้งปัญหา ติดตามสถานะ มอบหมายงาน และบันทึกผลการซ่อมในระบบเดียว</p>
<a class="btn btn-light btn-lg" href="<?= BASE_URL ?>login.php">เข้าสู่ระบบ</a>
</div>
<div class="row g-4">
<div class="col-md-4"><div class="card shadow-sm p-4"><h4>แจ้งซ่อมออนไลน์</h4><p>ส่งรายละเอียดปัญหาและรูปภาพประกอบได้ง่าย</p></div></div>
<div class="col-md-4"><div class="card shadow-sm p-4"><h4>ติดตามสถานะ</h4><p>ตรวจสอบว่างานอยู่ขั้นตอนไหนแบบเป็นลำดับ</p></div></div>
<div class="col-md-4"><div class="card shadow-sm p-4"><h4>จัดการงานช่าง</h4><p>รับงาน บันทึกผล ค่าใช้จ่าย และรูปหลังซ่อม</p></div></div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
