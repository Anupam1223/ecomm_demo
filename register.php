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
    <title>LocalMarket Registeration</title>

    <style>

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
        .alert-success{
            color: #721c24;
            background-color: #20c997;
            border-color: #f5c6cb;
            padding: 10px
        }
        .inputWithIcon.inputIconBg .bg {
            padding: 10px 4px;
        }
        .text-center a{
            text-decoration: none;
        }
    </style>
</head>

<body>
    <?php include "navbar2.php"; ?>
    <div class="registrationFormDiv">
        <form id="registrationForm" method="POST">
            <div class="form-control">
                <h2 class="border-bottom text-center">Create Account</h2>
                <div class="pt-2">
                    <div class="inputWithIcon inputIconBg">
                        <input type="text" class="username" name="username" placeholder="Name" />
                        <i class="fa fa-user fa-lg fa-fw bg"></i>
                    </div>

                    <div class="inputWithIcon inputIconBg">
                        <input type="email" class="email" name="email_id" placeholder="Email" />
                        <i class="fa fa-envelope fa-lg fa-fw bg"></i>
                    </div>

                    <div class="inputWithIcon inputIconBg">
                        <input type="text" class="address" name="address" placeholder="Address" />
                        <i class="fas fa-map-marker-alt fa-lg fa-fw bg"></i>
                    </div>

                    <div class="inputWithIcon inputIconBg">
                        <input type="text" class="phone" name="phone_no" placeholder="Phone Number" />
                        <i class="fa fa-phone fa-lg fa-fw bg"></i>
                    </div>

                    <div class="inputWithIcon inputIconBg">
                        <input type="password" class="password3" name="pass"  placeholder="Password" />
                        <i class="fas fa-lock fa-lg fa-fw bg"></i>
                    </div>
                    
                    <div class="inputWithIcon inputIconBg">
                        <input type="password" class="password4" name="confirm_pass" placeholder="Re-enter Password" />
                        <i class="fas fa-lock fa-lg fa-fw bg"></i>
                    </div>

                    <input class="btn text-white" name="submit" type="submit" value="Create Your LocalMarket Account" />

                    <div class="text-center">
                        <p class="mb-0">
                            <small>Already have an account? <a href="login.php">Signin</a></small>
                        </p>
                        <p>
                            <small>Create LoaclMarket Trader's Account?
                                <a href="traders-register.php">Register</a></small>
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php include "footer2.php" ?>
    <?php include "script.php" ?>

    <script src="script/action.js"></script>  
    <script src="http://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>
</body>
</html>