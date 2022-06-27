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
  <title>Document</title>
</head>

<body>
  <?php
  session_start();
  $conn = mysqli_connect("localhost", "root", "", "regisdoc_db");
  $id = $_GET['id'];
  $sql = "SELECT * FROM document WHERE document_id='$id' ";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    $row = mysqli_fetch_array($result);
    $_SESSION['id_doc']= $id;
  ?>
    <form action="saveedit.php" method="POST" name="saveupdate" id="saveupdate" enctype='multipart/form-data'>
      <table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td height="40" colspan="2" align="center" bgcolor="#D6D5D6"><b>Edit</b></td>
        </tr>

        <tr>
          <td align="right" bgcolor="#EBEBEB">&nbsp;</td>
          <td bgcolor="#EBEBEB">&nbsp;</td>
        </tr>
        <tr>
          <td width="117" align="right" bgcolor="#EBEBEB">แก้ไขชื่อเอกสาร </td>
          <td width="583" bgcolor="#EBEBEB"><input style="position:relative;left:10px;" name="doc_name" type="text" id="doc_name" value="<?php print $row["document_name"]; ?>" size="30" required="required" /></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#EBEBEB">&nbsp;</td>
          <td bgcolor="#EBEBEB">&nbsp;</td>
        </tr>
        <tr>
          <td align="right" bgcolor="#EBEBEB">ชื่อผู้ส่ง
            <label> </label>
          </td>
          <td bgcolor="#EBEBEB"><input style="position:relative;left:10px;" type="text" name="id_create" id="id_create" value="<?php print $row["upload_user"]; ?>" placeholder="ตัวเลขหรือภาษาอังกฤษเท่านั้น" required pattern="[a-zA-Z0-9-]+"/></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#EBEBEB">&nbsp;</td>
          <td bgcolor="#EBEBEB">&nbsp;</td>
        </tr>
        <tr>
          <td align="right" bgcolor="#EBEBEB">อัพโหลดไฟล์ใหม่
            <label> </label>
          </td>
          <td bgcolor="#EBEBEB"><input style="position:relative;left:10px;" type="file" name="txtFile" id="id_create" value="<?php print $row["doucument_file"]; ?>" placeholder="ตัวเลขหรือภาษาอังกฤษเท่านั้น"></td>
        </tr>
        <tr>
          <td bgcolor="#EBEBEB">&nbsp;</td>
          <td bgcolor="#EBEBEB">&nbsp;</td>
        </tr>
        <tr>
          <td bgcolor="#EBEBEB">&nbsp;</td>
          <td bgcolor="#EBEBEB">&nbsp;
            <input class="btn btn-danger" type="button" value=" ยกเลิก " onclick="window.location.href='admin_show.php';" /> <!-- ถ้าไม่แก้ไขให้กลับไปหน้าแสดงรายการ -->
            &nbsp;
            <input class="btn btn-danger" type="submit" name="Update" id="Update" value="Update" />
          </td>
        </tr>
        <tr>
          <td bgcolor="#EBEBEB">&nbsp;</td>
          <td bgcolor="#EBEBEB">&nbsp;</td>
        </tr>
      </table>
      <input type="hidden" name="doc_id" value="<?php print $row['document_id']; ?>" </form>
      <?php } else {
      print "<script>alert('เกิดข้อผิดพลาดกรุณาลองใหม่ภายหลัง')</script>";
      print "<script>window.location.href='login.html'</script>";
    } ?>

    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>

</html>