<!DOCTYPE html>
<?php  // Session ellenőrzés
    session_start();  
    require "check_logged_in.php"; 
    require "config.php"; 
    
    ini_set('display_errors', 'on');
	// Függvények
	function delUser(){ // Felhasználó törlését megvalósító függvény
        	require "config.php"; 
        	$user = $_POST['delUser']; // HTML-ből átadott neptun kód
        	$delUser = mysqli_query($con,"DELETE FROM USER WHERE NEPTUN='$user'"); // Adatbázisból adott felhasználó törlése
        	if($delUser){ // Hibakezelés
        		$message = "Sikeres felhasználó törlés!"; 
        		echo "<script type='text/javascript'>alert('$message');</script>"; // Nyugtázás
        	}
        	else{
        		echo "Hiba, probald ujra!" . mysqli_error($delUser); // Hibaüzenet
        		echo '<a href="oktatoi.php">'. Vissza . '</a>';
        	}
	} 

	function delTeam(){ // Csapat törlését megvalósító függvény
        	require "config.php"; 
        	$team = $_POST['delTeam']; // HTML-ből átadott csapat id
        	$delTeam = mysqli_query($con,"DELETE FROM TEAM WHERE ID='$team'"); // Adatbázisból adott csapat törlése
        	if($delTeam){ // Hibakezelés
        		$message = "Sikeres csapat törlés!"; 
        		echo "<script type='text/javascript'>alert('$message');</script>"; // Nyugtázás
        	}
        	else{
        		echo "Hiba, probald ujra!" . mysqli_error($delTeam); // Hibaüzenet
        		echo '<a href="oktatoi.php">'. Vissza . '</a>';
        	}
	} 


	function setAdmin(){ // Oktatói jogosultság beállítását megvalósító függvény
        	require "config.php"; 
        	$admin = $_POST['setAdmin']; // HTML-ből átadott neptun kód
        	$setAdmin = mysqli_query($con,"UPDATE USER SET TYPE=2, TEAM_ID=-1 WHERE NEPTUN='$admin'"); // Adatbázisban oktatói jogosultság beállítása
        	if($setAdmin){ // Hibakezelés
        		$message = "Sikeres oktató hozzáadás!"; 
        		echo "<script type='text/javascript'>alert('$message');</script>"; // Nyugtázás
        	}
        	else{
        		echo "Hiba, probald ujra!" . mysqli_error($setAdmin); // Hibaüzenet
        		echo '<a href="oktatoi.php">'. Vissza . '</a>';
        	}
	}

	function delAdmin(){ // Oktatói jogosultság törlését megvalósító függvény
        	require "config.php"; 
        	$admin = $_POST['delAdmin']; // HTML-ből átadott neptun kód
        	$delAdmin = mysqli_query($con,"UPDATE USER SET TYPE=1, TEAM_ID=null WHERE NEPTUN='$admin'"); // Adatbázisban oktatói jogosultság törlése
        	if($delAdmin){ // Hibakezelés
        		$message = "Sikeres oktató elvétel!"; 
			echo "<script type='text/javascript'>alert('$message');</script>"; // Nyugtázás
			if($admin == $_SESSION['NEPTUN']){ // Admin jogosultság elvétele a SESSION-ből is
				$_SESSION['TYPE']=1;
			}
        	}
		else{
        		echo "Hiba, probald ujra!" . mysqli_error($delAdmin); // Hibaüzenet
        		echo '<a href="oktatoi.php">'. Vissza . '</a>';
		}
	}

	function addRole(){ // Szerepkör felvételét megvalósító függvény
        	require "config.php"; 
        	$role = $_POST['addRole']; // HTML-ből átadott szerepkör név
		$addRole = mysqli_query($con,"INSERT INTO ROLE VALUES (null,'$role')"); // Adatbázisba szerepkör felvétele
		if($addRole){ // Hibakezelés
			$message = "Szerepkör sikeresen felvéve!"; 
			echo "<script type='text/javascript'>alert('$message');</script>"; // Nyugtázás
		}
		else{
        		echo "Hiba, probald ujra!" . mysqli_error($addRole); // Hibaüzenet
        		echo '<a href="oktatoi.php">'. Vissza . '</a>';
		}
	}

	function delRole(){ // Szerepkör törlését megvalósító függvény
        	require "config.php"; 
        	$role = $_POST['delRole']; // HTML-ből átadott szerepkör név
        	$delRole = mysqli_query($con,"DELETE FROM ROLE WHERE NAME='$role'"); // Adatbázisban szerepkör törlése
        	if($delRole){ // Hibakezelés
        		$message = "Sikeres szerepkör törlés!"; 
        		echo "<script type='text/javascript'>alert('$message');</script>"; // Nyugtázás
        	}
        	else{
        		echo "Hiba, probald ujra!" . mysqli_error($delRole); // Hibaüzenet
        		echo '<a href="oktatoi.php">'. Vissza . '</a>';
        	}
	} 
	
	function delMsg(){  // Aktuális információk törlését megvalósító függvény
		require "config.php";   
		$igen = $_POST['delMsg']; // HTML-ből átadott igen/nem
		if($igen=='igen') { // Ellenőrző input textboxban igen legyen
			$delMsg = mysqli_query($con,"DELETE FROM MSG_BOARD WHERE TEAM_ID=-1"); // Adatbázisból aktuális információk törlése
			if($delMsg){ // Hibakezelés
				$message = "Aktuális információk sikeresen törölve!";   
				echo "<script type='text/javascript'>alert('$message');</script>"; // Nyugtázás
			}  
			else{  
				echo "Hiba, probald ujra!" . mysqli_error($delMsg); // Hibaüzenet  
				echo '<a href="oktatoi.php">'. Vissza . '</a>';  
			}  
		} 
		else { 
			echo "Csak az igen szó megadásával tudod törölni a híreket!"; // Ha nem "igen" az input mező tartalma 
			echo '<a href="oktatoi.php">'. Vissza . '</a>';  
		} 
	} 
	
	if(isset($_POST['delUser'])){ // html adatátvétel - felhasználó
		delUser(); // felhasználó törlés függvény meghívása
	}
	if(isset($_POST['delTeam'])){ // html adatátvétel - csapat
		delTeam(); // csapat törlés függvény meghívása
	}
	if(isset($_POST['setAdmin'])){ // html adatátvétel - felhasználó
		setAdmin(); // oktatói jogosultság beállítás függvény meghívása
	}
	if(isset($_POST['delAdmin'])){ // html adatátvétel - felhasználó
		delAdmin(); // oktató jogosultság megvonása függvény meghívása
	}
	if(isset($_POST['addRole'])){ // html adatátvétel - szerepkör
		addRole(); // szerepkör felvétele függvény meghívása
	}
	if(isset($_POST['delRole'])){ // html adatátvétel - szerepkör
		delRole(); // szerepkör törlése függvény meghívása
	}
	if(isset($_POST['delMsg'])){ // html adatátvétel igen/nem érték
		delMsg();  // aktuális információk törlése függvény meghívása
	} 
?>
<html>
<head>
    <meta charset="UTF-8"></meta>
    <title>Oktatói felület</title>
    <style media="screen" type="text/css"> 
        #profile { font-size:120% }
    </style>
</head>
<body>
<?php	if($_SESSION['TYPE']==1){ // Hallgató fejléce	?>
	<h1>Oktatók</h1><br/>
	
<?php	} if($_SESSION['TYPE']==2){ // Oktató fejléce	?>
	<h1>Oktatói felület</h1><br/>
<?php
	} if($_SESSION['TYPE']==1){ // Hallgatónak oktatók megjelenítése
		echo "Jelenlegi oktatók és elérhetőségük:";
?>
	<table border="1"> <!-- Táblázatos formában -->
		<tr><td><b>Név</b></td>
		<td><b>E-mail cím</b></td></tr>
<?php
		$result=mysqli_query($con,"SELECT ifnull(U.NAME,'') as NAME, ifnull(U.EMAIL,'') as EMAIL FROM USER U WHERE U.TYPE=2 ORDER BY NAME"); // Szükséges oktatói adatok lekérdezése
		while($row = mysqli_fetch_assoc($result)) // Szükséges oktatói adatok listázása táblázatos formátumban
		{
			echo "<tr>";
			echo "<td>".$row['NAME']."</td>";
			echo "<td>".$row['EMAIL']."</td>";
			echo "</tr>";
		} 
        } // Hallgatói rész vége
        
        if($_SESSION['TYPE']==2){ // Oktatóknak admin felület megjelenítése
?>
        <b>Felhasználó törlése:</b></br> <!-- Felhasználó törlése -->
    	<form action="#" method="POST">  <!-- Form legördülő listával és submit gombbal -->
		<select name="delUser" id="del"> <!-- Kiválasztott hallgató php függvények átadása -->
<?php 
		$get=mysqli_query($con,"SELECT NEPTUN FROM USER WHERE TYPE=1 ORDER BY NEPTUN"); // Hallgatók lekérdezése adatbázisból
		$option = ''; 
		while($row = mysqli_fetch_assoc($get)) // Hallgatók listába illesztése
                { 
			$option .= '<option value = "'.$row['NEPTUN'].'">'.$row['NEPTUN'].'</option>'; 
                } 
                echo $option; 
?> 
        	</select> 
        	<input type="submit" id="Submit" value="Törlés"  /> <!-- Nyugtázás gomb -->
        </form></br></br>
        
        <b>Csapat törlése (létrehozás év-hónap):</b></br> <!-- Csapat törlése -->
    	<form action="#" method="POST"> <!-- Form legördülő listával és submit gombbal -->
		<select name="delTeam" id="del"> <!-- Kiválasztott csapat php függvénynek átadása -->
<?php 
		$get=mysqli_query($con,"SELECT ID, NAME, LEFT(DATE_CRT,7) as DATE_CRT FROM TEAM ORDER BY NAME"); // Csapatok lekérdezése adatbázisból
		$option = ''; 
                while($row = mysqli_fetch_assoc($get))  // Csapatok listába illesztése
                { 
			$option .= '<option value = "'.$row['ID'].'">'.$row['NAME']." ".$row['DATE_CRT'].'</option>'; 
                } 
		echo $option; 
?> 
        	</select> 
        	<input type="submit" id="Submit" value="Törlés"  /> <!-- Nyugtázás gomb -->
        </form> </br></br>
        
        <b>Oktatói jogosultság beállítása:</b> <!-- Oktatói jogosultság beállítása -->
	<form action="#" method="POST"> <!-- Form legördülő listával és submit gombbal -->
		<select name="setAdmin" id="set"> <!-- Kiválasztott felhasználó php függvénynek átadása -->
<?php 
		$get=mysqli_query($con,"SELECT NEPTUN FROM USER WHERE TYPE=1 ORDER BY NEPTUN"); // Felhasználók lekérdezése adatbázisból
		$option = ''; 
		while($row = mysqli_fetch_assoc($get)) // Felhasználók listába illesztése
		{ 
		$option .= '<option value = "'.$row['NEPTUN'].'">'.$row['NEPTUN'].'</option>'; 
		} 
		echo $option;
?>
		</select>
		<input type="submit" id="Submit" value="Beállítás"  /> <!-- Nyugtázás gomb -->
	</form>
	</br></br>
	
        <b>Oktatói jogosultság megvonása:</b> <!-- Oktatói jogosultság törlése -->
	<form action="#" method="POST"> <!-- Form legördülő listával és submit gombbal -->
		<select name="delAdmin" id="del"> <!-- Kiválasztott oktató php függvénynek átadása -->
<?php 
		$get=mysqli_query($con,"SELECT NEPTUN FROM USER WHERE TYPE=2 ORDER BY NEPTUN"); // Oktatók lekérdezése adatbázisból
		$option = ''; 
		while($row = mysqli_fetch_assoc($get)) // Oktatók listába illesztése
		{ 
			$option .= '<option value = "'.$row['NEPTUN'].'">'.$row['NEPTUN'].'</option>'; 
		} 
		echo $option;
?>
		</select>
		<input type="submit" id="Submit" value="Beállítás"  /> <!-- Nyugtázás gomb -->
	</form>	</br</br></br></br>
	
        <b>Új szerepkör felvétele:</b> <!-- Új szerepkör felvétele -->
	<form action="#" method="POST"> <!-- Form egy input texttel és egy submit gombbal -->
		<input type="text" name="addRole" class="box" size="30"/> <!-- text input szerepkör megadására  -->
		<input type="submit" id="Submit" value="Hozzáadás" />  <!-- Nyugtázás -->
	</form></br></br>
	
        <b>Szerepkör törlése:</b></br> <!-- Szerepkör törlése -->
    	<form action="#" method="POST">  <!-- Form legördülő listával és submit gombbal -->
		<select name="delRole" id="del"> <!-- Kiválasztott szerepkör php függvénynek átadása -->
<?php 
		$get=mysqli_query($con,"SELECT NAME FROM ROLE ORDER BY NAME"); // Szerepkörök lekérdezése adatbázisból
		$option = ''; 
		while($row = mysqli_fetch_assoc($get)) // Szerepkörök listába illesztése
                { 
			$option .= '<option value = "'.$row['NAME'].'">'.$row['NAME'].'</option>'; 
		} 
		echo $option; 
?> 
        	</select> 
        	<input type="submit" id="Submit" value="Törlés"  /> <!-- Nyugtázás -->
        </form> </br></br>

	<b>Aktuális információk törlése</b> <!-- Aktuális információk törlése -->
	</br> 
	<form action="#" method="POST">  <!-- Form input texttel és egy submit gombbal -->
		Biztos törölni akarod az összes aktuális információt? (igen)</br> 
		<input type="text" name="delMsg" class="box" size="10"/> <!-- text input "igen" megadására  -->
		<input type="submit" id="Submit" value="Mehet"  />   <!-- Nyugtázás -->
	</form>	  
<?php
	} // Oktatói rész lezárása
?>
</body>
</html>


