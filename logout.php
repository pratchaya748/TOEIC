<?php session_start();
include "connect.php";
$tUser = $_SESSION["username"];
// print $tUser ;

// log
date_default_timezone_set('Asia/Bangkok');
$date = new DateTime("now"); 
$LoginTime = $date->format('Y-m-d H:i:s');
$userLogin = $_SESSION["user"];
$ip = $_SERVER['REMOTE_ADDR'];

$sql_log = "INSERT into tbl_logdata values ('','$LoginTime','$userLogin','$ip','edit department')";
$result_log = $conn->query($sql_log);

$sql_active = "UPDATE tbl_member SET member_active='inactive' WHERE member_username = '$tUser'";
$result_active = $conn->query($sql_active);

session_destroy();
print "<script>alert('Logout finish')</script>" ;
print "<script>window.location='index.html';</script>" ;
?>