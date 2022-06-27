<!--logon-->
<?php
include "connect.php";
session_start();

$tUser = $_POST['tUser'];
$tPass = $_POST['tPass'];

$sql = "SELECT * FROM userdb where user_username like '$tUser' and user_password like '$tPass'";

$sql = "SELECT tbl_member.member_username,tbl_member.member_password,tbl_member.member_name,tbl_member.member_active,
tbl_member_type.member_type_name,

tbl_member_dep.member_dep_name,tbl_member_dep.member_dep_major,tbl_member_dep.member_dep_faculty,tbl_member_dep.member_dep_address
FROM tbl_member,tbl_member_dep,tbl_member_type
WHERE 
tbl_member.member_username like '$tUser' and tbl_member.member_password like '$tPass'
AND tbl_member.member_type = tbl_member_type.member_type_code 
AND tbl_member.member_department = tbl_member_dep.member_dep_code";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION["username"] = $tUser;
    $_SESSION["user"] = $row['member_name'];
    $active = $row['member_active'];
    $_SESSION["type"] = $row['member_type_name'];
    $_SESSION["dep_name"] = $row['member_dep_name'];
    $_SESSION["dep_major"] = $row['member_dep_major'];
    $_SESSION["dep_faculty"] = $row['member_dep_faculty'];
    $_SESSION["dep_address"] = $row['member_dep_address'];
    // $_SESSION[""] = $row[''];

    // date_default_timezone_set('date_default_timezone_set');
    // $date = new DateTime("now");
    // $LoginTime = $date->format('Y-m-d H:i:s');
    // $userLogin = $_SESSION["username"];

    // log
    date_default_timezone_set('Asia/Bangkok');
    $date = new DateTime("now"); 
    $LoginTime = $date->format('Y-m-d H:i:s');
    $userLogin = $_SESSION["user"];
    $ip = $_SERVER['REMOTE_ADDR'];

    $sql_log = "INSERT into tbl_logdata values ('','$LoginTime','$userLogin','$ip','edit department')";
    $result_log = $conn->query($sql_log);

    // $sql_log = "INSERT into log_user values ('','$LoginTime','$ip','$userLogin','Login')";
    // $result_log = $conn->query($sql_log);

    $sql_active = "UPDATE tbl_member SET member_active='active' WHERE member_username = '$tUser'";
    $result_active = $conn->query($sql_active);

    if ($row['member_type_name'] == 'admin') {
        print "<script>window.location.href='admin_show.php'</script>";
    } 
    elseif ($row['member_type_name'] == 'academic') {
        print "<script>window.location.href='academic_show.php'</script>";
    }
    else {
        print "<script>window.location.href='user_show.php'</script>";
    }
} else {
    print "<script>alert('Incorrect user or password.')</script>";
    print "<script>window.location.href='index.html'</script>";
}
$result->free_result();
$conn->close();

?>