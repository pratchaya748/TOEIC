<?php
include 'connect.php';

$member_username = $_POST['txtmember_username'] ;
$member_name = $_POST['txtmember_name'] ;
$member_password = $_POST['txtmember_password'] ;
$member_mail = $_POST['txtmember_mail'] ;
$member_card_id = $_POST['txtmember_card_id'] ;
$depcode =$_POST['txtdepcode'];
$typecode =$_POST['txttypecode'];



date_default_timezone_set("Asia/Bangkok");
$date = new DateTime("now"); 
$LoginTime = $date->format('Y-m-d H:i:s');


$sql_search = "SELECT  *  FROM  tbl_member where member_username like '$member_username'";

$result_search = $conn -> query($sql_search)  ;
$row_count = mysqli_num_rows($result_search);
print  $row_count ;
if ($row_count > 0)  {
     print "<script>alert ('ข้อมูลผู้ใช้ ซ้ำในฐานข้อมูล ไม่สามารถเพิ่มได้ กรุณาตรวจสอบ')</script>";
       print "<script>window.location='add_m.php';</script>";
}
else {
  $sql = "INSERT INTO tbl_member (member_username, member_password, member_name, member_mail, member_card_id ,member_type, member_active, member_department, member_create_date)
            VALUES ('$member_username', '$member_password', '$member_name', '$member_mail', '$member_card_id', '$typecode', 'active', '$depcode', '$LoginTime')";
    $result = $conn -> query($sql)  ;
    if ($result) {
    print "<script>alert ('เพิ่มผู้ใช้งานสำเร็จ')</script>";
    print "<script>window.location='add_m.php';</script>";
    }
    else {
       echo $conn -> error ; 
       print "กรุณาติดต่อ ผู้ดูแลระบบ" ;
    }
}


?>