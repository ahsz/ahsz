<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">  </meta>
	<title>Profil</title>
	<style media="screen" type="text/css">
	
	#page_name {
		font-size:150%;
		margin-top : 100px;
		margin-left : 200px	
	}
	
	div.user_info {
		margin-top : 15px;

	}
	textarea {
    		resize: none;
	}
	</style>
</head>

<body style="background-color:PaleTurquoise">

	<div id="page_name"> 
		<b>Profil:</b> 
	</div>

	<div id="profile">
	
		<div class="user_info">
			Csapatod:
		</div>
		<textarea readonly name="message" rows="1" cols="30">
		<?php
	
			session_start(); 
			require "config.php";
			$sql="SELECT T.NAME FROM TEAM T, USER U WHERE T.ID=U.TEAM_ID AND U.NEPTUN='$user' and U.PASSWORD='$pass'";
			$result = $con->query($sql);
			
			if($result->num_rows>0) {
				echo . $row['NAME'].;
			} else {
				echo "ERROR :" . mysqli_error($con);
			}
		?>
		</textarea>
	</div>

</body>

</html>
