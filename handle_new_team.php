<?php
	session_start(); 
	require "config.php";
	
		$team  = $_POST['team']; 
		$user  = $_SESSION['username']; 
		
		$result=mysqli_query($con,"INSERT INTO TEAM (NAME, MEMBERS, DATE_CRT, CRT_BY) 
						 VALUES ('$team',1,sysdate(),'$user')");
		
		if(!$result){
			echo mysqli_error($con);
			exit();
		}
		
		$result=mysqli_query($con,"SELECT ID FROM ROLE WHERE NAME = 'Scrum Master'");
		$count=mysqli_num_rows($result);
		
		if($count<1){
			echo "Nincs ilyen role!";
			exit();
		}
		
		$row = mysqli_fetch_assoc($result);
		$id = $row["ID"];
		
		$result=mysqli_query($con,"UPDATE USER SET ROLE_ID=$id WHERE NAME = '$user'");
		
		if(!$result){
			echo mysqli_error($con);
			exit();
		}
		$_SESSION['ROLE_ID'] = $id;
		
		echo "OK";		
?>