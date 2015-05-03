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
	<?php	
		session_start(); 
		require "config.php";
		if($_SESSION['TYPE']==1){	
	?> 
	<h1>Üzenetek</h1></br>
	Az itt megadott üzenetek csak Te és a csapattársaid látjátok.
	<?php	} if($_SESSION['TYPE']==2){	?> 
	<h1>Aktuális információk</h1></br>
	Az itt megadott információk kikerülnek a kezdőlapra, az "Aktuális információk" blokkhoz. </br>
	Az itt megadott információk az oktatói felületen törölhetőek.
	<?php } ?>
	
	</div>
	<textarea readonly name="message" rows="40" cols="80"><?php
	

	
	$t_id=$_SESSION['def_tid'];
	
	$result=mysqli_query($con,"SELECT M.DATE_CRT, U.NAME, M.MESSAGE FROM MSG_BOARD M, USER U WHERE U.NEPTUN=M.NEPTUN AND M.TEAM_ID='$t_id'");
	
	if(!$result)
	{
		echo "ERROR :" . mysqli_error($con);
	}
	echo "\n";	
	while($row=mysqli_fetch_assoc($result))
	{
	echo $row['DATE_CRT']." ".$row['NAME'].": ".$row['MESSAGE']."\n";
	}	

	?></textarea>
	<form form id="form" name="form" method="post" action="msgboard.php">
	<textarea id="postmessage" name="postmessage" rows="2" cols="74"></textarea>
	<input type="submit" name="submit" value="Küldés" />
	</form>
	
</body>

</html>
