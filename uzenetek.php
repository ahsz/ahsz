<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">  </meta>
<title>Munka státusz</title>
<style media="screen" type="text/css">

textarea {
    resize: none;
}
</style>
</head>

<body>
	<div style="margin-left:200">
	<h1>Üzenetek</h1>
	</div>
	<textarea readonly name="message" rows="40" cols="80">
	<?php
	
	session_start(); 
	require "config.php";
	
	$result=mysqli_query($con,"SELECT DATE_CRT, NEPTUN, MESSAGE FROM MSG_BOARD");
	
	if(!$result)
	{
		echo "ERROR :" . mysqli_error($con);
	}
		
	while($row=mysqli_fetch_assoc($result))
	{
		echo $row['DATE_CRT']." ".$row['NEPTUN']." :".$row['MESSAGE']."\n";
	}	

	?>
	</textarea>
	<form form id="form" name="form" method="post" action="msgboard.php">
	<textarea id="postmessage" name="postmessage" rows="2" cols="74">
	</textarea>
	<input type="submit" name="submit" value="Küldés" />
	</form>
	
</body>

</html>