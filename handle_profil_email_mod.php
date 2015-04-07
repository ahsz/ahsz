<?php
	session_start(); 
	require "config.php";
	
	if (isset($_POST['email_mod'])) {
		$user=$_SESSION['username'];
		$email=$_POST['email_mod'];
		
		if($email==null)
		{
			echo "Üresen hagytad az e-mail mezőt!";
			exit();
		}
		
		$sql="UPDATE USER SET EMAIL='$email', DATE_MOD=sysdate() WHERE NEPTUN='$user'";
		$res=mysqli_query($con,$sql);	
		
		if(!$res)
		{	
			Echo "ERROR: " . mysqli_error($con);
		}
		else
		{
			header("Location: profil.php");
		}
	}
?>
