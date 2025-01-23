<?php

include "../config.php";

session_start();
if(!isset($_SESSION['trader_username'])){
    header("Location: login.php");
}
else {
$id =$_SESSION['trader_id'];

$sql = "SELECT * from trader where trader_id='$id'";
$run_sql = oci_parse($conn,$sql);
oci_execute($run_sql);

$row = oci_fetch_assoc($run_sql) or die("Not Successful");

$sid = $row['SHOP'];

          $name = $_POST['itemName'];
          $price = $_POST['itemPrice'];
          $stock = $_POST['stockLevel'];
          $desc = $_POST['itemDesc'];
          $rating = 0;
          $rated=0;

          if(!empty(isset($_FILES['image']))){

                  $file_name = $_FILES['image']['name'];
                  $temp_name = $_FILES['image']['tmp_name'];
                  move_uploaded_file($temp_name, "../images/".$file_name);
                  
                  $qry ="INSERT INTO product(Product_name, Product_Description, Rating, Product_image, Product_price, Product_quantity, trader_id, Rated_by, shop) VALUES ('$name', '$desc', '$rating', '$file_name', '$price', '$stock', '$id', '$rated', '$sid')";

                  $query=oci_parse($conn, $qry);
                  oci_execute($query);
                }
                else{
                  echo "please choose product image";
                }
          if ($query) {
          echo "<script>
          alert('Your Product has been inserted')
          </script>";
          ?>
          
          <META HTTP-EQUIV="REFRESH" CONTENT="0; URL=http://localhost/ecommfinal/traderdashboard/index.php#viewItem">
          <?php
                  } else {
                    echo "<script>alert('Your record has not been inserted')</script>";

                    ?>
          <META HTTP-EQUIV="REFRESH" CONTENT="0; URL=http://localhost/ecommfinal/traderdashboard/index.php#viewItem">
          <?php
                      }
                    }
          ?>