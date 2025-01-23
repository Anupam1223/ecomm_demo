<?php 
    include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style/form.css" />
    <title>LocalMarket Trader's Registeration</title>

    <style>
            .inputWithIcon.inputIconBg .bg {
                background-color: rgb(22, 100, 177);
                color: #fff;
            }
            .alert{

                text-align:center;
                padding: .75rem 1.25rem;
                margin-bottom: 1rem;
                margin-top: 1rem;
                border: 1px solid transparent;
                border-radius: .25rem;
            }

            .alert-danger{
                color: #721c24;
                background-color: #f8d7da;
                border-color: #f5c6cb;
                padding: 10px
            }
            .inputWithIcon.inputIconBg .bg {
                padding: 10px 4px;
            }
            .text-center a{
            text-decoration: none;
            }
            
            .form-control select {
            width: 100%;
            border: 2px solid #aaa;
            border-radius: 4px;
            margin: 8px 0;
            padding: 8px;
            box-sizing: border-box;
            }
    </style>
</head>

<body>

    <?php include "navbar2.php"; ?>
    <form id="traderregister" method="POST">
        <div class="form-control">
            <h2 class="border-bottom text-center">Create Trader's Account</h2>
            <div class="pt-2">
                <div class="inputWithIcon inputIconBg">
                    <input type="text" class="name" placeholder="Your Name" />
                    <i class="fa fa-user fa-lg fa-fw bg"></i>
                </div>

                <?php 
                    $query = "SELECT * FROM shop";
                    $result = oci_parse($conn, $query);
                    oci_execute($result);
                ?>
                <div class="inputWithIcon inputIconBg">
                    <select name="shoptype" class="shoptype">
                        <option value="" disabled selected></option>

                        <?php 

                        while (($row = oci_fetch_array($result, OCI_ASSOC)) != false){
                                ?>
                        <option value="<?php echo $row['SHOP']; ?>">
                            <?php echo $row['SHOPE_NAME'];?></option>
                        <?php
                            }
                            ?>

                    </select>
                    <class class="fas fa-store-alt fa-lg fa-fw bg"></i>
                </div>
                <div class="inputWithIcon inputIconBg">
                    <input type="email" class="email" placeholder="Email" />
                    <i class="fa fa-envelope fa-lg fa-fw bg"></i>
                </div>
                <div class="inputWithIcon inputIconBg">
                    <input type="text" class="address" placeholder="Address" />
                    <i class="fas fa-map-marker-alt fa-lg fa-fw bg"></i>
                </div>
                <div class="inputWithIcon inputIconBg">
                    <input type="text" class="phonenumber" placeholder="Phone Number" />
                    <i class="fa fa-phone fa-lg fa-fw bg"></i>
                </div>
                <div class="inputWithIcon inputIconBg">
                    <input type="password" class="password" placeholder="password" />
                    <i class="fa fa-lock fa-lg fa-fw bg"></i>
                </div>
                <div class="mt-2 inputWithIcon inputIconBg">
                    <i class="fas fa-list-ul fa-lg fa-fw bg-textarea"></i>
                    <textarea class="shopdesc" placeholder="Please specify name of items you want to sell on LocalMarket"></textarea>
                    <small class="text-muted">For example: egg, chicken</small>
                </div>
                <input class="btn text-white" type="submit" value="Continue" />

                <div class="text-center">
                    <p>
                        <small>Already have Trader account? <a href="traderdashboard/login.php">Signin</a></small>
                    </p>
                </div>
            </div>
        </div>
    </form>
    <?php include "footer2.php" ?>
    <?php include "script.php" ?>

<script src="script/action.js"></script>  
<script src="http://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>
</body>

</html>