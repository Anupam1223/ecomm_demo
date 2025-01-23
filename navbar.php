<?php

if(!isset($_SESSION['username'])){
    session_start();
}
include "config.php";
?>
<?php $cur_format = '$';
    if(!empty($header[0]['currency_format'])){
        $cur_format = $header[0]['currency_format'];
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link crossorigin="anonymous" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        referrerpolicy="no-referrer" rel="stylesheet" />
    <link rel="stylesheet" href="style/style.css">
    <style>
    .modal-content {
        height: 400px;
        width: 500px;
    }

    .modal-content form {
        height: 250px;
        width: 200px;
        text-align: center;
    }

    .modal-content .close {
        text-align: right;
        margin-top: 2px;
        margin-right: 2px;
    }

    .modal-content .form-control .text-center {
        margin: 2px;
    }

    .modal-content .form-control {
        height: 50px;
        width: 100%;
    }

    .modal .form-control {
        width: 30%;
        margin: 0 auto;
        background: #fff;
        padding: 2%;
        border: none;
    }

    .modal .border-bottom {
        padding-bottom: 4px;
        border-bottom: 2px solid #808080;
    }

    .modal input {
        width: 100%;
        border: 2px solid #aaa;
        border-radius: 4px;
        margin: 8px 0;
        padding: 8px;
        box-sizing: border-box;
    }

    .modal input[type="checkbox"] {
        display: inline-block;
        width: auto;
    }

    .modal input:focus {
        border-color: rgb(22, 100, 177);
    }

    .modal .inputWithIcon input {
        padding-left: 40px;
        width: 240px
    }

    .modal .inputWithIcon {
        position: relative;
    }

    .modal .inputWithIcon .bg {
        position: absolute;
        right: 237px;
        top: 13px;
        padding: 9px 8px;
        color: #aaa;
    }

    .modal .inputWithIcon.inputIconBg .bg {
        background-color: #aaa;
        color: #fff;
        padding: 9px 3px;
        border-radius: 4px 4px 4px 4px;
    }

    .modal .inputWithIcon.inputIconBg input:focus+.bg {
        color: #fff;
        background-color: rgb(22, 100, 177);
    }

    .modal .eye {
        position: absolute;
        left: 238px;
        top: 8px;
        padding: 9px 7px;
        color: #aaa;
    }

    /* form styling ends */

    /* Utilities */
    .modal .btn {
        background: rgb(22, 100, 177);
        padding: 7px;
        border-color: #3b719f;
        width: 100px;
        color: white;
    }

    .modal .btn:hover {
        background: rgb(24, 110, 197);
        cursor: pointer;
    }

    .modal a {
        color: rgb(22, 100, 177);
        text-decoration: none;
    }

    .modal a:hover {
        color: rgb(24, 104, 185);
        text-decoration: underline;
    }

    .modal .pt-2 {
        padding-top: 8px;
        height: 200px;
        width: 300px;
    }

    .modal .text-center {
        text-align: center;
        height: 50px;
        width: 300px;
    }
    .modal-content .close {
        margin-right: 10px;
    }
    </style>
</head>

<body>
    <div id="bg-light">
        <div class="container">
            <nav class="navbar navbar-expand-md navbar-light">
                <a class="navbar-brand mr-md-2 mr-lg-2 mr-0" href="index.php"><img src="images/logo.png" alt=""></a>

                <div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#openSearchbar">
                        <i class="fas fa-search"></i>
                    </button>

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#openNavbar">
                        <i class="fas fa-align-justify"></i>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="openSearchbar">
                    <hr />
                    <form action="search.php" method="get" class="form-inline d-flex d-md-none justify-content-center">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" id="increase-width" name="search-product"
                                placeholder="Search">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-dark" name="submit-search"> <i
                                        class="text-white fas fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="collapse navbar-collapse" id="openNavbar">
                    <hr />
                    <form action="search.php" method="get" class="form-inline ml-auto mr-5 d-none d-md-flex my-4">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" name="search-product" id="increase-width"
                                placeholder="Search">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-dark" name="submit-search"> <i
                                        class="text-white fas fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <?php if(isset($_SESSION['username'])){
                                        $name =$_SESSION['id'];

                                        /*
                                        $sql ="SELECT * FROM signup WHERE customer_id='$name' ";
                                        $query=mysqli_query($conn,$sql);
                                        $email_pass=mysqli_fetch_assoc($query);
                                        $customer_name = $email_pass['customer_name'];
                                        $image = $email_pass['imagee'];
                                        */

                                        $sql = "SELECT * FROM customer WHERE customer_id='$name'";
                                        $query = oci_parse($conn,$sql);
                                        oci_execute($query);
                                        $email_pass=oci_fetch_array($query);
                                        $customer_name = $email_pass['CUSTOMER_NAME'];
                                        $image = $email_pass['IMAGE'];

                                ?>
                            <a class="nav-link active text-center " href="customer-profile.php"><img
                                    src="<?php echo $image ?>" class="mr-1 rounded-circle" alt="">Welcome |
                                <?Php echo $customer_name?>
                            </a>
                            <?php   }?>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active text-center" href="cart.php"><i
                                    class="fas fa-shopping-cart basket"></i>
                                <?php if(isset($_COOKIE['cart_count'])){
                                            echo '<span id="item-holder">'.$_COOKIE["cart_count"].'</span>';
                                        } ?>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link active text-center" href="#" id="navbarDropdown" role="button"
                                data-toggle="dropdown">
                                More<i class="fas fa-angle-down ml-1"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <?php if(isset($_SESSION['username'])){ ?>
                                <a class="dropdown-item" href="customer-profile.php">Profie Setting</a>
                                <?php }?>
                                <?php if(!isset($_SESSION['username'])){ ?>
                                <a class="dropdown-item" href="register.php">Register</a>
                                <?php }?>
                                <?php if(!isset($_SESSION['username'])){ ?>
                                <a class="dropdown-item" href="login.php">Login</a>
                                <?php }?>
                                <?php if(isset($_SESSION['username'])){ ?>
                                <a class="dropdown-item" href="logout.php">Logout</a>
                                <?php }?>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="userLogin_form" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <div class="modal-body">
                                <!-- Form -->
                                <form id="loginUser" method="POST">
                                    <div class="form-control">
                                        <h2 class="border-bottom text-center">Sign-In</h2>
                                        <div class="pt-2">
                                            <div class="inputWithIcon inputIconBg">
                                                <input type="email" class="username" name="email" placeholder="Email" />
                                                <i class="fa fa-envelope fa-lg fa-fw bg"></i>
                                            </div>
                                            <div class="inputWithIcon inputIconBg">
                                                <input type="password" class="password" name="password"
                                                    placeholder="Password" />
                                                <i class="fas fa-key fa-lg fa-fw bg"></i>
                                                <span class="eye">
                                                    <i class="fas fa-eye togglePassword"></i>
                                                </span>
                                            </div>
                                            <input class="btn" type="submit" value="Continue" />
                                            <div class="text-center">
                                                <p>
                                                    <small>Don't have an account?
                                                        <a href="register.php">Register</a></small>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!-- /Form -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Modal -->
            </nav>
        </div>
    </div>
</body>

</html>