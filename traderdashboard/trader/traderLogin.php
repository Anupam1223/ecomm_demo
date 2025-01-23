<?php
include '../../config.php';
if(isset($_POST['login'])){
		if(!isset($_POST['username']) || empty($_POST['username'])){
			echo json_encode(array('error'=>'Username Field is Empty.')); exit;
		}elseif(!isset($_POST['password']) || empty($_POST['password'])){
			echo json_encode(array('error'=>'Passowrd Field is Empty.')); exit;
		}else{
            $Email=$_POST['username'];
            $pass=$_POST['password'];
            $email_search="SELECT * FROM trader WHERE email='$Email'and status='active'";
            $query=oci_parse($conn,$email_search);
            oci_execute($query);
            $email_count=oci_num_fields($query);

			if($email_count > 0){

                                $email_pass=oci_fetch_assoc($query);
                                $d_pass=$email_pass['PASSWORD'];
                               // $pass_decode=password_verify($pass,$d_pass);

                        if ($pass == $d_pass){ 
                                
                                session_start();
                                $_SESSION['trader_username']=$email_pass['TRADER_NAME'];
                                $_SESSION['trader_id']=$email_pass['TRADER_ID'];

                                echo json_encode(array('success'=>'Logged In Successfully.')); exit;

                        }
                        else{
                            echo json_encode(array('error'=>'Username and Password not matched.')); exit;
                        }
                }
        }
}  
       
?>