<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link crossorigin="anonymous" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        referrerpolicy="no-referrer" rel="stylesheet" />
    <title>Trader Login</title>
    <link rel="stylesheet" href="../style/form.css">

    <style>
    .alert {
        text-align: center;
        padding: .75rem 1.25rem;
        margin-bottom: 1rem;
        margin-top: 1rem;
        border: 1px solid transparent;
        border-radius: .25rem;
    }

    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
        padding: 10px
    }

    .alert-success {
        color: #721c24;
        background-color: #20c997;
        border-color: #f5c6cb;
        padding: 10px
    }

    form {
        height: 62.5vh;
        display: flex;
        justify-content: center;
        align-items: center;
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
    <?php include "navbar2.php" ?>
    <div class="background-img">
        <form id="traderLogin" method="POST">
            <div class="form-control">
                <h2 class="border-bottom text-center">Trader Sign-In</h2>
                <div class="pt-2">
                    <div class="inputWithIcon inputIconBg">
                        <input type="email" class="email" placeholder="Email" />
                        <i class="fa fa-envelope fa-lg fa-fw bg"></i>
                    </div>
                    <div class="inputWithIcon inputIconBg">
                        <input type="password" placeholder="Password" class="password" />
                        <i class="fas fa-key fa-lg fa-fw bg"></i>
                        <span class="eye">
                            <i class="fas fa-eye togglePassword"></i>
                        </span>
                    </div>
                    <input type="checkbox" id="rememberMe" name="rememberMe" value="rememberMe" />
                    <label for="rememberMe"> Remember Me</label>
                    <input class="btn" type="submit" name="submit" value="Signin" />
                    <div class="text-center">
                    <p>
                        <small>Don't have an trader account
                            <a href="../traders-register.php">Register</a></small>
                    </p>
                    <p>
                        <small>Login as customer
                            <a href="../login.php">customer login</a></small>
                    </p>
                </div>
                </div>
            </div>
        </form>
    </div>

    <?php include "../script.php" ?>
    <script src="../script/script.js"></script>
    <script src="../script/action.js"></script>

    <script src="http://code.jquery.com/jquery-3.4.0.min.js"
        integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>
    <script>
    < /body>

    <
    /html>