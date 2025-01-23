<?php
// Import PHPMailer classes into the global namespace 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
$mail = new PHPMailer(true); 

session_start();

include 'config.php';

if(isset($_POST['cusname'])){
    $username=$_POST['cusname'];
    $email=$_POST['cusmail'];
    $addr=$_POST['cussaddress'];
    $mobile=$_POST['cussmob'];
    $password=$_POST['pass3'];
    $cpassword=$_POST['pass4'];
    $pattern = "/^(?=.*\d)(?=.*[0-9a-zA-Z]).*$/";

    if(!isset($_POST['cusname']) || empty($_POST['cusname'])){
        echo json_encode(array('error'=>'Please enter your name')); exit;
    }
    elseif(!isset($_POST['cusmail']) || empty($_POST['cusmail'])){
        echo json_encode(array('error'=>'Please enter your email')); exit;
    }
    elseif(!isset($_POST['cussaddress']) || empty($_POST['cussaddress'])){
        echo json_encode(array('error'=>'Please enter your address')); exit;
    }
    elseif(!isset($_POST['cussmob']) || empty($_POST['cussmob'])){
        echo json_encode(array('error'=>'Please enter your contact number')); exit;
    }
    elseif(!isset($_POST['pass3']) || empty($_POST['pass3'])){
        echo json_encode(array('error'=>'Please enter your password')); exit;
    }
    elseif(!isset($_POST['pass4']) || empty($_POST['pass4'])){
        echo json_encode(array('error'=>'Please re-enter your password')); exit;
    }
    else{

            $pass=password_hash($password, PASSWORD_BCRYPT);
            $cpass=password_hash($cpassword, PASSWORD_BCRYPT);

            $token= bin2hex(random_bytes(15));

            $emailquery="SELECT * FROM customer WHERE email='$email' ";
            $query=oci_parse($conn,$emailquery);
            oci_execute($query);

            $email_count=oci_fetch_assoc($query);
            if($email_count>0){
                echo json_encode(array('error'=>'Email already exists')); exit;
            }
            else{

               
                if(!empty($username)){
                                        
                    if(!empty($email)){ 
                            
                        if(!empty($addr)){
                    
                            if(!empty($mobile)){

                                if(!empty($password)){

                                    if(!empty($cpassword)){
                
                                        if(filter_var($email, FILTER_VALIDATE_EMAIL)){

                                                if(preg_match($pattern, $password)){

                                                    if($password === $cpassword){

                                                            $insertqry="INSERT INTO customer(customer_name,
                                                            email,phone_no, customer_address,  password,token,status)
                                                            VALUES('$username','$email','$mobile','$addr','$pass','$token','inactive')";

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
                                                                            $mail->setFrom('anupam.siwakoti@gmail.com', 'Anupam'); 
                                                                            
                                                                            // Add a recipient 
                                                                            $mail->addAddress($email); 
                                                                            
                                                                            //$mail->addCC('cc@example.com'); 
                                                                            //$mail->addBCC('bcc@example.com'); 
                                                                            
                                                                            // Set email format to HTML 
                                                                            $mail->isHTML(true); 
                                                                            
                                                                            // Mail subject 
                                                                            $mail->Subject = 'Complete your registration @ localmarket'; 
                                                                            
                                                                            // Mail body content 
                                                                            $body="Hi, $username. Click here to activate your account 
                                                                            http://localhost/ecommfinal/activate.php?token=$token "; 
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
                                                                /*
                                                                    if(mail($email,$subject,$body,$headers)){
                                                                        $_SESSION['msg']="check your mail to activate your account $email";
                                                                        echo json_encode(array('success'=>'registered successfully!!!!')); exit;
                                                                    }
                                                                    else{
                                                                        echo json_encode(array('error'=>'Email sending failed...')); exit;
                                                                    }
                                                                */
                                                            }
                                                                else{
                                                                    echo json_encode(array('error'=>'Error occurs while creating an account')); exit;

                                                                }
                                                    }
                                                    else{
                                                        echo json_encode(array('error'=>'Password are not matching')); exit;
                                                        }
                                                }
                                                else{
                                                    echo json_encode(array('error'=>'Password must contain a capital letter, a number and a symbol(!$%^&)')); exit;
                                                }
                                        }
                                        else{
                                                echo json_encode(array('error'=>'Provided email is invalid, please provide valid Email')); exit;
                                            }
                                    }
                                    else{
                                            echo json_encode(array('error'=>'Please re-enter password for validation!!')); exit;
                                    }
                                }
                                else{
                                    echo json_encode(array('error'=>'Password is missing!!')); exit;
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
 