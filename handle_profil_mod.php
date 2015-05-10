<?php // Session ellenőrzése
	session_start(); 
	require "config.php";
		header("Refresh:0; url=../testsite/profil.php"); 
	if (isset($_POST['email_mod'])) { // Ha e-mail cím változóval került meghívásra
		$user=$_SESSION['username']; // Session-ből neptun kód lekérése 
		$email=$_POST['email_mod']; // Session-ből aktuális e-mail cím lekérése
		$escapedemail = htmlspecialchars($email, ENT_QUOTES);
		if($email==null) // Ha üres, hibaüzenettel kilépünk
		{
			echo "<script type='text/javascript'>alert('Üresen hagytad az e-mail cím mezőt!');</script>"; // Hibaüzenet megjelenítése
			exit();
		}
		$sql="UPDATE USER SET EMAIL='$escapedemail', DATE_MOD=sysdate() WHERE NEPTUN='$user'"; // szükséges SQL script e-mail cím módosításhoz
		$res=mysqli_query($con,$sql);	// E-mail cím módosítása
		if(!$res) // MySQL hibakezelés
		{	
			echo "<script type='text/javascript'>alert('Hiba:  mysqli_error($con)');</script>"; // Hibaüzenet megjelenítése
			exit();
		}
		else
		{
			echo "<script type='text/javascript'>alert('Sikeres e-mail cím módosítás!');</script>"; // Nyugtázás
			exit();
		}
	}
	if (isset($_POST['github_user_mod'])) { // Ha github felhasználó név változóval került meghívásra 
		$user=$_SESSION['username']; // Session-ből neptun kód lekérése 
		$github_user=$_POST['github_user_mod']; // Session-ből github felhasználó név lekérése
		$escapedgithub_user = htmlspecialchars($github_user, ENT_QUOTES);
		if($github_user==null) // Ha üres, hibaüzenettel kilépünk
		{
			echo "<script type='text/javascript'>alert('Üresen hagytad a GITHUB felhasználó név mezőt!');</script>"; // Hibaüzenet megjelenítése
			exit();
		}
		$sql="UPDATE USER SET GITHUB_NAME='$escapedgithub_user', DATE_MOD=sysdate() WHERE NEPTUN='$user'"; // szükséges SQL script github felhasználó név módosításhoz
		$res=mysqli_query($con,$sql); // github felhasználó név módosítása
		if(!$res) // MySQL hibakezelés
		{	
			echo "<script type='text/javascript'>alert('Hiba: mysqli_error($con)');</script>"; // Hibaüzenet megjelenítése
			exit();
		}
		else
		{
			echo "<script type='text/javascript'>alert('Sikeres GITHUB felhasználó név módosítás!');</script>"; // Nyugtázás
			exit();
		}
	}

	if (isset($_POST['old_pw']) && isset($_POST['new_pw1']) && isset($_POST['new_pw2'])) { // Ha jelszó változókkal került meghívásra 
		$user=$_SESSION['username']; // Session-ből neptun kód
		
		$sql="SELECT PASSWORD FROM USER WHERE NEPTUN='$user'"; // szükséges SQL script jelszó lekéréshez
		$res1=mysqli_query($con,$sql); // jelenlegi jelszó lekérése adatbázisból
		 
		if($res1->num_rows>0){  // MySQL hibakezelés
			$row=mysqli_fetch_assoc($res1);
			$old_pw=$row['PASSWORD'];
		} else 	{
			echo "<script type='text/javascript'>alert('Hiba: mysqli_error($con)');</script>"; // Hibaüzenet megjelenítése
			exit(); 
		}

		if($_POST['old_pw']==null) {  // Ha üres, hibaüzenettel kilépünk 
			echo "<script type='text/javascript'>alert('Üresen hagytad a régi jelszó mezőt!');</script>"; // Hibaüzenet megjelenítése
			exit(); 
		} 
		$old_pw_p=$_POST['old_pw'];
		$escapedold_pw_p = htmlspecialchars($old_pw_p, ENT_QUOTES);
		
		if ($_POST['new_pw1']==null) {  // Ha üres, hibaüzenettel kilépünk
			echo "<script type='text/javascript'>alert('Üresen hagytad az új jelszo mezőt!');</script>" ; // Hibaüzenet megjelenítése
			exit();
		}
		$new_pw1_p=$_POST['new_pw1'];
		$escapednew_pw1_p = htmlspecialchars($new_pw1_p, ENT_QUOTES);
		
		if ($_POST['new_pw2']==null) {  // Ha üres, hibaüzenettel kilépünk
			echo "<script type='text/javascript'>alert('Üresen hagytad az új jelszó mégegyszer mezőt!');</script>" ; // Hibaüzenet megjelenítése
			exit();
		}
		$new_pw2_p=$_POST['new_pw2'];
		$escapednew_pw2_p = htmlspecialchars($new_pw2_p, ENT_QUOTES);
		
		if(strcmp($old_pw,$escapedold_pw_p)!=0){ // adatbázis jelszó és megadott régi jelszó egyezés vizsgálat
			echo "<script type='text/javascript'>alert('Nem egyezik a régi jelszó!');</script>" ; // Hibaüzenet megjelenítése
			exit();
		} else if (strcmp($escapednew_pw1_p,$escapednew_pw2_p)!=0) { // új jelszó és új jelszó mégegyszer egyezés vizsgálat
			echo "<script type='text/javascript'>alert('Nem egyezik a két új jelszó!');</script>"; // Hibaüzenet megjelenítése
			exit();
		}
		
		$sql="UPDATE USER SET PASSWORD='$escapednew_pw1_p', DATE_MOD=sysdate() WHERE NEPTUN='$user'"; // szükséges SQL script jelszó módosításhoz
		$res2=mysqli_query($con,$sql);	// jelszó módosítás
		
		if(!$res2) { // MySQL hibakezelés	
			echo "<script type='text/javascript'>alert('Hiba: mysqli_error($con)');</script>"; // Hibaüzenet megjelenítése
			exit();
		} else {
			echo "<script type='text/javascript'>alert('Sikeres jelszó módosítás!');</script>"; // Nyugtázás
			exit();
		}
	}
?>
