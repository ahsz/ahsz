<?php
	session_start(); 
	require "config.php";
	
	if (isset($_GET['message'])) {
		$user=$_SESSION['username'];
		$team_id=1;
		$message=$_GET['message'];
		$date=date('Y-m-d',time());
		
		$sql="INSERT INTO MSG_BOARD( NEPTUN, MESSAGE, DATE_CRT) VALUES('$user','$message','$date')";
		$res=mysqli_query(con$,$sql);	
		
		If(!$res)
		{	
			Echo "ERROR: " . mysqli_error($con);
		}
		Else
		{
			header("location:uzenetek.php");
		}
	}	
?>