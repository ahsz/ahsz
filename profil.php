<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">  </meta>
	<title>Profil</title>
	<style media="screen" type="text/css">

	</style>
</head>

<body style="background-color:PaleTurquoise">

	<b>Profil:</b> 

	Csapatod:
	<?php
	
		session_start(); 
		require "config.php";
		$result=mysqli_query($con,"SELECT T.NAME FROM TEAM T, USER U WHERE T.ID=U.TEAM_ID AND U.NEPTUN='$user'");
			
		if($result->num_rows>0) {
			echo $row['NAME'];
		} else {
			echo "ERROR :" . mysqli_error($con) . $_SESSION['NAME'];
		}
	?>

</body>

</html>
