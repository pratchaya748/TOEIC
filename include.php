<?php
include "connect.php";

if(isset($_POST["import"]))
{
 $extension = end(explode(".", $_FILES["excel"]["name"])); // For getting Extension of selected file
 $allowed_extension = array("xls", "xlsx", "csv"); //allowed extension
 if(in_array($extension, $allowed_extension)) //check selected file extension is present in allowed extension array
 {
  $file = $_FILES["excel"]["tmp_name"]; // getting temporary source of excel file
  include("Classes/PHPExcel/IOFactory.php"); // Add PHPExcel Library in this code
  $objPHPExcel = PHPExcel_IOFactory::load($file); // create object of PHPExcel library by using load() method and in load method define path of selected file

  foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
  {
   $highestRow = $worksheet->getHighestRow();
   for($row=2; $row<=$highestRow; $row++)
   {
      $student_id = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
      $student_pre_thai = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(1, $row)->getValue());
      $student_name = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(2, $row)->getValue());
      $student_surname = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(3, $row)->getValue());       
      $student_pre_eng = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(4, $row)->getValue());
      $student_name_eng = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(5, $row)->getValue());
      $student_surname_eng = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(6, $row)->getValue());
      $student_department = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(7, $row)->getValue());
      
      $query = "INSERT INTO tbl_student VALUES ('$student_id','$student_pre_thai','$student_name','$student_surname',
      '$student_pre_eng','$student_name_eng','$student_surname_eng','$student_department')";
      mysqli_query($conn, $query);
   }
  } 
 }
 else
 {
    print "<script>alert('Import error')</script>" ; //if non excel file then
 }
}


?>

<html>
 <body>
   <form method="post" enctype="multipart/form-data">
        <label>Select Excel File</label>
        <input type="file" name="excel" />
        <br />
        <input type="submit" name="import" class="btn btn-info" value="Import" />
   </form>
   
 </body>
</html>

