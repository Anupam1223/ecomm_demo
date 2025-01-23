<?php 

include "config.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link crossorigin="anonymous" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        referrerpolicy="no-referrer" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
    <title>LocalMarket | Welcome</title>
</head>

<body>
    <div id="navbar">
        <?php include "navbar.php" ;
?></div>
    <div class="container">
        <?php include "category.php" ?>
    </div>
    <?php 
 			if(isset($_GET['submit-search'])){

                $search = $_GET['search-product'];

                if(!empty($search)){

                $sql = "SELECT * FROM PRODUCT WHERE PRODUCT_NAME='{$search}' ORDER BY Product_name";
            
                $result = oci_parse($conn,$sql);
                oci_execute($result);
                $count = oci_fetch($result);
            }else{
                echo '
                        <div class="container">
                        <div class="alert alert-danger" role="alert">
    Please enter the name of item you want to search!
    </div>
                        </div>
                        ';

                         include "footer.php" ;

    die();
    }


    ?>

    <main class="all-items">
        <div class="container">

            <div class="row justify-content-center justify-content-md-start">

                <?php
    
                if($count > 0){
                        
                        $pid= oci_result($result, 'PRODUCT_ID');
                        $sql_discount = "SELECT offer_amount FROM product_offer WHERE product_id =$pid ";
                        $discount_result = oci_parse($conn,$sql_discount);
                        oci_execute($discount_result);
                        $product_offer_amount = oci_fetch_assoc($discount_result);
                        
                        ?>
                                <div class="col-md-4 col-lg-3 col-sm-6 col-10 my-2">

                    <div class="card shadow">
                        <img class="card-img-top img-fluid border-bottom"
                            src="images/<?php echo oci_result($result, 'PRODUCT_IMAGE') ?>" alt="">
                        <div class="card-body">
                            <h5 class="product-name card-title text-center"><?php echo oci_result($result, 'PRODUCT_NAME'); ?>
                            </h5>
                            <p class="text-center">
                            
                            <?php 
                            $final_price = oci_result($result, 'PRODUCT_PRICE');
                            if(!empty($product_offer_amount['OFFER_AMOUNT'])){
                                $final_price = $final_price-$product_offer_amount['OFFER_AMOUNT'];
                            }
                            echo '£'.$final_price; 
                            ?>
                                <?php if(!empty($product_offer_amount)) {?>
                                <small class="pl-3 text-muted">
                                    <?php echo '£'.$product_offer_amount['OFFER_AMOUNT'].' off' ?></small>
                                <?php }?>
                            </p>
                            <p class="mr-2 text-center"><?php echo oci_result($result, 'RATING'); ?>
                                <i class="fas fa-star fa-md text-warning"></i>
                            </p>
                            <a href="products.php?pid=<?php echo oci_result($result, 'PRODUCT_ID'); ?>"
                                class="btn btn-primary btn-sm w-100 mb-2">View Details</a>
                            <a href="" class="add-to-cart btn btn-warning w-100 btn-sm"
                                data-id="<?php echo oci_result($result, 'PRODUCT_ID'); ?>"><i class="fas fa-shopping-cart pr-2">
                                </i>Add To Cart</a>
                        </div>
                    </div>
                </div>
                <?php 
                  }else{
                            echo '
                            <div class="container">
                            <div class="alert alert-danger" role="alert">
 The item you are searching for is not available
</div>
                            </div>
                            ';
                        }?>
            </div>
        </div>
    </main>

    <?php } ?>



    <?php include "footer.php" ?>


    <?php include "script.php" ?>

    <script src="http://code.jquery.com/jquery-3.4.0.min.js"
        integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>


    <script type="text/javascript" src="js/jquery.js"></script>

    <script>
    $(document).ready(function() {

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
    </script>

</body>

</html>