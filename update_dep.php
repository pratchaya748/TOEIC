<?php 
session_start();
if ($_SESSION['type'] != 'admin')  {
    print "<script>alert ('กรุณา Login ก่อน')</script>";
    print "<script>window.location='index.html';</script>";
}
include 'connect.php';


$id = $_POST['txtid'] ;
$txtmajor = $_POST['txtmajor'] ;
$txtfaculty = $_POST['txtfaculty'] ;
$txtdepname = $_POST['txtdepname'] ;
$txtdepaddress = $_POST['txtdepaddress'] ;

print "$id" ;
print "$txtmajor";

$sql = "Update tbl_member_dep set  member_dep_name = '$txtdepname' , member_dep_major = '$txtmajor' , member_dep_faculty = '$txtfaculty', member_dep_address= '$txtdepaddress' where member_dep_code like '$id'";
$result = $conn -> query($sql)  ;

if ($result) {
  print "<script>alert ('แก้ไขแล้วครับผม')</script>";
  print "<script>window.location='dep.php';</script>";
}
else {
   echo $conn -> error ; 
   print "กรุณาติดต่อ ผู้ดูแลระบบ" ;
}
?>


?>