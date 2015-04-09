<!DOCTYPE html>
<?php
	session_start(); 
	require "config.php";
	//$s = mysqli_query($con,"SELECT role.name FROM role, user WHERE user.neptun='$user' and user.password='$pass'" and user.role_id=role.id);
	
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
	//require "config.php";
	//$s = mysqli_query($con,"SELECT role.name FROM role, user WHERE user.neptun='$user' and user.password='$pass'" and user.role_id=role.id);
	//echo $_SESSION['neptun'];
	if($_SESSION['ID'] == 2) {
		?>
		<b>Csapattag felvétele:</b>
		</br>
		<p>
			<select name="addTeammate" id="add">
			<?php
				$get=mysqli_query($con,"SELECT NEPTUN FROM USER");
				$option = '';
				 while($row = mysqli_fetch_assoc($get))
				{
				  $option .= '<option value = "'.$row['NEPTUN'].'">'.$row['NEPTUN'].'</option>';
				}
				//$res=mysqli_query($con,"SELECT NEPTUN FROM USER");
				//$names = mysqli_fetch_assoc($res);
			?>
			<?php echo $option; ?>
			</select>
			<input type="submit" id="Submit" value="Kiválaszt" onclick="" />
		</p>
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