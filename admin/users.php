<?php
require_once __DIR__ . '/../config/config.php';
require_role(['admin']);
if($_SERVER['REQUEST_METHOD']==='POST'){
    $hash=password_hash($_POST['password'],PASSWORD_DEFAULT);
    $pdo->prepare("INSERT INTO users(username,password,fullname,role,email,created_at) VALUES(?,?,?,?,?,NOW())")->execute([trim($_POST['username']),$hash,trim($_POST['fullname']),$_POST['role'],trim($_POST['email'])]);
    flash('success','เพิ่มผู้ใช้แล้ว');redirect(BASE_URL.'admin/users.php');
}
$rows=$pdo->query("SELECT id,username,fullname,role,email,created_at FROM users ORDER BY id DESC")->fetchAll();
$title='จัดการผู้ใช้';include __DIR__.'/../includes/header.php';
?>
<div class="row g-4"><div class="col-md-5"><div class="card shadow-sm p-4"><h4>เพิ่มผู้ใช้</h4><form method="post">
<input class="form-control mb-2" name="username" placeholder="Username" required><input class="form-control mb-2" name="password" type="password" placeholder="Password" required><input class="form-control mb-2" name="fullname" placeholder="ชื่อ-นามสกุล" required><input class="form-control mb-2" name="email" type="email" placeholder="Email">
<select name="role" class="form-select mb-3"><option value="user">ผู้แจ้ง</option><option value="technician">ช่าง</option><option value="admin">Admin</option></select><button class="btn btn-primary">เพิ่มผู้ใช้</button></form></div></div>
<div class="col-md-7"><div class="card shadow-sm"><div class="table-responsive"><table class="table mb-0"><thead><tr><th>User</th><th>ชื่อ</th><th>Role</th><th>Email</th></tr></thead><tbody><?php foreach($rows as $r): ?><tr><td><?=e($r['username'])?></td><td><?=e($r['fullname'])?></td><td><?=e($r['role'])?></td><td><?=e($r['email'])?></td></tr><?php endforeach;?></tbody></table></div></div></div></div>
<?php include __DIR__.'/../includes/footer.php'; ?>
