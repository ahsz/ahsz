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
			<table style="width:50%">
				<div class="user_info">
					<tr><td>
				<?php
					session_start(); 
					require "config.php";
					
					$neptun_kod=$_SESSION['NEPTUN'];
					$result=mysqli_query($con,"SELECT ifnull(U.NAME,'') AS U_NAME, ifnull(U.NEPTUN,''), ifnull(U.EMAIL,''), ifnull(T.NAME,'') AS T_NAME, ifnull(R.NAME,'') AS R_NAME FROM USER U LEFT JOIN (TEAM T, ROLE R) ON (T.ID=U.TEAM_ID AND R.ID=U.ROLE_ID) WHERE U.NEPTUN='B5L3OU'");
				
					if($result->num_rows>0){
						$row=mysqli_fetch_assoc($result);
						echo "Neved: "; 
				?>
					</td><td>
				<?php
						echo $row['U_NAME'];
				?>
					</td></tr>
				</div>
				<div class="user_info">
					<tr><td>
				<?php
						echo "Neptun kódod: ";
				?>
					</td><td>
				<?php 
						echo  $row['NEPTUN'];
				?>
					</td></tr>
				</div>
				<div class="user_info">
					<form form id="form" name="form" method="post" action="handle_profil_mod.php">
						<tr><td>
				<?php
						echo "E-mail címed: ";
				?>
						</td><td>
							<textarea id="email_mod" name="email_mod" rows="1" cols="30"><?php
						echo $row['EMAIL'];
				?></textarea>
						</td><td>
								<input type="submit" name="submit" value="Módosítás" />
						</td></tr>
					</form>
				</div>
				<div class="user_info">
					<tr><td>
				<?php
						echo "Csapatod neve: "; 
				?>
					</td><td>
				<?php 
						echo $row['T_NAME']; 
				?>
					</td></tr>	
				</div> 
				<div class="user_info">
					<tr><td>
				<?php
						echo "Szerepköröd: ";
				?>
					</td><td>
				<?php
						echo $row['R_NAME'];
					} else {
						echo "HIBA: " . mysqli_error($con);
						echo '<a href="profil.php">'. Vissza . '</a>'; 
						exit(); 
					}
				?>
					</td></tr>
				</div>
			</table>
			<br><br>
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
