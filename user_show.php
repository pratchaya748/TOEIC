<?php
session_start();
if ($_SESSION['type'] != 'faculty' && $_SESSION["type"] != "major")  {
    print "<script>alert ('กรุณา Login ก่อน')</script>";
    print "<script>window.location='login.html';</script>";
}
 $type =$_SESSION["username"];
include 'connect.php';

// search year
// $sql_year = "SELECT SUBSTRING(student_id, 1, 2) AS year FROM tbl_student GROUP BY SUBSTRING(student_id, 1, 2)";
// $result_year = $conn -> query($sql_year)  ;

// กำหนดหน้า
if (!isset($_GET['page'])) {
    $page = 1;
 }
 else {
    $page = $_GET['page'];
 }

 //  กำหนดปี
 if (!isset($_GET['year'])) {
    $year = "";
 }
 else {
    $year = $_GET['year'];
 }
 
 // เช็ค type user
 if (!isset($_POST['txtsearch']) && !isset($_GET['year']) && !isset($_GET['search'])) {
    // print "<script>alert ('index')</script>";
    
    if ($_SESSION["type"] == "major") {
        $major = $_SESSION["dep_major"];
        $faculty = $_SESSION["dep_faculty"];
        $dep_name = $_SESSION["dep_name"];
        $address = $_SESSION["dep_address"];

        // search year
        $sql_year = "SELECT SUBSTRING(tbl_student.student_id, 1, 2) AS year 
        FROM  tbl_student ,tbl_member_dep  
        where  tbl_student.student_department = tbl_member_dep.member_dep_code 
        and tbl_member_dep.member_dep_major like '$major' 
        and tbl_member_dep.member_dep_faculty like '$faculty'
        and tbl_member_dep.member_dep_name like '$dep_name'
        and tbl_member_dep.member_dep_address like '$address'
        GROUP BY SUBSTRING(tbl_student.student_id, 1, 2)";
        $result_year = $conn -> query($sql_year)  ;

        $sql_count = "SELECT  *  FROM  tbl_student ,tbl_member_dep  
        where  tbl_student.student_department = tbl_member_dep.member_dep_code 
        and tbl_member_dep.member_dep_major like '$major' 
        and tbl_member_dep.member_dep_faculty like '$faculty'
        and tbl_member_dep.member_dep_name like '$dep_name'
        and tbl_member_dep.member_dep_address like '$address'
        ";
        
        $result = $conn -> query($sql_count)  ;
        /* หาจำนวน Record ทั้งหมด */
        $total_records=mysqli_num_rows($result);
        $show_record = 10 ;
        $amountOfPage=(int)($total_records/$show_record) ;
        if($total_records%$show_record != 0) $amountOfPage++;
     
        $startRec = ($page*$show_record) - $show_record ;
     
        $sql_show = "SELECT  *  FROM  tbl_student ,tbl_member_dep  
        where  tbl_student.student_department = tbl_member_dep.member_dep_code 
        and tbl_member_dep.member_dep_major like '$major' 
        and tbl_member_dep.member_dep_faculty like '$faculty'
        and tbl_member_dep.member_dep_name like '$dep_name'
        and tbl_member_dep.member_dep_address like '$address'
        limit $startRec,$show_record";
     }
     elseif ($_SESSION["type"] == "faculty") {
        $major = $_SESSION["dep_major"];
        $faculty = $_SESSION["dep_faculty"];

        // search year
        $sql_year = "SELECT SUBSTRING(tbl_student.student_id, 1, 2) AS year 
        FROM  tbl_student ,tbl_member_dep  
        where  tbl_student.student_department = tbl_member_dep.member_dep_code 
        and tbl_member_dep.member_dep_major like '$major'
        GROUP BY SUBSTRING(tbl_student.student_id, 1, 2)";
        $result_year = $conn -> query($sql_year)  ;
     
        $sql_count = "SELECT  *  FROM  tbl_student ,tbl_member_dep  
        where  tbl_student.student_department = tbl_member_dep.member_dep_code 
        and tbl_member_dep.member_dep_major like '$major' 
        -- and tbl_member_dep.member_dep_faculty like '$faculty' 
        ";
        
        $result = $conn -> query($sql_count)  ;
        /* หาจำนวน Record ทั้งหมด */
        $total_records=mysqli_num_rows($result);
        $show_record = 10 ;
        $amountOfPage=(int)($total_records/$show_record) ;
        if($total_records%$show_record != 0) $amountOfPage++;
     
        $startRec = ($page*$show_record) - $show_record ;
        // print  "จำนวนนักศึกษา ทั้งหมด  :: " . $total_records ."<br>";
        // print  "จำนวนหน้า :: " . $amountOfPage ."<br>";
     
        $sql_show = "SELECT  *  FROM  tbl_student ,tbl_member_dep  
        where  tbl_student.student_department = tbl_member_dep.member_dep_code 
        and tbl_member_dep.member_dep_major like '$major'  
        -- and tbl_member_dep.member_dep_faculty like '$faculty'  
        limit $startRec,$show_record";
     }
        
}
// กรณีค้นหา ปี
else if ($year != "") {
    if ($_SESSION["type"] == "major"){
        $major = $_SESSION["dep_major"];
        $faculty = $_SESSION["dep_faculty"];
        $dep_name = $_SESSION["dep_name"];
        $address = $_SESSION["dep_address"];
        $year = $_GET['year'];

       // search year
       $sql_year = "SELECT SUBSTRING(tbl_student.student_id, 1, 2) AS year 
        FROM  tbl_student ,tbl_member_dep  
        where  tbl_student.student_department = tbl_member_dep.member_dep_code 
        and tbl_member_dep.member_dep_major like '$major' 
        and tbl_member_dep.member_dep_faculty like '$faculty'
        and tbl_member_dep.member_dep_name like '$dep_name'
        and tbl_member_dep.member_dep_address like '$address'
        GROUP BY SUBSTRING(tbl_student.student_id, 1, 2)";
        $result_year = $conn -> query($sql_year)  ;

        $sql_count = "SELECT  *  FROM  tbl_student ,tbl_member_dep  
        where  tbl_student.student_department = tbl_member_dep.member_dep_code 
        and tbl_member_dep.member_dep_major like '$major' 
        and tbl_member_dep.member_dep_faculty like '$faculty'
        and tbl_member_dep.member_dep_name like '$dep_name'
        and tbl_member_dep.member_dep_address like '$address'

        and (student_id LIKE '$year%')";
        
        $result = $conn -> query($sql_count)  ;
        /* หาจำนวน Record ทั้งหมด */
        $total_records=mysqli_num_rows($result);
        $show_record = 10 ;
        $amountOfPage=(int)($total_records/$show_record) ;
        if($total_records%$show_record != 0) $amountOfPage++;
    
        $startRec = ($page*$show_record) - $show_record ;
    
        $sql_show = "SELECT  *  FROM  tbl_student ,tbl_member_dep  
        where  tbl_student.student_department = tbl_member_dep.member_dep_code 
        and tbl_member_dep.member_dep_major like '$major' 
        and tbl_member_dep.member_dep_faculty like '$faculty'
        and tbl_member_dep.member_dep_name like '$dep_name'
        and tbl_member_dep.member_dep_address like '$address' 

        and (student_id LIKE '$year%') limit $startRec,$show_record";
    }
    elseif ($_SESSION["type"] == "faculty") {
        $major = $_SESSION["dep_major"];
        $faculty = $_SESSION["dep_faculty"];
        $year = $_GET['year'];

        // search year
        $sql_year = "SELECT SUBSTRING(tbl_student.student_id, 1, 2) AS year 
        FROM  tbl_student ,tbl_member_dep  
        where  tbl_student.student_department = tbl_member_dep.member_dep_code 
        and tbl_member_dep.member_dep_major like '$major'
        GROUP BY SUBSTRING(tbl_student.student_id, 1, 2)";
        $result_year = $conn -> query($sql_year)  ;

        $sql_count = "SELECT  *  FROM  tbl_student ,tbl_member_dep  
        where  tbl_student.student_department = tbl_member_dep.member_dep_code 
        and tbl_member_dep.member_dep_major like '$major'

        and (student_id LIKE '$year%')";
        
        $result = $conn -> query($sql_count)  ;
        /* หาจำนวน Record ทั้งหมด */
        $total_records=mysqli_num_rows($result);
        $show_record = 10 ;
        $amountOfPage=(int)($total_records/$show_record) ;
        if($total_records%$show_record != 0) $amountOfPage++;
    
        $startRec = ($page*$show_record) - $show_record ;
    
        $sql_show = "SELECT  *  FROM  tbl_student ,tbl_member_dep  
        where  tbl_student.student_department = tbl_member_dep.member_dep_code 
        and tbl_member_dep.member_dep_major like '$major' 

        and (student_id LIKE '$year%') limit $startRec,$show_record";
    }
}
else if (isset($_GET['search'])) {
    $search = $_GET['search'];
    // print "<script>alert($search)</script>";
    if ($_SESSION["type"] == "major") {

        $major = $_SESSION["dep_major"];
        $faculty = $_SESSION["dep_faculty"];
        $dep_name = $_SESSION["dep_name"];
        $address = $_SESSION["dep_address"];

        // search year
        $sql_year = "SELECT SUBSTRING(tbl_student.student_id, 1, 2) AS year 
        FROM  tbl_student ,tbl_member_dep  
        where  tbl_student.student_department = tbl_member_dep.member_dep_code 
        and tbl_member_dep.member_dep_major like '$major' 
        and tbl_member_dep.member_dep_faculty like '$faculty'
        and tbl_member_dep.member_dep_name like '$dep_name'
        and tbl_member_dep.member_dep_address like '$address'
        GROUP BY SUBSTRING(tbl_student.student_id, 1, 2)";
        $result_year = $conn -> query($sql_year)  ;
    
        $sql_count = "SELECT  *  FROM  tbl_student ,tbl_member_dep  
        where  tbl_student.student_department = tbl_member_dep.member_dep_code 
        and tbl_member_dep.member_dep_major like '$major' 
        and tbl_member_dep.member_dep_faculty like '$faculty'
        and tbl_member_dep.member_dep_name like '$dep_name'
        and tbl_member_dep.member_dep_address like '$address'

        and (tbl_student.student_id like '%$search%' 
        or student_pre_thai like '%$search%'
        or student_name like '%$search%'
        or student_surname like '%$search%'
        or member_dep_name like '%$search%'
        or member_dep_major like '%$search%'
        or member_dep_faculty like '%$search%'
        or member_dep_address like '%$search%')";
        
        $result = $conn -> query($sql_count)  ;
        /* หาจำนวน Record ทั้งหมด */
        $total_records=mysqli_num_rows($result);
        $show_record = 10 ;
        $amountOfPage=(int)($total_records/$show_record) ;
        if($total_records%$show_record != 0) $amountOfPage++;
     
        $startRec = ($page*$show_record) - $show_record ;
     
        $sql_show = "SELECT  *  FROM  tbl_student ,tbl_member_dep  
        where  tbl_student.student_department = tbl_member_dep.member_dep_code 
        and tbl_member_dep.member_dep_major like '$major' 
        and tbl_member_dep.member_dep_faculty like '$faculty'
        and tbl_member_dep.member_dep_name like '$dep_name'
        and tbl_member_dep.member_dep_address like '$address'

        and (student_id like '%$search%' 
        or student_pre_thai like '%$search%'
        or student_name like '%$search%'
        or student_surname like '%$search%'
        or member_dep_name like '%$search%'
        or member_dep_major like '%$search%'
        or member_dep_faculty like '%$search%'
        or member_dep_address like '%$search%') limit $startRec,$show_record";
     }
     elseif ($_SESSION["type"] == "faculty") {
        // print "<script>alert(" . $search . ")</script>";
        $major = $_SESSION["dep_major"];
        $faculty = $_SESSION["dep_faculty"];

        // search year
        $sql_year = "SELECT SUBSTRING(tbl_student.student_id, 1, 2) AS year 
        FROM  tbl_student ,tbl_member_dep  
        where  tbl_student.student_department = tbl_member_dep.member_dep_code 
        and tbl_member_dep.member_dep_major like '$major' 
        GROUP BY SUBSTRING(tbl_student.student_id, 1, 2)";
        $result_year = $conn -> query($sql_year)  ;
     
        $sql_count = "SELECT  *  FROM  tbl_student ,tbl_member_dep  
        where  tbl_student.student_department = tbl_member_dep.member_dep_code 
        and tbl_member_dep.member_dep_major like '$major' 
        -- and tbl_member_dep.member_dep_faculty like '$faculty' 

        and (tbl_student.student_id like '%$search%' 
        or tbl_student.student_pre_thai like '%$search%'
        or tbl_student.student_name like '%$search%'
        or tbl_student.student_surname like '%$search%'
        or tbl_member_dep.member_dep_name like '%$search%'
        or tbl_member_dep.member_dep_major like '%$search%'
        or tbl_member_dep.member_dep_faculty like '%$search%'
        or tbl_member_dep.member_dep_address like '%$search%')";
        
        $result = $conn -> query($sql_count)  ;
        /* หาจำนวน Record ทั้งหมด */
        $total_records=mysqli_num_rows($result);
        $show_record = 10 ;
        $amountOfPage=(int)($total_records/$show_record) ;
        if($total_records%$show_record != 0) $amountOfPage++;
     
        $startRec = ($page*$show_record) - $show_record ;
        // print  "จำนวนนักศึกษา ทั้งหมด  :: " . $total_records ."<br>";
        // print  "จำนวนหน้า :: " . $amountOfPage ."<br>";
     
        $sql_show = "SELECT  *  FROM  tbl_student ,tbl_member_dep  
        where  tbl_student.student_department = tbl_member_dep.member_dep_code 
        and tbl_member_dep.member_dep_major like '$major' 
        -- and tbl_member_dep.member_dep_faculty like '$faculty' 

        and (tbl_student.student_id like '%$search%' 
        or tbl_student.student_pre_thai like '%$search%'
        or tbl_student.student_name like '%$search%'
        or tbl_student.student_surname like '%$search%'
        or tbl_member_dep.member_dep_name like '%$search%'
        or tbl_member_dep.member_dep_major like '%$search%'
        or tbl_member_dep.member_dep_faculty like '%$search%'
        or tbl_member_dep.member_dep_address like '%$search%')  limit $startRec,$show_record";
     }
}
// กรณีค้นหา
else{
    // print "<script>alert ('search')</script>";

    $search = $_POST['txtsearch'];
    if ($_SESSION["type"] == "major") {

        $major = $_SESSION["dep_major"];
        $faculty = $_SESSION["dep_faculty"];
        $dep_name = $_SESSION["dep_name"];
        $address = $_SESSION["dep_address"];

        // search year
        $sql_year = "SELECT SUBSTRING(tbl_student.student_id, 1, 2) AS year 
        FROM  tbl_student ,tbl_member_dep  
        where  tbl_student.student_department = tbl_member_dep.member_dep_code 
        and tbl_member_dep.member_dep_major like '$major' 
        and tbl_member_dep.member_dep_faculty like '$faculty'
        and tbl_member_dep.member_dep_name like '$dep_name'
        and tbl_member_dep.member_dep_address like '$address'
        GROUP BY SUBSTRING(tbl_student.student_id, 1, 2)";
        $result_year = $conn -> query($sql_year)  ;
    
        $sql_count = "SELECT  *  FROM  tbl_student ,tbl_member_dep  
        where  tbl_student.student_department = tbl_member_dep.member_dep_code 
        and tbl_member_dep.member_dep_major like '$major' 
        and tbl_member_dep.member_dep_faculty like '$faculty'
        and tbl_member_dep.member_dep_name like '$dep_name'
        and tbl_member_dep.member_dep_address like '$address'

        and (tbl_student.student_id like '%$search%' 
        or student_pre_thai like '%$search%'
        or student_name like '%$search%'
        or student_surname like '%$search%'
        or member_dep_name like '%$search%'
        or member_dep_major like '%$search%'
        or member_dep_faculty like '%$search%'
        or member_dep_address like '%$search%')";
        
        $result = $conn -> query($sql_count)  ;
        /* หาจำนวน Record ทั้งหมด */
        $total_records=mysqli_num_rows($result);
        $show_record = 10 ;
        $amountOfPage=(int)($total_records/$show_record) ;
        if($total_records%$show_record != 0) $amountOfPage++;
     
        $startRec = ($page*$show_record) - $show_record ;
     
        $sql_show = "SELECT  *  FROM  tbl_student ,tbl_member_dep  
        where  tbl_student.student_department = tbl_member_dep.member_dep_code 
        and tbl_member_dep.member_dep_major like '$major' 
        and tbl_member_dep.member_dep_faculty like '$faculty'
        and tbl_member_dep.member_dep_name like '$dep_name'
        and tbl_member_dep.member_dep_address like '$address'

        and (student_id like '%$search%' 
        or student_pre_thai like '%$search%'
        or student_name like '%$search%'
        or student_surname like '%$search%'
        or member_dep_name like '%$search%'
        or member_dep_major like '%$search%'
        or member_dep_faculty like '%$search%'
        or member_dep_address like '%$search%') limit $startRec,$show_record";
     }
     elseif ($_SESSION["type"] == "faculty") {
        // print "<script>alert(" . $search . ")</script>";
        $major = $_SESSION["dep_major"];
        $faculty = $_SESSION["dep_faculty"];

        // search year
        $sql_year = "SELECT SUBSTRING(tbl_student.student_id, 1, 2) AS year 
        FROM  tbl_student ,tbl_member_dep  
        where  tbl_student.student_department = tbl_member_dep.member_dep_code 
        and tbl_member_dep.member_dep_major like '$major' 
        GROUP BY SUBSTRING(tbl_student.student_id, 1, 2)";
        $result_year = $conn -> query($sql_year)  ;
     
        $sql_count = "SELECT  *  FROM  tbl_student ,tbl_member_dep  
        where  tbl_student.student_department = tbl_member_dep.member_dep_code 
        and tbl_member_dep.member_dep_major like '$major' 
        -- and tbl_member_dep.member_dep_faculty like '$faculty' 

        and (tbl_student.student_id like '%$search%' 
        or tbl_student.student_pre_thai like '%$search%'
        or tbl_student.student_name like '%$search%'
        or tbl_student.student_surname like '%$search%'
        or tbl_member_dep.member_dep_name like '%$search%'
        or tbl_member_dep.member_dep_major like '%$search%'
        or tbl_member_dep.member_dep_faculty like '%$search%'
        or tbl_member_dep.member_dep_address like '%$search%')";
        
        $result = $conn -> query($sql_count)  ;
        /* หาจำนวน Record ทั้งหมด */
        $total_records=mysqli_num_rows($result);
        $show_record = 10 ;
        $amountOfPage=(int)($total_records/$show_record) ;
        if($total_records%$show_record != 0) $amountOfPage++;
     
        $startRec = ($page*$show_record) - $show_record ;
        // print  "จำนวนนักศึกษา ทั้งหมด  :: " . $total_records ."<br>";
        // print  "จำนวนหน้า :: " . $amountOfPage ."<br>";
     
        $sql_show = "SELECT  *  FROM  tbl_student ,tbl_member_dep  
        where  tbl_student.student_department = tbl_member_dep.member_dep_code 
        and tbl_member_dep.member_dep_major like '$major' 
        -- and tbl_member_dep.member_dep_faculty like '$faculty' 

        and (tbl_student.student_id like '%$search%' 
        or tbl_student.student_pre_thai like '%$search%'
        or tbl_student.student_name like '%$search%'
        or tbl_student.student_surname like '%$search%'
        or tbl_member_dep.member_dep_name like '%$search%'
        or tbl_member_dep.member_dep_major like '%$search%'
        or tbl_member_dep.member_dep_faculty like '%$search%'
        or tbl_member_dep.member_dep_address like '%$search%')  limit $startRec,$show_record";
     }
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
    <nav class="navbar navbar-primary bg-primary justify-content-between">
        <ul class="nav">
        <li class="nav-item">
            <a class="navbar-brand" href="user_show.php">Regis Toeic</a>
        </li>
        <li class="nav-item">
            <a class="nav-link justify-content-start" href="user_show.php">หน้าหลัก</a>
        </li>
          <li class="nav-item">
            <a class="nav-link justify-content-start" href="Editonly.php?id=<?php print $type ?>">ข้อมูลผู้ใช้งาน</a>
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
        <div class="card bg-light text-dark text-left p-3" style="text-align: center; border-radius: 25px;">

            <div class="card-header bg-light text-dark">
                <div class="form-inline justify-content-between">
                   <!-- ค้นหา -->
                    <form action="user_show.php" id="serach_data" method="post" class="form-inline">
                        <label class="form-label mr-sm-2" for="inlineFormCheck">
                            ค้นหา
                        </label>
                        <input class="form-control mr-sm-2" type="search" id="txt" name="txtsearch" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-primary my-sm-2" id="ts" type="submit">Search</button>
                        <!-- <button class="btn btn-outline-success mr-sm-2 " id="re" type="button" value="user_show2.php">Reset</button> -->
                        <a href="user_show.php" class="btn btn-outline-success">Reset</a>
                    </form>

                    <!-- PDF -->
                    <form action="pdf_user.php" method="post" class="form-inline ">
                        <label class="form-label mr-sm-2" >
                            จำนวนนักศึกษา ทั้งหมด  :: <?php print $total_records; ?>
                        </label>
                        <?php echo "<a class='btn btn-outline-danger' target='_blank' href='pdf_user.php?year=".$year."&search=".$search."'> Export PDF </a>";?>
                    </form> 
                </div>
                <div class="form-inline ">
                    <form action="" class="form-inline ">
                        <label class="form-label mr-sm-2" for="form-select">
                            หน้า
                        </label>
                        <select class="form-select mr-sm-3" onchange='location = this.value;'>
                            <?php 
                            print "<option value='#'selected>" .$page ."</option>";
                            for ($i = 1 ; $i<=$amountOfPage ; $i++) {
                            print "<option value='user_show.php?page=$i&year=$year&search=$search'>" .$i ."</option>";
                            } ?>
                        </select>
                        
                        <!-- ค้นหาจากปี -->
                        <label class="form-label mr-sm-2" for="txt">
                            ปีการศึกษา
                        </label>
                        <select class="form-select mr-sm-5" onchange='location = this.value;'>
                            <?php 
                            print "<option value='#'selected>" .$year ."</option>";
                            while ($row = $result_year -> fetch_assoc()) {
                                $year = $row['year'];
                                print "<option value='user_show.php?year=$year'>" .$year ."</option>";
                            } ?>
                        </select>
                    </form>
                </div>

                
            </div>
            <div class="card-body" style="overflow-y: auto; display:flex; height: 500px;">
                <table class="table table-primary table-striped table-hover" id="Tdata" style=" text-align: center;">
                    <thead>
                        <tr class="bg-primary">
                            <th scope="col" style="text-align: center; color:white">#</th>
                            <th scope="col" style="text-align: center; color:white">รหัสนักศึกษา</th>
                            <th scope="col" style=" text-align: center; color:white">ชื่อ - นามสกุล</th>
                            <th scope="col" style=" text-align: center; color:white">หลักสูตร/สาขาวิชา</th>
                            <th scope="col" style=" text-align: center; color:white">คณะ/โรงเรียน</th>
                            <!-- <th scope="col" style=" text-align: center; color:white">สาขา</th> -->
                            <th scope="col" style=" text-align: center; color:white">สถานที่จัดการศึกษา</th>
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
                                   $_SESSION["id"] = $id;
                                   $major_name = $row['member_dep_major']." / ".$row['member_dep_name'];
                                    print "<TR><TD>" . $p ;
                                    print "</td><TD>" . $row['student_id']  ;
                                    print "</td><TD>" . $row['student_pre_thai'] . "" . $row['student_name'] . " " . $row['student_surname']  ;
                                    print "</TD><TD>" .  $major_name . "</TD> ";
                                    print "</TD><TD>" .  $row['member_dep_faculty'] . "</TD> ";
                                    // print "</TD><TD>" .  $row['member_dep_name'] . "</TD> ";
                                    print "</TD><TD>" .  $row['member_dep_address'] . "</TD> </tr>";
                                    // print "</TD><TD>
                                    // <a href='info.php?id=$id'class='btn btn-outline-success'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-eye' viewBox='0 0 16 16'>
                                    // <path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
                                    // <path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
                                    // </svg></a>

                                    // </TD></tr> ";
                                    $p++;
                               }
                            }
                            elseif (mysqli_num_rows($result) ==0) {
                                print "<script>alert('ไม่พบข้อมูล')</script>"; 
                                print "<script>window.location='user_show.php';</script>";
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