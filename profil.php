<?php // Session ellenőrzése
	session_start(); 
	require "check_logged_in.php";		 
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">  </meta>
	<title>Profil</title>
	<!-- Beagyázatott szöveg stílusok amiket a későbbiekben felhasználunk -->
	<style media="screen" type="text/css">
		#profile { font-size:120% }
		div.user_info { margin-top : 15px; }
		textarea { resize: none; }
	</style>
<body>
	<h1>Profil</h1>
		<div id="profile">
			<table style="width:50%"> <!-- Adatok táblázatos megjelenítése -->
				<div class="user_info"><tr><td><b>Adatok</b></td></tr></div> <!-- Táblázat első sora -->
				<div class="user_info"><tr><td>  <!-- Táblázat új sor: név -->
				<?php // Session NEPTUN kód alapján szükséges adatok lekérdezése adatbázisból
					// Adatbázis kapcsolat felépítése
					session_start(); 
					require "config.php";
					$neptun_kod=$_SESSION['NEPTUN'];
					// SQL lekérdezés az összes szükséges adatra
					$result=mysqli_query($con,"SELECT ifnull(U.NAME,'') AS U_NAME, ifnull(U.NEPTUN,'') AS NEPTUN, ifnull(U.EMAIL,'') as EMAIL, ifnull(T.NAME,'') AS T_NAME, ifnull(R.NAME,'') AS R_NAME, GITHUB_NAME FROM USER U LEFT JOIN (TEAM T, ROLE R) ON (T.ID=U.TEAM_ID AND R.ID=U.ROLE_ID) WHERE U.NEPTUN='$neptun_kod'");
					// Hibakezelés
					if($result->num_rows>0){
						$row=mysqli_fetch_assoc($result);
						echo "Neved: ";
					} else {
						echo "HIBA: " . mysqli_error($con);
						echo '<a href="profil.php">'. Vissza . '</a>'; 
						exit(); 
					}
				?></td><td>
				<?php	
					echo $row['U_NAME']; // Név megjelenítése
				?></td></tr></div>
				<div class="user_info"><tr><td> <!-- Táblázat új sor: Neptun kód -->
				<?php
						echo "Neptun kódod: ";
				?>
					</td><td>
				<?php 
					echo  $row['NEPTUN']; // Neptun kód megjelenítése
				?></td></tr></div>
				<div class="user_info">
					<form form id="form" name="form" method="post" action="handle_profil_mod.php">
					<!-- E-mail cím módosítható, két input segítéségével egy form-ban, ami a handle_profil_mod.php-t hívja meg -->
						<tr><td> <!-- Táblázat új sor: E-mail cím -->
				<?php
						echo "E-mail címed: ";
				?>
						</td><td> <!-- Input text az e-mail cím megjelenítésére és módosítására az email_mod változó segítségével -->
							<input type="text" name="email_mod" class="box" size=30 value="<?php echo $row['EMAIL'];?>" />
						</td><td> <!-- Input submit a módosítás nyugtázására -->
							<input type="submit" name="submit" value="Módosítás" />
						</td></tr>
					</form>
				</div>
				<div class="user_info">
					<form form id="form" name="form" method="post" action="handle_profil_mod.php">
					<!-- GITHUB felhasználó név módosítható, két input segítéségével egy form-ban, ami a handle_profil_mod.php-t hívja meg -->
						<tr><td> <!-- Táblázat új sor: GITHUB felhasználó név-->
				<?php
						if($_SESSION['TYPE']==1){ // csak hallgatónak jelenjen meg a GITHUB felhasználó név, a csapatnév és a szerepkör
						echo "GITHUB felhasználó neved: ";
				?>
						</td><td> <!-- Input text az GITHUB felhasználónév megjelenítésére és módosítására a github_user_mod változó segítségével -->
							<input type="text" name="github_user_mod" class="box" size=30 value="<?php echo $row['GITHUB_NAME'];?>" />
						</td><td> <!-- Input submit a módosítás nyugtázására -->
							<input type="submit" name="submit" value="Módosítás" />
						</td></tr>
					</form>
				</div>
				<div class="user_info"><tr><td> <!-- Táblázat új sor: Csapat név -->
				<?php
						echo "Csapatod neve: "; 
				?>
					</td><td>
				<?php 
						echo $row['T_NAME']; // Csapat név megjelenítése
				?>
					</td></tr>	</div> 
				<div class="user_info"><tr><td> <!-- Táblázat új sor: Szerepkör -->
				<?php
						echo "Szerepköröd: ";
				?>
					</td><td>
				<?php
						echo $row['R_NAME']; // Szerepkör megjelenítése
					} // Csak hallgatónak megjelenítés lezárása
				?>
					</td></tr>
				</div><tr><td><br><br></td></tr>
				<div class="user_info">
					<tr><td> <!-- Táblázat új sor: Jelszó módosítás -->
						<b>Jelszó módosítás</b>
					</td></tr>
				</div>
				<div class="user_info">
					<!-- Jelszó módosítható, négy input segítéségével egy form-ban, ami a handle_profil_mod.php-t hívja meg -->
					<form form id="form2" name="form2" method="post" action="handle_profil_mod.php">
						<tr><td> <!-- Táblázat új sor: Régi jelszó -->
							Régi jelszavad:
						</td><td> <!-- Input password a régi jelszó megadásához az old_pw változó segítségével -->
							<input type="password" name="old_pw" class="box" size=30 />
						</td></tr>
						<tr><td> <!-- Táblázat új sor: Új jelszó -->
							Új jelszavad:
						</td><td> <!-- Input password az új jelszó megadásához a new_pw1 változó segítségével -->
							<input type="password" name="new_pw1" class="box" size=30 />
						</td></tr>
						<tr><td> <!-- Táblázat új sor: Új jelszó mégegyszer -->
							Új jelszavad mégegyszer:
						</td><td> <!-- Input password az új jelszó újboli megadásához a new_pw2 változó segítségével -->
							<input type="password" name="new_pw2" class="box" size=30 />
						</td><tr>
						<tr><td/><td>
							<!-- Input submit a módosítás nyugtázására -->
							<input type="submit" name="submit2" value="Módosítás"/>
						</td></tr>
					</form>
				</div>
			</table>
		</div>
	</div>
</body>
</html>
