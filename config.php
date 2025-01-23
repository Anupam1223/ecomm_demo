<?php    
/*
 $servername = "localhost";
 $username = "root";
 $password = "";
 $dbname = "localmarket";

 // Create connection

 $conn = mysqli_connect($servername, $username, $password, $dbname);

 // Check connection

 if (!$conn) {
     die("Connection failed: " . mysqli_connect_error());
 }

*/
 
 $conn = oci_connect('localmarket', '1234', '//localhost/xe'); 

 if (!$conn) {
     $m = oci_error();
     echo $m['message'], "\n";
     exit;
 } 
?>