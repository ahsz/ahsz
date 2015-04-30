<!DOCTYPE html>
<?php 
    session_start();  
    require "check_logged_in.php"; 
    require "config.php"; 
    
    ini_set('display_errors', 'on');

	function delUser(){ 
        	require "config.php"; 
        	$user = $_POST['delUser'];
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

	function setAdmin(){
        	require "config.php"; 
        	$admin = $_POST['setAdmin'];
        	$setAdmin = mysqli_query($con,"UPDATE USER SET TYPE=2 WHERE NEPTUN='$admin'"); 
        	if($setAdmin){
        		$message = "Sikeres oktató hozzáadás!"; 
        		echo "<script type='text/javascript'>alert('$message');</script>";
        	}
        	else{
        		echo "Hiba, probald ujra!" . mysqli_error($setAdmin);
        		echo '<a href="oktatoi.php">'. Vissza . '</a>';
        	}
	}

	function delAdmin(){
        	require "config.php"; 
        	$admin = $_POST['delAdmin'];
        	$delAdmin = mysqli_query($con,"UPDATE USER SET TYPE=1 WHERE NEPTUN='$admin'"); 
        	if($delAdmin){
        		$message = "Sikeres oktató elvétel!"; 
			echo "<script type='text/javascript'>alert('$message');</script>";
        	}
		else{
        		echo "Hiba, probald ujra!" . mysqli_error($delAdmin);
        		echo '<a href="oktatoi.php">'. Vissza . '</a>';
		}
	}

	function addRole(){
        	require "config.php"; 
        	$role = $_POST['addRole'];
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

	function delRole(){ 
        	require "config.php"; 
        	$role = $_POST['delRole'];
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
	

    if(isset($_POST['delUser'])){
        delUser();
    }
    
    if(isset($_POST['setAdmin'])){
    	setAdmin();
    }
    
    if(isset($_POST['delAdmin'])){
    	delAdmin();
    }
    
    if(isset($_POST['addRole'])){
    	addRole();
    }
    
    if(isset($_POST['delRole'])){
    	delRole();
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
	<h1>Oktatói felület</h1>
	<br/>
    <?php
        //nem oktató
        if($_SESSION['TYPE']==1){
            echo "Oktatói jogosultság szükséges a megtekintéshez!<br/><br/>Jelenlegi oktatók és elérhetőségük:";
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
                $get=mysqli_query($con,"SELECT NEPTUN FROM USER ORDER BY NEPTUN"); 
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
	</br</br></br>
	
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
		
    <?php
        }
    ?>
    </table>
</body>
</html>


