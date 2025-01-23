<?php

include '../config.php';


session_start();
if(!isset($_SESSION['trader_username'])){
    header("Location: login.php");
}
else{
    $id = $_POST['productID'];

    $name = $_POST['itemName'];
    $desc = $_POST['itemDesc'];
    $price = $_POST['itemPrice'];
    $stock = $_POST['stockLevel'];

    if($_FILES['fileName']['name'] != ""){

        $file_name = $_FILES['fileName']['name'];
        $temp_name = $_FILES['fileName']['tmp_name'];
        move_uploaded_file($temp_name, "../images/".$file_name);
        
            $qry = "UPDATE product SET Product_name = '$name', Product_Description = '$desc', Product_price = '$price', Product_quantity = '$stock', Product_image='$file_name' WHERE Product_ID = '$id'"; 
        }
        else{
            $qry = "UPDATE product SET Product_name = '$name', Product_Description = '$desc', Product_price = '$price', Product_quantity = '$stock' WHERE Product_ID = '$id'";   
        }

    $result = oci_parse($conn, $qry);
    oci_execute($result);
?>

<?php
if ($result) {
    echo "<script>alert('Your record has been updated')</script>";
    ?>
    <META HTTP-EQUIV="REFRESH" CONTENT="0; URL=http://localhost/ecommfinal/traderdashboard/">
    <?php
    }
    }
    
?>
    