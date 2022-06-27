<?php 
include "connect.php";
session_start();

if (!isset($_GET['page'])) {
   $page = 1;
}
else {
   $page = $_GET['page'];
}


// เช็ค type user
if ($_SESSION["type"] == "major") {
   $major = $_SESSION["dep_major"];
   $sql_count = "SELECT  *  FROM  tbl_student ,tbl_member_dep  where  tbl_student.student_department = tbl_member_dep.member_dep_code and member_dep_major like '$major' ";
   
   $result = $conn -> query($sql_count)  ;
   /* หาจำนวน Record ทั้งหมด */
   $total_records=mysqli_num_rows($result);
   $show_record = 10 ;
   $amountOfPage=(int)($total_records/$show_record) ;
   if($total_records%$show_record != 0) $amountOfPage++;

   $startRec = ($page*$show_record) - $show_record ;
   print  "จำนวนนักศึกษา ทั้งหมด  :: " . $total_records ."<br>";
   print  "จำนวนหน้า :: " . $amountOfPage ."<br>";

   $sql_show = "SELECT  *  FROM  tbl_student ,tbl_member_dep  where  tbl_student.student_department = tbl_member_dep.member_dep_code and member_dep_major like '$major' limit $startRec,$show_record";
}
elseif ($_SESSION["type"] == "faculty") {
   $major = $_SESSION["dep_major"];
   $faculty = $_SESSION["dep_faculty"];
   print $faculty;

   $sql_count = "SELECT  *  FROM  tbl_student ,tbl_member_dep  where  tbl_student.student_department = tbl_member_dep.member_dep_code and member_dep_major like '$major' and member_dep_faculty like '$faculty' ";
   
   $result = $conn -> query($sql_count)  ;
   /* หาจำนวน Record ทั้งหมด */
   $total_records=mysqli_num_rows($result);
   $show_record = 10 ;
   $amountOfPage=(int)($total_records/$show_record) ;
   if($total_records%$show_record != 0) $amountOfPage++;

   $startRec = ($page*$show_record) - $show_record ;
   print  "จำนวนนักศึกษา ทั้งหมด  :: " . $total_records ."<br>";
   print  "จำนวนหน้า :: " . $amountOfPage ."<br>";

   $sql_show = "SELECT  *  FROM  tbl_student ,tbl_member_dep  where  tbl_student.student_department = tbl_member_dep.member_dep_code and member_dep_major like '$major'  and member_dep_faculty like '$faculty'  limit $startRec,$show_record";
}

// $sql_count = "SELECT  *  FROM  tbl_student ,tbl_member_dep  where  tbl_student.student_department = tbl_member_dep.member_dep_code and member_dep_faculty like 'วิทยาการจัดการ'  and member_dep_name like '%มนุษย์%' ";
// $result = $conn -> query($sql_count)  ;
// /* หาจำนวน Record ทั้งหมด */
// $total_records=mysqli_num_rows($result);
// $show_record = 10 ;
// $amountOfPage=(int)($total_records/$show_record) ;
// if($total_records%$show_record != 0) $amountOfPage++;

// $startRec = ($page*$show_record) - $show_record ;
// print  "จำนวนนักศึกษา ทั้งหมด  :: " . $total_records ."<br>";
// print  "จำนวนหน้า :: " . $amountOfPage ."<br>";
// $sql_show = "SELECT  *  FROM  tbl_student ,tbl_member_dep  where  tbl_student.student_department = tbl_member_dep.member_dep_code and member_dep_faculty like 'วิทยาการจัดการ'  and member_dep_name like '%มนุษย์%' limit $startRec,$show_record";

// print "<select> 
// <option selected value='<a href=`Show_student.php?page=$page`>Page $page</a>'>" .$page ."</option>";
print "<select> onchange='location = this.value;'";
for ($i = 1 ; $i<=$amountOfPage ; $i++) {
   print "<option value='Show_student.php?page=$i'>page " .$i ."</option>";
}
print "</select>";

$result = $conn -> query($sql_show)  ;
if ($result) {
   print  "<table border=1>" ;
   print "<TR><TH>#</TH> <TH> รหัส</TH><TH> ชื่อ นามสกุล </TH> <TH> mail </TH> <TH> รายละเอียด </TH></TR>" ;
   $p = 1;
   while ($row = $result -> fetch_assoc()) { 
	   print "<TR><TD>" . $p  ;
	   print "</td><TD>" . $row['student_id']  ;
	   print "</td><TD>" . $row['student_pre_thai'] . "" . $row['student_name'] . " " . $row['student_surname']  ;
	   print "</TD><TD>" .  $row['member_dep_faculty'] . "</TD> ";
	   print "</TD><TD>" .  $row['member_dep_name'] . "</TD></tr> ";
      $p++;
   }
}
else 
   echo $conn -> error ; 
?>