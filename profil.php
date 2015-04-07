<!DOCTYPE html>


<html>
<head>

	<style>
	
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
	
	#modify {
		margin-top : 20px;
		margin-left : 350px;
	
	}
	
	#team_name {
		margin-left : 150px;
	}
	
	#role {
		position: absolute;
		margin-left : 150px;
	}
	
	#mail {
		position: absolute;
		margin-left : 191px;
	}
	
	#old_pass {
		position: absolute;
		margin-left : 140px;
	}
	
	#new_pass {
		position: absolute;
		margin-left : 157px;
	}
	
	#new_pass2 {
		position: absolute;
		margin-left : 110px;
	}
	</style>
	
	
	<meta charset="UTF-8">  </meta>
	<title>Title of the document</title>
</head>

<body style="background-color:PaleTurquoise">

<div id="page_name"> <b>Profil:</b> </div>

	<div id="profile">
	
		<div class="user_info" >
			Csapatod: 
		</div>
		<textarea readonly name="message" rows="1 cols="30">
		<?php
	
			session_start(); 
			require "config.php";
			$sql=mysqli_query($con,"SELECT T.NAME FROM TEAM T, USER U WHERE T.ID=U.TEAM_ID AND U.NEPTUN='$user' and U.PASSWORD='$pass'");
			
			if(!$sql)
			{
				echo "ERROR :" . mysqli_error($con);
			}
			echo $row['NAME'];
		?>
		</textarea>

		<div class="user_info">
			Szerepkör: 
			<input id="role" type="text"></input>
		</div>
		<div class="user_info">
			Mail: 
			<input id="mail" type="text">	</input>
		</div>
		<br/>
		<br/>
		
		<b>Jelszóváltoztatás</b>
	


		<div class="user_info" >
			Régi jelszó: 
		<input id="old_pass">	</input>
		</div>
		<div class="user_info">
			Új jelszó: 
			<input id="new_pass" type="text">	</input>
		</div>
		<div class="user_info">
			Új jelszó ismét: <input id="new_pass2" type="text">	</input>
		</div>
		
		<input id="modify" type="button" value="Mentés"> </input>
	
</div>
	
	
	
	
</body>

</html>
