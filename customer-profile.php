<?php 
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location: index.php");
    }
    else{
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link crossorigin="anonymous" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        referrerpolicy="no-referrer" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Customer Profile | LocalMarket</title>

    <style>
    .customer-profile h6 {
        text-transform: uppercase;
    }

    .customer-profile .change-clr {
        color: #474849;
    }

    .customer-profile .icons i {
        color: #325C8C;
    }

    .customer-profile .active {
        color: black;
    }


    .right-side-nav a {
        color: #325C8C;
    }

    .right-side-nav a:hover {
        color: #284970;
    }

    .right-side-nav nav i {
        position: absolute;
        padding-top: 4px;
    }

    .right-side-nav nav span {
        position: relative;
        left: 30px;
    }

    .update-profile input {
        color: black;
    }


    .customer-profile p {
        font-size: 16px;
    }

    .upload-image {
        width: 100%;
        border: 1px solid #000;
        border-radius: 3px;
    }
    #invoice a{
        text-decoration: none;
    }
    </style>
</head>
<body>
<div id="navbar">
        <?php include "navbar.php" ;
              include "config.php";
?></div>
    <section class="customer-profile">
        <div class="container mt-3">
            <div class="row">
                <div class="col-md-12 col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php" class="change-clr">LocalMarket</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Customer Account</li>
                        </ol>
                    </nav>

                    <div class="row">
                        <!-- right side user setting -->
                        <div class="col-lg-3 col-md-4 d-md-block d-none ">
                            <div class="card right-side-nav">
                                <div class="row">
                                    <nav class="nav d-block pl-4">

                                        <a data-toggle="tab" class="nav-link active" href="#profile"><i
                                                class="fas fa-user"></i><span>Profile</span> </a>
                                        <a data-toggle="tab" class="nav-link" href="#updateProfile"><i
                                                class="fas fa-user-edit"></i><span>Update Profile</span> </a>
                                        <a data-toggle="tab" class="nav-link" href="#changePassword"><i
                                                class="fas fa-key"></i><span>Change
                                                Password</span> </a>
                                        <a data-toggle="tab" class="nav-link" href="#invoice"><i
                                                class="fas fa-receipt"></i></i><span>Invoice</span> </a>
                                        <a data-toggle="tab" class="nav-link" href="#deleteAccount"><i
                                                class="fas fa-trash-alt"></i><span>Delete Account</span> </a>
                                        <a data-toggle="tab" class="nav-link" href="#logout"><i
                                                class="fas fa-sign-out-alt"></i><span>Logout</span> </a>
                                    </nav>

                                </div>
                            </div>
                        </div>


                        <?php    
                        /*
                                $name =$_SESSION['id'];
                                $sql ="SELECT * FROM signup WHERE customer_id='$name' ";
                                $query=mysqli_query($conn,$sql);
                                $email_pass=mysqli_fetch_assoc($query);
                                $customer_name = $email_pass['customer_name'];
                                $phone = $email_pass['phone_no'];
                                $email = $email_pass['customer_email'];
                                $address = $email_pass['customer_address'];
                                $image = $email_pass['imagee'];
                        */
                                
                                $sql ="SELECT * FROM customer WHERE customer_id='$name' ";
                                $query=oci_parse($conn,$sql);
                                oci_execute($query);
                                $email_pass=oci_fetch_assoc($query);
                                $customer_name = $email_pass['CUSTOMER_NAME'];
                                $phone = $email_pass['PHONE_NO'];
                                $email = $email_pass['EMAIL'];
                                $address = $email_pass['CUSTOMER_ADDRESS'];
                                $image = $email_pass['IMAGE'];
                        ?>

                        <div class="col-lg-9 col-md-8 d-md-block d-none">
                            <div class="card-body tab-content border ">
                                <!-- Customer profile -->
                                <div class="tab-pane active" id="profile">
                                    <h6>MY PROFILE</h6>
                                    <div class="text-center">
                                        <img class="img-fluid rounded-circle mt-5 mb-2" height="120px" width="120px"
                                            src="<?php echo $image ?>" alt="customer pic">
                                        <p>Name: <?php echo $customer_name ?> </p>
                                        <p>Email: <?php echo $phone?></p>
                                        <p>Phone Number: <?php echo $email ?> </p>
                                        <p>Address: <?php echo $address ?> </p>
                                    </div>
                                </div>

                                <!-- Customer profile Ends-->
                                <!-- Update profile -->
                                <div class="tab-pane update-profile" id="updateProfile">
                                    <h6>Update Profile</h6>
                                    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST"
                                        enctype="multipart/form-data">
                                        <input class="form-control form-control-sm mb-2" name="username"
                                            value=<?php echo $customer_name?> type="text" placeholder="Name">
                                        <input class="form-control form-control-sm mb-2" name="email_id"
                                            value=<?php echo $email ?> type="text" placeholder="Email">
                                        <input class="form-control form-control-sm mb-2" name="phone_no"
                                            value=<?php echo $phone ?> type="text" placeholder="Phone Number">
                                        <input class="form-control form-control-sm mb-2" name="address"
                                            value=<?php echo $address ?> type="text" placeholder="Address">
                                        <input type="file" name="image" class="form-control-file mb-2 upload-image" />
                                        <input type="submit" name="submit" class="btn btn-primary btn-sm"
                                            value="Update Account">
                                    </form>
                                </div>

                                <?php 
                                        if(isset($_POST['submit'])){

                                            $username=$_POST['username'];
                                            $email=$_POST['email_id'];
                                            $addr=$_POST['address'];
                                            $mobile=$_POST['phone_no'];

                                            $customersql=" SELECT customer_id FROM customer WHERE customer_name = '$customer_name' ";
                                            $customer_query=oci_parse($conn,$customersql);
                                            oci_execute($customer_query);
                                            $customer_id=oci_fetch_assoc($customer_query);
                                            $id = $customer_id['CUSTOMER_ID'];

                                            if($_FILES['image']['name'] != ""){
                                                    $file_name = $_FILES['image']['name'];
                                                    $temp_name = $_FILES['image']['tmp_name'];
                                                    move_uploaded_file($temp_name, "images/".$file_name);

                                                    $emailquery="UPDATE customer SET customer_name='$username', email='$email',
                                                    customer_address='$addr', phone_no='$mobile', image='images/$file_name' WHERE customer_id = $id ";
                                            }
                                            else{
                                                $emailquery="UPDATE customer SET customer_name='$username', email='$email',
                                                customer_address='$addr', phone_no='$mobile' WHERE customer_id = $id ";
                                            }

                                            $query=oci_parse($conn,$emailquery) or die("Record not updated");
                                            oci_execute($query);

                                            if($query){
                                                echo("<meta http-equiv='refresh' content='0'>");
                                            }   
                                        }
                                    ?>

                                <!-- Update profile Ends-->
                                <!-- Change Password-->
                                <div class="tab-pane changePasswordForm" id="changePassword">
                                    <h6>Change Password</h6>
                                    <form id="changePassword2" method="POST">
                                        <input class="form-control form-control-sm mb-2 oldpass" name="oldPass"
                                            type="password" placeholder="Old Password" reqiured>
                                        <input class="form-control form-control-sm mb-2 newPass1" name="newPass1"
                                            type="password" placeholder="New Password" reqiured>
                                        <input class="form-control form-control-sm mb-2 newPass2" name="newPass2"
                                            type="password" placeholder="Re-enter New Password" reqiured>
                                        <input type="submit" name="changePassword1" class="btn btn-primary btn-sm"
                                            value="Change Password">
                                    </form>
                                </div>
                                <!-- Change Password Ends-->

                                <!-- Invoice -->
                                <div class="tab-pane" id="invoice">
                                    <h6>Invoice</h6>
                                    <table class="table table-bordered">
                                    <?php
                                            $sqlpayment ="SELECT * FROM PAYMENT WHERE customer_id='$name' ";
                                            $querypayment=oci_parse($conn,$sqlpayment);
                                            oci_execute($querypayment);
                                    ?>
                                        <thead>
                                            <tr>
                                                <th scope="col">Invoice No</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php while($email_pass=oci_fetch_assoc($querypayment)) {
                                            ?>
                                            <tr>
                                                <th scope="row"><?php echo $email_pass['PAYMENT_ID']; ?></th>
                                                <td><?php echo $email_pass['PAYMENT_DATE']; ?></td>
                                                <td><?php echo "£ ".$email_pass['SUB_TOTAL']; ?></td>
                                                <!--<td><a href="" data-toggle="modal" data-target="#staticBackdrop">View</a></td> -->
                
                                                <table class="table table-bordered">
                                                <?php
                                                            $paymentid = $email_pass['PAYMENT_ID'];
                                                            $sqlpaymentdetails ="SELECT * FROM PAYMENT_DETAILS WHERE payment_id='$paymentid' ";
                                                            $querypaymentdetails=oci_parse($conn,$sqlpaymentdetails);
                                                            oci_execute($querypaymentdetails);
                                                    ?>
                                                     <h6>Details</h6>
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Product Price</th>
                                                                <th scope="col">Quantity</th>
                                                                <th scope="col">Product</th>
                                                                <th scope="col">Trader</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php while($details=oci_fetch_assoc($querypaymentdetails)) {
                                                                ?>
                                                                <tr>
                                                                    <th scope="row"><?php echo $details['PRODUCT_PRICE']; ?></th>
                                                                    <td><?php echo $details['PRODUCT_QUANTITY']; ?></td>
                                                                    <td><?php echo $details['PRODUCT_ID']; ?></td>
                                                                    <td><?php echo $details['TRADER_ID']; ?></td>
                                                                </tr>
                                                            <?php }?>
                                                        </tbody>


                                                </table>

                                            </tr>
                                        <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Invoice Ends-->

                                <!-- Delete Account -->
                                <div class="tab-pane" id="deleteAccount">
                                    <h6>Delete Account</h6>
                                    <p>Are you sure you want to delete this account</p>
                                    <form action="deleteAccount.php" method="POST">
                                        <input type="submit" name="delete" class="btn btn-danger btn-sm"
                                            value="Delete Account" />
                                    </form>
                                </div>
                                <!-- Delete Account Ends-->

                                <!-- Logout -->
                                <div class="tab-pane" id="logout">
                                    <h6>Logout</h6>
                                    <p>Are you sure you want to logout of your account</p>
                                    <a class="btn btn-outline-dark btn-sm" href="logout.php"> Logout</a>
                                </div>
                                <!-- Logout Ends-->
                            </div>
                        </div>
                    </div>
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
});
    </script>

</body>

</html>

<?php }?>