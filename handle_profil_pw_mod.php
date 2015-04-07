<?php
	session_start();  
	require "config.php"; 

	if (isset($_POST['old_pw']) && isset($_POST['new_pw1']) && isset($_POST['new_pw2'])) {
		$user=$_SESSION['username'];
		$old_pw=$_SESSION['PASSWORD'];

		if($old_pw_p==null) { 
			echo "Üresen hagytad a régi jelszó mezőt!"; 
			exit(); 
		} 
		$old_pw_p=$_POST['old_pw'];
		
		if ($new_pw1_p==null) {
			echo "Üresen hagytad az új jelszó mezőt!";
			exit();
		}
		$new_pw1_p=$_POST['new_pw1'];
		
		if ($new_pw2_p==null) {
			echo "Üresen hagytad az új jelszó mégegyszer mezőt!";
			exit();
		}
	/*	$new_pw2_p=$_POST['new_pw2'];
		
		if(strcmp($old_pw,$old_pw_p)!=0){
			echo "Nem egyezzik a régi jelszó!";
		} else if (strcmp($new_pw1_p,$new_pw2_p)!=0) {
			echo "Nem egyezzik a két új jelszó!";
		} else {
			$sql="UPDATE USER SET PASSWORD='$new_pw1_p', DATE_MOD=sysdate() WHERE NEPTUN='$user'";
			$res=mysqli_query($con,$sql);	
		
		if(!$res) {	
			Echo "ERROR: " . mysqli_error($con);
		} else
		{
			header("Location: profil.php");
		}*/
	}
?>
