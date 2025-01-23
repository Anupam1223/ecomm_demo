<?php

include "../config.php";
    
        $id = $_POST['traderId'];
        $name = $_POST['traderName'];
        $email = $_POST['email'];
        $desc = $_POST['traderDesc'];
        $phone = $_POST['phone'];

        if($_FILES['fileName']['name'] != ""){

                $file_name = $_FILES['fileName']['name'];
                $temp_name = $_FILES['fileName']['tmp_name'];
                move_uploaded_file($temp_name, "images/".$file_name);
                
                $sql = "UPDATE trader SET trader_name = '$name', email = '$email', phone_no = '$phone', trader_description = '$desc', trader_image='$file_name' WHERE trader_id = '$id'";
        }
        else{
                $sql = "UPDATE trader SET trader_name = '$name', email = '$email', phone_no = '$phone', trader_description = '$desc' WHERE trader_id = '$id'";     
        }
        $query=oci_parse($conn,$sql);
        oci_execute($query);

        if($query){
                        echo "<script>alert('Your profile has been updated')</script>";
                        ?>
        <META HTTP-EQUIV="REFRESH" CONTENT="0; URL=http://localhost/ecommfinal/traderdashboard/index.php#viewItem">
        <?php
                }   
                
        
        ?>