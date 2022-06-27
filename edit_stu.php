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

$sql_log = "INSERT into tbl_logdata values ('','$LoginTime','$userLogin','$ip','edit student')";
$result_log = $conn->query($sql_log);

$id = $_GET['id'];

$sql_info = "SELECT * FROM tbl_student,tbl_member_dep 
WHERE tbl_student.student_department = tbl_member_dep.member_dep_code and tbl_student.student_id = '$id'";
$result_info = $conn->query($sql_info);
if ($result_info) {
    $row = $result_info->fetch_assoc();
    $name = $row['student_pre_thai']." ".$row['student_name']." ".$row['student_surname'];
    $Mname =$row['student_pre_thai'];
    $fname =$row['student_name'];
    $lname =$row['student_surname'];
    $MnameEn =$row['student_pre_eng'];
    $fnameEn =$row['student_name_eng'];
    $lnameEn =$row['student_surname_eng'];
    $id_student = $row['student_id']  ;
    $dep_name = $row['member_dep_name'];
    $dep_major = $row['member_dep_major'];
    $dep_faculty  = $row['member_dep_faculty'];
    $dep_address  = $row['member_dep_address'];
    $dep_code =$row["member_dep_code"];
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
                    <h3>ข้อมูลนักศึกษา รหัส : <?php print $id_student; ?> </h3>

                    <form method="post" action="update.php?id=<?php print $id?>"  name="txtid" class="form-inline ">
                            <button class="btn btn-success my-2 my-sm-0" type="submit">บันทึก</button>
                    
                </div>


            </div>

            <!-- body -->
                <table class="table table-borderless text-white">
                    <tbody>
                        <tr>
                            <th scope="row">
                            <label class="form-label mr-sm-2" for="inlineFormCheck">
                                คำนำหน้าชื่่อ : 
                                </label>
                                <input type="text" class="form-control" name="txtMname" value="<?php print $Mname; ?>">
                             </th>
                             <th scope="row">
                            <label class="form-label mr-sm-2" for="inlineFormCheck">
                                ชื่อจริง : 
                                </label>
                                <input type="text" class="form-control" name="txtfname" value="<?php print $fname; ?>">
                             </th>
                             <th scope="row">
                            <label class="form-label mr-sm-2" for="inlineFormCheck">
                                นามสกุล : 
                                </label>
                                <input type="text" class="form-control" name="txtlname" value="<?php print $lname; ?>">
                             </th>
                        </tr>
                        <tr>
                        <th scope="row">
                            <label class="form-label mr-sm-2" for="inlineFormCheck">
                                คำนำหน้าชื่่อ : 
                                </label>
                                <input type="text" class="form-control" name="txtMnameEn" value="<?php print $MnameEn; ?>">
                             </th>
                             <th scope="row">
                            <label class="form-label mr-sm-2" for="inlineFormCheck">
                                ชื่อจริง : 
                                </label>
                                <input type="text" class="form-control" name="txtfnameEn" value="<?php print $fnameEn; ?>">
                             </th>
                             <th scope="row">
                            <label class="form-label mr-sm-2" for="inlineFormCheck">
                                นามสกุล : 
                                </label>
                                <input type="text" class="form-control" name="txtlnameEn" value="<?php print $lnameEn; ?>">
                             </th>
                        </tr>
                        <tr>
                            <th scope="row">สาขา : 
                            </div>
                           
                           
                            <?php $sql1 = "SELECT * FROM tbl_member_dep ";
                            $result1 = $conn->query($sql1);
                            if ($result1) {
                                
                                $dep_name = $row['member_dep_name'];
                                $dep_major = $row['member_dep_major'];
                                $dep_faculty  = $row['member_dep_faculty'];
                                $dep_address  = $row['member_dep_address'];
                                $dep_code =$row["member_dep_code"];
                                $Full = $row['member_dep_name']." ".$row['member_dep_major']." ".$row['member_dep_faculty']."".$row['member_dep_address'];
                            }?> 
                    
                        <select name="txtdepcode" class="form-control" required>
                            <option value=""><?php print $Full; ?></option>
                            <?php foreach($result1 as $results){?>
                            <option value="<?php echo $results["member_dep_code"];?>">
                            
                            <?php echo $results["member_dep_name"]." ".$results["member_dep_major"]." ".$results["member_dep_faculty"]." ".$results["member_dep_address"]; ?>
                            </option>
                            <?php } ?>
                        </select>
                        
                        </div>
			            
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>