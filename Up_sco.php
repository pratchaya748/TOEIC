<?php 
session_start();
if ($_SESSION['type'] != 'admin')  {
    print "<script>alert ('กรุณา Login ก่อน')</script>";
    print "<script>window.location='index.html';</script>";
}
include 'connect.php';

$id = $_GET['id'];

$listening = $_POST['txtlistening'] ;
$reading= $_POST['txtreading'] ;
$total = $_POST['txttotal'] ;
$train = $_POST['txttrain'] ;
$date = $_POST['txtdate'] ;
$id_student = $_POST['txtid'] ;

$sql = "Update tbl_score set  listening = '$listening' , reading = '$reading' , total = '$total' 
, train = '$train' , date = '$date'  where score_id like '$id'";
$result = $conn -> query($sql)  ;

if ($result) {
  print "<script>alert ('แก้ไขแล้วครับผม)</script>";
  print "<script>window.location='info_admin.php?id=$id_student';</script>";
}
else {
   echo $conn -> error ; 
   print "กรุณาติดต่อ ผู้ดูแลระบบ" ;
}
?>
