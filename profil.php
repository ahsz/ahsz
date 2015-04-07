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
	
	textarea {
    		resize: none;
	}
	
	</style>
</head>

<body style="background-color:PaleTurquoise">

	<div id="page_name"> <b>Profil</b> </div>

		<div id="profile">
			<!-- Név --> 
			
			<div class="user_info">
				<?php
					session_start(); 
					require "config.php";
					
					$neptun_kod=$_SESSION['NEPTUN'];
					$result=mysqli_query($con,"SELECT U.NAME AS U_NAME, U.NEPTUN, U.EMAIL, T.NAME AS T_NAME, R.NAME AS R_NAME FROM USER U, TEAM T, ROLE R WHERE U.NEPTUN='$neptun_kod' AND T.ID=U.TEAM_ID AND R.ID=U.ROLE_ID");
				
					if($result->num_rows>0){
						$row=mysqli_fetch_assoc($result);
						echo "Neved: " . $row['U_NAME'];
				?>
			</div> <div class="user_info">
				<?php
						echo "Neptun kódod: " . $row['NEPTUN'];
				?>
			</div> <div class="user_info">
				<form form id="form" name="form" method="post" action="handle_profil_mod.php">
				<?php
						echo "E-mail címed: ";
				?>
				
					<textarea id="email_mod" name="email_mod" rows="1" cols="30"><?php
						echo $row['EMAIL'];
				?></textarea>
					<input type="submit" name="submit" value="Módosítás" />
				</form>
				
			</div> 	<div class="user_info">
				<?php
						echo "Csapatod neve: " . $row['T_NAME'];
				?>
			</div> <div class="user_info">
				<?php
						echo "Szerepköröd: " . $row['R_NAME'];
					} else {
						echo "ERROR :" . mysqli_error($con);
					}
				?>
			</div><br><br>
			<div class="user_info"><b>Jelszó módosítás</b></div>
			<div class="user_info">
				<form form id="form2" name="form2" method="post" action="handle_profil_mod.php">
					Régi jelszavad: <textarea id="old_pw" name="old_pw" rows="1" cols="30"></textarea></br>
					Új jelszavad: <textarea id="new_pw1" name="new_pw1" rows="1" cols="30"></textarea></br>
					Új jelszavad mégegyszer: <textarea id="new_pw2" name="new_pw2" rows="1" cols="30"></textarea></br>
					<input type="submit" name="submit2" value="Módosítás" />
				</form>
			</div>
		</div>
	</div>
</body>

</html>
