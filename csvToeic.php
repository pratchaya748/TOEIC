<?php
require ("connect.php");

if(!empty($_FILES["csvF"]["name"])){ 
    $allowed_ext = array("csv");  
    $file = explode(".", $_FILES["csvF"]["name"]);
    $extension = end($file);  

      if(in_array($extension, $allowed_ext))  { 
           $file_data = fopen($_FILES["csvF"]["tmp_name"], 'r');  
           fgetcsv($file_data);  
           $data = array();

           while($row = fgetcsv($file_data)) {   
                $studentID = mysqli_real_escape_string($conn, $row[0]);
                $studentID = str_replace(' ', '', $studentID);
                $student_pre_thai = mysqli_real_escape_string($conn, $row[1]); 
                $student_name  = mysqli_real_escape_string($conn, $row[2]); 
                $student_surname  = mysqli_real_escape_string($conn, $row[3]);
                $student_pre_eng = mysqli_real_escape_string($conn, $row[4]);  
                $student_name_eng = mysqli_real_escape_string($conn, $row[5]); 
                $student_surname_eng =  mysqli_real_escape_string($conn, $row[6]); 

                $member_dep_address = mysqli_real_escape_string($conn, $row[7]);  
                $member_dep_address = str_replace(' ', '', $member_dep_address); 
                $member_dep_faculty = mysqli_real_escape_string($conn, $row[8]); 
                $member_dep_faculty = str_replace(' ', '', $member_dep_faculty);
                $member_dep_major = mysqli_real_escape_string($conn, $row[9]); 
                $member_dep_major = str_replace(' ', '', $member_dep_major);
                $member_dep_name = mysqli_real_escape_string($conn, $row[10]); 
                $member_dep_name = str_replace(' ', '', $member_dep_name);

                $listening =  mysqli_real_escape_string($conn, $row[11]);
                $reading =  mysqli_real_escape_string($conn, $row[12]);
                $total =  mysqli_real_escape_string($conn, $row[13]);
                $train = mysqli_real_escape_string($conn, $row[14]);

                // check studentID
               $id = mysqli_query($conn,"SELECT * FROM tbl_student WHERE student_id = '$studentID'");
               $check_id = mysqli_fetch_assoc($id);
               
                //   ซ้ำ
               if (isset($check_id['student_id'])) {
                //    วัน
                    date_default_timezone_set('Asia/Bangkok');
                    $date = new DateTime("now"); 
                    $putdate = $date->format('Y-m-d');

                    // หาสาขา
                    $dep = mysqli_query($conn,"SELECT * FROM tbl_member_dep
                    WHERE member_dep_address = '$member_dep_address' and member_dep_name = '$member_dep_name' ");
                    $search_dep = mysqli_fetch_assoc($dep);
                    $m_dep = $search_dep['member_dep_code'];

                    // ใส่คะแนน
                   $put_s = mysqli_query($conn,"INSERT INTO tbl_score VALUES ('','$studentID','$m_dep','$listening',
                   '$reading','$total','$train','$putdate')");
                   
                    // ส่งชื่อที่ซ้ำ
                    $result = mysqli_query($conn, "SELECT * FROM tbl_student,tbl_member_dep WHERE 
                    tbl_student.student_department = tbl_member_dep.member_dep_code and student_id = '$studentID'");

                    $row = mysqli_fetch_object($result);
                    $data[] = $row;
                    
               }
                //    ไม่ซ้ำ
               else if (!isset($check_id['student_id'])){
                   //    วัน
                   date_default_timezone_set('Asia/Bangkok');
                   $date = new DateTime("now"); 
                   $putdate = $date->format('Y-m-d');

                   // หาสาขา
                   $dep = mysqli_query($conn,"SELECT * FROM tbl_member_dep 
                   WHERE member_dep_address = '$member_dep_address' and member_dep_name = '$member_dep_name' and
                   member_dep_major = '$member_dep_major' and member_dep_faculty = '$member_dep_faculty' ");
                   $search_dep = mysqli_fetch_assoc($dep);
                //    $m_dep = $search_dep['member_dep_code'];

                //    เช็คสาขากับที่ตั้งว่าซ้ำหรือป่าว
                   if(!isset($search_dep['member_dep_code'])){

                        $a_dep = mysqli_query($conn,"INSERT INTO tbl_member_dep VALUES 
                        ('','$member_dep_name','$member_dep_major','$member_dep_faculty','$member_dep_address') ");
                        // $ra_dep = mysqli_fetch_assoc($dep);

                        // หาสาขา
                        $dep = mysqli_query($conn,"SELECT * FROM tbl_member_dep 
                        WHERE member_dep_address = '$member_dep_address' and member_dep_name = '$member_dep_name' and
                        member_dep_major = '$member_dep_major' and member_dep_faculty = '$member_dep_faculty' ");
                        $search_dep = mysqli_fetch_assoc($dep);
                        $m_dep = $search_dep['member_dep_code'];
                   }
                   else {
                        $m_dep = $search_dep['member_dep_code'];
                   }

                //    เพิ่ม นร.
                    $add_student = mysqli_query($conn,"INSERT INTO tbl_student 
                    VALUES ('$studentID','$student_pre_thai','$student_name','$student_surname',
                    '$student_pre_eng','$student_name_eng','$student_surname_eng','$m_dep')");

                   // ใส่คะแนน
                   $put_s = mysqli_query($conn,"INSERT INTO tbl_score VALUES ('','$studentID','$m_dep','$listening',
                   '$reading','$total','$train','$putdate')");

                //     echo "บันทึกข้อมูลสำเร็จ";
                }
               else {
                    $data = "ผิดพลาด";
                    echo json_encode($data);
               }
           }
           if (isset($check_id['student_id'])) {
                echo json_encode($data);
           }

      }  
      else  
      {  
          echo 'Error1';  
      }  
 }  
 else  
 {  
     echo "Error2";  
 }  




?>