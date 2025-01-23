<?php

include "config.php";

$page = basename($_SERVER['PHP_SELF']);
switch($page){
  case "products.php":
    if(isset($_GET['pid'])){
    /*
      $sql_title = "SELECT * FROM product WHERE Product_ID = {$_GET['pid']}";
      $result_title = mysqli_query($conn,$sql_title) or die("Tile Query Failed");
      $row_title = mysqli_fetch_assoc($result_title);
      $page_title = $row_title['Product_name'];
    */
      $sql_title = "SELECT * FROM product WHERE Product_ID = {$_GET['pid']}";
      $result_title = oci_parse($conn,$sql_title) or die("Tile Query Failed");
      oci_execute($result_title); 
      $row_title = oci_fetch_array($result_title);
      $page_title = $row_title['PRODUCT_NAME'];

    }else{
      $page_title = "LocalMarket | Welcome";
    }
    break;
    
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    </meta>

    <link crossorigin="anonymous" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        referrerpolicy="no-referrer" rel="stylesheet" />
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" rel="stylesheet">
    <link href="bootstrap.css" rel="stylesheet" />
    <link rel="stylesheet" href="style/style.css">
    <title>
        <?php echo $page_title; ?>
    </title>
</head>
<style>
.product-page {
    margin-top: 25px;
}

.rating {
    list-style: none;
    padding-left: 0;
}

.rating li {
    display: inline;
}

.heading {
    border-bottom: 1px solid #ccc;
    padding-bottom: 5px;
}

.product-img img {
    height: 410px;
    background: #fff;
    border: 1px solid #ccc;
    padding: 5px;
    object-fit: contain;
    border-radius: 5px;
    filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.1))
}

.fa-info {
    font-size: 12px;
    background: #ccc;
    border-radius: 50%;
    padding: 4px;
}

.offer a {
    text-decoration: none;
}

.offer a:hover {
    text-decoration: underline;
}

.button-primary {
    background: #317393;
    border-color: #317393;
}

.button-primary:hover {
    background: #336699;
}

.rating-reveiw {
    /* background-color: white; */
    /* color: #000; */
    padding: 20px 0px;
    /* margin: 0; */
    /* border-radius: 8px; */
}

.border-top-2px {
    border-top: 2px solid #ccc;
}

ul.product-info>li>a {
    text-decoration: none;
    background: #fff;
    border: 2px solid #317393;
    padding: 8px;
    margin-right: 12px;
    border-radius: 3px;
    color: black;
}

ul.product-info>li>a:hover {
    background: #336699;
    color: #fff;
}

ul.product-info .active {
    background: #317393;
    color: #fff;
}

ul.rating {
    list-style: none;
    padding-left: 0;
}

ul.rating li {
    display: inline-block;
}

.button-bg {
    background: #317393;
    border-color: #317393;
    border-radius: 3px;
    border: none;
    color: #000;
    padding: 8px;
}

.button-bg:hover {
    background: #336699;
}

.button-bg:focus {
    box-shadow: none;
}

.rated {
    background: #317393;
    color: #fff;
    padding: 3px 2px 3px 6px;
    border-radius: 5px;
}

.write-reveiw textarea {
    max-width: 100%;
}

.modal {
    height: 400px !important;
}

.modal .btn {
    background: rgb(22, 100, 177);
    padding: 5px !important;
    border-color: #3b719f;
    width: 28px !important;
    color: black;

}

@media (max-width: 768px) {
    .product-img {
        margin: 0 12px;
    }

    .product-img img {
        height: auto;
    }

    .button-outline {
        outline: none;
    }

    .reveiw {
        margin-top: 15px;
    }
}
</style>

<body>


    <div id="navbar">
        <?php include "navbar.php" ;
 
?></div>
    <!-- Main product page -->
    <section class="product-page">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="row product-img mx-0">
                        <?php
			        // fetch all posts
                    /*
                    $product_id= $_GET['pid'];
                    $sql = "SELECT * FROM product WHERE Product_ID = {$product_id}";
                    $result = mysqli_query($conn,$sql);
                    */
                    $product_id= $_GET['pid'];
                    $sql = "SELECT * FROM product WHERE Product_ID = {$product_id}";
                    $result = oci_parse($conn,$sql);
                    oci_execute($result); 


                    if(oci_num_fields($result) > 0){

				        while($row = oci_fetch_array($result)){ 
                    
                    /*
                    $pid= $row['Product_ID'];
                    $sql_discount = "SELECT offer_amount FROM product_offer WHERE product_id =$pid ";
                    $discount_result = mysqli_query($conn,$sql_discount);
                    $product_offer_amount = mysqli_fetch_assoc($discount_result);
                    */

                    $pid= $row['PRODUCT_ID'];
                    $sql_discount = "SELECT offer_amount FROM product_offer WHERE product_id =$pid ";
                    $discount_result = oci_parse($conn,$sql_discount);
                    oci_execute($discount_result); 
                    $product_offer_amount = oci_fetch_array($discount_result);

                    /*
                    $sid= $row['shop'];
                    $shop_name = "SELECT shope_name FROM shop WHERE shop_id =$sid ";
                    $result_name = mysqli_query($conn,$shop_name);
                    $product_shopname = mysqli_fetch_assoc($result_name);
                    */
                    $sid= $row['SHOP'];
                    $shop_name = "SELECT shope_name FROM shop WHERE shop =$sid ";
                    $result_name = oci_parse($conn,$shop_name);
                    oci_execute($result_name); 
                    $product_shopname = oci_fetch_array($result_name);

                    ?>

                        <img alt="" class="img-fluid " src="images/<?php echo $row['PRODUCT_IMAGE']; ?>" />
                    </div>
                </div>
                <div class="col-md-6 mt-md-0 mt-3">
                    <h4 class="text-capitalize">
                        <?php echo $row['PRODUCT_NAME']; ?>
                    </h4>
                    <p class="mb-2 text-muted text-uppercase small">
                        <strong>
                            <?php echo $product_shopname['SHOPE_NAME'] ?>
                        </strong>
                    </p>
                    <ul class="rating mb-0">
                        <li>
                            <h4>
                                <?php 
                                    if($row['RATING'] == 0){
                                        echo floor($row['RATING'])." *newly added"; ?> 
                                        <i class="fas fa-star text-warning ps-1 pt-1"></i>
                                   <?php }
                                    else{
                                        echo floor($row['RATING']/$row['RATED_BY']); ?> 
                                        <i class="fas fa-star text-warning ps-1 pt-1"></i>
                                <?php } ?>
                            </h4>
                        </li>
                    </ul>
                    <p>
                        <span class="mr-1">
                            <strong>
                            <?php 
                            $final_price = $row['PRODUCT_PRICE'];
                            if(!empty($product_offer_amount['OFFER_AMOUNT'])){
                                $final_price = $row['PRODUCT_PRICE']-$product_offer_amount['OFFER_AMOUNT'];
                            }
                            echo '£'.$final_price; 
                        ?>
                            </strong>

                            <?php if(!empty($product_offer_amount)) {?>
                            <small class="pl-3 text-muted">
                                <?php echo '£'.$product_offer_amount['OFFER_AMOUNT'].' off'?>
                            </small>
                            <?php }?>

                        </span>
                    </p>
                    <div class="offer">
                        <h5>
                            <strong class="d-block offer">
                                Available Offers
                            </strong>
                        </h5>
                        <?php if(!empty($product_offer_amount)) {?>
                        <p>
                            <i class="fas fa-info">
                            </i>


                            <small>

                                Order now & get <?php echo '£'.$product_offer_amount['OFFER_AMOUNT'].' off'?>
                                <a data-target="#myModal" data-toggle="modal" href="">
                                    T&C↓
                                </a>
                            </small>

                        </p>
                        <?php } ?>
                        <p>
                            <i class="fas fa-info">
                            </i>
                            <small>
                                Pay online via PayPal and save 2% extra
                                <a data-target="#myModal" data-toggle="modal" href="">
                                    T&C↓
                                </a>
                            </small>
                        </p>
                    </div>
                    <h3 class="heading">
                        Description
                    </h3>
                    <p class="pt-1">
                        <?php echo $row['PRODUCT_DESCRIPTION']; ?>
                    </p>
                    <hr>
                    <button class="btn button-primary btn-sm mb-2 text-light" type="button">
                        Buy now
                    </button>
                    <button class="add-to-cart btn btn-warning btn-sm ml-1 mb-2"
                        data-id="<?php echo $row['PRODUCT_ID']; ?>" type="button">
                        <i class="fas fa-shopping-cart pr-2">
                        </i>
                        Add to cart
                    </button>
                    </hr>
                </div>
            </div>
        </div>
        <!-- Main product page Ends-->
        <!-- More from seller -->
        <?php 
        /*
                $tid= $row['trader_id'];
                $related_products = "SELECT * FROM product WHERE trader_id =$tid and Product_ID <> {$product_id} ORDER BY RAND() LIMIT 4";
                $related_products_name = mysqli_query($conn,$related_products);
        */
                $tid= $row['TRADER_ID'];
                $related_products = "SELECT * FROM (SELECT * FROM product WHERE trader_id =$tid and Product_ID <> {$product_id} ORDER BY DBMS_RANDOM.RANDOM) WHERE ROWNUM <= 4";
                $related_products_name = oci_parse($conn,$related_products);
                oci_execute($related_products_name); 

        ?>
        <?php if(oci_num_fields($related_products_name)>0){ ?>
        <div class="bg-white py-2 mt-md-4 mt-3">
            <div class="container">
                <h4 class="mb-1">
                    More From This Seller
                </h4>
            </div>
        </div>

        <?php
            }
        ?>

        <div class="all-items mt-md-3 mt-2">
            <div class="container">
                <div class="row justify-content-center justify-content-md-start">
                    <?php   while($row1 = oci_fetch_array($related_products_name)){    

                        $pid= $row1['PRODUCT_ID'];
                        $sql_discount = "SELECT offer_amount FROM product_offer WHERE product_id =$pid ";
                        $discount_result = oci_parse($conn,$sql_discount);
                        oci_execute($discount_result); 
                        $product_offer_amount = oci_fetch_array($discount_result);

                        ?>
                    <div class="col-md-4 col-lg-3 col-sm-6 col-12 my-2">
                        <div class="card shadow">
                            <img class="card-img-top img-fluid border-bottom"
                                src="images/<?php echo $row1['PRODUCT_IMAGE']; ?>" alt="">
                            <div class="card-body">
                                <h5 class="card-title text-center text-capitalize"><?php echo $row1['PRODUCT_NAME']; ?>
                                </h5>
                                <p class="text-center">
                                <?php 
                            $final_price = $row['PRODUCT_PRICE'];
                            if(!empty($product_offer_amount['OFFER_AMOUNT'])){
                                $final_price = $row['PRODUCT_PRICE']-$product_offer_amount['OFFER_AMOUNT'];
                            }
                            echo '£'.$final_price; 
                        ?>

                                    <?php if(!empty($product_offer_amount)) {?>
                                    <small class="pl-4 text-muted">
                                        <?php echo '£'.$product_offer_amount['OFFER_AMOUNT'].' off'?>
                                    </small>
                                </p>
                                <?php }?>

                                <p class="mr-2 text-center"><?php echo $row1['RATING']; ?>
                                    <i class="fas fa-star fa-md text-warning">
                                    </i>
                                </p>
                                <a href="products.php?pid=<?php echo $row1['PRODUCT_ID']; ?>"
                                    class="btn btn-primary btn-sm w-100 mb-2">View Details</a>
                                <a href="" class="add-to-cart btn btn-warning w-100 btn-sm"
                                    data-id="<?php echo $row1['PRODUCT_ID']; ?>"><i class="fas fa-shopping-cart pr-2">
                                    </i>Add To Cart</a>
                            </div>
                        </div>
                    </div>
                    <?php 
                    }
                    ?>

                </div>
            </div>
        </div>

        <!-- More from seller Ends-->
        <!-- Rating & Reviews -->
        <div class="container">
            <div class="row">
                <div class="col-md-12 rating-reveiw">
                    <ul class="nav nav-pills mb-3 product-info pt-md-3">
                        <li class="nav-item">
                            <a aria-controls="pills-description" aria-selected="true" class="btn-outline active"
                                data-toggle="pill" href="#pills-description" id="pills-description-tab" role="tab">
                                Description
                            </a>
                        </li>
                        <li class="nav-item">
                            <a aria-controls="pills-rating-reveiw" aria-selected="false" class="btn-outline btn-down"
                                data-toggle="pill" href="#pills-rating-reveiw" id="pills-rating-reveiw-tab" role="tab">
                                Rating & Reveiws
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content border-top-2px" id="pills-tabContent">
                        <div aria-labelledby="pills-description-tab" class="tab-pane fade show active"
                            id="pills-description" role="tabpanel">
                            <h4 class="mt-md-2">
                                Product Description
                            </h4>
                            <p>
                                <small class="p-0">
                                    Lorem ipsum dolor, sit amet consectetur adipisicing, elit. Quod minima rerum ratione
                                    deserunt animi odio quaerat quam error. Dolorem facilis, natus quibusdam illum
                                    velit! Deleniti, autem voluptatum quae vel maiores.
                                </small>
                            </p>
                            <h4>
                                Additional Info
                            </h4>
                            <p>
                                <small>
                                    Quantity: 1
                                </small>
                            </p>
                            <h4>
                                Vendor Info
                            </h4>
                            <p>
                                <small>
                                    A.N Shop, Cleckhuddersfax
                                </small>
                            </p>
                        </div>
                        <div aria-labelledby="pills-rating-reveiw-tab" class="tab-pane fade" id="pills-rating-reveiw"
                            role="tabpanel">
                            <div class="row mb-md-3">
                                <div class="col-md-8">
                                    <h4>
                                        Ratings
                                    </h4>
                                    <ul class="rating">
                                        <li>
                                            <h2>
                                            <?php 
                                                if($row['RATING'] == 0){
                                                    echo floor($row['RATING'])." *newly added"; ?> 
                                            <?php }
                                                else{
                                                    echo floor($row['RATING']/$row['RATED_BY']); ?> 
                                            <?php } ?>
                                            </h2>
                                        </li>
                                        <li>
                                            <i class="fas fa-star fa-2x text-warning">
                                            </i>
                                        </li>
                                        <li>
                                            <small class="text-muted">
                                                Total 2200 rating and 300 reviews
                                            </small>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-4 mt-md-4">
                                    <div class="pt-2">
                                        <ul class="rating text-muted" id="<?php echo $row['PRODUCT_ID'];?>">
                                            <li>
                                                <h3 class="">
                                                    Rate here
                                                </h3>
                                            </li>
                                            <li class="ps-2">
                                                <i class="fa fa-star fa-2x" data-index="3">
                                                </i>
                                            </li>
                                            <li>
                                                <i class="fa fa-star fa-2x" data-index="4">
                                                </i>
                                            </li>
                                            <li>
                                                <i class="fa fa-star fa-2x " data-index="5">
                                                </i>
                                            </li>
                                            <li>
                                                <i class="fa fa-star fa-2x" data-index="6">
                                                </i>
                                            </li>
                                            <li>
                                                <i class="fa fa-star fa-2x" data-index="7">
                                                </i>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <hr />

                            <section class="review ">
                                <div class="row">
                                    <div class="container">
                                        <div class="row justify-content-between">
                                            <h4>
                                                Reviews
                                            </h4>
                                            <div class="col-md-8 write-review mt-md-3">
                                                <div class="review-section ">
                                                    <span class="rated">
                                                        <strong>
                                                        <?php 
                                                                if($row['RATING'] == 0){
                                                                    echo floor($row['RATING'])." *newly added"; ?> 
                                                                    <i class="fas fa-star text-warning ps-1 pt-1"></i>
                                                            <?php }
                                                                else{
                                                                    echo floor($row['RATING']/$row['RATED_BY']); ?> 
                                                                    <i class="fas fa-star text-warning ps-1 pt-1"></i>
                                                            <?php } ?>
                                                        </strong>
                                                    </span>
                                                    <span>
                                                        <strong class="ps-3">
                                                            Reveiw heading.
                                                        </strong>
                                                    </span>
                                                    <p>
                                                        <small>
                                                            post your thougths and comments on this product 
                                                        </small>
                                                    </p>
                                                    <hr />
                                                </div>
                                                <form method="POST" id="reviewform">
                                                <div class="write-review mt-md-2">
                                                    <textarea class="w-100 review" cols="100" id="review" name="review"
                                                        placeholder="Your Review" rows="5"></textarea>
                                                    
                                                </div>
                                                <div class="w-100 text-center">
                                                    <input type="submit" class="button-bg w-50 mt-md-0 mt-2 text-light" value="Post Your Review">
                                                </form>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mt-3">
                                                <div class=" ">
                                                    <div class="bg-white pb-2">
                                                        <div class="bg-white">
                                                            <h4 class="text-center py-2 d-block border-bottom">
                                                                Best Selling Product
                                                            </h4>
                                                        </div>
                                                        <div class="all-items">
                                                            <div class="container">
                                                                <div class="row justify-content-center">
                                                                    <div class="col-md-12 my-2">
                                                                        <div class="card shadow">
                                                                            <img class="card-img-top img-fluid border-bottom"
                                                                                src="images/chicken.jpg" alt="" />
                                                                            <div class="card-body">
                                                                                <h5 class="card-title text-center">Item
                                                                                    Name
                                                                                </h5>
                                                                                <p class="text-center">£9.99 <strike
                                                                                        class="pl-4 text-muted">£19.99</strike>
                                                                                </p>
                                                                                <p class="mr-2 text-center">4
                                                                                    <i
                                                                                        class="fas fa-star fa-md text-warning">
                                                                                    </i>
                                                                                </p>
                                                                                <a href="products.php"
                                                                                    class="btn btn-primary btn-sm w-100 mb-2">View
                                                                                    Details</a>
                                                                                <a href="#"
                                                                                    class="btn btn-warning btn-sm w-100"><i
                                                                                        class="fas fa-shopping-cart pr-2">
                                                                                    </i>Add To Cart</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <?php }
    } ?>
    <!-- Modal for terms and condions-->
    <div id="term-condition">
        <div class="modal" id="myModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="m-1">
                            Terms and Conditions
                        </h4>
                        <button class="close btn btn-outline-dark btn-sm" data-dismiss="modal" type="button">
                            <i class="fas fa-times">
                            </i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul>
                            <li>
                                <small>
                                    Lorem ipsum dolor, sit, amet consectetur adipisicing elit. Facere, obcaecati.
                                </small>
                            </li>
                            <li>
                                <small>
                                    Lorem ipsum dolor, sit, amet consectetur adipisicing elit. Facere, obcaecati.
                                </small>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal ends-->
    <!-- Rating & Reviews Ends -->
    <?php include "footer.php" ?>
    <?php include "script.php" ?>

    <script src="script/action.js"></script> 
    <script src="http://code.jquery.com/jquery-3.4.0.min.js"
        integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>
    <script>
    $(document).ready(function() {
        $('.fa-star').on('click', function() {
            ratedIndex = parseInt($(this).data('index'));
            var post_id = $(this).parent().parent().attr('id');
            console.log(ratedIndex);

            $.ajax({
                url: "rating.php",
                method: "post",
                data: {
                    post: post_id,
                    rating: ratedIndex
                },
                success: function(response) {
                    if (response == 'true') {
                        location.reload();
                    }
                }
            });
        });

        $('.fa-star').mouseover(function() {
            resetStarColors();
            var currentIndex = parseInt($(this).data('index'));
            setStars(currentIndex);

        });

        $('.fa-star').mouseleave(function() {
            resetStarColors();
        });

        //adds the product to the cart 
        $('.add-to-cart').click(function(e) {
            e.preventDefault();
            var p_id = $(this).attr('data-id');
            $.ajax({
                url: 'actions.php',
                method: 'POST',
                data: {
                    addCart: p_id
                },
                success: function(data) {
                    $('#navbar').load('index.php #navbar', function() {
                        setTimeout(10);
                    });
                    setTimeout(8000);
                }
            });
        });

    });

    function setStars(max) {
        for (var i = 0; i <= max; i++)
            $('.fa-star:eq(' + i + ')').css('color', 'green');
    }

    function resetStarColors() {
        $('.fa-star').css('color', '#6c757d');
    }
    </script>
</body>

</html>