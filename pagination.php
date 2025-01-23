<?php

include "config.php";

                $limit_per_page = 8;
                $page ="";
                if(isset($_POST["page_no"])){
                    $page =$_POST["page_no"];
                }else{
                    $page = 1;
                }

                $offset =($page -1) * $limit_per_page;
/*
            $sql = "SELECT * FROM product LIMIT ". $offset.",".$limit_per_page."";
            $result = mysqli_query($conn,$sql);
*/

            $sql = "SELECT * FROM (SELECT a.*, ROWNUM rnum FROM (SELECT * FROM product)a WHERE ROWNUM <= $limit_per_page) WHERE rnum >= $offset";
            $result = oci_parse($conn , $sql);
            oci_execute($result); 

 ?>


<div class="container">

    <div class="row justify-content-center justify-content-md-start">

        <?php
                        /*
                        if(mysqli_num_rows($result) > 0){

                            while($row = mysqli_fetch_assoc($result)){ 
                                $pid= $row['Product_ID'];
                                $sql_discount = "SELECT offer_amount FROM product_offer WHERE product_id =$pid ";
                                $discount_result = mysqli_query($conn,$sql_discount);
                                $product_offer_amount = mysqli_fetch_assoc($discount_result);
                        */

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
                <img class="card-img-top img-fluid border-bottom" src="images/<?php echo $row['PRODUCT_IMAGE']; ?>"
                    alt="">
                <div class="card-body">
                    <h5 class="product-name card-title text-center"><?php echo $row['PRODUCT_NAME']; ?>
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
                        <small class="pl-3 text-muted">
                            <?php echo '£'.$product_offer_amount['OFFER_AMOUNT'].' off' ?></small>
                    </p>
                    <?php }?>
                    <p class="mr-2 text-center"><?php 
                                                if($row['RATING'] == 0){
                                                    echo floor($row['RATING'])." *new"; ?> 
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

<!--Pagination  -->
<div class="next-prev-pagination pagination mb-3" id="pagination">

    <?php 
        /*
        $sql_total_items= "SELECT * FROM product";
        $records = mysqli_query($conn,$sql_total_items);
        $total_records = mysqli_num_rows($records);
        $total_pages = ceil($total_records/$limit_per_page);
        */

        $sql_total_items= "SELECT * FROM product";
        $records = oci_parse($conn,$sql_total_items);
        oci_execute($records);
        $total_records = oci_num_fields($records); 
        $total_pages = ceil($total_records/$limit_per_page);

      
        for($i=1;$i<=$total_pages;$i++){

            if($i == $page){
               echo "<a class='active mr-1' href='' id='{$i}'>{$i}</a>";
              }else{
               echo "<a class='mr-1' href='' id='{$i}'>{$i}</a>";
              }

           
            
          
        }
        ?>
</div>
<!-- Pagination Ends -->

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