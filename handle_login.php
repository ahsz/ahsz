<?php

	session_start(); 
	require "config.php";
	
	if($_POST["login"])
	{
		$user  = $_POST['username']; 
		$pass  = $_POST['password']; 
		
		if($user == "" || $pass == "") 
		{ 
			echo "Kerlek toltsd ki a mezoket!"; 
		} 
		else
		{
			$result=mysqli_query($con,"SELECT * FROM USER WHERE NEPTUN='$user' and PASSWORD='$pass'");
			$count=mysqli_num_rows($result);
		
			if($count==1){
				$_SESSION['username'] = $user;
				header("location:success.php");
			}
			 else{ 
				echo "Nem letezo neptun kod vagy rossz jelszo!"; 
			} 
		}
	}
	
	if($_POST["register"]) {
		header("Location: register.html");
	}
	exit;
?>
