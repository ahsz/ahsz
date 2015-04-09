<!DOCTYPE html>
<?php
	session_start(); 
	require "config.php";
	
	function addToTeam(){
		$smNeptun  = $_SESSION['NEPTUN']; 
		$SM_TeamID = mysqli_query($con,"SELECT TEAM_ID FROM USER WHERE NEPTUN='$smNeptun'");
		$addUserToTeam = mysqli_query($con,"UPDATE USER SET TEAM_ID='$SM_TeamID' WHERE NEPTUN='$_POST['addTeammate']'"); //injection védelmet nekem!!!
	}
	if(isset($_POST['addTeammate'])){
		addToTeam();
	}
	?>
<html>
<head>
	<meta charset="UTF-8">  </meta>
<title>Title of the document</title>
</head>

<body>
	<div style="margin-left:200">
	<h1>Csapatstátusz</h1>
	<h2>Csapatnév</h2>
	</div>
	
<?php
	
	if($_SESSION['ID'] == 2) {
		?>
		<b>Csapattag felvétele:</b>
		</br>
		<form action="#" method="POST">
			<select name="addTeammate" id="add">
			<?php
				$get=mysqli_query($con,"SELECT NEPTUN FROM USER");
				$option = '';
				 while($row = mysqli_fetch_assoc($get))
				{
				  $option .= '<option value = "'.$row['NEPTUN'].'">'.$row['NEPTUN'].'</option>';
				}

			?>
			<?php echo $option; ?>
			</select>
			<input type="submit" id="Submit" value="Kiválaszt"  />
			</form>
		<?php
	}
	?>
	
	</form><br/>
	
	<table border="1" width="600">
		<tr>
        <td>Név</td>
        <td>Szerepkör</td>
        <td>Email</td>
    </tr>
    <tr>
        <td>-</td>
        <td>-</td>
        <td>-</td>
    </tr>
    <tr>
        <td>-</td>
        <td>-</td>
        <td>-</td>
    </tr>
    <tr>
        <td>-</td>
        <td>-</td>
        <td>-</td>
    </tr>
</table>
	
</body>

</html>