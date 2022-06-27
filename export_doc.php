<meta charset="UTF-8">
<script>
  function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}
</script><br>
<center><button style="font-size:1em ;background: #072a40 color:white ; border-radius: 20px ; width: 150px; height: 35px;" onclick="exportTableToExcel('tableData')">Export to Excel</button></center>
<?php
$conn = new mysqli("localhost", "rooot", "", "regisdoc_db");
$sql = "SELECT * FROM documents";
$result = $conn->query($sql);
 if(isset($_GET['act'])){
  if($_GET['act']== 'excel'){
    header("Content-Type: application/vnd.ms-excel");
    header('Content-Disposition: attachment; filename="myexcel.xls"');
    header("Content-Type: application/force-download"); 
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download"); 
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: ".filesize("myexcel.xls"));   

    @readfile($filename);
  }
}

?>
<body>
<center>
<table border='1' id="tableData" class="table-main"> 
<tr>
<tH>รหัสเอกสาร</tH><tH>ชื่อเอกสาร</tH><tH>วันที่สร้างเอกสาร</tH><tH>วันที่อัพเดตเอกสาร</tH><tH>รหัสคนสร้างเอกสาร</tH><tH>รหัสคนอัพเดตเอกสาร</tH>

</TR>
<?php
$i=1
?>
<?php while($row = $result -> fetch_row()) {  ?>
 <tr align='center'>
 <?php  for ($i=0; $i<6; $i++) { ?>
  <td><?php echo $row[$i];  ?>   </td>
 <?php } ?>
 </tr>
<?php } ?>
 </body>
</center>
</table>