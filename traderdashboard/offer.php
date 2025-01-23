<?php 

include "../config.php";

session_start();
if(!isset($_SESSION['trader_username'])){
    header("Location: login.php");
}
else{
$id =$_SESSION['trader_id'];
if(isset($_POST['offerAmount'])){
    
        $product = $_POST['product_offer'];
   
        $offer = $_POST['offerAmount'];
        
        $sql = "INSERT INTO product_offer (offer_amount, product_id,trader_id) VALUES ('$offer', '$product', '$id')";

        $result = oci_parse($conn,$sql);
        oci_execute($result);

        if ($result) {
            echo "<script>alert('Offer has been Added')</script>";
            ?>
<META HTTP-EQUIV="REFRESH" CONTENT="0; URL=http://localhost/ecommfinal/traderdashboard/">
<?php
        } else {
            echo "<script>alert('Record has not updated')</script>";
            ?>
<META HTTP-EQUIV="REFRESH" CONTENT="0; URL=http://localhost/ecommfinal/traderdashboard/">
<?php
        }

    }
}
?>