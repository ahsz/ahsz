<?php
	session_start(); 
	require "check_logged_in.php";
	require "config.php";
	
	if (isset($_POST['postmessage'])) {
		$user=$_SESSION['username'];
		$team_id=1;
		$message=$_POST['postmessage'];
		$date=date('Y-m-d h:i:s',time());
		
		$sql="INSERT INTO MSG_BOARD (TEAM_ID, NEPTUN, MESSAGE, DATE_CRT) VALUES(1,'$user','$message',sysdate())";
		$res=mysqli_query($con,$sql);	
		
		If(!$res)
		{	
			Echo "ERROR: " . mysqli_error($con);
		}
		Else
		{
			header("Location: uzenetek.php");
		}
	}	
?>
