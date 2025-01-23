<h1>Your payment has been successful.</h1>
<?php
/*
error_reporting(1);
include_once("db_connect.php");
//Store transaction information into database from PayPal
$item_number = $_GET['item_number']; 
$txn_id = $_GET['tx'];
$payment_gross = $_GET['amt'];
$currency_code = $_GET['cc'];
$payment_status = $_GET['st'];
//Get product price to store into database
$sql = "SELECT * FROM products WHERE id = ".$item_number;
$resultset = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
$row = mysqli_fetch_assoc($resultset);
if(!empty($txn_id) && $payment_gross == $row['price']){
    //Insert tansaction data into the database
    mysqli_query($conn, "INSERT INTO payments(item_number,txn_id,payment_gross,currency_code,payment_status) VALUES('".$item_number."','".$txn_id."','".$payment_gross."','".$currency_code."','".$payment_status."')");
	$last_insert_id = mysqli_insert_id($conn);  
	
?>
	<h1>Your payment has been successful.</h1>
    <h1>Your Payment ID - <?php echo $last_insert_id; ?>.</h1>
<?php
}else{
?>
	<h1>Your payment has failed.</h1>
<?php
}
?>
*/
include '../config.php';

session_start();
echo "<pre>";
print_r($_SESSION['collection_slot']);
echo "</pre>";

 for($i = 0 ; $i < count($_SESSION['collection_slot']) ; $i++) {
    
    //fetching collection to update the status------------------------------------------------------------------------
    $id_to_change = $_SESSION['collection_slot'][$i]['COLLECTION_SLOT_ID'];
   
    $sqlupdatecollection = "UPDATE collection_slots SET status = 'complete' WHERE collection_slot_id = '$id_to_change'";
    $result = oci_parse($conn, $sqlupdatecollection);
    oci_execute($result);
    //----------------------------------------------------------------------------------------------------------------

    //product quantity to change
    $product_to_change = $_SESSION['updateproduct'][$i];
    
    //product id of the product that needs to be changed
    $product_to_change_id = $_SESSION['updateproductid'][$i];

    //sql query to select old product quantity from product table so that we can update that
    $sqlselectproduct = "SELECT product_quantity FROM PRODUCT WHERE product_id='$product_to_change_id'";
    $resultselectproduct = oci_parse($conn, $sqlselectproduct);
    oci_execute($resultselectproduct);
    $seeproductquantity = oci_fetch_assoc($resultselectproduct);
    $productquantity = $seeproductquantity['PRODUCT_QUANTITY'];

    //new quantity saved in variable $new_quantity
    $new_quantity = $productquantity - $product_to_change;

    //
    $sqlupdateproduct = "UPDATE PRODUCT SET product_quantity = '$new_quantity' WHERE product_id = '$product_to_change_id'";
    $resultupdateproduct = oci_parse($conn, $sqlupdateproduct);
    oci_execute($resultupdateproduct);

    /*
    print_r($product_to_change_id);
    echo "<br>";
    echo "<br>";
    print_r($product_to_change);
    echo "<br>";
    echo "<br>";
    print_r($productquantity);
    echo "<br>";
    echo "<br>";
    */

 }

 $total = $_SESSION['sub_total'];
 $cid  = $_SESSION['id'];
 $trader_to_add_in_payment_details = $_SESSION['paymenttrader'];
 $token_for_payment = bin2hex(random_bytes(15));

    $sqlpayment = "INSERT INTO payment (payment_date, sub_total, customer_id, token) VALUES (sysdate,' $total' , ' $cid' , '$token_for_payment')";
    $resultsqlpayment = oci_parse($conn, $sqlpayment);
    oci_execute($resultsqlpayment);
    $_SESSION['tokenforpayment'] = $token_for_payment;

    $token_for_this = $_SESSION['tokenforpayment'];
    $selectpaymentid = "SELECT payment_id FROM payment WHERE customer_id = '$cid' and token = '$token_for_this'";
    $resultpaymentid = oci_parse($conn, $selectpaymentid);
    oci_execute($resultpaymentid);
    $paymentid = oci_fetch_array($resultpaymentid);
    $payment_id = $paymentid['PAYMENT_ID'];


//for inserting into payment details
for($i = 0; $i < count($_SESSION['collection_slot']); $i++) {

    //product id to store in payment details
    $product_to_add_in_payment_details = $_SESSION['updateproductid'][$i];

    //product quantity to store in payment details
    $product_quantity_to_store_in_payment_details = $_SESSION['updateproduct'][$i];

    //product unit price to store in payment details
    $sqlselectproductprice = "SELECT product_price FROM PRODUCT WHERE product_id='$product_to_add_in_payment_details'";
    $resultselectproductorice = oci_parse($conn, $sqlselectproductprice);
    oci_execute($resultselectproductorice);
    $seeproductprice = oci_fetch_assoc($resultselectproductorice);
    $productprice = $seeproductprice['PRODUCT_PRICE'];

    /*
    echo "payment details: <br>";
    print_r($product_to_add_in_payment_details);
    echo "<br>";
    echo "<br>";
    print_r($product_quantity_to_store_in_payment_details);
    echo "<br>";
    echo "<br>";
    print_r($productprice);
    echo "<br>";
    echo "<br>";
    print_r($trader_to_add_in_payment_details[$i]);
    echo "<br>";
    echo "<br>";
    print_r($payment_id);
    echo "<br>";
    echo "<br>";
    */
    $trader_to_add = $trader_to_add_in_payment_details[$i];
    
    $sqlpaymentdetail = "INSERT INTO payment_details (product_id, trader_id, product_price, product_quantity, payment_id) 
    VALUES ('$product_to_add_in_payment_details',' $trader_to_add' , ' $productprice','$product_quantity_to_store_in_payment_details','$payment_id')";

    $resultpaymentdetail = oci_parse($conn, $sqlpaymentdetail);
    oci_execute($resultpaymentdetail);
   
    header("location: ../index.php");
}
?>


