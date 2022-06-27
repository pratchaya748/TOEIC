<!-- connect_server.php -->
<?php
$hostname = "regis-doc.sci.dusit.ac.th";
$username = "regisdoc";
$password = "12345678";
$mydb = "regisdoc_db";
$conn = new mysqli($hostname , $username , $password , $mydb);
?>