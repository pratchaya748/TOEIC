<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>นำเข้าเอกสาร</title>
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins' , sans-serif;
        }
        body{
            background:url('https://media.discordapp.net/attachments/887997881179602986/925047743985094686/IMG_2216.png?width=853&height=480');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            background-position: top;
            overflow: hidden;
        }
        .container{
            position:relative;
            bottom: 80px;
            left: 10px;
            max-width: 500px;
            width: 300%;
            background: #fff;
            padding: 25px 30px;
            position:relative;
            right: 100px;
            box-shadow: 0 10px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 100px 0 rgba(0, 0, 0, 0.19);
            border-radius: 12px;
            
        }
        .container form .user-details{
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        form .user-details .input-box{
            width: calc(100% / 2 - 20px);
            margin: 20px 0 12px 0;
        }
        .user-details .input-box .details{
            display: block;
            font-weight:500;
            margin-bottom: 5px;
        }
        .user-details .input-box input{
            height: 30px;
            width: 200%;
            outline: none;
            border-radius: 5px;
            border: 1px solid #ccc;
            padding-left: 15px;
            font-size: 16px;
        }
        ::placeholder{
            color:white;
        }
    </style>
</head>
<body>

    <div class="image">
        <img style="height:120px; position:relative; left:30px; top:10px; " src="https://cdn.discordapp.com/attachments/917410705483903026/925064964870389890/SDU2016.png" alt="img">
    </div>
    <FORM METHOD=POST ACTION="importdocument_on.php" enctype='multipart/form-data'>
    <div class="container">
        <div class="user-details">
            <div class="user-details">
            <div class="input-box">   
            <h3 style ="position:relative;left:140px;"><b>เพิ่มเอกสาร</b></h3>
            </div>
            <div class="input-box">
                <span class="details"><b>ชื่อเอกสาร</b></span>
                <input style="height:40px;background-color:#1E90FF;color:white;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);" type="text" name="documentname" placeholder="(ชื่อเอกสาร...)" class="btn btn-outline ">
            </div>
            <div class="user-details">
        
            <div class="input-box">
                <span class="details"><b>ชื่อผู้ส่ง</b></span>
                <input style="height:40px;color:white;background-color:#1E90FF;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);" type="text" name="fromuser" placeholder="(u.........@mail.dusit.ac.th)"   class="btn btn-outline ">
            </div>
            <div class="input-box">
                <span class="details" ><b>ไฟล์</b></span>
                <input style="height:45px;background-color:#1E90FF;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);" type="file" name="txtFile"  class="btn btn-outline " required>
            </div>
            <div class="Submit">
                <input class="btn btn-danger" type="button" value=" ยกเลิก " onclick="window.location.href='admin_show.php';"/> <!-- ถ้าไม่แก้ไขให้กลับไปหน้าแสดงรายการ -->
                   &nbsp;
                 <input class="btn btn-danger" type="submit" name="ยื่นยัน" id="Update" value="ยืนยัน" /></td>
            </div>
    </FORM>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>
</html>
