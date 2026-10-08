<?php
require_once __DIR__ . '/../config/config.php';
require_role(['technician','admin']);
$id=(int)($_GET['id']??0);
$q=$pdo->prepare("SELECT * FROM repair_requests WHERE id=?");$q->execute([$id]);$r=$q->fetch();
if(!$r) exit('ไม่พบงาน');
if($_SERVER['REQUEST_METHOD']==='POST'){
    $pdo->prepare("UPDATE repair_requests SET status='completed',result=?,cost=?,completion_date=NOW() WHERE id=?")->execute([trim($_POST['result']),max(0,(float)$_POST['cost']),$id]);
    if(!empty($_FILES['image']['name']) && $_FILES['image']['error']===UPLOAD_ERR_OK){
        $ext=strtolower(pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION));$allowed=['jpg','jpeg','png','webp'];
        if(in_array($ext,$allowed,true)&&$_FILES['image']['size']<=2*1024*1024){$name=uniqid('after_',true).'.'.$ext;move_uploaded_file($_FILES['image']['tmp_name'],__DIR__.'/../uploads/'.$name);$pdo->prepare("INSERT INTO repair_images(repair_id,image_type,image_path,uploaded_at) VALUES(?,?,?,NOW())")->execute([$id,'after',$name]);}
    }
    flash('success','บันทึกผลการซ่อมแล้ว');redirect(BASE_URL.'technician/list.php');
}
$title='บันทึกผลการซ่อม';include __DIR__.'/../includes/header.php';
?>
<div class="card shadow-sm p-4"><h3>บันทึกผลการซ่อม <?=e($r['request_no'])?></h3>
<form method="post" enctype="multipart/form-data">
<label>ผลการซ่อม</label><textarea name="result" class="form-control mb-3" rows="5" required></textarea>
<label>ค่าใช้จ่าย (บาท)</label><input type="number" step="0.01" min="0" name="cost" class="form-control mb-3" value="0">
<label>รูปหลังซ่อม</label><input type="file" name="image" class="form-control mb-3" accept=".jpg,.jpeg,.png,.webp">
<button class="btn btn-success">บันทึกและปิดงาน</button>
</form></div>
<?php include __DIR__.'/../includes/footer.php'; ?>
