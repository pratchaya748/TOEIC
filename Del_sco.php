<?php 
session_start();
if ($_SESSION['type'] != 'admin')  {
    print "<script>alert ('กรุณา Login ก่อน')</script>";
    print "<script>window.location='login.html';</script>";
}
include 'connect.php';
// log
date_default_timezone_set('Asia/Bangkok');
$date = new DateTime("now"); 
$LoginTime = $date->format('Y-m-d H:i:s');
$userLogin = $_SESSION["user"];
$ip = $_SERVER['REMOTE_ADDR'];

$sql_log = "INSERT into tbl_logdata values ('','$LoginTime','$userLogin','$ip','delete score')";
$result_log = $conn->query($sql_log);

$id = $_GET['id'] ;
$sid = $_GET['sid'] ;
print $sid ;
$sql = "Delete FROM  tbl_score where score_id like '$id'";

$result = $conn -> query($sql)  ;

if ($result) {
  print "<script>alert ('ลบแล้วจ้า')</script>";
  print "<script>window.location='info_admin.php?id=$sid';</script>";
}
else {
   echo $conn -> error ; 
   print "กรุณาติดต่อ ผู้ดูแลระบบ" ;
}
?>


?>

