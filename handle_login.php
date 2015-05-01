<?php

	session_start(); 
	require "config.php";
	
	if($_POST["login"])
	{
		$user  = $_POST['username'];
		$escapeduser = htmlspecialchars($user, ENT_QUOTES);
		$pass  = $_POST['password']; 
		$escapedpass = htmlspecialchars($pass, ENT_QUOTES);
		
		if($user == "" || $pass == "") 
		{ 
			echo "Kerlek toltsd ki a mezoket!"; 
		} 
		else
		{
			$result=mysqli_query($con,"SELECT * FROM USER LEFT JOIN ROLE ON USER.ROLE_ID = ROLE.ID WHERE NEPTUN='$escapeduser' and PASSWORD='$escapedpass'");
			$count=mysqli_num_rows($result);
		
			if($count==1){
				$_SESSION = mysqli_fetch_assoc($result);
				$_SESSION['default_tid'] = $_SESSION['TEAM_ID'];
				$_SESSION['username'] = $escapeduser;
				if($_SESSION['TYPE']==2){
					$result=mysqli_query($con,"SELECT * FROM TEAM");
					$row=mysqli_fetch_assoc($result);
					$_SESSION['TEAM_ID']=$row['ID'];
				}
				header("location:success.php");
			}
			 else{ 
				echo "Nem letezo neptun kod vagy rossz jelszo!"; 
			} 
		}
	}
	
	if($_POST["register"]) {
		header("Location: register.html");
	}
	exit;
?>
