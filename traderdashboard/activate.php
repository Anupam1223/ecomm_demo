<?php
session_start();
include '../config.php';
if(isset($_GET['token'])){

    $token = $_GET['token'];
    $update_qry= "UPDATE TRADER SET STATUS='active' WHERE TOKEN='$token'";

    $query=oci_parse($conn,$update_qry);
    oci_execute($query);

    if(oci_execute($query)){
        if(isset($_SESSION['msg'])){
            $_SESSION['msg']="Account Activate successfully";
            header('location: activatesuccess.php');
        }
        else{
            $_SESSION['msg']="you are logged out.";
            header('location: activatesuccess.php');
        }
    }
    else{
        $_SESSION['msg']="Account not Activated ";
            header('location: register.php');
    }
}

?>