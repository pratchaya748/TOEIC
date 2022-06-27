<?php
  session_start();
  if ( $_SESSION['permission'] != 'admin')  {
	print "<script>alert ('กรุณา Login ก่อน')</script>";
    print "<script>window.location='index.html';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>

<body>
	<meta charset="UTF-8">
	<?php
	session_start();
	$con = mysqli_connect("localhost", "root", "", "regisdoc_db");
	//ตรวจสอบถ้าว่างให้เด้งไปหน้าหลักและไม่แก้ไขข้อมูล


	//สร้างตัวแปรสำหรับรับค่าที่นำมาแก้ไขจากฟอร์ม
	$imgname = $_FILES["txtFile"]["name"];
	$document_name = $_POST["doc_name"];
	$date_create = $_POST["doc_creat"];
	$date_update = $_POST["doc_update"];
	$user_create	= $_POST["id_create"];
	$user_update = $_POST["id_update"];
	$date = date("d/m/Y");
	$dot = pathinfo($imgname,PATHINFO_EXTENSION); 
	$rannum = rand(0,10000);
	$newname = date("yHmdis").$rannum;
	$FileName= $newname.".".$dot;
	$filena = $_FILES['txtFile']['tmp_name'];
	$document_id = $_SESSION['id_doc'];

	//ทำการปรับปรุงข้อมูลที่จะแก้ไขลงใน database 

	if ($imgname == '') {
		$sql = "UPDATE document SET  document_name='$document_name' , upload_user='$user_create', date_update='$date' WHERE document_id like '$document_id' ";
		$result = mysqli_query($con, $sql);
		print $sql;
		if ($result) {
			print "<script>alert('อัพเดทสำเร็จ')</script>";
        print "<script>window.location.href='admin_show.php'</script>";
		}
		else {
			print "<script>alert('เกิดข้อผิดพลาดกรุณาลองใหม่อีกครั้ง.')</script>";
			print "<script>window.location.href='admin_show.php'</script>";
		}
	} else {

		$sql = "UPDATE document SET  document_name='$document_name' ,document_type = '$dot', upload_user='$user_create', date_update='$date',doucument_file='$FileName' WHERE document_id like '$document_id' ";
		$result = mysqli_query($con, $sql);
		copy($filena,'document_database/'.$FileName);
		print $sql;
		if ($result) {
			print "<script>alert('อัพเดทสำเร็จ')</script>";
        print "<script>window.location.href='admin_show.php'</script>";
		}
		else {
			print "<script>alert('เกิดข้อผิดพลาดกรุณาลองใหม่อีกครั้ง.')</script>";
			print "<script>window.location.href='admin_show.php'</script>";
		}
	}
	?>
</body>

</html>