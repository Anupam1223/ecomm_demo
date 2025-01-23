<?php
	// db connection
	include 'config.php';
	
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	  }  

	if(!session_id()){
		session_start();
	}
	if(!isset($_SESSION['username'])){
		die('please_login');
	}else{

	if(isset($_POST['post']) && isset($_POST['rating'])){
		$post_id = mysqli_real_escape_string($conn,test_input($_POST['post']));
		$rating = mysqli_real_escape_string($conn,test_input($_POST['rating']));

		$sql = "UPDATE product SET  Rating = Rating + {$rating}, Rated_by = Rated_by + 1 WHERE Product_ID='".$post_id."'";
		$result = mysqli_query($conn,$sql) or die("query didnt worked");
		if($result == '1'){
			echo 'true'; exit;
			}
		}
	}
?>