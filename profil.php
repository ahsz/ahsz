<?php
	session_start(); 
	require "check_logged_in.php";		 
?>
<!DOCTYPE html>
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
	<h1>Profil</h1>


		<div id="profile">
			<!-- Név --> 
			<table style="width:50%">
				<div class="user_info">
					<tr><td>
						<b>Adatok</b>
					</td></tr>
				</div>
				<div class="user_info">
					<tr><td>
				<?php
					session_start(); 
					require "config.php";
					
					$neptun_kod=$_SESSION['NEPTUN'];
					$result=mysqli_query($con,"SELECT ifnull(U.NAME,'') AS U_NAME, ifnull(U.NEPTUN,'') AS NEPTUN, ifnull(U.EMAIL,'') as EMAIL, ifnull(T.NAME,'') AS T_NAME, ifnull(R.NAME,'') AS R_NAME, GITHUB_NAME FROM USER U LEFT JOIN (TEAM T, ROLE R) ON (T.ID=U.TEAM_ID AND R.ID=U.ROLE_ID) WHERE U.NEPTUN='$neptun_kod'");
				
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
							<input type="text" name="email_mod" class="box" size=30 value="<?php echo $row['EMAIL'];?>" />
						</td><td>
							<input type="submit" name="submit" value="Módosítás" />
						</td></tr>
					</form>
				</div>
				<div class="user_info">
					<form form id="form" name="form" method="post" action="handle_profil_mod.php">
						<tr><td>
				<?php
						if($_SESSION['TYPE']==1){
						echo "GITHUB felhasználó neved: ";
				?>
						</td><td>
							<input type="text" name="github_user_mod" class="box" size=30 value="<?php echo $row['GITHUB_NAME'];?>" />
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
					}
				?>
					</td></tr>
				</div>
				<tr><td><br><br></td></tr>
				<div class="user_info">
					<tr><td>
						<b>Jelszó módosítás</b>
					</td></tr>
				</div>
				<div class="user_info">
					<form form id="form2" name="form2" method="post" action="handle_profil_mod.php">
						<tr><td>
							Régi jelszavad:
						</td><td>
							<input type="password" name="old_pw" class="box" size=30 />
						</td></tr>
						<tr><td>
							Új jelszavad:
						</td><td>
							<input type="password" name="new_pw1" class="box" size=30 />
						</td></tr>
						<tr><td>
							Új jelszavad mégegyszer:
						</td><td>
							<input type="password" name="new_pw2" class="box" size=30 />
						</td><tr>
						<tr><td/><td>
							<input type="submit" name="submit2" value="Módosítás"/>
						</td></tr>
					</form>
				</div>
			</table>
				
		</div>
	</div>
</body>

</html>
