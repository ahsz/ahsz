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
	
	$result=mysqli_query($con,"SELECT M.DATE_CRT, U.NAME, M.MESSAGE FROM MSG_BOARD M, USER U WHERE U.NEPTUN=M.NEPTUN");
	
	if(!$result)
	{
		echo "ERROR :" . mysqli_error($con);
	}
	echo "\n";	
	while($row=mysqli_fetch_assoc($result))
	{
		echo $row['M.DATE_CRT']." ".$row['U.NAME']." :".$row['M.MESSAGE']."\n";
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
