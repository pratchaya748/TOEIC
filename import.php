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

$sql_log = "INSERT into tbl_logdata values ('','$LoginTime','$userLogin','$ip','admin show')";
$result_log = $conn->query($sql_log);

?>

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
    <div class="container-sm mt-0 pt-3" style="text-align: center; border-radius: 25px;">
        <div class="card bg-light text-dark text-left p-3" style="text-align: center; border-radius: 25px;">
            <!-- head -->
            <div class="card-header bg-light text-dark">
                <div class="form-inline justify-content-between">
                    <label class="form-label mr-sm-2" >
                        นำเข้าข้อมูลไฟล์ CSV 
                    </label> 
                    <a href="example_toeic.csv" class="btn btn-outline-warning">ตัวอย่างไฟล์ข้อมูล</a>
                </div>

                <div class="form-inline justify-content-between pt-2">
                    <form action="import.php" method="POST" enctype='multipart/form-data' id="c">
                        <!-- <img src="ex.png" style="display:flex; height: 150px;"> -->
                        <div class="form-group">
                            <div class="input-group">
                                <!-- <input type="file" class="form-control" id="CSVfile" name="csvF"> -->
                                <input type="file" class="form-control" id="CSVfile" name="csvF">
                                <button class="btn btn-outline-success" type="submit" id="inputCSV" name="inputCSV">Upload</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- body -->
            <div class="card-body" style="overflow-y: auto; display:flex; height: 400px;">
                <table class="table table-primary table-striped table-hover" style=" text-align: center;">
                    <thead>
                        <tr class="bg-primary">
                            <th scope="col" colspan="6" style="text-align: center; color:white">รายชื่อนักศึกษาที่ซ้ำ</th>
                        </tr>
                        <tr class="bg-primary">
                            <th scope="col" style="text-align: center; color:white">#</th>
                            <th scope="col" style="text-align: center; color:white">รหัสนักศึกษา</th>
                            <th scope="col" style=" text-align: center; color:white">ชื่อ - นามสกุล</th>
                            <th scope="col" style=" text-align: center; color:white">หลักสูตร/สาขาวิชา</th>
                            <th scope="col" style=" text-align: center; color:white">คณะ/โรงเรียน</th>
                            <th scope="col" style=" text-align: center; color:white">สถานที่จัดการศึกษา</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

</body>
<script src="js/jquery-3.5.1.js"></script>
<script type="text/javascript">
    $(function() {
        $('form#c').on("submit", function(e){  
                e.preventDefault();
                // $("table tbody#sub").replaceAll(''); 
                if ($('#CSVfile').val() == '') {
                    alert("โปรดเลือกไฟล์");  
                } else {
                    $.ajax({  
                         url:"csvToeic.php",  
                         method:"POST",  
                         data:new FormData(this),  
                         contentType:false,          // The content type used when sending data to the server.  
                         cache:false,                // To unable request pages to be cached  
                         processData:false,          // To send DOMDocument or non processed data file it is set to false  
                        //  dataType: "json",
                         success: function(data){  
                            if(data == 'Error1'){  
                                alert("ไฟล์ไม่ถูกต้อง");   
                            }  
                            else if (data.length != 0) {
                                alert("บันทึกข้อมูลสำเร็จ");
                            // alert(data); 
                            console.log(data); 
                            console.log("-----------------------"); 
                            // กำหนดตัวแปรเก็บโครงสร้างแถวของตาราง
                            var trstring = "";

                            data = JSON.parse(data);
                            // alert(data);
                            // console.log(jQuery.type(data)); 
                            console.log(data.length); 
                            var o = 1;
                            // วนลูปข้อมูล JSON ลงตาราง
                                $.each(data, function(key, value) {
                                    // แสดงค่าลงในตาราง
                                    trstring += `
                                        <tr id ="oo" class="bg-light">
                                            <td class="text-center" id="subID">${o}</td>
                                            <td class="text-center" id="subID">${value.student_id}</td>
                                            <td class="text-center" id="name">${value.student_pre_thai}${value.student_name} ${value.student_surname}</td>
                                            <td class="text-center" id="credit">${value.member_dep_major} / ${value.member_dep_name}</td>
                                            <td class="text-center" id="credit">${value.member_dep_faculty}</td>
                                            <td class="text-center" id="credit">${value.member_dep_address}</td>
                                        </tr>`; 
                                    $("table tbody").html(trstring);
                                    o++;     
                                    
                                });
                                $('#CSVfile').val('');
                            } 
                            else {
                                alert('ผิดพลาด');
                            }
                        }  
                    })  
                }
           });  
    });
</script>





