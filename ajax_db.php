<?php

          $con= mysqli_connect("localhost","root","","toeic") or die("Error: " . mysqli_error($con));
          mysqli_query($con, "SET NAMES 'utf8' ");
          error_reporting( error_reporting() & ~E_NOTICE );
          date_default_timezone_set('Asia/Bangkok');  


  if (isset($_POST['function']) && $_POST['function'] == 'provinces') {
  	$id = $_POST['id'];
  	$sql = "SELECT * FROM tbl_member_dep WHERE province_id='$id'";
  	$query = mysqli_query($con, $sql);
  	echo '<option value="" selected disabled>-กรุณาเลือกอำเภอ-</option>';
  	foreach ($query as $value) {
  		echo '<option value="'.$value['id'].'">'.$value['name_a'].'</option>';
  		
  	}
  }


if (isset($_POST['function']) && $_POST['function'] == 'tbl_member_dep') {
    $id = $_POST['id'];
    $sql = "SELECT * FROM tbl_member_dep WHERE amphure_id='$id'";
    $query = mysqli_query($con, $sql);
    echo '<option value="" selected disabled>-กรุณาเลือกตำบล-</option>';
    foreach ($query as $value2) {
      echo '<option value="'.$value2['id'].'">'.$value2['name_t'].'</option>';
      
    }
  }

  if (isset($_POST['function']) && $_POST['function'] == 'tbl_member_dep') {
    $id = $_POST['id'];
    $sql = "SELECT * FROM tbl_member_dep WHERE id='$id'";
    $query3 = mysqli_query($con, $sql);
    $result = mysqli_fetch_assoc($query3);
    echo $result['zip_code'];
    exit();
  }
?>