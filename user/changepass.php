<?php
                            include "../config.php";

                            session_start();
                            $name =$_SESSION['id'];
                           
                            if(isset($_POST['pass'])){

                                if(!isset($_POST['pass']) || empty($_POST['pass'])){
                                    echo json_encode(array('error'=>'Please enter old password')); exit;
                                }
                                elseif(!isset($_POST['pass1']) || empty($_POST['pass1'])){
                                    echo json_encode(array('error'=>'New password is empty.')); exit;
                                }elseif(!isset($_POST['pass2']) || empty($_POST['pass2'])){
                                    echo json_encode(array('error'=>'Re-enter new password. ')); exit;
                                }else{

                                $password=$_POST['pass'];
                                $password1=$_POST['pass1'];
                                $password2=$_POST['pass2'];

                                $customersql1=" SELECT password FROM customer WHERE customer_id='$name' ";

                                $customer_query1=oci_parse($conn,$customersql1);
                                oci_execute($customer_query1);

                                $customer_id1=oci_fetch_assoc($customer_query1) or die("query didnt worked");
                                $pass = $customer_id1['PASSWORD'];
                                $verify = password_verify($password, $pass);

                                    if ($verify) {
                                        if(preg_match('/[A-Z]+/', $password1) && preg_match('/[0-9]+/', $password1) && preg_match('/[!$%^&]+/', $password1)){
                                            if($password1 == $password2){
                                                $pass=password_hash($password1, PASSWORD_BCRYPT);
                                                $emailquery="UPDATE customer SET password='$pass' WHERE customer_id = $name ";
                                                $query=oci_parse($conn,$emailquery);
                                                oci_execute($query);
                                                echo json_encode(array('success'=>'npassword changed successfully')); exit;
                                            }
                                            else{
                                                echo json_encode(array('error'=>'new passwords doesnt match with each other')); exit;
                                            }
                                        }
                                        else{
                                            echo json_encode(array('error'=>'Password must contain a capital letter, a number and a symbol(!$%^&)')); exit;
                                        }
                                    } 
                                    else {
                                        echo json_encode(array('error'=>'Incorrect Old Password!!!!')); exit;
                                    }
                                }
                            }
                         ?>