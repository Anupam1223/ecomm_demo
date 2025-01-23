<?php
include '../config.php';

$id = $_GET['pid'];
$query = "SELECT * FROM product WHERE Product_ID='$id'";
$result = oci_parse($conn, $query);
oci_execute($result);
$row = oci_fetch_assoc($result);

    ?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!--font Awesome-->
    <link rel="stylesheet" href="css/all.min.css">
    <link crossorigin="anonymous" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        referrerpolicy="no-referrer" rel="stylesheet" />
    <!--css only-->
    <link rel="stylesheet" href="css/style.css">

    <!--Fonts library-->
    <!--fonts-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@600;700&family=Roboto:wght@400;500&display=swap"
        rel="stylesheet">
    <title>Trader Dashboard</title>
    <style>        
    
        input.choosefile {
                padding: 0px;
            }
    </style>

</head>

<body>

    <h4 class="text-center mt-3">Edit Item</h4>
    <hr>
    <div class="comtainer">
        <div class="row justify-content-center">
            <div class="col-md-6 col-12">
                <form method="POST" action="update.php" enctype="multipart/form-data">
                    <label for="productID"></label>
                    <input type="hidden" name="productID" value="<?php echo $row['PRODUCT_ID'] ?>" /><br>
                    <label for="name">Item Name</label>
                    <input type="text" name="itemName" class="input-field"
                        value="<?php echo $row['PRODUCT_NAME'] ?>"><br>

                    <label for="price">Item Price</label>
                    <input type="number" name="itemPrice" class="input-field"
                        value="<?php echo $row['PRODUCT_PRICE'] ?>"><br>

                    <label for="stock">Stock Level</label>
                    <input type="number" name="stockLevel" class="input-field"
                        value="<?php echo $row['PRODUCT_QUANTITY'] ?>"><br>

                    <label for="desc">Item Description</label>
                    <textarea name="itemDesc" class="p-2"><?php echo $row['PRODUCT_DESCRIPTION'] ?></textarea><br>

                    <div class="form-group">
                        <label for="exampleFormControlInput1" class="text-dark">Upload Product
                            Pic</label>
                        <input type="file" name="fileName" class="choosefile text-dark rounded" /><br>
                    </div>
                    <button type="submit" name="updateItem" class="btn btn-outline-dark ">Update Item</button>
                    <a href="index.php" class="btn btn-outline-dark btn-sm w-100 ">Back To
                        Dashboard</a>

                </form>
            </div>
        </div>
    </div>
</body>

</html>