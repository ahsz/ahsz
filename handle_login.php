<?php
	if($_POST["login"]) {
		header("Location: frame.html");
	}
	if($_POST["register"]) {
		header("Location: register.html");
	}
	exit;
?>