<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link crossorigin="anonymous" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" rel="stylesheet">
    <link crossorigin="anonymous" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        referrerpolicy="no-referrer" rel="stylesheet" />
    <link rel="stylesheet" href="style/style.css">
    <title>
        Cart
    </title>
</head>
<body>
    <div id="navbar">
        <?php include "navbar.php" ;
              include "config.php";
        ?>
    </div>
    <div class="container">
        <?php include "category.php" ?>
    </div>
    <section class="my-cart">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-12 mx-auto col-12 main_cart mb-lg-0">
                    <div class="card">
                        <h2 class="pt-4 mx-auto font-weight-bold pb-1 border-bottom">
                            <i class="fas fa-shopping-basket"></i>
                            My Cart
                        </h2>
                        <hr />
                        <?php
                     if(isset($_COOKIE['user_cart'])){
                         $pid = json_decode($_COOKIE['user_cart']);
                         if(is_object($pid)){
                            $pid = get_object_vars($pid);
                                  }
                            $pids = implode(',',$pid);
                                /*
                                $sql = "select * from product where Product_ID in ($pids)";
                                $result = mysqli_query($conn, $sql) or die("query didnt worked");
                                $no_of_rows=mysqli_num_rows($result);
                                */
                                $sql = "SELECT * FROM product WHERE Product_ID IN ($pids)";
                                $result = oci_parse($conn,$sql);
                                oci_execute($result) or die("query didnt worked"); 

                                $no_of_rows = oci_num_fields($result);
                                
                                $totalquantity=1;
                                $total_unit_price = 0;
                                $product_id_cart = [];
                                $product_id_unitprice = [];

                                if(oci_num_fields($result) > 0){

                                while (($row = oci_fetch_array($result, OCI_ASSOC)) != false){


                                    $pid= $row['PRODUCT_ID'];
                                    $sql_discount = "SELECT offer_amount FROM product_offer WHERE product_id =$pid ";
                                    $discount_result = oci_parse($conn,$sql_discount);
                                    oci_execute($discount_result);
                                    $product_offer_amount = oci_fetch_array($discount_result);
                                  ?>
                        <div class="cart-border row mt-4">
                            <!-- cart images div -->
                            <div class="col-md-2 d-flex product_img">
                                <img alt="cart img" class="img-fluid cart-image"
                                    src="images/<?php echo $row['PRODUCT_IMAGE']; ?>">
                                </img>
                            </div>
                            <!-- cart product details -->
                            <div class="col-md-10 col-12 mt-2 ">
                                <div class="row justify-content-md-center">
                                    <!-- product name  -->
                                    <div class="col-10 card-title">
                                        <h1 class="product_name">
                                            <?php echo $row['PRODUCT_NAME']; ?>
                                        </h1>
                                    </div>
                                    <!-- quantity -->
                                    <div class="col-2 card-title">
                                        <input class="form-control form-control-sm item-qty" value="1" type="number" min='1' max='20' />
                                    </div>
                                </div>
                                <!-- //remover move and price -->
                                <div class="row">
                                    <div class="col-6 d-flex justify-content-between remove">
                                        <a class="text-danger productid" href="" data-id="<?php echo $row['PRODUCT_ID']; ?>">
                                            <i class="fas fa-trash-alt">
                                            </i>
                                            REMOVE ITEM
                                        </a>
                                    </div>
                                    <div class="col-6 d-flex justify-content-end unit">
                                        <p>
                                            UNIT PRICE: £
                                            <?php 
                                                    $final_price = $row['PRODUCT_PRICE'];
                                                    if(!empty($product_offer_amount['OFFER_AMOUNT'])){
                                                        $final_price = $row['PRODUCT_PRICE']-$product_offer_amount['OFFER_AMOUNT'];
                                                    }
                                                    echo "<span class='cart-price'>".$final_price."</span>"; 
                                                    ?>
                                                    <?php if(!empty($product_offer_amount)) {?>
                                                        <small class="pl-3 text-muted">
                                                            <?php echo '£'.$product_offer_amount['OFFER_AMOUNT'].' off' ?></small>
                                                        <?php }?>

                                            <?php 
                                            
                                            $total_unit_price = $total_unit_price + $final_price; 
                                                               
                                            array_push($product_id_cart , $pid); // if not then pushes it into array
                                        
                                            array_push($product_id_unitprice , $final_price); // if not then pushes it into array
                                        
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr />
                        <?php }
                        
                            }?>

                        <div class="row">
                            <div class="col-md-12 d-flex flex-column-reverse flex-sm-row justify-content-sm-between ">
                                <div class="coupon-code d-flex justify-content-sm-start justify-content-end">
                                    <div>
                                        <input class="form-control-sm" id="exampleFormControlInput1"
                                            placeholder="Enter Coupon Code" type="text">
                                        </input>
                                    </div>
                                    <div>
                                        <a class="btn btn-primary btn-sm ml-2 px-3" href="">
                                            Apply
                                        </a>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-sm-start justify-content-end mb-sm-0 mb-2">
                                    <h5>
                                        TOTAL PRICE: <?php echo "£"; ?>
                                        
                                    </h5>
                                    <h5 id="show-price">
                                        <?php
                                    if(isset($total_unit_price)){
                                        echo $total_unit_price;
                                    }
                                    else{

                                    }
                               ?>
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <hr />
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-between">
                                <a href="index.php" class="btn btn-primary btn-sm">Continue Shopping</a>

                                <?php if(isset($_SESSION['username'])){?>

                                <a class="btn btn-primary btn-sm" id="checkoutform" href="after-checkout.php">Checkout</a>
                                <?php }?>


                                <?php if(!isset($_SESSION['username'])){ ?>
                                <a class="btn btn-primary btn-sm" href="#" data-toggle="modal"
                                    data-target="#userLogin_form">Checkout</a>
                                <?php }?>
                            </div>
                        </div>

                        <?php }
                        else { ?>
                        <div class="empty-result text-center">
                            Your cart is currently empty. <a href="index.php">Continue Shopping</a>
                        </div>
                        <?php }?>
                    </div>
                </div>
            </div>
    </section>

    <?php include "footer.php" ?>
    <?php include "script.php" ?>

    <script src="script/action.js"></script>

    <script src="http://code.jquery.com/jquery-3.4.0.min.js"
        integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>
    <script>
    $(document).ready(function() {

        $('.text-danger').click(function(e) {
            e.preventDefault();
            var p_id = $(this).attr('data-id');
            $.ajax({
                url: 'actions.php',
                method: 'POST',
                data: {
                    removeCartItem: p_id
                },
                success: function(data) {
                    location.reload();
                }
            });
        });

        $('.item-qty').change(function() {

            var cartRows = document.getElementsByClassName("cart-border");

            total = 0
            total_quantity = 0

            for (var i = 0; i < cartRows.length; i++) {
                var cartRow = cartRows[i]
                var priceElement = cartRow.getElementsByClassName('cart-price')[0]
                var quantityElement = cartRow.getElementsByClassName('item-qty')[0]
                var price = parseFloat(priceElement.innerText.replace('$', ''))
                var quantity = quantityElement.value
                total = total + (price * quantity)
                var total_quantity = total_quantity + parseInt(quantity)
            }
            if (total_quantity > 20) {
                alert("You cannot purchase more than 20 item");
            } else {
                document.getElementById("show-price").innerHTML = total;
            }

        });

        $('#checkoutform').click(function(e) {
            e.preventDefault();

            var clicks = 0;
            function linkClick() {
                    document.getElementById('checkoutform').value = ++clicks;
            }

            console.log(clicks);

            var cartRows = document.getElementsByClassName("cart-border");

            total = 0
            total_quantity = 0
            const quan = [];
            const pric = [];
            const proid = [];

            for (var i = 0; i < cartRows.length; i++) {
                var cartRow = cartRows[i]
                var priceElement = cartRow.getElementsByClassName('cart-price')[0]
                var quantityElement = cartRow.getElementsByClassName('item-qty')[0]

                var product = cartRow.getElementsByClassName('productid')[0]
                proid.push(product.getAttribute('data-id'))

                var price = parseFloat(priceElement.innerText.replace('$', ''))
                pric.push(price)

                var quantity = quantityElement.value
                quan.push(quantity)

                total = total + (price * quantity)
                var total_quantity = total_quantity + parseInt(quantity)
            }

            $.ajax({
                url: 'actions.php',
                method: 'POST',
                data: {
                    price: pric,
                    quantity: quan,
                    product: proid,
                    totalprice: total,
                },
                dataType: 'json',
                success: function(response){
                    $('.alert').hide();
                   // console.log("response");
                    var res = response;
                    if(res.hasOwnProperty('success')){
                        $('.card').append('<div class="alert alert-success mt-3">Cart Saved</div>');
                        setTimeout(function(){ location.reload(); }, 1000);
                        window.location.href = 'after-checkout.php';
                    }else if(res.hasOwnProperty('error')){
                        $('.card').append('<div class="alert alert-danger mt-3">'+res.error+'</div>');
                    }

                }
            });
        });


        
    });
</script>
</body>
</html>