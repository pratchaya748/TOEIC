<?php
include 'connect.php';

// รับค่าจาก jQuery
$search = $_POST['search'];

// เช็คว่าทั้ง 3 ช่องต้องไม่เป็นค่าว่าง
if(!empty($search) or !empty($nickname) or !empty($province)){
    $sql = "SELECT  student_id,student_pre_thai,student_name,
    student_surname,member_dep_name,
    member_dep_major,member_dep_faculty,member_dep_address  
    FROM  student_data  WHERE student_id like '%$search%' 
    or student_pre_thai like '%$search%'
    or student_name like '%$search%'
    or student_surname like '%$search%'
    or member_dep_name like '%$search%'
    or member_dep_major like '%$search%'
    or member_dep_faculty like '%$search%'
    or member_dep_address like '%$search%'";
    
    $qeury = mysqli_query($conn,$sql);

    // กำหนดตัวแปรไว้เก็บข้อมูลที่ค้นหาได้
    $search_data = array();
    // วนลูปค้นหาข้อมูล
    while($result = mysqli_fetch_assoc($qeury)){
        // เก็บข้อมูลที่ค้นหาได้ลงตัวแปร
        $search_data[] = $result;
    }
    // แสดงข้อมูลออกเป็น JSON Data
    echo json_encode($search_data);
}