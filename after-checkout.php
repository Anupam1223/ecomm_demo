<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link crossorigin="anonymous" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" rel="stylesheet">
    <link crossorigin="anonymous" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        referrerpolicy="no-referrer" rel="stylesheet" />

    <link rel="stylesheet" href="style/style.css">

    <title>Delivery Details | LocalMarket</title>

    <style>
    .bg-check {
        background: #fff;
        border-radius: 8px;
    }

    .checkout h4 {
        display: inline-block;
        border-bottom: 1px solid black;
    }
    </style>
</head>

<body>
    <?php 
        include "config.php";
        session_start();
        include "navbar2.php";
     ?>
    <div class="checkout mt-2">
        <div class="container">
            <div class="row bg-check">
                <div class="col-md-11 col-12 mx-auto mt-md-3 mt-2">
                    <h4>Order Details</h4>
                    <table class="table">

                    <?php 

                        $cid = $_SESSION['id'];
                        $token_for_now = $_SESSION['tokenforcart'];
                        $sql = "SELECT * FROM CART WHERE customer_id ='$cid' and token ='$token_for_now'";
                        $result = oci_parse($conn, $sql);
                        oci_execute($result);
                        $count = 0;
                        $total_price = 0;
                        
                    ?>
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
                                            TOTAL PRICE: <?php echo "£ ".$total_price; ?>
                                        <?php }?>
                                    </h5>
                            </div>
                    <hr />
                </div>

                <div class="col-md-11 col-12 mx-auto mt-2">
                    <h4 class="mb-md-3 mb-2 mt-2">Collection Slot</h4>
                    <form action="paypal/index.php" method="POST" enctype="multipart-form-data">
                        <div class="row">
                            <div class="col-12 col-md-5 mr-auto">
                                <?php
                                    date_default_timezone_set('Asia/Kathmandu');
                                        $datenow = date("l");
                                                    if ($datenow = 'Sunday' || $datenow = 'Monday' || $datenow = 'Tuesday'){
                                                        ?>
                                                    <select id="collectionDay" class="form-control custom-select-sm" name="collectionDay">
                                                        <option selected value="0">Collection Day</option>
                                                        <option value="Wednesday">Wednesday</option>
                                                        <option value="Thursday">Thursday</option>
                                                        <option value="Friday">Friday</option>
                                                    </select>
                                                    <?php
                                                    } elseif($datenow = 'Wednesday'){
                                                    ?>
                                                    <select id="collectionDay" class="form-control custom-select-sm" name="collectionDay">
                                                        <option selected value="0">Collection Day</option>
                                                        <option value="Thursday">Thursday</option>
                                                        <option value="Friday">Friday</option>
                                                    </select>
                                                    <?php
                                                    } elseif($datenow = 'Thursday'){
                                                    ?>
                                                    <select id="collectionDay" class="form-control custom-select-sm" name="collectionDay">
                                                        <option selected value="0">Collection Day</option>
                                                        <option value="Friday">Friday</option>
                                                        <option value="Wednesday">Wednesday</option>
                                                    </select>
                                                    <?php
                                                    } elseif($datenow = 'Friday' || $datenow = 'Saturday'){
                                                    ?>
                                                    <select id="collectionDay" class="form-control custom-select-sm" name="collectionDay">
                                                        <option selected value="0">Collection Day</option>
                                                        <option value="Wednesday">Wednesday</option>
                                                        <option value="Thursday">Thursday</option>
                                                    </select>
                                                    <?php
                                                    } ?>


                            </div>
                            <div class="col-12 col-md-5">
                                <?php
                                    date_default_timezone_set('Asia/Kathmandu');
                                        $time = date('H');
                                                    if ($time >= 16 || $time < 10){
                                                        ?>
                                                    <select id="collectionTime" class="form-control custom-select-sm mt-2 mt-md-0" name="collectionTime">
                                                        <option selected value="0">Collection Time</option>
                                                        <option value="10-13">10 AM - 1 PM

                                                        
                                                        </option>
                                                        <option value="13-16">1 PM - 4 PM</option>
                                                        <option value="16-19">4 PM - 7 PM</option>
                                                        
                                                    </select>
                                                    <?php
                                                    }elseif($time < 13){
                                                    ?>
                                                    <select id="collectionTime" class="form-control custom-select-sm mt-2 mt-md-0" name="collectionTime">
                                                        <option selected value="0">Collection Time</option>
                                                        <option value="13-16">1 PM - 4 PM</option>
                                                        <option value="16-19">4 PM - 7 PM</option>
                                                    </select>
                                                    <?php
                                                    }elseif($time < 16){
                                                    ?>
                                                    <select id="collectionTime" class="form-control custom-select-sm mt-2 mt-md-0" name="collectionTime">
                                                        <option selected value="0">Collection Time</option>
                                                        <option value="16-19">4 PM - 7 PM</option>
                                                    </select>
                                                    <?php

                                                    }
                                                    ?>
                            </div>
                        </div>
                        <div class="col-md-9 col-12 mx-auto">
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary btn-sm mt-md-3 mt-2 w-50 mb-3" name="submit">PayPal Pay</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include "footer.php"; ?>
</body>
</html>