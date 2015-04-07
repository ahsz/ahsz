<?php
  session_start(); 
	require "config.php";
	
	if (isset($_POST['email_mod'])) {
		$user=$_SESSION['username'];
		$email=$_POST['email_mod'];
		
		$sql="UPDATE USER SET EMAIL='$email', DATE_MOD=sysdate() WHERE NEPTUN='$user'";
		$res=mysqli_query($con,$sql);	
		
		If(!$res)
		{	
			Echo "ERROR: " . mysqli_error($con);
		}
		Else
		{
			header("Location: profil.php");
		}
	}	
?>
