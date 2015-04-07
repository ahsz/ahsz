<?php
  session_start();  
  require "config.php"; 

	
	if (isset($_POST['old_pw']) || isset($_POST['new_pw1']) || isset($_POST['new_pw2'])) {
		$user=$_SESSION['username'];
		$old_pw=$_SESSION['PASSWORD'];
		$old_pw_p=$_POST['old_pw'];
		$new_pw1_p=$_POST['new_pw1'];
		$new_pw2_p=$_POST['new_pw2'];
		
		if($old_pw <> $old_pw_p){
			echo "Nem egyezzik a régi jelszó!";
		} else if ($new_pw1_p <> $new_pw2_p) {
			echo "Nem egyezzik a két új jelszó!";
		} else {
			$sql="UPDATE USER SET PASSWORD='$new_pw1_p', DATE_MOD=sysdate() WHERE NEPTUN='$user'";
			$res=mysqli_query($con,$sql);	
		
		If(!$res)
		{	
			Echo "ERROR: " . mysqli_error($con);
			exit();
		}
		Else
		{
			header("Location: profil.php");
			exit();
		}
	}
