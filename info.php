<?php
session_start();
if ($_SESSION['type'] != 'academic')  {
    print "<script>alert ('กรุณา Login ก่อน')</script>";
    print "<script>window.location='index.html';</script>";
}
include 'connect.php';
// log
date_default_timezone_set('Asia/Bangkok');
$date = new DateTime("now"); 
$LoginTime = $date->format('Y-m-d H:i:s');
$userLogin = $_SESSION["user"];
$ip = $_SERVER['REMOTE_ADDR'];

$sql_log = "INSERT into tbl_logdata values ('','$LoginTime','$userLogin','$ip','info academic')";
$result_log = $conn->query($sql_log);

$id = $_GET['id'];

$sql_info = "SELECT * FROM tbl_student,tbl_member_dep 
WHERE tbl_student.student_department = tbl_member_dep.member_dep_code and tbl_student.student_id = '$id'";
$result_info = $conn->query($sql_info);

if ($result_info) {
    $row = $result_info->fetch_assoc();
    $name = $row['student_pre_thai']." ".$row['student_name']." ".$row['student_surname'];
    $id_student = $row['student_id']  ;
    $dep_name = $row['member_dep_name'];
    $dep_major = $row['member_dep_major'];
    $dep_faculty  = $row['member_dep_faculty'];
    $dep_address  = $row['member_dep_address'];
}

// กำหนดหน้า
if (!isset($_GET['page'])) {
    $page = 1;
 }
 else {
    $page = $_GET['page'];
 }

 // เช็ค type user
 if (!isset($_POST['txtsearch']) && !isset($_GET['search'])) {

    $sql_count = "SELECT  *  FROM  tbl_score where student_id = '$id'";
        
    $result = $conn -> query($sql_count)  ;
    /* หาจำนวน Record ทั้งหมด */
    $total_records=mysqli_num_rows($result);
    $show_record = 10 ;
    $amountOfPage=(int)($total_records/$show_record) ;
    if($total_records%$show_record != 0) $amountOfPage++;
     
    $startRec = ($page*$show_record) - $show_record ;
     
    $sql_show = "SELECT  *  FROM  tbl_score where student_id = '$id'
    limit $startRec,$show_record";
}
// กรณีค้นหา get
else if (isset($_GET['search'])){
    $search = $_GET['search'];
        $sql_count = "SELECT  *  FROM  tbl_score where student_id = '$id'
        and (student_id like '%$search%' 
        or student_dep like '%$search%'
        or listening like '%$search%'
        or reading like '%$search%'
        or total like '%$search%'
        or train like '%$search%'
        or date like '%$search%')";
        
        $result = $conn -> query($sql_count)  ;
        /* หาจำนวน Record ทั้งหมด */
        $total_records=mysqli_num_rows($result);
        $show_record = 10 ;
        $amountOfPage=(int)($total_records/$show_record) ;
        if($total_records%$show_record != 0) $amountOfPage++;
     
        $startRec = ($page*$show_record) - $show_record ;
     
        $sql_show = "SELECT  *  FROM  tbl_score where student_id = '$id'
        and (student_id like '%$search%' 
        or student_dep like '%$search%'
        or listening like '%$search%'
        or reading like '%$search%'
        or total like '%$search%'
        or train like '%$search%'
        or date like '%$search%')
        limit $startRec,$show_record";
}
// กรณีค้นหา
else{
    $search = $_POST['txtsearch'];
        $sql_count = "SELECT  *  FROM  tbl_score where student_id = '$id'
        and (student_id like '%$search%' 
        or student_dep like '%$search%'
        or listening like '%$search%'
        or reading like '%$search%'
        or total like '%$search%'
        or train like '%$search%'
        or date like '%$search%')";
        
        $result = $conn -> query($sql_count)  ;
        /* หาจำนวน Record ทั้งหมด */
        $total_records=mysqli_num_rows($result);
        $show_record = 10 ;
        $amountOfPage=(int)($total_records/$show_record) ;
        if($total_records%$show_record != 0) $amountOfPage++;
     
        $startRec = ($page*$show_record) - $show_record ;
     
        $sql_show = "SELECT  *  FROM  tbl_score where student_id = '$id'
        and (student_id like '%$search%' 
        or student_dep like '%$search%'
        or listening like '%$search%'
        or reading like '%$search%'
        or total like '%$search%'
        or train like '%$search%'
        or date like '%$search%')
        limit $startRec,$show_record";
}

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
    <nav class="navbar navbar-primary bg-primary justify-content-between">
        <ul class="nav">
        <li class="nav-item">
            <a class="navbar-brand" href="academic_show.php">Regis Toeic</a>
        </li>
        <li class="nav-item">
            <a class="nav-link justify-content-start" href="academic_show.php">หน้าหลัก</a>
        </li>
        <li class="nav-item">
            <a class="nav-link justify-content-start" href="Editonly_academic.php?id=<?php print $type ?>">ข้อมูลผู้ใช้งาน</a>
        </li>
        </ul>
        <form class="form-inline" action="logout.php">
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
            <div class="card-header bg-info text-white">
                <div class="form-inline justify-content-between">
                    <h3>ข้อมูลนักศึกษา</h3>
                </div>
            </div>

            <!-- body -->
            <div class="card-body" style="display:flex; height: 170px;">
                <!-- <p class="text-center">
                    รหัส ::<?php print $id_student; ?> 
                    ชื่อ - นามสกุล ::<?php print $name; ?>
                    สาขา ::<?php print $dep_name; ?>
                    คณะ/โรงเรียน ::<?php print $dep_major; ?>
                    หลักสูตร ::<?php print $dep_faculty; ?>
                    สถานที่จัดการศึกษา ::<?php print $dep_address; ?>
                </p> -->

                <table class="table table-borderless text-white">
                    <tbody>
                        <tr>
                            <th scope="row" >รหัส : <?php print $id_student; ?> </th>
                            <th>ชื่อ - นามสกุล : <?php print $name; ?></th>
                        </tr>
                        <tr>
                            <th scope="row" >หลักสูตร : <?php print $dep_major; ?></th>
                            <th>คณะ/โรงเรียน : <?php print $dep_faculty; ?></th>
                        </tr>
                        <tr>
                            <th scope="row">สาขา : <?php print $dep_name; ?></th>
                            <th>สถานที่จัดการศึกษา : <?php print $dep_address; ?></th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- card 2 -->
        <div class="card bg-light text-dark text-left mt-3" style="text-align: center; border-radius: 25px;">
            
                <!-- head -->
                <div class="card-header bg-light text-dark">
                    <label class="form-label mr-sm-2" >
                            <h3>คะแนนสอบ</h3>
                    </label>
                    <div class="form-inline justify-content-between">
                       <!-- ค้นหา -->
                        <form action="info.php?id=<?php print $id;?>" id="serach_data" method="post" class="form-inline">
                            <label class="form-label mr-sm-2" for="inlineFormCheck">
                                ค้นหา
                            </label> 
                            <input class="form-control mr-sm-2" type="search" id="txt" name="txtsearch" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-primary my-sm-2" id="ts" type="submit">Search</button>
                            <!-- <button class="btn btn-outline-success mr-sm-2 " id="re" type="button" value="user_show2.php">Reset</button> -->
                            <a href="info.php?id=<?php print $id;?>" class="btn btn-outline-success">Reset</a>
                        </form> 
    
                        <!-- PDF -->
                        <!-- <form action="#" method="post" class="form-inline "> -->
                            <label class="form-label mr-sm-2" >
                                จำนวนคะแนนนักศึกษา ทั้งหมด  :: <?php print $total_records; ?>
                            </label>
                            <!-- <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">Export PDF</button> -->
                        <!-- </form>  -->
                    </div>
                    <div class="form-inline ">
                        <form action="" class="form-inline ">
                            <label class="form-label mr-sm-2" for="form-select">
                                หน้า
                            </label>
                            <select class="form-select" onchange='location = this.value;'>
                                <?php 
                                print "<option value='#'selected>" .$page ."</option>";
                                for ($i = 1 ; $i<=$amountOfPage ; $i++) { 
                                print "<option value='info.php?page=$i&id=$id&search=$search'>" .$i ."</option>";
                                } ?>
                            </select>
                        </form>
                    </div>
    
                    
                </div>

                <!-- body -->
                <div class="card-body" style="overflow-y: auto; display:flex; height: 500px;">
                    <table class="table table-primary table-striped table-hover" id="Tdata" style=" text-align: center;">
                        <thead>
                            <tr class="bg-primary">
                                <th scope="col" style="text-align: center; color:white">#</th>
                                <th scope="col" style=" text-align: center; color:white">Listening</th>
                                <th scope="col" style=" text-align: center; color:white">Reading</th>
                                <th scope="col" style=" text-align: center; color:white">Total</th>
                                <th scope="col" style=" text-align: center; color:white">ผ่านเงื่อนไขหรือข้อกำหนดการอบรมตามประกาศของมหาวิทยาลัย</th>
                                <th scope="col" style="text-align: center; color:white">วันที่นำส่ง</th>
                                <!-- <th scope="col" style=" text-align: center; color:white">รายละเอียด</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $result = $conn -> query($sql_show)  ;
                                if (mysqli_num_rows($result) !=0) {
                                    $p = ($page * 10)-9;
                                    while ($row = $result -> fetch_assoc()) { 
                                       $id = $row['student_id']  ;
                                        print "<TR><TD>" . $p ;
                                        print "</td><TD>" . $row['listening']  ;
                                        print "</td><TD>" . $row['reading'];
                                        print "</TD><TD>" .  $row['total'] . "</TD> ";
                                        print "</TD><TD>" .  $row['train'] . "</TD> ";
                                        print "</TD><TD>" .  $row['date'] . "</TD> ";
                                        // print "</TD><TD>" .  $row['member_dep_address'] . "</TD> ";
                                        print "</TD>
                                        </tr> ";
                                        $p++;
                                   }
                                }
                                elseif (mysqli_num_rows($result) ==0) {
                                    print "<script>alert('ไม่พบข้อมูล')</script>"; 
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    </div>
</body>

</html>

<script src="js/jquery-3.5.1.js"></script>
<!-- <script src="DataTables/media/js/jquery.js"></script>
<script src="DataTables/media/js/jquery.dataTables.min.js"></script> -->
<link rel="stylesheet" href="DataTables/media/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
