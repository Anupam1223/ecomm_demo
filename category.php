<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />

    <link rel="stylesheet" href="style/style.css">
</head>

<body>
    <?php include "config.php";

/*
    $shop="SELECT * FROM shop";
    $query=mysqli_query($conn,$shop);
    $total_shops=mysqli_num_rows($query);
*/
    $shop="SELECT * FROM shop";
    $query = oci_parse($conn , $shop);
    oci_execute($query); 
    $total_shops= oci_num_fields($query)

?>


    <section class="category-offers">
        <div class="d-flex justify-content-between mt-1">
            <div class="menu-dropdown">
                <ul>
                    <li class="category-list"><i class="fas fa-list"></i> Category<i class="fas fa-angle-down"></i>
                        <ul>
                            <?php    
                            
                                 if($total_shops){
                                    while($row = oci_fetch_array($query)){ 
                                            $products = "SELECT * FROM product WHERE shop={$row['SHOP']}";
                                            $product_query=oci_parse($conn,$products);
                                            oci_execute($product_query);
                                            $total_products=oci_num_fields($query);
                                        ?>
                            <li><a class="text-capitalize" href="category_shop.php?sid=<?php echo $row['SHOP']?>"><?php echo $row['SHOPE_NAME']?><i
                                        class="fas fa-angle-right"></i></a>
                                <ul>
                                    <?php   
                                                if($total_products){
                                                    while($product_row = oci_fetch_array($product_query)){ ?>
                                    <li><a class="text-capitalize"
                                            href="category_search.php?product_id=<?php echo $product_row['PRODUCT_ID'] ?>"><?php echo $product_row['PRODUCT_NAME']?></a>
                                    </li>
                                    <?php }
                                                    }?>
                                </ul>
                            </li>
                            <?php 
                                    }
                                 }
                            
                            ?>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="top-offers">
                <ul>
                    <li><a href=""><i class="fas fa-gift"></i>
                            Top Offers</a></li>
                </ul>
            </div>

        </div>

    </section>

</body>

</html>