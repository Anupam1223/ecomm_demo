<?php

include "../config.php";

session_start();
if(!isset($_SESSION['trader_username'])){
    header("Location: login.php");
}
else {
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
        th.gmail{
                text-align: center;
        }
        input.choosefile {
            padding: 0px;
        }

</style>

</head>

<?php include "navbar2.php";?>

<body class="bg-right">
    <div class="container-fluid mt-4">
        <div class="row">
            <!--right side navbar-->
            <div class="col-lg-3 col-md-4 d-md-block">
                <div class="card bg-common sidebar-left">
                    <div class="card-body">

                        <?php 

                        $id =$_SESSION['trader_id'];

                        $qry = "SELECT * FROM trader where trader_id='$id'";

                        $result = oci_parse($conn, $qry);
                        oci_execute($result);

                        $row = oci_fetch_assoc($result);
                       
                    ?>

                        <table>
                            <tr>
                                <th><img src="images/<?php echo $row['TRADER_IMAGE'] ?>" class="img-responsive img-fluid"></th>
                            </tr>
                            <tr>

                                <th class="gmail"><?php echo $row['EMAIL']?></th>

                            </tr>
                            <th class="font-text text-muted signout-opt"><a href="logout.php">Signout</a></th>
                        </table>
                        <nav class="nav d-md-block d-none sidebar">
                            <a class="nav-link text-dark" data-toggle='tab' href="#profile"><i
                                    class="far fa-user-circle"></i>
                                <span> Profile</span></a>
                            <hr />
                            <a class="nav-link active text-dark" data-toggle='tab' href="#Dashboard"><i
                                    class="fas fa-desktop mr-1"></i> <span>View Order</span></a>
                            <hr />
                            <a class="nav-link text-dark" data-toggle='tab' href="#addItem"><i
                                    class="fab fa-product-hunt mr-1"></i><span>Add Item</span></a>
                            <hr />
                            <a class="nav-link text-dark" data-toggle='tab' href="#viewItem"><i
                                    class="fas fa-th-list mr-1"></i></i><span>View Item</span></a>
                            <hr />
                        </nav>
                    </div>
                </div>
            </div>
            <!--Right side content-->
            <div class="col-md-8 col-lg-9 ">
                <div class="card">
                    <div class="card-header border-bottom mb-3 d-md-none">
                        <ul class="nav nav-tabs card-header-tabs nav-fill">
                            <li class="nav-item">
                                <a class="nav-link" data-toggle='tab' href="#profile"><i
                                        class="far fa-user-circle mr-1"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle='tab' href="#Dashboard"><i
                                        class="fas fa-desktop mr-1"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle='tab' href="#addItem"><i
                                        class="fab fa-product-hunt mr-1"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle='tab' href="#viewItem"><i
                                        class="fas fa-th-list mr-1"></i></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle='tab' href="#Invoice"><i
                                        class="fas fa-file-alt mr-1"></i></a>
                            </li>

                        </ul>
                    </div>
                    <div class="card-body tab-content border-0">
                        <!--Dashboard data-->
                        <div class="tab-pane active" id="Dashboard">
                            <h4 class="text-dark text-center">View Order</h4>
                            <hr>
                            <?php 

                                $pname = [];
                                $pprice= [];
                                $pid = [];
                                $quan = [];
                                $stat = [];
                                $cus = [];
                                $dayy = [];
                                $timee = [];
                                $count = 0;

                                $sqlorder = "SELECT * FROM CART";
                                $resultorder = oci_parse($conn, $sqlorder);
                                oci_execute($resultorder);
                                ?>
                            <table class="table">
                                <thead>
                                    <tr>
                                    <th scope="col">Sno</th>
                                    <th scope="col">Customer Name</th>
                                    <th scope="col">Product name</th>
                                    <th scope="col">Product Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Time</th>
                                    <th scope="col">Day</th>
                                    <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <?php while($roworder = oci_fetch_assoc($resultorder)){
                                    
                                        $productorder=$roworder['PRODUCT_ID'];
                                        
                                        $sqlproductorder = "SELECT product_id, product_name, product_price FROM PRODUCT WHERE product_id = '$productorder' and trader_id='$id'";
                                        $resultproductorder = oci_parse($conn, $sqlproductorder);
                                        oci_execute($resultproductorder);
                                        $rowproductorder = oci_fetch_assoc($resultproductorder);

                                        $proname = $rowproductorder['PRODUCT_NAME'];
                                        $proprice = $rowproductorder['PRODUCT_PRICE'];
                                        $proid = $rowproductorder['PRODUCT_ID'];

                                        //get the product offer
                                        $sql_discount = "SELECT offer_amount FROM product_offer WHERE product_id ='$proid' ";
                                        $discount_result = oci_parse($conn,$sql_discount);
                                        oci_execute($discount_result);
                                        $product_offer_amount = oci_fetch_array($discount_result);

                                        if(!empty($product_offer_amount['OFFER_AMOUNT'])){
                                            $proprice = $proprice-$product_offer_amount['OFFER_AMOUNT'];
                                        }

                                        $custo = $roworder['CUSTOMER_ID'];

                                        if(!empty($proname)){

                                            //for fetching customer
                                            $sqlcustomer = "SELECT customer_name FROM CUSTOMER WHERE customer_id='$custo'";
                                            $resultcustomer = oci_parse($conn, $sqlcustomer);
                                            oci_execute($resultcustomer);
                                            $rowcustomer = oci_fetch_assoc($resultcustomer);
                                            $custoname = $rowcustomer['CUSTOMER_NAME'];

                                            //help for fetching status
                                            $sqlstatushelp = "SELECT cart_id, quantity FROM CART WHERE product_id='$proid' AND customer_id='$custo'";
                                            $resultstatushelp = oci_parse($conn, $sqlstatushelp);
                                            oci_execute($resultstatushelp);
                                            $rowcustomer = oci_fetch_assoc($resultstatushelp);
                                            $cccid= $rowcustomer['CART_ID'];
                                            $proquan = $rowcustomer['QUANTITY'];

                                            //for status
                                            $sqlcart = "SELECT status, collection_time, collection_day  FROM COLLECTION_SLOTS WHERE cart_id='$cccid'";
                                            $resultcart = oci_parse($conn, $sqlcart);
                                            oci_execute($resultcart);
                                            $rowcart = oci_fetch_assoc($resultcart);
                                            $cartstat = $rowcart['STATUS'];
                                            $cartday = $rowcart['COLLECTION_DAY'];
                                            $carttime = $rowcart['COLLECTION_TIME'];

                                            array_push($pname , $proname);
                                            array_push($pprice , $proprice);
                                            array_push($pid , $proid);
                                            array_push($quan , $proquan);
                                            array_push($cus , $custoname);
                                            array_push($stat , $cartstat);
                                            array_push($dayy , $cartday);
                                            array_push($timee , $carttime);
                                        }

                                        }
                                    for ($i = 0; $i < count($pname); $i++){
                                        $count++;
                                    ?>
                                <tbody>
                                    <tr>
                                    <th scope="row"><?php echo $count; ?></th>
                                    <td><?php echo $cus[$i]; ?></td>
                                    <td><?php echo $pname[$i]; ?></td>
                                    <td><?php echo "£ ".$pprice[$i]; ?></td>
                                    <td><?php echo $quan[$i]; ?></td>
                                    <td><?php echo $dayy[$i]; ?></td>
                                    <td><?php echo $timee[$i]; ?></td>
                                    <td><?php echo $stat[$i]; ?></td>
                                    </tr>
                                    <tr>
                                </tbody>
                                <?php }?>
                                </table>
                        </div>
                        <!-- Add Item -->
                        <div class="tab-pane" id="addItem">
                            <h4 class="text-dark text-center">Add Item</h4>
                            <hr>
                            <form action="insert.php" method="POST"  enctype="multipart/form-data">
                                <input type="text" name="itemName" class="input-field" placeholder="Item Name"/><br>
                                <input type="text" name="itemPrice" class="input-field" placeholder="Item Price" /><br>
                                <input type="text" name="stockLevel" class="input-field" placeholder="Stock Level" /><br>
                                <textarea name="itemDesc" placeholder="Item Description" class="p-2"></textarea><br>
                                <input type="file" name="image" class="form-control-file mb-2 upload-image" />
                                <button type ="submit" name="addItem" class="btn btn-outline-dark">Add Item</button>
                            </form>
                        </div>

                        <!--Item data-->
                        <div class="tab-pane" id="viewItem">
                            <h3 class="text-dark text-center">View Item</h3>
                            <div class="mb-2 d-flex justify-content-end btn-color">
                                <a href="" class="text-dark btn btn-outline-dark " data-toggle="modal"
                                    data-target="#exampleModalCenter"><i class="fas fa-gift mr-1"></i>Add Offer</a>
                            </div>
                            <div class="table-responsive">
                                <?php
                                          $query = "SELECT * FROM product where trader_id='$id' order by Product_ID desc";

                                          $result = oci_parse($conn, $query);
                                          oci_execute($result);

                                          $count = 0;
                                ?>


                                <table class="table table-bordered pr-5" cellspacing=0>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Item Name</th>
                                        <th>Item Image</th>
                                        <th>Price</th>
                                        <th>Item Description</th>
                                        <th>Quantity</th>
                                        <th>Action</th>
                                        <th>Offer Price</th>
                                    </tr>
                                    <?php while ($row = oci_fetch_assoc($result)) { 
                                                $count++;
                                              ?>
                                    <tr>
                                        <td><?php echo $count ?></td>
                                        <td class="text-capitalize"><?php echo $row['PRODUCT_NAME'] ?></td>
                                        <td><img height="30px" src="../images/<?php echo $row['PRODUCT_IMAGE'] ?>"
                                                alt="product image">
                                        </td>
                                        <td><?php echo '£'.$row['PRODUCT_PRICE'] ?></td>
                                        <td><?php echo $row['PRODUCT_DESCRIPTION'] ?></td>
                                        <td><?php echo $row['PRODUCT_QUANTITY'] ?></td>
                                        <td><a href="ammend.php?pid=<?php echo $row['PRODUCT_ID'] ?>"
                                                class="mr-3 text-muted" title="Edit"><i class="fas fa-edit"></i></a><a
                                                class="text-danger" title="Delete"
                                                href="delete.php?pid=<?php echo $row['PRODUCT_ID'] ?>"><i
                                                    class="fas fa-trash-alt"></i></a></td>


                                        <?php  
                                        $pid = $row['PRODUCT_ID'];

                                        $offer_qry = "SELECT offer_amount from product_offer where Product_ID = '$pid'";

                                        $offer_result = oci_parse($conn, $offer_qry);
                                        oci_execute($offer_result);

                                        while($offer_row =oci_fetch_assoc($offer_result)){
                                        ?>
                                        <td><?php echo $offer_row['OFFER_AMOUNT'] ?></td>
                                        <?php } ?>

                                    </tr>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>

                        <!-- Offer Modal -->

                        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Offer Amount</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>


                                    <?php
                                    
                                    $query = "SELECT * FROM product where trader_id='$id' order by Product_ID desc";

                                    $result = oci_parse($conn, $query);
                                    oci_execute($result);
                                        ?>

                                    <form method="POST" action="offer.php">
                                        <div class="modal-body">


                                            <select name="product_offer" class="form-control">

                                                <option value="" required>
                                                    Choose Product </option>

                                                <?php 

                                                while (($row = oci_fetch_array($result, OCI_ASSOC)) != false){
                                                        ?>
                                                <option value="<?php echo $row['PRODUCT_ID']; ?>">
                                                    <?php echo $row['PRODUCT_NAME'];?></option>
                                                <?php
                                                    }
                                                    ?>

                                            </select>


                                            <label for="text" class="mt-3">Discount Amount</label>

                                            <input type="text" name="offerAmount" value="<?php  ?>" class="form-control"
                                                required><br>
                                            <div>
                                                <button type="submit" class="btn btn-primary btn-sm mb-2 w-100"
                                                    name="offer" value="">Add Offer</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Offer Modal Ends-->
                        <!--Profile data-->
                        <div class="tab-pane" id="profile">
                            <h6 class="text-dark text-center">Your Profile Information</h6>
                            <hr>

                            <?php

                        $qry = "SELECT * FROM trader where trader_id='$id'";

                        $result = oci_parse($conn, $qry);
                        oci_execute($result);

                        $row2 = oci_fetch_assoc($result);
                       
                    ?>
                            <form action="update-profile.php" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <input type="hidden" name="traderId" class="form-control"
                                        value="<?php echo $row2['TRADER_ID'] ?>">

                                    <label for="exampleFormControlInput1" class="text-dark">Full Name</label>
                                    <input type="Text" name="traderName" class="form-control"
                                        value="<?php echo $row2['TRADER_NAME'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1" class="text-dark">Email</label>
                                    <input type="Text" name="email" class="form-control"
                                        value="<?php echo $row2['EMAIL'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlInput1" class="text-dark">Your Bio</label>
                                    <textarea name="traderDesc"
                                        class="form-control p-2"><?php echo $row2['TRADER_DESCRIPTION'] ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlInput1" class="text-dark">Phone Number</label>
                                    <input type="Text" name="phone" class="form-control"
                                        value="<?php echo $row2['PHONE_NO'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlInput1" class="text-dark">Upload Your Profile
                                        Pic</label>
                                    <input type="file" name="fileName" class="choosefile text-dark rounded" /><br>
                                </div>
                                <div>
                                    <button type="submit" name="updateProfile" class="btn btn-outline-dark">Update
                                        Profile</button>
                                </div>
                            </form>
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </div>
    </div>
    </div>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script>
    $('a[data-toggle="tab"]').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
    });

    $('a[data-toggle="tab"]').on("shown.bs.tab", function(e) {
        var id = $(e.target).attr("href");
        sessionStorage.setItem('selectedTab', id)
    });

    var selectedTab = sessionStorage.getItem('selectedTab');
    if (selectedTab != null) {
        $('a[data-toggle="tab"][href="' + selectedTab + '"]').tab('show');
    }
    </script>
</body>
</html>
<?php }?>