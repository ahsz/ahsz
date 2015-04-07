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
	
	#profile {
		margin-top : 100px;
		margin-left : 200px;	
		font-size:120%
	}
	
	div.user_info {
		margin-top : 15px;
	}
	
	</style>
</head>

<body style="background-color:PaleTurquoise">

	<div id="page_name"> <b>Profil</b> </div>

		<div id="profile">
			<div class="user_info" >
				<?php
	
					session_start(); 
					require "config.php";
					
					$team_id=$_SESSION['TEAM_ID'];
					$result=mysqli_query($con,"SELECT NAME FROM TEAM WHERE ID='$team_id'");
			
					if($result->num_rows>0){
						$row=mysqli_fetch_assoc($result);
						echo "Csapatod: " . $row['NAME'];
					} else {
						echo "ERROR :" . mysqli_error($con);
					}

				?>
				<br>
				<?php

					$role_id=$_SESSION['ID'];
					$result=mysqli_query($con,"SELECT NAME FROM ROLE WHERE ID='$role_id'");
			
					if($result->num_rows>0) {
						$row=mysqli_fetch_assoc($result);
						echo "Szerepköröd: " . $row['NAME'];
					} else {
						echo "ERROR :" . mysqli_error($con);
					}
				?>
			</div>
		</div>
	</div>
</body>

</html>
