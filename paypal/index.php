<?php 

include_once("../config.php");
session_start();
//Set variables for paypal form
$paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; 
//Test PayPal API URL
$paypal_email = 'sb-t5cjy6650961@business.example.com';
?>
<title> Paypal Integration in PHP</title>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<style>
button, input {
    padding-left: 50px;
}

</style>
</head>
<div class="container">
	<div class="col-lg-12">
	<div class="row">
		
        <?php             
            
            $cid = $_SESSION['id'];
            $token_for_now = $_SESSION['tokenforcart'];
            $sql = "SELECT * FROM CART WHERE customer_id ='$cid' and  token='$token_for_now'";
            $result = oci_parse($conn, $sql);
            oci_execute($result);

            //collection id to be stored and later accessed after success of payment
            $_SESSION['collection_slot']=array();
            $cart_id_array = [];
            while($row = oci_fetch_assoc($result)){

                $cart = $row['CART_ID'];
                array_push($cart_id_array , $cart);
            }

            if (isset($_POST['submit'])){
            
                $day =$_POST['collectionDay'];
                $time =$_POST['collectionTime'];

                for($i=0; $i<count($cart_id_array); $i++){
                    
                    $cart = $cart_id_array[$i];                         
                    $sql = "INSERT INTO COLLECTION_SLOTS(collection_time, collection_day, status, cart_id) VALUES('$day','$time','incomplete',$cart)";
                    $result = oci_parse($conn, $sql);
                    oci_execute($result);

                    $sqlupdatecollection = "SELECT collection_slot_id FROM COLLECTION_SLOTS WHERE cart_id = '$cart'";
                    $resultupdatecollection = oci_parse($conn, $sqlupdatecollection);
                    oci_execute($resultupdatecollection);
                    $collection_slots_to_update = oci_fetch_array($resultupdatecollection);

                    array_push($_SESSION['collection_slot'],$collection_slots_to_update);
                }
            }

            //for showing data in paypal folder
            $sql = "SELECT * FROM CART WHERE customer_id ='$cid' and token='$token_for_now'";
            $result = oci_parse($conn, $sql);
            oci_execute($result);
            $count = 0;
            $total_price = 0;
            	?>		    <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">Sn.no</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Product Price</th>
                                <th scope="col">Quantity</th>
                                </tr>
                            </thead>
            <?php
            while($row = oci_fetch_assoc($result)){
                $count++;

                $pid = $row['PRODUCT_ID']; 
                $sqlp = "SELECT product_name FROM PRODUCT WHERE product_id ='$pid'";
                $resultp = oci_parse($conn, $sqlp);
                oci_execute($resultp);
                $row1 = oci_fetch_assoc($resultp);
                $pname = $row1['PRODUCT_NAME'];

            ?>
                            <tbody>
                                <tr>
                                <th scope="row"><?php echo $count; ?></th>
                                <td><?php echo $pname; ?></td>
                                <td><?php echo $row['PRODUCT_PRICE']; ?></td>
                                <td><?php echo $row['QUANTITY']; ?></td>
                                </tr>
                                <?php 
                                        
                                        $quan = $row['QUANTITY'];
                                        $pprice = $row['PRODUCT_PRICE'];
                                        $total_price = $total_price + ($quan * $pprice);       
                            }
                            
                        ?>
                            </tbody>
                            </table>
                            <div class="d-flex justify-content-sm-start justify-content-end mb-sm-0 mb-2">
                                    <h5>
                                        <?php if(isset($total_price)){?>
                                            TOTAL PRICE: <?php echo "£ ".$total_price; 
                                            $_SESSION['sub_total'] = $total_price; ?>
                                        <?php }?>
                                    </h5>
                            </div>

               
                    <form action="<?php echo $paypal_url; ?>" method="post">			
                        <!-- Paypal business test account email id so that you can collect the payments. -->
                        <input type="hidden" name="business" value="<?php echo $paypal_email; ?>">			
                        <!-- Buy Now button. -->
                        <input type="hidden" name="cmd" value="_cart">	

                        <input type="hidden" name="upload" value="1">
                        <!-- Details about the item that buyers will purchase. -->
                    <?php      
                    
                    $_SESSION['updateproduct']= array();
                    $_SESSION['paymenttrader']= array();
                    $_SESSION['updateproductid']= array();

                    $sql = "SELECT * FROM CART WHERE customer_id ='$cid' and  token='$token_for_now'";
                    $result = oci_parse($conn, $sql);
                    oci_execute($result);
                    $count = 0;

                        while($row = oci_fetch_assoc($result)){
                                $count++;
                                
                                //to update product id after success of payment
                                $pid = $row['PRODUCT_ID']; 
                                array_push($_SESSION['updateproductid'],$pid);

                                $sqlp = "SELECT product_name,trader_id FROM PRODUCT WHERE product_id ='$pid'";
                                $resultp = oci_parse($conn, $sqlp);
                                oci_execute($resultp);
                                $row1 = oci_fetch_assoc($resultp);
                                $pname = $row1['PRODUCT_NAME'];
                                $protraderid = $row1['TRADER_ID'];
                                array_push($_SESSION['paymenttrader'],$protraderid);
                                
                                ?>

                        <input type="hidden" name="item_name_<?php echo $count; ?>" value="<?php echo $pname?>">
                        <input type="hidden" name="quantity_<?php echo $count; ?>" value="<?php 
                            
                            echo $row['QUANTITY']; 
                            $update_product_quantity = $row['QUANTITY'];
                            array_push($_SESSION['updateproduct'],$update_product_quantity);
                            ?>">
                        <input type="hidden" name="item_number_<?php echo $count; ?>" value="<?php echo $count; ?>">
                        <input type="hidden" name="amount_<?php echo $count; ?>" value="<?php echo $row['PRODUCT_PRICE']; ?>">

                            <?php    }?>

                            <input type="hidden" name="currency_code" value="GBP">			
                        <!-- URLs -->
                        <input type='hidden' name='cancel_return' value='http://localhost/ecommfinal/paypal/cancel.php'>
                        <input type='hidden' name='return' value='http://localhost/ecommfinal/paypal/success.php'>						
                        <!-- payment button. -->
                        <input type="image" name="submit" border="0"
                        src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" alt="PayPal - The safer, easier way to pay online">
                        <img alt="" border="0" width="1" height="1" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >    
                </form>
			</div>
			</div>
		</div>		
	</div>	
		
</div>



