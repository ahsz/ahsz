<?php   

	session_start(); 
	require "config.php";

	If($_POST["submit"])
	{
		$name = $_POST["name"];
		$escapedname = htmlspecialchars($name, ENT_QUOTES);
		$neptun = $_POST["neptun"];
		$escapedneptun = htmlspecialchars($neptun, ENT_QUOTES);
		$email = $_POST["email"];
		$escapedemail = htmlspecialchars($email, ENT_QUOTES);
		$pass = $_POST["password"];
		$escapedpass = htmlspecialchars($pass, ENT_QUOTES);
		$date=date('Y-m-d',time());
		
		If($name=="" || $neptun=="" || $email=="" || $pass=="")
		{
			Echo "Kerlek toltsd ki az uresen maradt mezoket!";
		}
		Else
		{
			$res=mysqli_query($con,"INSERT INTO USER (NEPTUN, NAME, TYPE, PASSWORD, TEAM_ID, DATE_CRT, DATE_MOD, EMAIL, ROLE_ID) 
							 VALUES ('$escapedneptun','$escapedname',1,'$escapedpass',null,sysdate(),null,'$escapedemail',null)");
			If($res)
			{
				Echo "Sikeres regisztracio! ";
				Echo '<a href="index.html">'. Belepes . '</a>';
			}
			Else
			{
				Echo "ERROR volt megint: " . mysqli_error($con);
			}
		}
	}
?>
