<?php
require_once __DIR__ . '/../config/config.php';
require_role(['user','admin']);
if($_SERVER['REQUEST_METHOD']==='POST'){
    $type=$_POST['problem_type']; $urg=$_POST['urgency'];
    $stmt=$pdo->prepare("INSERT INTO repair_requests(request_no,user_id,building,room,problem_type,description,urgency,status,created_at) VALUES(?,?,?,?,?,?,?,'pending',NOW())");
    $no='RP-'.date('Ym').'-'.str_pad((string)((int)$pdo->query("SELECT COUNT(*) FROM repair_requests")+1),3,'0',STR_PAD_LEFT);
    $stmt->execute([$no,$_SESSION['user']['id'],trim($_POST['building']),trim($_POST['room']),$type,trim($_POST['description']),$urg]);
    $id=(int)$pdo->lastInsertId();
    if(!empty($_FILES['image']['name']) && $_FILES['image']['error']===UPLOAD_ERR_OK){
        $allowed=['jpg','jpeg','png','webp']; $ext=strtolower(pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION));
        if(in_array($ext,$allowed,true) && $_FILES['image']['size']<=2*1024*1024){
            $name=uniqid('before_',true).'.'.$ext; move_uploaded_file($_FILES['image']['tmp_name'],__DIR__.'/../uploads/'.$name);
            $pdo->prepare("INSERT INTO repair_images(repair_id,image_type,image_path,uploaded_at) VALUES(?,?,?,NOW())")->execute([$id,'before',$name]);
        }
    }
    flash('success','แจ้งซ่อมเรียบร้อย เลขที่ '.$no); redirect(BASE_URL.'user/list.php');
}
$title='แจ้งซ่อม';
include __DIR__ . '/../includes/header.php';
?>
<div class="card shadow-sm p-4"><h3>แจ้งซ่อมใหม่</h3>
<form method="post" enctype="multipart/form-data">
<div class="row">
<div class="col-md-6 mb-3"><label>อาคาร</label><input name="building" class="form-control" required></div>
<div class="col-md-6 mb-3"><label>ห้อง</label><input name="room" class="form-control" required></div>
<div class="col-md-6 mb-3"><label>ประเภทปัญหา</label><select name="problem_type" class="form-select"><option value="electrical">ไฟฟ้า</option><option value="furniture">เฟอร์นิเจอร์</option><option value="computer">คอมพิวเตอร์</option><option value="aircon">เครื่องปรับอากาศ</option><option value="network">เครือข่าย</option><option value="other">อื่น ๆ</option></select></div>
<div class="col-md-6 mb-3"><label>ความเร่งด่วน</label><select name="urgency" class="form-select"><option value="low">ต่ำ</option><option value="medium">ปานกลาง</option><option value="high">สูง</option></select></div>
<div class="col-12 mb-3"><label>รายละเอียดปัญหา</label><textarea name="description" class="form-control" rows="5" required></textarea></div>
<div class="col-12 mb-3"><label>รูปก่อนซ่อม (ไม่เกิน 2MB)</label><input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png,.webp"></div>
</div>
<button class="btn btn-primary">ส่งแจ้งซ่อม</button>
</form></div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
