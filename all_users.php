<?php
include 'connect.php';
$sql = "SELECT tbl_student.student_id,tbl_student.student_pre_thai,tbl_student.student_name,tbl_student.student_surname,tbl_member_dep.member_dep_name,tbl_member_dep.member_dep_major,tbl_member_dep.member_dep_faculty,tbl_member_dep.member_dep_address
FROM tbl_student,tbl_member_dep 
WHERE tbl_student.student_department = tbl_member_dep.member_dep_code";

$qeury = mysqli_query($conn,$sql);

 // กำหนดตัวแปรไว้เก็บข้อมูลที่ค้นหาได้
 $data = array();
 // วนลูปค้นหาข้อมูล
 while($result = mysqli_fetch_assoc($qeury)){
     // เก็บข้อมูลที่ค้นหาได้ลงตัวแปร
     $data[] = $result;
 }

// แสดงข้อมูลออกเป็น JSON Data
 echo json_encode($data);

 ?>