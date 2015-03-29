<?php   

	session_start(); 
	require "config.php";

	If($_POST["submit"])
	{
		$name = $_POST["name"];
		$neptun = $_POST["neptun"];
		$email = $_POST["email"];
		$pass = $_POST["password"];
		$date=date('Y-m-d',time());
		
		If($name=="" || $neptun=="" || $email=="" || $pass=="")
		{
			Echo "please fill the empty field.";
		}
		Else
		{
			$res=mysqli_query($con,"INSERT INTO USER (NEPTUN, NAME, TYPE, PASSWORD, TEAM_ID, DATE_CRT) VALUES ('$neptun','$name',1,'$pass',1,'$date')");
			If($res)
			{
				Echo "Record successfully inserted";
				Echo '<a href="frame.html">'. Kezdőlap . '</a>';
			}
			Else
			{
				Echo "ERROR volt megint: " . mysqli_error($con);
			}
		}
	}
?>