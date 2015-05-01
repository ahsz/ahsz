<!DOCTYPE html>

<?php
	session_start();  
    require "check_logged_in.php"; 
    require "config.php"; 
    
	ini_set('display_errors', 'on');

	function save(){
        	require "config.php"; 
			
			$passed = $_POST['passed'];
			if (!preg_match('/\d+/',$passed)){
				echo "HIBA: nem számot adtál meg Passednak";
				echo '<a href="profil.php">'. Vissza . '</a>'; 
				exit();
				}		
				
			$time = $_POST['time'];
			if (!preg_match('/(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})/',$time)){
				echo "HIBA: rossz dátumformátum";
				echo '<a href="profil.php">'. Vissza . '</a>'; 
				exit();
				}
			
			$failed = $_POST['failed'];
			if (!preg_match('/\d+/',$failed)){
				echo "HIBA: nem számot adtál meg Failednek";
				echo '<a href="profil.php">'. Vissza . '</a>'; 
				exit();
				}		

			$inconclusive = $_POST['inconclusive'];	
			if (!preg_match('/\d+/',$inconclusive)){
				echo "HIBA: nem számot adtál meg Inconclusivenak";
				echo '<a href="profil.php">'. Vissza . '</a>'; 
				exit();
				}		
				
			$sum= $passed + $failed + $inconclusive;
			
			$neptun_kod=$_SESSION['NEPTUN'];
			$t_id=$_SESSION['TEAM_ID'];

		$saveentry	 = mysqli_query($con,"INSERT INTO TEST VALUES (null,$t_id, STR_TO_DATE('$time ', '%Y-%m-%d %H:%i:%s') , $sum,$passed,$failed,$inconclusive, sysdate(),'$neptun_kod')");
		if($saveentry){
			$message = "Szerepkör sikeresen felvéve!"; 
			echo "<script type='text/javascript'>alert('$message');</script>";
		}
		else{
        		echo "Hiba, probald ujra!" . mysqli_error($con);
        		/*echo '<a href="oktatoi.php">'. Vissza . '</a>';*/
		}
	}
	
    if(isset($_POST['time']) && isset($_POST['passed']) && isset($_POST['failed']) && isset($_POST['inconclusive'])){
    	save();
    }
?>

<html>
<head>
	<meta charset="UTF-8">  </meta>
	<title>Profil</title>
	<style media="screen" type="text/css">
	

	
	#profile {
		font-size:120%
	}
	
	div.user_info {
		margin-top : 15px;
	}
	
	textarea {
    		resize: none;
	}
	
	</style>
	
	

<body>
	<h1>Teszt eredmények</h1>


		<div id="profile">
			<table style="width:50%">
				<div class="user_info">
					<tr><td>
				<tr><td><br><br></td></tr>
				<div class="user_info">
					<tr><td>
						<b>Utolsó futtatás eredményei</b>
					</td></tr>
				</div>
				<div class="user_info">
					<form form id="form" name="form" method="post" action="#">
						<tr><td>
							Futtatás időpontja(YYYY-MM-DD HH:MM:SS):
						</td><td>
							<input type="text" name="time" class="box" size=30 />
						</td></tr>
						<tr><td>
							Passed:
						</td><td>
							<input type="text" name="passed" class="box" size=30 />
						</td></tr>
						<tr><td>
							Failed:
						</td><td>
							<input type="text" name="failed" class="box" size=30 />
						</td></tr>
						<tr><td>
							Inconclusive:
						</td><td>
							<input type="text" name="inconclusive" class="box" size=30 />
						</td><tr>
						<tr><td/><td>
							<input type="submit" name="Submit" value="Mentés"/>
						</td></tr>
					</form>
				</div>
			</table>
				
		</div>
	</div>
</body>

</html>
