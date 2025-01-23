<?php 
        include "config.php";
        session_start();
        $name =$_SESSION['id'];
        $sql ="DELETE FROM customer WHERE customer_id='$name' ";
        $query=oci_parse($conn,$sql) or die("Account deleting failed!!");
        oci_execute($query);
        session_unset();
        session_destroy();
        header("Location: index.php");
?>