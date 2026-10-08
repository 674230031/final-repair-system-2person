<?php require_once __DIR__ . '/../config/config.php'; ?>
<!doctype html>
<html lang="th">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($title ?? APP_NAME) ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
<div class="container">
<a class="navbar-brand fw-bold" href="<?= BASE_URL ?>">Repair System</a>
<button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav"><span class="navbar-toggler-icon"></span></button>
<div class="collapse navbar-collapse" id="nav">
<ul class="navbar-nav ms-auto">
<?php if (is_logged_in()): ?>
<li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>dashboard.php">Dashboard</a></li>
<?php if ($_SESSION['user']['role'] === 'user'): ?>
<li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>user/create.php">แจ้งซ่อม</a></li>
<li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>user/list.php">รายการของฉัน</a></li>
<?php elseif ($_SESSION['user']['role'] === 'technician'): ?>
<li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>technician/list.php">งานช่าง</a></li>
<?php elseif ($_SESSION['user']['role'] === 'admin'): ?>
<li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>admin/users.php">จัดการผู้ใช้</a></li>
<li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>admin/repairs.php">งานทั้งหมด</a></li>
<?php endif; ?>
<li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>logout.php">ออกจากระบบ</a></li>
<?php else: ?>
<li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>login.php">เข้าสู่ระบบ</a></li>
<?php endif; ?>
</ul>
</div>
</div>
</nav>
<main class="container py-4">
<?php if ($msg = flash('success')): ?><div class="alert alert-success"><?= e($msg) ?></div><?php endif; ?>
<?php if ($msg = flash('error')): ?><div class="alert alert-danger"><?= e($msg) ?></div><?php endif; ?>
