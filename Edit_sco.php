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

$sql_log = "INSERT into tbl_logdata values ('','$LoginTime','$userLogin','$ip','edit score')";
$result_log = $conn->query($sql_log);

$id = $_GET['id'];

$sql_info = "SELECT * FROM tbl_score 
WHERE  score_id = '$id'";
$result_info = $conn->query($sql_info);

if ($result_info) {
    $row = $result_info->fetch_assoc();
    $id_student = $row['student_id'];
    $listening = $row['listening'];
    $reading = $row['reading'];
    $total  = $row['total'];
    $train  = $row['train'];
    $date  = $row['date'];
}

// กำหนดหน้า
// if (!isset($_GET['page'])) {
//     $page = 1;
//  }
//  else {
//     $page = $_GET['page'];
//  }

 // เช็ค type user
//  if (!isset($_POST['txtsearch'])) {

//     $sql_count = "SELECT  *  FROM  tbl_score where student_id = '$id'";
        
//     $result = $conn -> query($sql_count)  ;
//     /* หาจำนวน Record ทั้งหมด */
//     $total_records=mysqli_num_rows($result);
//     $show_record = 10 ;
//     $amountOfPage=(int)($total_records/$show_record) ;
//     if($total_records%$show_record != 0) $amountOfPage++;
     
//     $startRec = ($page*$show_record) - $show_record ;
     
//     $sql_show = "SELECT  *  FROM  tbl_score where student_id = '$id'
//     limit $startRec,$show_record";
// }
// // กรณีค้นหา
// else{
//     $search = $_POST['txtsearch'];
//         $sql_count = "SELECT  *  FROM  tbl_score where student_id = '$id'";
        
//         $result = $conn -> query($sql_count)  ;
//         /* หาจำนวน Record ทั้งหมด */
//         $total_records=mysqli_num_rows($result);
//         $show_record = 10 ;
//         $amountOfPage=(int)($total_records/$show_record) ;
//         if($total_records%$show_record != 0) $amountOfPage++;
     
//         $startRec = ($page*$show_record) - $show_record ;
     
//         $sql_show = "SELECT  *  FROM  tbl_score where student_id = '$id' limit $startRec,$show_record";
// }



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="js/jquery-3.5.1.js"></script>
    <!-- <script src="DataTables/media/js/jquery.js"></script>
    <script src="DataTables/media/js/jquery.dataTables.min.js"></script> -->
    <link rel="stylesheet" href="DataTables/media/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>

    <link rel="stylesheet" href="./style.css">
    <title>Score</title>
</head>

<body>
    <!-- nav bar -->
    <nav class="navbar navbar-primary bg-primary ">
    <ul class="nav">
        <li class="nav-item">
            <a class="navbar-brand" href="admin_show.php">Regis Toeic</a>
        </li>
        <li class="nav-item">
            <a class="nav-link justify-content-start" href="admin_show.php">หน้าหลัก</a>
        </li>
        <li class="nav-item">
            <a class="nav-link justify-content-start" href="dep.php">หลักสูตร/สาขาวิชา</a>
        </li>
       <li class="nav-item">
            <a class="nav-link justify-content-start" href="add_m.php">ข้อมูลผู้ใช้งาน</a>
        </li>
        <li class="nav-item">
            <a class="nav-link justify-content-start" href="log_show.php">ข้อมูลการใช้งาน</a>
        </li>
        </ul>

        <form class="form-inline" action="logout.php" class="justify-content-end">
            <label class="form-label mr-sm-2" >
                ผู้ใช้งานระบบ : <?php print $_SESSION["user"]; ?>
            </label>
            <button class="btn btn btn-danger my-2 my-sm-0" type="submit">Logout</button>
        </form>
    </nav>

    <!-- card -->
    <div class="container-fluid mt-0 pt-3" style="text-align: center; border-radius: 25px;">
        <div class="card bg-info text-white text-left p-3" style="text-align: center; border-radius: 25px;">
            <!-- head -->
            <div class="card-header bg-info text-white justify-content-between">
                <div class="form-inline justify-content-between">
                    <h3>แก้ไขข้อมูลคะแนนของ <?php print $id_student?> </h3>

                    <form method="post" action="Up_sco.php?id=<?php print $id?>" class="form-inline ">
                            <button class="btn btn-success my-2 my-sm-0" type="submit" name="txtid" value="<?php print $id_student?>" >บันทึก</button>
                    
                </div>


            </div>

            <!-- body -->
                <table class="table table-borderless text-white">
                    <tbody>
                      
                        <tr>
                            <th scope="row" >
                            listening : <input type="text" class="form-control" name="txtlistening" value="<?php print $listening; ?>"></th>
                            <th scope="row" >
                            reading :  <input type="text" class="form-control" name="txtreading" value="<?php print $reading; ?>">
                       </th>
                        </tr>
                        <tr>
                            <th scope="row">
                            total : <input type="text" class="form-control" name="txttotal" value="<?php print $total; ?>"></th>
                            <th scope="row">
                            ผ่านเงื่อนไขหรือข้อกำหนดการอบรมตามประกาศของมหาวิทยาลัย : <input type="text" class="form-control" name="txttrain" value="<?php print $train; ?>"></th>

                        </tr>
                        <tr>
                            <th scope="row">
                            วันที่นำส่ง : <input type="text" class="form-control" name="txtdate" value="<?php print $date; ?>"></th>
                            
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>