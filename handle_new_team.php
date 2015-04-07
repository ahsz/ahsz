<?php
	session_start(); 
	require "config.php";
	
		$team  = $_POST['team']; 
		$user  = $_SESSION['username']; 
		
		$result=mysqli_query($con,"INSERT INTO TEAM (NAME, MEMBERS, DATE_CRT, CRT_BY) 
						 VALUES ('$team',1,sysdate(),'$user')");
		
		if($result){
			echo "OK"; 
		}
		else{ 
			echo mysqli_error($con); 
		} 
?>