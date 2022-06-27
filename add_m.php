<?php
session_start();

if ($_SESSION['type'] != 'admin')  {
    print "<script>alert ('กรุณา Login ใหม่')</script>";
    print "<script>window.location='login.html';</script>";
}
include 'connect.php';
// log
date_default_timezone_set('Asia/Bangkok');
$date = new DateTime("now"); 
$LoginTime = $date->format('Y-m-d H:i:s');
$userLogin = $_SESSION["user"];
$ip = $_SERVER['REMOTE_ADDR'];

$sql_log = "INSERT into tbl_logdata values ('','$LoginTime','$userLogin','$ip','show User')";
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
        // print "<script>alert('n')</script>" ;
        $sql_count = "SELECT  *  FROM  tbl_member ,tbl_member_type  
        where  member_type = member_type_code ";
        
        $result = $conn -> query($sql_count)  ;
        /* หาจำนวน Record ทั้งหมด */
        $total_records=mysqli_num_rows($result);
        $show_record = 10 ;
        $amountOfPage=(int)($total_records/$show_record) ;
        if($total_records%$show_record != 0) $amountOfPage++;
     
        $startRec = ($page*$show_record) - $show_record ;
     
        $sql_show = "SELECT  *   FROM  tbl_member ,tbl_member_type  
        where  member_type = member_type_code limit $startRec,$show_record";
        
}
// กรณีค้นหา get
else if (isset($_GET['search'])) {
    // print "<script>alert('get')</script>" ;
    $search = $_GET['search'];
        $sql_count = "SELECT  *  FROM  tbl_member ,tbl_member_type  
        where member_type = member_type_code and (
        member_username like '%$search%'
        or member_password like '%$search%'
        or member_name like '%$search%'
        or member_mail like '%$search%'
        or member_card_id like '%$search%'
        or member_type like '%$search%'
        or member_type_name like '%$search%')";
        
        $result = $conn -> query($sql_count)  ;
        /* หาจำนวน Record ทั้งหมด */
        $total_records=mysqli_num_rows($result);
        $show_record = 10 ;
        $amountOfPage=(int)($total_records/$show_record) ;
        if($total_records%$show_record != 0) $amountOfPage++;
     
        $startRec = ($page*$show_record) - $show_record ;
     
        $sql_show = "SELECT  *  FROM  tbl_member ,tbl_member_type  
        where member_type = member_type_code and (
        member_username like '%$search%'
        or member_password like '%$search%'
        or member_name like '%$search%'
        or member_mail like '%$search%'
        or member_card_id like '%$search%'
        or member_type like '%$search%'
        or member_type_name like '%$search%') limit $startRec,$show_record";
}
// กรณีค้นหา
else{
    // print "<script>alert('s')</script>" ;
    $search = $_POST['txtsearch'];
        $sql_count = "SELECT  *  FROM  tbl_member,tbl_member_type 
        where member_type = member_type_code and (
        member_username like '%$search%'
        or member_password like '%$search%'
        or member_name like '%$search%'
        or member_mail like '%$search%'
        or member_card_id like '%$search%'
        or member_type like '%$search%'
        or member_type_name like '%$search%')";
        
        $result = $conn -> query($sql_count)  ;
        /* หาจำนวน Record ทั้งหมด */
        $total_records=mysqli_num_rows($result);
        $show_record = 10 ;
        $amountOfPage=(int)($total_records/$show_record) ;
        if($total_records%$show_record != 0) $amountOfPage++;
     
        $startRec = ($page*$show_record) - $show_record ;
     
        $sql_show = "SELECT  *  FROM  tbl_member,tbl_member_type 
        where member_type = member_type_code and (
        member_username like '%$search%'
        or member_password like '%$search%'
        or member_name like '%$search%'
        or member_mail like '%$search%'
        or member_card_id like '%$search%'
        or member_type like '%$search%' 
        or member_type_name like '%$search%') limit $startRec,$show_record";
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
                    <form action="add_m.php" id="serach_data" method="post" class="form-inline">
                        <label class="form-label mr-sm-2" for="inlineFormCheck">
                            ค้นหา
                        </label>
                        <input class="form-control mr-sm-2" type="search" id="txt" name="txtsearch" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-primary my-sm-2" id="ts" type="submit">Search</button>
                        <!-- <button class="btn btn-outline-success mr-sm-2 " id="re" type="button" value="user_show2.php">Reset</button> -->
                        <a href="add_m.php" class="btn btn-outline-success">Reset</a>
                    </form>

                    <!-- PDF -->
                    <form action="" method="post" class="form-inline ">
                        <label class="form-label mr-sm-2" >
                            จำนวนผู้ใช้ ทั้งหมด  :: <?php print $total_records; ?>
                        </label>
                        <!-- <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">Export PDF</button> -->
                    </form> 
                
                </div>

                <div class="form-inline justify-content-between">
                    <form action="" class="form-inline ">
                        <label class="form-label mr-sm-2" for="form-select">
                            หน้า
                        </label>
                        <select class="form-select" onchange='location = this.value;'>
                            <?php 
                            print "<option value='#'selected>" .$page ."</option>";
                            for ($i = 1 ; $i<=$amountOfPage ; $i++) {
                            print "<option value='add_m.php?page=$i&search=$search'>" .$i ."</option>";
                            } ?>
                        </select>
                    </form>
                    <form action="add_user.php" class="form-inline ">
                        <button class="btn btn-success my-2 my-sm-0" type="submit">เพิ่มผู้ใช้งาน</button>
                    </form>
                    <!-- <form action="" class="form-inline "> -->
                        <!-- <button class="btn btn-success my-2 my-sm-0" type="submit">เพิ่มข้อมูลสาขา</button> -->
                        <!-- <a href='add_dep.php'class='btn btn-success'>เพิ่มข้อมูลสาขา</a> -->
                    <!-- </form> -->
                </div>

                
            </div>
            <div class="card-body" style="overflow-y: auto; display:flex; height: 500px;">
                <table class="table table-primary table-striped table-hover" id="Tdata" style=" text-align: center;">
                    <thead>
                        <tr class="bg-primary">
                            <th scope="col" style="text-align: center; color:white">#</th>
                            <!-- <th scope="col" style="text-align: center; color:white">รหัสสาขา</th> -->
                            <th scope="col" style=" text-align: center; color:white">User Name</th>
                            <th scope="col" style=" text-align: center; color:white">ID/Password</th>
                            <th scope="col" style=" text-align: center; color:white">E-mail</th>
                            <!-- <th scope="col" style=" text-align: center; color:white"></th> -->
                            <th scope="col" style=" text-align: center; color:white">Card Id</th>
                            <th scope="col" style=" text-align: center; color:white">Class</th>
                            <th scope="col" style=" text-align: center; color:white">Edit</th>
                            <th scope="col" style=" text-align: center; color:white">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $result = $conn -> query($sql_show)  ;
                            if (mysqli_num_rows($result) !=0) {
                                $p = ($page * 10)-9;

                               while ($row = $result -> fetch_assoc()) { 
                                    $id = $row['member_username'];
                                    $_SESSION["id"] = $id;
                                    $major_name = $row['member_username']." / ".$row['member_password'];
                                    print "<TR><TD>" . $p ;
                                    // print "</td><TD>" . $row['member_dep_code']  ;
                                    print "</TD><TD>" .  $row['member_name'] . "</TD> ";
                                    print "</TD><TD>" .  $major_name . "</TD> ";
                                    print "</TD><TD>" .  $row['member_mail'] . "</TD> ";
                                    // print "</TD><TD>" .  $row['member_dep_name'] . "</TD> ";
                                    print "</TD><TD>" .  $row['member_card_id'] . "</TD> ";
                                    print "</TD><TD>" .  $row['member_type_name'] . "</TD> ";
                                    print "</TD><TD>
                                    <a href='edit_user.php?id=$id'class='btn btn-warning'>
                                    
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                    <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                                    </svg></a>";
                                    print "<TD>
                                    <a href='Del_user.php?id=$id'class='btn btn-danger'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
                                    <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z'/>
                                    <path fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'/>
                                    </svg></a>
                                    </TD> </tr>";
                                    $p++;
                               }
                            }
                            elseif (mysqli_num_rows($result) ==0) {
                                print "<script>alert('ไม่พบข้อมูล')</script>"; 
                                print "<script>window.location='add_m.php';</script>";
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