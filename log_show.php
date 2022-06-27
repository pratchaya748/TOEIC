<?php
session_start();

if ($_SESSION['type'] != 'admin')  {
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

$sql_log = "INSERT into tbl_logdata values ('','$LoginTime','$userLogin','$ip','log show')";
$result_log = $conn->query($sql_log);

// กำหนดหน้า
if (!isset($_GET['page'])) {
    $page = 1;
 }
 else {
    $page = $_GET['page'];
 }

 // เช็ค type user
 if (!isset($_POST['txtsearch']) && !isset($_GET['search'])) {
        $sql_count = "SELECT  *  FROM  tbl_logdata ORDER BY logdata_time DESC";
        
        $result = $conn -> query($sql_count)  ;
        /* หาจำนวน Record ทั้งหมด */
        $total_records=mysqli_num_rows($result);
        $show_record = 10 ;
        $amountOfPage=(int)($total_records/$show_record) ;
        if($total_records%$show_record != 0) $amountOfPage++;
     
        $startRec = ($page*$show_record) - $show_record ;
     
        $sql_show = "SELECT  *  FROM  tbl_logdata ORDER BY logdata_time DESC
        limit $startRec,$show_record ";
        
}
// กรณีค้นหา get
else if (isset($_GET['search'])) {
    // print "<script>alert ('search get')</script>";

    $search = $_GET['search'];
    $sql_count = "SELECT  *  FROM  tbl_logdata  
    where  (logdata_time like '%$search%' 
    or logdata_username like '%$search%'
    or logdata_ip like '%$search%'
    or logdata_doing like '%$search%') ORDER BY logdata_time DESC";
    
    $result = $conn -> query($sql_count)  ;
    /* หาจำนวน Record ทั้งหมด */
    $total_records=mysqli_num_rows($result);
    $show_record = 10 ;
    $amountOfPage=(int)($total_records/$show_record) ;
    if($total_records%$show_record != 0) $amountOfPage++;
 
    $startRec = ($page*$show_record) - $show_record ;
 
    $sql_show = "SELECT  *  FROM  tbl_logdata  
    where  (logdata_time like '%$search%' 
    or logdata_username like '%$search%'
    or logdata_ip like '%$search%'
    or logdata_doing like '%$search%') ORDER BY logdata_time DESC limit $startRec,$show_record";
}
// กรณีค้นหา
else{
        $search = $_POST['txtsearch'];
        $sql_count = "SELECT  *  FROM  tbl_logdata  
        where  (logdata_time like '%$search%' 
        or logdata_username like '%$search%'
        or logdata_ip like '%$search%'
        or logdata_doing like '%$search%') ORDER BY logdata_time DESC";
        
        $result = $conn -> query($sql_count)  ;
        /* หาจำนวน Record ทั้งหมด */
        $total_records=mysqli_num_rows($result);
        $show_record = 10 ;
        $amountOfPage=(int)($total_records/$show_record) ;
        if($total_records%$show_record != 0) $amountOfPage++;
     
        $startRec = ($page*$show_record) - $show_record ;
     
        $sql_show = "SELECT  *  FROM  tbl_logdata  
        where  (logdata_time like '%$search%' 
        or logdata_username like '%$search%'
        or logdata_ip like '%$search%'
        or logdata_doing like '%$search%') ORDER BY logdata_time DESC limit $startRec,$show_record";
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
    <title>Home</title>
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
        <div class="card bg-light text-dark text-left p-3" style="text-align: center; border-radius: 25px;">

            <div class="card-header bg-light text-dark">
                <div class="form-inline justify-content-between">
                   <!-- ค้นหา -->
                    <form action="log_show.php" id="serach_data" method="post" class="form-inline">
                        <label class="form-label mr-sm-2" for="inlineFormCheck">
                            ค้นหา
                        </label>
                        <input class="form-control mr-sm-2" type="search" id="txt" name="txtsearch" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-primary my-sm-2" id="ts" type="submit">Search</button>
                        <!-- <button class="btn btn-outline-success mr-sm-2 " id="re" type="button" value="user_show2.php">Reset</button> -->
                        <a href="log_show.php" class="btn btn-outline-success">Reset</a>
                    </form>

                    <!-- PDF -->
                    <!-- <form action="#" method="post" class="form-inline ">
                        <label class="form-label mr-sm-2" >
                            จำนวนนักศึกษา ทั้งหมด  :: <?php //print $total_records; ?>
                        </label>
                        <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">Export PDF</button>
                    </form>  -->
                </div>

                <div class="form-inline justify-content-between">
                    <form action="log_show.php" method="POST" class="form-inline ">
                        <!-- หน้า -->
                        <label class="form-label mr-sm-2" for="form-select">
                            หน้า
                        </label>
                        <select class="form-select mr-sm-3" onchange='location = this.value;'>
                            <?php 
                            print "<option value='#'selected>" .$page ."</option>";
                            for ($i = 1 ; $i<=$amountOfPage ; $i++) {
                            print "<option value='log_show.php?page=$i&search=$search'>" .$i."</option>";
                            } ?>
                        </select>
                        
                        <!-- ค้นหาจากปี -->
                        <!-- <label class="form-label mr-sm-2" for="txt">
                            ปีการศึกษา
                        </label>
                        <select class="form-select mr-sm-5" onchange='location = this.value;'>
                            <?php 
                            // print "<option value='#'selected>" .$year ."</option>";
                            // while ($row = $result_year -> fetch_assoc()) {
                            //     $year = $row['year'];
                            //     print "<option value='log_show.php?year=$year'>" .$year ."</option>";
                            // } ?>
                        </select> -->
                    </form>
                    <!-- <form action="" class="form-inline ">
                        <button class="btn btn-success my-2 my-sm-0" type="submit">เพิ่มข้อมูลนักศึกษา</button>
                    </form> -->
                </div>

                
            </div>
            <div class="card-body" style="overflow-y: auto; display:flex; height: 500px;">
                <table class="table table-primary table-striped table-hover" id="Tdata" style=" text-align: center;">
                    <thead>
                        <tr class="bg-primary">
                            <th scope="col" style="text-align: center; color:white">#</th>
                            <th scope="col" style="text-align: center; color:white">วันที่และเวลา</th>
                            <th scope="col" style=" text-align: center; color:white">ผู้เข้าใช้</th>
                            <th scope="col" style=" text-align: center; color:white">เลข IP ผู้เข้าใช้</th>
                            <th scope="col" style=" text-align: center; color:white">หน้าที่เข้าใช้งาน</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $result = $conn -> query($sql_show)  ;
                            if (mysqli_num_rows($result) !=0) {
                                $p = ($page * 10)-9;

                               while ($row = $result -> fetch_assoc()) { 
                                //    $id = $row['student_id']  ;
                                //    $_SESSION["id"] = $id;
                                //    $major_name = $row['member_dep_major']." / ".$row['member_dep_name'];
                                    print "<TR><TD>" . $p ;
                                    print "</td><TD>" . $row['logdata_time']  ;
                                    print "</td><TD>" . $row['logdata_username'];
                                    print "</TD><TD>" .  $row['logdata_ip'] . "</TD> ";
                                    print "<TD>" .  $row['logdata_doing'] . "</TD> ";
                                    print "</tr>";
                                    $p++;
                               }
                            }
                            elseif (mysqli_num_rows($result) ==0) {
                                print "<script>alert('ไม่พบข้อมูล')</script>"; 
                                print "<script>window.location='log_show.php';</script>";
                            }
                        ?>
                    </tbody>
                </table>
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

<script>
    $(function() {

    });
</script>