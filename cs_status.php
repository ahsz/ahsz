<!DOCTYPE html>
<?php
	session_start(); 
	//require "config.php";
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
	echo $_SESSION['neptun'];
	if($_SESSION['ROLENAME'] == 'Scrum Master') {
		echo "<b>OK</b>";
		?>
		<i>Ez egy html kód.</i>
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