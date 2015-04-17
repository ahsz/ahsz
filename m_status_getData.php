<?php
	session_start(); 
	require "check_logged_in.php";
	require "config.php";
	ini_set('display_errors', 'on');
	
	// Github-os link lekérése a chart adatainak megszerzéséhez
	$tid = $_SESSION['TEAM_ID'];
	$teamname = mysqli_query($con,"SELECT GITHUB_URL FROM TEAM WHERE ID='$tid'");
	while($row = mysqli_fetch_assoc($teamname)) {
		$link = $row['GITHUB_URL'];
	}
	
	// Névpárok lekérése, hogy a charton rendes név legyen
	$sth = mysqli_query($con,"SELECT NAME, GITHUB_NAME FROM USER WHERE TEAM_ID='$teamid'");
	$nevek = array();
	while($r = mysqli_fetch_assoc($sth)) {
		$nevek[] = $r;
	}
	
	echo json_encode( array('url' => $link, 'nevek' => $nevek) );
	
?>
	