<?php
require_once __DIR__ . '/config/config.php';
if (is_logged_in()) redirect(BASE_URL . 'dashboard.php');
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username=? LIMIT 1");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        unset($user['password']);
        $_SESSION['user'] = $user;
        redirect(BASE_URL . 'dashboard.php');
    }
    $error = 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง';
}
$title = 'เข้าสู่ระบบ';
include __DIR__ . '/includes/header.php';
?>
<div class="row justify-content-center"><div class="col-md-5">
<div class="card shadow-sm p-4">
<h3 class="mb-3">เข้าสู่ระบบ</h3>
<?php if($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
<form method="post">
<label class="form-label">ชื่อผู้ใช้</label>
<input class="form-control mb-3" name="username" required>
<label class="form-label">รหัสผ่าน</label>
<input class="form-control mb-3" type="password" name="password" required>
<button class="btn btn-primary w-100">เข้าสู่ระบบ</button>
</form>
<hr>
<p class="small text-muted mb-0">บัญชีตัวอย่าง: admin/123456, teacher/123456, tech/123456</p>
</div></div></div>
<?php include __DIR__ . '/includes/footer.php'; ?>
