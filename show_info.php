<?php
  session_start();
  if ( $_SESSION['permission'] != 'admin')  {
	print "<script>alert ('กรุณา Login ก่อน')</script>";
    print "<script>window.location='index.html';</script>";
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
    <link rel="stylesheet" href="./style.css">
    <title>Info_User</title>
        <style>
            body {
                background:url('https://media.discordapp.net/attachments/887997881179602986/925047743985094686/IMG_2216.png?width=853&height=480');
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-size: cover;
                background-position: top;
            }
        </style>
    </head>
<body>
    <div class="img">
        <img style="position: relative;left: 10px;top: 10px;" src="https://upload.wikimedia.org/wikipedia/th/1/16/SDU2016.png" alt="sdu" width="100px">
    </div>
    <nav class="navbar navbar-expand-sm navbar-dark " style="position:relative;top:30px;background-color:#333;height: 60px; width:auto;opacity: 0.9;">
        <div class="container-fluid">

        


        <!-- โค้ตแสดงผู้ใช้งานเก่าเก็ยไว้สำรอง
            <div class="collapse navbar-collapse" id="navbarToggle">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="#" class="nav-link"style="position: relative;top:60px; width:100px;">ชื่อผู้ใช้งาน00</a>
                </li> 
        -->
            <div class="collapse navbar-collapse" id="navbarToggle">
            <ul class="navbar-nav">
            <a href="admin_show.php" style="position:relative;top:40px;height:40px;" class="btn btn-primary">ไปหน้าหลัก</a>
            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarToggle">
            <span class="navbar-toggler-icon"></span>
            </button>


                <!-- <li style="position:relative;" class="dropdown">
                    <a class="dropdown-toggle btn btn btn-primary text-light" style="position:relative;top:67px;height:40px;left:15px;" data-toggle="dropdown" href="#">เพิ่มเติม
                    <span class="caret"></span></a>
                    <ul style="position:relative;top:5px;" class="dropdown-menu">
                        <li><a href="#"  style="white-space: nowrap;overflow: hidden;box-sizing: border-box;text-overflow: ellipsis;"><div class="word3">Placeholder 1</div></a></li>
                        <li><a href="#"  style="white-space: nowrap;overflow: hidden;box-sizing: border-box;text-overflow: ellipsis;"><div class="word3">Placeholder 2</div></a></li>
                    </ul>
                </li> -->
                <div class="collapse navbar-collapse" id="navbarToggle">
            <ul class="navbar-nav">
            <a href="logout.php" style="position:relative;top:40px;height:40px;float:left;left:1000px;" class="btn btn-primary">Log out</a>
            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarToggle">
            <span class="navbar-toggler-icon"></span>
            </button>
                <form action="admin_show.php" method="post" class="d-flex" >
                    <div style="position :100px;left:500px;bottom: 160px;width: 300px;float:left;" class="container">
                    </div>
                </form>
                
            </ul>
        </div>
    </nav>
    

    <?php
       include "connect.php";

                    date_default_timezone_set('Europe/London');
                    $query = "SELECT  *  FROM  user_login  WHERE member_user like '%$search%' or user_mount like '$mount' or user_year like '$year_in' ORDER BY id DESC ";
                    $query_run = mysqli_query($conn, $query);
 
    ?>

        <table style="position:relative;top:30px;" class="bg-light table table-bordered " border="10px">
            <thead>

                    <th  scope="col" style="text-align:center;">username</th>
                    <th bgcolor="#efefef" scope="col" style="text-align:center;"> วันที่เข้าใช้งาน</th>
                    <th scope="col">เวลาที่เข้าใช้งาน  <?php   echo date("M d Y H:i:s");   ?></th>

                    <!-- <th><a href="adduser.php"><button style="position:relative;top:5px;" type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#studentaddModal" >add</button></a></th> -->
                </tr>
            </thead>

            <?php
                     if($query_run)
                     
                    {
                         foreach($query_run as $row)
                        {
                            $date_in_mount= $row["user_mount"];
                            if($date_in_mount =="01"){
                                $date_in_mount = "ม.ค.";
                            }elseif ($date_in_mount =="02"){
                                $date_in_mount = "ก.พ.";
                            }elseif ($date_in_mount =="03"){
                                $date_in_mount = "มี.ค.";
                            }elseif ($date_in_mount =="04"){
                                $date_in_mount = "เม.ย.";
                            }elseif ($date_in_mount =="05"){
                                $date_in_mount = "พ.ค.";
                            }elseif ($date_in_mount =="06"){
                                $date_in_mount = "มิ.ย.";
                            }elseif ($date_in_mount =="07"){
                                $date_in_mount = "ก.ค.";
                            }elseif ($date_in_mount =="08"){
                                $date_in_mount = "ส.ค.";
                            }elseif ($date_in_mount =="09"){
                                $date_in_mount = "ก.ย.";
                            }elseif ($date_in_mount =="10"){
                                $date_in_mount = "ต.ค.";
                            }elseif ($date_in_mount =="11"){
                                $date_in_mount = "พ.ย.";
                            }elseif ($date_in_mount =="12"){
                                $date_in_mount = "ธ.ค.";
                            }
                ?>
                   
                        <tbody>
                            <tr>
                                <td bgcolor="#d5d5d5"  style="white-space: nowrap;overflow: hidden;box-sizing: border-box;text-overflow: ellipsis;"><?php echo $row ['member_user']; ?></td>
                                <td bgcolor="#e5e5e5"  style="white-space: nowrap;overflow: hidden;box-sizing: border-box;text-overflow: ellipsis;"><?php echo $row['user_day']."/".$date_in_mount."/".$row["user_year"]; ?></td>
                                <td bgcolor="#d5d5d5"  style="white-space: nowrap;overflow: hidden;box-sizing: border-box;text-overflow: ellipsis;"><?php echo $row ['user_time'];?></td>
                            </tr>
                        </tbody>
                        <?php
                        }
                    }
                    else
                    {
                        echo "No Record Found";
                    }
                ?>
                    </table>

 <script  src="./script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>
</html>

