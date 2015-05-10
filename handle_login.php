<?php
	session_start(); 
	require "config.php";
	
	//Ha a bejelentkezni szeretne a felhasználó.
	if($_POST["login"])
	{
		//Adatok beolvasása a HTML mezőkből
		$user  = $_POST['username'];
		$escapeduser = htmlspecialchars($user, ENT_QUOTES);
		$pass  = $_POST['password']; 
		$escapedpass = htmlspecialchars($pass, ENT_QUOTES);
		
		//Ha nem töltötte ki a mezőket, akkor hibaüzenetet kap.
		if($user == "" || $pass == "") 
		{ 
			echo "Kerlek toltsd ki a mezoket!"; 
		} 
		else
		{
			//Lekérdezzük az adatbázisból, hogy helyes adatokat adott-e meg.
			$result=mysqli_query($con,"SELECT * FROM USER LEFT JOIN ROLE ON USER.ROLE_ID = ROLE.ID WHERE NEPTUN='$escapeduser' and PASSWORD='$escapedpass'");
			$count=mysqli_num_rows($result);
		
			//Ha igen, akkor elmentjük az attribútumait a SESSION tömbbe, hogy a munkamenet során megmaradjon.
			if($count==1){
				$_SESSION = mysqli_fetch_assoc($result);
				$_SESSION['def_tid'] = $_SESSION['TEAM_ID'];
				$_SESSION['username'] = $escapeduser;
				//Ha oktató jelenkezett be, akkor kijelölünk egy default csapatot, aminek az adatait kezdetben láthatja.
				if($_SESSION['TYPE']==2){
					$result=mysqli_query($con,"SELECT * FROM TEAM");
					$row=mysqli_fetch_assoc($result);
					$_SESSION['TEAM_ID']=$row['ID'];
				}
				header("location:success.php");
			}
			//Ha nem jók a megadott adatok, akkor hibaüzenet.
			 else{ 
				echo "Nem letezo neptun kod vagy rossz jelszo!"; 
			} 
		}
	}
	//Ha a regisztrációt nyomta meg, akkor átkerül a regisztrálás oldalra.
	if($_POST["register"]) {
		header("Location: register.html");
	}
	exit;
?>
