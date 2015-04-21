<?php
	session_start(); 
	require "config.php";
	
		header("Refresh:3; url=../testsite/profil.php"); 
	
	if (isset($_POST['email_mod'])) {
		$user=$_SESSION['username'];
		$email=$_POST['email_mod'];
		$escapedemail = htmlspecialchars($email, ENT_QUOTES);
		if($email==null)
		{
			echo "Uresen hagytad az e-mail cim mezot!"; 
			echo '<a href="profil.php">'. Vissza . '</a>';
			exit();
		}
		
		$sql="UPDATE USER SET EMAIL='$escapedemail', DATE_MOD=sysdate() WHERE NEPTUN='$user'";
		$res=mysqli_query($con,$sql);	
		
		if(!$res)
		{	
			echo "HIBA: " . mysqli_error($con) . " ";
			echo '<a href="profil.php">'. Vissza . '</a>';
			exit();
		}
		else
		{
			echo "Sikeres e-mail cim modositas!";
			echo '<a href="profil.php">'. Vissza . '</a>';
			exit();
		}
	}

	if (isset($_POST['github_user_mod'])) {
		$user=$_SESSION['username'];
		$github_user=$_POST['github_user_mod'];
		$escapedgithub_user = htmlspecialchars($github_user, ENT_QUOTES);
		if($github_user==null)
		{
			echo "Uresen hagytad a GITHUB felhasznalo nev mezot!"; 
			echo '<a href="profil.php">'. Vissza . '</a>';
			exit();
		}
		
		$sql="UPDATE USER SET GITHUB_NAME='$escapedgithub_user', DATE_MOD=sysdate() WHERE NEPTUN='$user'";
		$res=mysqli_query($con,$sql);	
		
		if(!$res)
		{	
			echo "HIBA: " . mysqli_error($con) . " ";
			echo '<a href="profil.php">'. Vissza . '</a>';
			exit();
		}
		else
		{
			echo "Sikeres GITHUB felhasznalo nev modositas!";
			echo '<a href="profil.php">'. Vissza . '</a>';
			exit();
		}
	}

	if (isset($_POST['old_pw']) && isset($_POST['new_pw1']) && isset($_POST['new_pw2'])) {
		$user=$_SESSION['username'];
		
		$sql="SELECT PASSWORD FROM USER WHERE NEPTUN='$user'";
		$res1=mysqli_query($con,$sql);
		
		if($res1->num_rows>0){
			$row=mysqli_fetch_assoc($res1);
			$old_pw=$row['PASSWORD'];
			$old_temp=$old_pw;
			$escapedold_pw = htmlspecialchars($old_pw, ENT_QUOTES);
		} else 	{
			echo "HIBA: " . mysqli_error($con);
			echo '<a href="profil.php">'. Vissza . '</a>'; 
			exit(); 
		}


		if($_POST['old_pw']==null) { 
			echo "Uresen hagytad a regi jelszo mezot! "; 
			echo '<a href="profil.php">'. Vissza . '</a>';
			exit(); 
		} 
		$old_pw_p=$_POST['old_pw'];
		$escapedld_pw_p = htmlspecialchars($old_pw_p, ENT_QUOTES);
		
		if ($_POST['new_pw1']==null) {
			echo "Uresen hagytad az uj jelszo mezot! ";
			echo '<a href="profil.php">'. Vissza . '</a>';
			exit();
		}
		$new_pw1_p=$_POST['new_pw1'];
		$escapednew_pw1_p = htmlspecialchars($new_pw1_p, ENT_QUOTES);
		
		if ($_POST['new_pw2']==null) {
			echo "Uresen hagytad az uj jelszo megegyszer mezot! ";
			echo '<a href="profil.php">'. Vissza . '</a>';
			exit();
		}
		$new_pw2_p=$_POST['new_pw2'];
		$escapednew_pw2_p = htmlspecialchars($new_pw2_p, ENT_QUOTES);
		
		if(strcmp($old_pw,$old_pw_p)!=0){
			echo "Nem egyezik a regi jelszo! ";
			echo '<a href="profil.php">'. Vissza . '</a>';
			echo "---old_pw---";
			echo $old_pw;			
			echo "---escapedold_pw---";
			echo $escapedold_pw;
			echo "---old_pw_p---";
			echo $old_pw_p;
			echo "---escapedld_pw_p---";
			echo $escapedld_pw_p;
			echo "---old_temp---";
			echo $old_temp;
			exit();
		} else if (strcmp($escapednew_pw1_p,$escapednew_pw2_p)!=0) {
			echo "Nem egyezik a ket uj jelszo! ";
			echo '<a href="profil.php">'. Vissza . '</a>';
			exit();
		}
		
		$sql="UPDATE USER SET PASSWORD='$escapednew_pw1_p', DATE_MOD=sysdate() WHERE NEPTUN='$user'";
		$res2=mysqli_query($con,$sql);	
		
		if(!$res2) {	
			echo "HIBA: " . mysqli_error($con) . " ";
			echo '<a href="profil.php">'. Vissza . '</a>';
			exit();
		} else {
			echo "Sikeres jelszo modositas! ";
			echo '<a href="profil.php">'. Vissza . '</a>';
			exit();
		}
	}

	
?>

<?php 

?>
	
