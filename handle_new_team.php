<?php
	session_start(); 
	require "config.php";

	
		$team  = $_POST['team']; 
		$user  = $_SESSION['username']; 

		mysql_query("BEGIN");
		
		$result=mysqli_query($con,"INSERT INTO TEAM (NAME, MEMBERS, DATE_CRT, CRT_BY) 
						 VALUES ('$team',1,sysdate(),'$user')");
		
		if(!$result){
			mysql_query("ROLLBACK");
			echo mysqli_error($con);
			exit();
		}

		$teamid=mysqli_insert_id($con);
		
		$result2=mysqli_query($con,"SELECT ID FROM ROLE WHERE NAME = 'Scrum Master'");
		$count=mysqli_num_rows($result2);
		
		if($count<1){
			mysql_query("ROLLBACK");
			echo "Nincs ilyen role!";
			exit();
		}
		
		$row = mysqli_fetch_assoc($result2);
		$id = $row['ID'];
		
		$result3=mysqli_query($con,"UPDATE USER SET ROLE_ID=$id, TEAM_ID=$teamid WHERE NEPTUN = '$user'");
		
		if(!$result3){
			mysql_query("ROLLBACK");
			echo mysqli_error($con);
			exit();
		}

		mysql_query("COMMIT");

		$_SESSION['ROLE_ID'] = $id;
		$_SESSION['TEAM_ID'] = $teamid;
		
		echo "OK";		
?>