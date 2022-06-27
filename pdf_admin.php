<?php
session_start();
include 'connect.php';

require('fpdf.php');
class PDF extends FPDF
{
//load data
function LoadData($file)
{
 //Read file lines
 $lines=file($file);
 $data=array();
 foreach($lines as $line)
 $data[]=explode(';',chop($line));
 return $data;
}
function Header(){
 $this->Image('sdu.jpg',10,8,30);
 $this->AddFont('THSarabunNew','','THSarabunNew.php');
 $this->SetFont('THSarabunNew','',16);
 $this->Cell(30, 10, iconv('UTF-8', 'cp874', ' '));
 $this->Cell(10, 25, iconv('UTF-8', 'cp874', 'รายงานผู้ผ่านการทดสอบความรู้ความสามารถด้านภาษาอังกฤษของนักศึกษาตามเกณฑ์มหาวิทยาลัย'));
 $this->Cell(38, 10, iconv('UTF-8', 'cp874', ' '));
 $this->Cell(-40, 45, iconv('UTF-8', 'cp874', 'มหาวิทยาลัยสวนดุสิต'));
 $this->Cell(0,0,iconv( 'UTF-8','TIS-620','หน้าที่... '.$this->PageNo()),0,1,"R");

$this->Cell(0,0,iconv( 'UTF-8','TIS-620', $post_regisdate),0,1,"R");

 $this->Ln(35);
 }
//Simple table
function BasicTable($header,$data)
{
 //Header
 $w=array(15,35,55,35,55);
 //Header
 $this->Ln(1);
 for($i=0;$i<count($header);$i++)
 $this->Cell($w[$i],6,iconv('UTF-8','cp874',$header[$i]),1,0,'C');
 //$pdf->Write(5,iconv('UTF-8','cp874' , 'อะไร ' ));
 $this->Ln();
 //Data
 $number=0;
 foreach ($data as $eachResult)
 {
 $number=$number+1;
 $this->Cell(15,6,$number,1,0,'C');
 $this->Cell(35,6,iconv('UTF-8', 'TIS-620',$eachResult["student_id"]),1,0,'C');
 $this->Cell(55,6,iconv('UTF-8', 'TIS-620',$eachResult["student_pre_thai"]."  ".$eachResult["student_name"]."  ".$eachResult["student_surname"]),1,0,'L');
 $this->Cell(35,6,iconv('UTF-8', 'TIS-620',$eachResult["member_dep_major"]),1,0,'C');
 $this->Cell(55,6,iconv('UTF-8', 'TIS-620',$eachResult["member_dep_name"]),1,0,'L');
 $this->Ln();
 }
}
}
$pdf=new PDF();
$header=array('ลำดับ','รหัสนักศึกษา','ชื่อ - นามสกุล','หลักสูตร','สาขาวิชา');


//Data loading
 //***Load MySQL Data***//
    //  กำหนดปี
if (!isset($_GET['year'])) {
    $year = "";
 }
 else {
    $year = $_GET['year'];
 }

 if (!isset($_GET['search'])) {
    $search = "";
 }
 else {
    $search = $_GET['search'];
 }

if ($year != "") {
    $year = $_GET['year'];
    $result = $conn -> query($sql_count)  ;
 
    $sql_show = "SELECT  *  FROM  tbl_student ,tbl_member_dep  
    where  tbl_student.student_department = tbl_member_dep.member_dep_code and (student_id LIKE '$year%')";
}
// กรณีค้นหา get
else if ($search != "") {
    // print "<script>alert ('search get')</script>";

    $search = $_GET['search'];
    $sql_show = "SELECT  *  FROM  tbl_student ,tbl_member_dep  
    where  tbl_student.student_department = tbl_member_dep.member_dep_code 

    and (student_id like '%$search%' 
    or student_pre_thai like '%$search%'
    or student_name like '%$search%'
    or student_surname like '%$search%'
    or member_dep_name like '%$search%'
    or member_dep_major like '%$search%'
    or member_dep_faculty like '%$search%'
    or member_dep_address like '%$search%')";
}
// กรณีค้นหา
else{
    $sql_show = "SELECT  *  FROM  tbl_student ,tbl_member_dep  
    where  tbl_student.student_department = tbl_member_dep.member_dep_code ";
}

$post_regisdate = $_GET['id'] ;
$sql = "SELECT student_id, student_name, student_surname, member_dep_name, member_dep_major ,member_dep_faculty ,member_dep_address, student_pre_thai
FROM tbl_student, tbl_member_dep
WHERE student_department=member_dep_code " ;

 $dbquery = $conn->query($sql_show);
 $resultData = array();
 for($i=0;$i<mysqli_num_rows($dbquery);$i++){
 $result = $dbquery->fetch_assoc();
 array_push($resultData,$result);
 }
$pdf->AddFont('THSarabunNew','','THSarabunNew.php');
$pdf->SetFont('THSarabunNew','',16);
$pdf->AddPage();
$pdf->Ln(10);
$pdf->BasicTable($header,$resultData);
$pdf->Output("",'I');
print $id
?>
