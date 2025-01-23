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
              include "config.php";
?></div>
    <div class="container">
        <?php include "category.php"; ?>
    </div>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner rounded">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="images/banner3.jpg" alt="First slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="images/banner2.jpg" alt="Second slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="images/banner.jpg" alt="Third slide">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>



    <div class="item-header my-md-3 mt-2 bg-white">
        <div class="container ">
            <h4 class="py-2">Recently Added</h4>
        </div>
    </div>


    <main class="all-items">
        <div class="container">

            <div class="row justify-content-center justify-content-md-start">
                <?php

                //"SELECT * FROM PRODUCT ORDER BY PRODUCT_ID DESC LIMIT 4"
                        $sql = "SELECT * FROM (SELECT * FROM PRODUCT ORDER BY PRODUCT_ID DESC) WHERE ROWNUM <= 4";
                        $result = oci_parse($conn , $sql);
                        oci_execute($result); 
                        
			            if(oci_num_fields($result) > 0){

				            while($row = oci_fetch_array($result)){
                                
                                $pid= $row['PRODUCT_ID'];
                                $sql_discount = "SELECT offer_amount FROM product_offer WHERE product_id =$pid ";
                                $discount_result = oci_parse($conn,$sql_discount);
                                oci_execute($discount_result);
                                $product_offer_amount = oci_fetch_array($discount_result);

                                ?>
                <div class="col-md-4 col-lg-3 col-sm-6 col-11 my-2">

                    <div class="card shadow">
                        <img class="card-img-top img-fluid border-bottom"
                            src="images/<?php echo $row['PRODUCT_IMAGE']; ?>" alt="">
                        <div class="card-body">
                            <h5 class="product-name card-title text-center"><?php echo $row['PRODUCT_NAME']; ?>
                            </h5>
                            <p class="text-center">
                            
                            <?php 
                            $final_price = $row['PRODUCT_PRICE'];
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


                            <p class="mr-2 text-center"><?php 
                                                if($row['RATING'] == 0){
                                                    echo floor($row['RATING'])."*new"; ?> 
                                            <?php }
                                                else{
                                                    echo floor($row['RATING']/$row['RATED_BY']); ?> 
                                            <?php } ?>
                                <i class="fas fa-star fa-md text-warning"></i>
                            </p>
                            <a href="products.php?pid=<?php echo $row['PRODUCT_ID']; ?>"
                                class="btn btn-primary btn-sm w-100 mb-2">View Details</a>
                            <a href="" class="add-to-cart btn btn-warning w-100 btn-sm"
                                data-id="<?php echo $row['PRODUCT_ID']; ?>"><i class="fas fa-shopping-cart pr-2">
                                </i>Add To Cart</a>
                        </div>
                    </div>
                </div>
                <?php }
                    }?>
            </div>
        </div>
        </div>
    </main>




    <div class="item-header my-md-3 mt-2 bg-white">
        <div class="container ">
            <div class="py-2 d-sm-flex justify-content-between my-auto">
                <h4 class="my-auto text-center">Just For You</h4>
                <div class="nav-item dropdown sort-product" id="">
                    <select class="sort-select form-control form-control-sm mt-sm-1 mt-2">
                        <option>Sort: Default</option>
                        <option>Sort: Rating High to Low</option>
                        <option>Sort: Rating Low to High</option>
                        <option>Sort: Price High to Low</option>
                        <option>Sort: Price Low to High</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <main class="all-items add-pages" id="add-pages">
        <!-- Pagination -->
    </main>


    <?php include "footer.php" ?>

    <?php include "script.php" ?>

    <script src="http://code.jquery.com/jquery-3.4.0.min.js"
        integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>
    <script>
    $(document).ready(function() {
        function loadTable(page) {
            $.ajax({
                url: "pagination.php",
                type: "POST",
                data: {
                    page_no: page
                },
                success: function(data) {
                    $("#add-pages").html(data);
                }
            });
        }
        loadTable();

        //Pagination Code
        $(document).on("click", "#pagination a", function(e) {
            e.preventDefault();
            var page_id = $(this).attr("id");
            loadTable(page_id);
        })
    });

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