<?php
	$host="localhost"; // Host name 
	$username="agile_user"; // Mysql username 
	$password="qwerty"; // Mysql password 
	$db="agile"; // Database name 
	$port=40022; //port

	$con = mysqli_connect($host,$username,$password,$db,$port);

	if(!$con){
		die("Can not connect to Server.");
	}
	
	
	mysqli_close($con);
?>
