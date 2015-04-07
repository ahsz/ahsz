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
		$neptunkod=$_SESSION['NEPTUN'];
		require "config.php";
		$result=mysqli_query($con,"SELECT NAME FROM USER WHERE NEPTUN='$neptunkod'");
			
		if($result->num_rows>0) {
			echo $row['NAME'];
		} else {
			echo "ERROR :" . mysqli_error($con);
		}
	?>

</body>

</html>
