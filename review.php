<?php

session_start();

include 'config.php';

if(isset($_POST['review'])){
    $review=$_POST['review'];
    $product_id = $_POST['product_id'];


    if(!isset($_POST['review']) || empty($_POST['review'])){
        echo json_encode(array('error'=>'please enter your feedback on our product')); exit;
    }
    else{

        $cid = $_SESSION['id'];
        $feedbackquery="SELECT * FROM feedback WHERE customer_id='$cid' and product_id='$product_id' ";
        $query=oci_parse($conn,$feedbackquery);
        oci_execute($query);

        $feedback_count=oci_fetch_assoc($query);
        if($feedback_count>0){
            echo json_encode(array('error'=>'already reviewed')); exit;
        }
        else{
            $insertqry="INSERT INTO feedback(feedback, customer_id, product_id)
            VALUES('$review','$cid','$product_id')";
            $iqry=oci_parse($conn,$insertqry);
            oci_execute($iqry);
            if($iqry){
                echo json_encode(array('success'=>'review added!!!!')); exit;
            }
        }

    }
}
?>