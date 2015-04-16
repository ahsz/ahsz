<!DOCTYPE html>

<?php
	session_start(); 
	require "check_logged_in.php";
	require "config.php";
	ini_set('display_errors', 'on');
	
	//csapatnév lekérése, hogy ki legyen írva az oldal tetejére
	$tid = $_SESSION['TEAM_ID'];
	$teamname = mysqli_query($con,"SELECT NAME FROM TEAM WHERE ID='$tid'");
	while($row=mysqli_fetch_assoc($teamname))
	{
		$t_name = $row['NAME'];
	}
	
	function addToTeam(){
		require "config.php";
		$smNeptun  = $_SESSION['NEPTUN']; 
		$SM_TeamID = mysqli_query($con,"SELECT TEAM_ID FROM USER WHERE NEPTUN='$smNeptun'");
		while($row=mysqli_fetch_assoc($SM_TeamID))
		{
			$t_id = $row['TEAM_ID'];
		}
		$team = $_POST['addTeammate'];
		$addUserToTeam = mysqli_query($con,"UPDATE USER SET TEAM_ID='$t_id' WHERE NEPTUN='$team'"); //injection védelmet nekem!!!
		$message = "Sikeres csapathoz adás!";
		echo "<script type='text/javascript'>alert('$message');</script>";
	}
	function giveRole(){
		require "config.php";
		$selected_neptun = $_POST['addRoleToTeammate'];
		$selected_roleName = $_POST['roleList'];
		$getRoleID = mysqli_query($con,"SELECT ID FROM ROLE WHERE NAME='$selected_roleName'");
		while($row=mysqli_fetch_assoc($getRoleID))
		{
			$selected_role_id = $row['ID'];
		}
		$giveRoleToUser = mysqli_query($con,"UPDATE USER SET ROLE_ID='$selected_role_id' WHERE NEPTUN='$selected_neptun'");
		$message = "A szerep sikeresen a felhasználóhoz adva!";
		echo "<script type='text/javascript'>alert('$message');</script>";
	}
	
	function delTeammate(){
		require "config.php";
		$selected_user = $_POST['deleteTeammate'];
		$delUser = mysqli_query($con,"UPDATE USER SET TEAM_ID=NULL WHERE NEPTUN='$selected_user'");
		$message = "Felhasználó sikeresen törölve a csapatból!";
		echo "<script type='text/javascript'>alert('$message');</script>";
	}
	
	function modGithubRepo(){
		require "config.php";
		$github_repo = $_POST['github_mod'];
		$tid = $_SESSION['TEAM_ID'];
		$updateGithub = mysqli_query($con,"UPDATE TEAM SET GITHUB_LINK='$github_repo' WHERE ID='$tid'");
		$message = "Github repo sikeresen módosítva!";
		echo "<script type='text/javascript'>alert('$message');</script>";
	}
	
	if(isset($_POST['addTeammate'])){
		addToTeam();
	}
	if(isset($_POST['addRoleToTeammate']) && isset($_POST['roleList'])){
		giveRole();
	}
	if(isset($_POST['deleteTeammate'])){
		delTeammate();
	}
	if(isset($_POST['github_mod'])){
		modGithubRepo();
	}
	
	?>
<html>
<head>
	<meta charset="UTF-8">  </meta>
	<title>Title of the document</title>
	
<style media="screen" type="text/css">
	textarea {
		resize: none;
	}
</style>
</head>

<body style="background-color:DarkKhaki">
	<div style="margin-left:200">
	<h1>Csapatstátusz</h1>
	<h2><?php echo $t_name; ?></h2>
	</div>
	
<?php
	
	if($_SESSION['ID'] == 2) {
		?>
		<b>Csapattag felvétele:</b>
		</br>
		<form action="#" method="POST">
			<select name="addTeammate" id="add">
			<?php
				$get=mysqli_query($con,"SELECT NEPTUN FROM USER WHERE TEAM_ID IS NULL");
				$option = '';
				 while($row = mysqli_fetch_assoc($get))
				{
				  $option .= '<option value = "'.$row['NEPTUN'].'">'.$row['NEPTUN'].'</option>';
				}

				echo $option; ?>
			</select>
			<input type="submit" id="Submit" value="Kiválaszt"  />
			</form>
			
			</br>
			</br>
			<b>Csapattag törlése:</b>
			</br>
			<form action="#" method="POST">
			<select name="deleteTeammate" id="deleteTeammate">
			<?php
				//csapat listájának lekérése dbből
				$smNeptun  = $_SESSION['NEPTUN']; 
				$SM_TeamID = mysqli_query($con,"SELECT TEAM_ID FROM USER WHERE NEPTUN='$smNeptun'");
				while($row=mysqli_fetch_assoc($SM_TeamID))
				{
					$t_id = $row['TEAM_ID'];
				}
				$getTeammates=mysqli_query($con,"SELECT NEPTUN FROM USER WHERE TEAM_ID='$t_id'");
				$delTeammates = '';
				 while($row = mysqli_fetch_assoc($getTeammates))
				{
				  $delTeammates .= '<option value = "'.$row['NEPTUN'].'">'.$row['NEPTUN'].'</option>';
				}

				echo $delTeammates; ?>
			</select>
			<input type="submit" id="Submit" value="Törlés"  />
			</form>
			
			</br>
			</br>
			<b>Szerep adása csapattársnak:</b>
			</br>
			<form action="#" method="POST">
			<select name="addRoleToTeammate" id="addRole">
			<?php
				//csapat listájának lekérése dbből
				$smNeptun  = $_SESSION['NEPTUN']; 
				$SM_TeamID = mysqli_query($con,"SELECT TEAM_ID FROM USER WHERE NEPTUN='$smNeptun'");
				while($row=mysqli_fetch_assoc($SM_TeamID))
				{
					$t_id = $row['TEAM_ID'];
				}
				$getTeammates=mysqli_query($con,"SELECT NEPTUN FROM USER WHERE TEAM_ID='$t_id'");
				$teammates = '';
				 while($row = mysqli_fetch_assoc($getTeammates))
				{
				  $teammates .= '<option value = "'.$row['NEPTUN'].'">'.$row['NEPTUN'].'</option>';
				}

				echo $teammates; ?>
			</select>
			
			<!-- Szerepek legördülő listája-->
			<select name="roleList" id="roleList">
			<?php
				//SM csapatának lekérése dbből
				$roles = mysqli_query($con,"SELECT NAME FROM ROLE");
				$roleNames = '';
				 while($row = mysqli_fetch_assoc($roles))
				{
				  $roleNames .= '<option value = "'.$row['NAME'].'">'.$row['NAME'].'</option>';
				}
				echo $roleNames; ?>
			</select>
			<input type="submit" id="Submit" value="Kiválaszt"  />
			</form>

		<?php
	}
	?>
	
	</form>
	</br>
	</br>
	
	<b>Github repo:</b>
	</br>
	<form action="#" method="POST">
	<?php
		$github_repo_query = mysqli_query($con,"SELECT GITHUB_LINK FROM TEAM WHERE ID='$t_id'");
		while($row = mysqli_fetch_assoc($github_repo_query))
		{
		  $t_ghub = $row['GITHUB_LINK'];
		}
	?>
	<textarea id="github_mod" name="github_mod" rows="1" cols="30"><?php echo $t_ghub; ?></textarea>
	<input type="submit" name="submit" value="Módosítás" />
	
	</form>
	
	<!-- Csapattagok adatainak listázása-->
	<table border="1" width="600">
	<tr>
        <td><b>Neptun</b></td>
        <td><b>Szerepkör</b></td>
        <td><b>Email</b></td>
    </tr>
	<?php
		$teamid = $_SESSION['TEAM_ID'];
		//$members = mysqli_query($con,"SELECT USER.NAME AS uname, ROLE.NAME AS urole, USER.EMAIL AS uemail FROM USER, ROLE WHERE USER.ROLE_ID=ROLE.ID AND TEAM_ID='$teamid'");
		$members = mysqli_query($con,"SELECT USER.NEPTUN AS uneptun, ifnull(ROLE.NAME,'') AS urole, ifnull(USER.EMAIL,'') AS uemail FROM USER LEFT JOIN (ROLE) ON (ROLE.ID=USER.ROLE_ID) WHERE TEAM_ID='$teamid'");
		 while($row = mysqli_fetch_assoc($members))
		{
		  echo "<tr>";
		  echo "<td>".$row['uneptun']."</td>";
		  echo "<td>".$row['urole']."</td>";
		  echo "<td>".$row['uemail']."</td>";
		  echo "</tr>";
		}
	?>
</table>
	
</body>

</html>