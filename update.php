<?php 
session_start();
if ($_SESSION['type'] != 'admin')  {
    print "<script>alert ('กรุณา Login ก่อน')</script>";
    print "<script>window.location='index.html';</script>";
}
include 'connect.php';

$id = $_GET['id'];
$Mname = $_POST['txtMname'] ;
$fname = $_POST['txtfname'] ;
$lname = $_POST['txtlname'] ;
$MnameEn = $_POST['txtMnameEn'] ;
$fnameEn = $_POST['txtfnameEn'] ;
$lnameEn = $_POST['txtlnameEn'] ;
$depcode =$_POST['txtdepcode'];

$sql = "Update tbl_student set  student_pre_thai = '$Mname' , student_name = '$fname' , student_surname = '$lname' 
, student_pre_eng = '$MnameEn' , student_name_eng = '$fnameEn' , student_surname_eng = '$lnameEn' 
, student_department = '$depcode' where student_id like '$id'";
$result = $conn -> query($sql)  ;

if ($result) {
  print "<script>alert ('แก้ไขแล้วครับผม)</script>";
  print "<script>window.location='info_admin.php?id=$id';</script>";
}
else {
   echo $conn -> error ; 
   print "กรุณาติดต่อ ผู้ดูแลระบบ" ;
}
?>



