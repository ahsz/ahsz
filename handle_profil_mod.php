<?php
	session_start(); 
	require "config.php";
	
	if (isset($_POST['email_mod'])) {
		$user=$_SESSION['username'];
		$email=$_POST['email_mod'];
		
		if($email==null)
		{
			echo "Üresen hagytad az e-mail mezőt! ";
			echo '<a href="profil.php">'. Vissza . '</a>';
			exit();
		}
		
		$sql="UPDATE USER SET EMAIL='$email', DATE_MOD=sysdate() WHERE NEPTUN='$user'";
		$res=mysqli_query($con,$sql);	
		
		if(!$res)
		{	
			echo "HIBA: " . mysqli_error($con);
			echo '<a href="profil.php">'. Vissza . '</a>';
			exit();
		}
		else
		{
			//header("Location: profil.php");
			echo "Sikeres e-mail cím módosítás!";
			echo '<a href="profil.php">'. Vissza . '</a>';
			exit();
		}
	}


	if (isset($_POST['old_pw']) && isset($_POST['new_pw1']) && isset($_POST['new_pw2'])) {
		$user=$_SESSION['username'];
		$old_pw=$_SESSION['PASSWORD'];

		if($_POST['old_pw']==null) { 
			echo "Üresen hagytad a régi jelszó mezőt!"; 
			exit(); 
		} 
		$old_pw_p=$_POST['old_pw'];
		
		if ($_POST['new_pw1']==null) {
			echo "Üresen hagytad az új jelszó mezőt!";
			exit();
		}
		$new_pw1_p=$_POST['new_pw1'];
		
		if ($_POST['new_pw2']==null) {
			echo "Üresen hagytad az új jelszó mégegyszer mezőt!";
			exit();
		}
		$new_pw2_p=$_POST['new_pw2'];
		
		if(strcmp($old_pw,$old_pw_p)!=0){
			echo "Nem egyezzik a régi jelszó!";
			exit();
		} else if (strcmp($new_pw1_p,$new_pw2_p)!=0) {
			echo "Nem egyezzik a két új jelszó!";
			exit();
		}
		
		$sql="UPDATE USER SET PASSWORD='$new_pw1_p', DATE_MOD=sysdate() WHERE NEPTUN='$user'";
		$res=mysqli_query($con,$sql);	
		
		if(!$res) {	
			echo "ERROR: " . mysqli_error($con);
			exit();
		} else {
			header("Location: profil.php");
			exit();
		}
	}
?>