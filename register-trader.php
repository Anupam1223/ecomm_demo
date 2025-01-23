<?php
// Import PHPMailer classes into the global namespace 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
$mail = new PHPMailer(true); 

session_start();

include 'config.php';

if(isset($_POST['tradname'])){
    
    $tradername=$_POST['tradname'];
    $email=$_POST['tradmail'];
    $addr=$_POST['tradaddress'];
    $mobile=$_POST['tradmob'];
    $desc=$_POST['sdesc'];
    $pass = $_POST['password'];
    $shop = $_POST['shoptype'];
    $pattern = "/^(?=.*\d)(?=.*[0-9a-zA-Z]).*$/";

    if(!isset($_POST['tradname']) || empty($_POST['tradname'])){
        echo json_encode(array('error'=>'Please enter your name')); exit;
    }
    elseif(!isset($_POST['tradmail']) || empty($_POST['tradmail'])){
        echo json_encode(array('error'=>'Please enter your email')); exit;
    }
    elseif(!isset($_POST['password']) || empty($_POST['password'])){
        echo json_encode(array('error'=>'Please enter your password')); exit;
    }
    elseif(!isset($_POST['tradaddress']) || empty($_POST['tradaddress'])){
        echo json_encode(array('error'=>'Please enter your address')); exit;
    }
    elseif(!isset($_POST['tradmob']) || empty($_POST['tradmob'])){
        echo json_encode(array('error'=>'Please enter your contact number')); exit;
    }
    elseif(!isset($_POST['sdesc']) || empty($_POST['sdesc'])){
        echo json_encode(array('error'=>'Please enter your shop description')); exit;
    }
    else{

            $token= bin2hex(random_bytes(15));

            $emailquery="SELECT * FROM trader WHERE email='$email' ";
            $query=oci_parse($conn,$emailquery);
            oci_execute($query);

            $email_count=oci_fetch_assoc($query);
            if($email_count>0){
                echo json_encode(array('error'=>'Email already exists')); exit;
            }
            else{

                if(!empty($tradername)){
                                        
                    if(!empty($email)){ 
                            
                        if(!empty($addr)){
                    
                            if(!empty($mobile)){

                                if(preg_match($pattern, $pass)){

                                    //$password=password_hash($pass, PASSWORD_BCRYPT);
                                    $token= bin2hex(random_bytes(15));

                                    $insertqry="INSERT INTO TRADER(trader_name, email,phone_no, password, trader_description , shop, token, status, address)
                                    VALUES('$tradername','$email','$mobile','$pass','$desc','$shop','$token','inactive','$addr')";

                                    $iqry=oci_parse($conn,$insertqry);
                                    oci_execute($iqry);
                                        if($iqry){
                                            $mail->isSMTP();                      // Set mailer to use SMTP 
                                            $mail->Host = 'smtp.gmail.com';       // Specify main and backup SMTP servers 
                                            $mail->SMTPAuth = true;               // Enable SMTP authentication 
                                            $mail->Username = 'anupam.siwakoti@gmail.com';   // SMTP username 
                                            $mail->Password = 'password';   // SMTP password 
                                            $mail->SMTPSecure = 'tls';            // Enable TLS encryption, `ssl` also accepted 
                                            $mail->Port = 587;                    // TCP port to connect to 
                                            
                                            // Sender info 
                                            $mail->setFrom($email, $tradername); 
                                            
                                            // Add a recipient 
                                            $mail->addAddress('anupam.siwakoti@gmail.com'); 
                                            $mail->addAddress('amit254742@gmail.com'); 
                                            
                                            //$mail->addCC('cc@example.com'); 
                                            //$mail->addBCC('bcc@example.com'); 
                                            
                                            // Set email format to HTML 
                                            $mail->isHTML(true); 
                                            
                                            // Mail subject 
                                            $mail->Subject = 'Trader registration request'; 
                                            
                                            // Mail body content 
                                            $body="Hey this is, $tradername, I want to register my shop in local market.<br><b>Furthur details are given below</b><br>  
                                            mail = $email <br>
                                            contact = $mobile <br>
                                            address = $addr <br>
                                            shop description = $desc <br> 
                                            If you want to add $tradername as a trader of localmarket, click here to activate account<br>
                                            http://localhost/ecommfinal/traderdashboard/activate.php?token=$token "; 
                                            $mail->Body    = $body; 
                                            
                                            // Send email 
                                            if(!$mail->send()) { 
                                                //echo 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo; 
                                                echo json_encode(array('error'=>'Email sending failed...'.$mail->ErrorInfo)); exit;
                                            } else { 
                                                //echo 'Message has been sent.'; 
                                                $_SESSION['msg']="check your mail to activate your account $email";
                                                echo json_encode(array('success'=>'registered successfully!!!!')); exit;
                                            } 
                                        }
                                        else{
                                            echo json_encode(array('error'=>'Error occurs while creating an account')); exit;

                                        }
                                    }
                                else{
                                    echo json_encode(array('error'=>'Password must contain a capital letter, a number and a symbol(!$%^&)')); exit;
                                }
                            }
                            else{
                            echo json_encode(array('error'=>'Phone number is missing!!')); exit;
                            }
                        }
                        else{
                            echo json_encode(array('error'=>'Address is missing!!')); exit;
                        }
                    }
                    else{
                        echo json_encode(array('error'=>'Email is missing!!')); exit;
                    }
                }
                else{
                    echo json_encode(array('error'=>'Username is missing!!')); exit;
                }   
            }        
        } 
}