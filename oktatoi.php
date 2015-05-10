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
        	$delUser = mysqli_query($con,"DELETE FROM USER WHERE NEPTUN='$user'"); 
        	if($delUser){
        		$message = "Sikeres felhasználó törlés!"; 
        		echo "<script type='text/javascript'>alert('$message');</script>";
        	}
        	else{
        		echo "Hiba, probald ujra!" . mysqli_error($delUser);
        		echo '<a href="oktatoi.php">'. Vissza . '</a>';
        	}
	} 

	function delTeam(){ // Csapat törlését megvalósító függvény
        	require "config.php"; 
        	$team = $_POST['delTeam']; // HTML-ből átadott csapat id
        	$delTeam = mysqli_query($con,"DELETE FROM TEAM WHERE ID='$team'"); 
        	if($delTeam){
        		$message = "Sikeres csapat törlés!"; 
        		echo "<script type='text/javascript'>alert('$message');</script>";
        	}
        	else{
        		echo "Hiba, probald ujra!" . mysqli_error($delTeam);
        		echo '<a href="oktatoi.php">'. Vissza . '</a>';
        	}
	} 


	function setAdmin(){ // Oktatói jogosultság beállítását megvalósító függvény
        	require "config.php"; 
        	$admin = $_POST['setAdmin']; // HTML-ből átadott neptun kód
        	$setAdmin = mysqli_query($con,"UPDATE USER SET TYPE=2, TEAM_ID=-1 WHERE NEPTUN='$admin'"); 
        	if($setAdmin){
        		$message = "Sikeres oktató hozzáadás!"; 
        		echo "<script type='text/javascript'>alert('$message');</script>";
        	}
        	else{
        		echo "Hiba, probald ujra!" . mysqli_error($setAdmin);
        		echo '<a href="oktatoi.php">'. Vissza . '</a>';
        	}
	}

	function delAdmin(){ // Oktatói jogosultság törlését megvalósító függvény
        	require "config.php"; 
        	$admin = $_POST['delAdmin']; // HTML-ből átadott neptun kód
        	$delAdmin = mysqli_query($con,"UPDATE USER SET TYPE=1, TEAM_ID=null WHERE NEPTUN='$admin'"); 
        	if($delAdmin){
        		$message = "Sikeres oktató elvétel!"; 
			echo "<script type='text/javascript'>alert('$message');</script>";
			if($admin == $_SESSION['NEPTUN']){
				$_SESSION['TYPE']=1;
			}
        	}
		else{
        		echo "Hiba, probald ujra!" . mysqli_error($delAdmin);
        		echo '<a href="oktatoi.php">'. Vissza . '</a>';
		}
	}

	function addRole(){ // Szerepkör felvételét megvalósító függvény
        	require "config.php"; 
        	$role = $_POST['addRole']; // HTML-ből átadott szerepkör név
		$addRole = mysqli_query($con,"INSERT INTO ROLE VALUES (null,'$role')");
		if($addRole){
			$message = "Szerepkör sikeresen felvéve!"; 
			echo "<script type='text/javascript'>alert('$message');</script>";
		}
		else{
        		echo "Hiba, probald ujra!" . mysqli_error($addRole);
        		echo '<a href="oktatoi.php">'. Vissza . '</a>';
		}
	}

	function delRole(){ // Szerepkör törlését megvalósító függvény
        	require "config.php"; 
        	$role = $_POST['delRole']; // HTML-ből átadott szerepkör név
        	$delRole = mysqli_query($con,"DELETE FROM ROLE WHERE NAME='$role'"); 
        	if($delRole){
        		$message = "Sikeres szerepkör törlés!"; 
        		echo "<script type='text/javascript'>alert('$message');</script>";
        	}
        	else{
        		echo "Hiba, probald ujra!" . mysqli_error($delRole);
        		echo '<a href="oktatoi.php">'. Vissza . '</a>';
        	}
	} 
	
	function delMsg(){  // Aktuális információk törlését megvalósító függvény
		require "config.php";   
		$igen = $_POST['delMsg']; // HTML-ből átadott igen/nem
		if($igen=='igen') { 
			$delMsg = mysqli_query($con,"DELETE FROM MSG_BOARD WHERE TEAM_ID=-1");   
			if($delMsg){  
				$message = "Aktuális információk sikeresen törölve!";   
				echo "<script type='text/javascript'>alert('$message');</script>";  
			}  
			else{  
				echo "Hiba, probald ujra!" . mysqli_error($delMsg);  
				echo '<a href="oktatoi.php">'. Vissza . '</a>';  
			}  
		} 
		else { 
			echo "Csak az igen szó megadásával tudod törölni a híreket!";  
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
	<?php	if($_SESSION['TYPE']==1){	?>
	<h1>Oktatók</h1>
	<br/>
	
	<?php	} if($_SESSION['TYPE']==2){	?>
	<h1>Oktatói felület</h1>
	<br/>
   
    <?php
		}
        //nem oktató
        if($_SESSION['TYPE']==1){
            echo "Jelenlegi oktatók és elérhetőségük:";
    ?>

    <table border="1">
        <tr>
		<td><b>Név</b></td>
            <td><b>E-mail cím</b></td>
        </tr>
	<?php
            $result=mysqli_query($con,"SELECT ifnull(U.NAME,'') as NAME, ifnull(U.EMAIL,'') as EMAIL FROM USER U WHERE U.TYPE=2 ORDER BY NAME");
            while($row = mysqli_fetch_assoc($result))
            {
                echo "<tr>";
                echo "<td>".$row['NAME']."</td>";
                echo "<td>".$row['EMAIL']."</td>";
                echo "</tr>";
            }
        }
        //oktató
        if($_SESSION['TYPE']==2){
	?>
        <b>Felhasználó törlése:</b></br>
    	<form action="#" method="POST"> 
			<select name="delUser" id="del"> 
	<?php 
                $get=mysqli_query($con,"SELECT NEPTUN FROM USER WHERE TYPE=1 ORDER BY NEPTUN"); 
                $option = ''; 
                while($row = mysqli_fetch_assoc($get)) 
                { 
                    $option .= '<option value = "'.$row['NEPTUN'].'">'.$row['NEPTUN'].'</option>'; 
                } 

                echo $option; 
	?> 
        	</select> 
        	<input type="submit" id="Submit" value="Törlés"  /> 
        </form> 
        </br></br>
        
        <b>Csapat törlése (létrehozás év-hónap):</b></br>
    	<form action="#" method="POST"> 
			<select name="delTeam" id="del"> 
	<?php 
                $get=mysqli_query($con,"SELECT ID, NAME, LEFT(DATE_CRT,7) as DATE_CRT FROM TEAM ORDER BY NAME"); 
                $option = ''; 
                while($row = mysqli_fetch_assoc($get)) 
                { 
                    $option .= '<option value = "'.$row['ID'].'">'.$row['NAME']." ".$row['DATE_CRT'].'</option>'; 
                } 

                echo $option; 
	?> 
        	</select> 
        	<input type="submit" id="Submit" value="Törlés"  /> 
        </form> 
        </br></br>
        
        <b>Oktatói jogosultság beállítása:</b>
	<form action="#" method="POST"> 
		<select name="setAdmin" id="set"> 
	<?php 
			$get=mysqli_query($con,"SELECT NEPTUN FROM USER WHERE TYPE=1 ORDER BY NEPTUN"); 
			$option = ''; 
			while($row = mysqli_fetch_assoc($get)) 
			{ 
				$option .= '<option value = "'.$row['NEPTUN'].'">'.$row['NEPTUN'].'</option>'; 
			} 
			echo $option;
	?>
		</select>
		<input type="submit" id="Submit" value="Beállítás"  /> 
	</form>
	</br></br>
	
        <b>Oktatói jogosultság elvétele:</b>
	<form action="#" method="POST"> 
		<select name="delAdmin" id="del"> 
	<?php 
			$get=mysqli_query($con,"SELECT NEPTUN FROM USER WHERE TYPE=2 ORDER BY NEPTUN"); 
			$option = ''; 
			while($row = mysqli_fetch_assoc($get)) 
			{ 
				$option .= '<option value = "'.$row['NEPTUN'].'">'.$row['NEPTUN'].'</option>'; 
			} 
			echo $option;
	?>
		</select>
		<input type="submit" id="Submit" value="Beállítás"  /> 
	</form>	
	</br</br></br></br>
	
        <b>Új szerepkör felvétele:</b>
	<form action="#" method="POST"> 
		<input type="text" name="addRole" class="box" size="30"/>
		<input type="submit" id="Submit" value="Hozzáadás" /> 
	</form>	
	</br></br>
	
        <b>Szerepkör törlése:</b></br>
    	<form action="#" method="POST"> 
		<select name="delRole" id="del"> 
	<?php 
                $get=mysqli_query($con,"SELECT NAME FROM ROLE ORDER BY NAME"); 
                $option = ''; 
                while($row = mysqli_fetch_assoc($get)) 
                { 
                    $option .= '<option value = "'.$row['NAME'].'">'.$row['NAME'].'</option>'; 
                } 

                echo $option; 
	?> 
        	</select> 
        	<input type="submit" id="Submit" value="Törlés"  /> 
        </form> 
        </br></br>


	<b>Aktuális információk törlése</b> 
	</br> 
	<form action="#" method="POST">   
		Biztos törölni akarod az összes aktuális információt? (igen)</br> 
		<input type="text" name="delMsg" class="box" size="10"/> 
		<input type="submit" id="Submit" value="Mehet"  />   
	</form>	  
	
    <?php
        }
    ?>
</body>
</html>


