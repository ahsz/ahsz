<?php
	session_start(); 
	require "check_logged_in.php";
	require "config.php";
	ini_set('display_errors', 'on');
	
	// Github-os link lekérése a chart adatainak megszerzéséhez
	$tid = $_SESSION['TEAM_ID'];
	$github_repo_query = mysqli_query($con,"SELECT GITHUB_LINK FROM TEAM WHERE ID='$tid'");
	while($row = mysqli_fetch_assoc($github_repo_query)) {
		$link = $row['GITHUB_LINK'];
	}

	// Névpárok lekérése, hogy a charton rendes név legyen
	$sth = mysqli_query($con,"SELECT NAME, GITHUB_NAME FROM USER WHERE TEAM_ID='$tid'");
	$nevek = array();
	while($r = mysqli_fetch_assoc($sth)) {
		$nevek[] = $r;
	}
	
	echo json_encode( array('url' => $link, 'nevek' => $nevek) );
	
?>
	