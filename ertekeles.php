<!DOCTYPE html>
<?php
	session_start(); 
	require "check_logged_in.php";
	require "config.php";
	ini_set('display_errors', 'on');
	
	//csapatnév lekérése, hogy ki legyen írva a csapatnév a megfelelő mezőbe
	$tid = $_SESSION['TEAM_ID'];
	$teamname = mysqli_query($con,"SELECT NAME FROM TEAM WHERE ID='$tid'");
	while($row=mysqli_fetch_assoc($teamname))
	{
		$t_name = $row['NAME'];
	}
	
	function evaluateTeammate(){
		require "config.php";
		$who=$_SESSION['NEPTUN'];
		$whom=$_POST['userWho'];
		$grade=$_POST['EvaluateTeammateGrade'];
		$evaluateMsg=$_POST['EvaluateTeammateMessage'];
		
		$getNeptunForName = mysqli_query($con,"SELECT NEPTUN FROM USER WHERE NAME='$who'");
		while($row=mysqli_fetch_assoc($getNeptunForName))
		{
			$selectedNeptun = $row['NEPTUN'];
		}
		
		$updateEvaluateTeammate = mysqli_query($con,"INSERT RATE SET NEPTUN_WHO='$who', NEPTUN_WHOM='$selectedNeptun', GRADE='$grade', MESSAGE='$evaluateMsg'");
		$message = "Értékelés sikeresen elküldve!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		
	}
	
	if(isset($_POST['EvaluateTeammateGrade']) && isset($_POST['EvaluateTeammateMessage'])){
		evaluateTeammate();
	}
?>
<html>
<head>
	
	<style>
	
	#page_name {
		font-size:150%;
		margin-top : 100px;
		margin-left : 200px	
	}
	
	#grade {
		margin-top : 100px;
		margin-left : 200px;	
		font-size:120%
	}
	
	div.user_info {
			margin-top : 15px;

	}
	
	#modify {
		margin-top : 20px;
		margin-left : 125px;
	
	}
	
	#team_name {
		margin-left : 150px;
	}
		
	#spinner {
		position: absolute;
		margin-left : 140px;
	}
	
	#members {
		position: absolute;
		margin-left : 92px;
	}
	
	#yourRating {
		position: absolute;
		margin-left : 130px;
	}
	
	textarea#input {
		resize: none;
		width: 300px;
		height: 100px;
	}
	
	textarea#output {
		resize: none;
		width: 300px;
		height: 100px;
	}

	</style>
	
	
	<meta charset="UTF-8">  </meta>
<title>Értékelés</title>
</head>

<body">

<div id="page_name"> <b>Értékelés:</b> </div>

		<div id="grade">
			<div class="user_info" >
				Csapatod:
				<span id="team_name">	
				
				<?php 
					if($tid != null){
						echo $t_name;
					}
					else{
						$noTeamMsg = "Még nincsen csapatod! Kérlek csatlakozz egy csapathoz!";
						echo "<script type='text/javascript'>alert('$noTeamMsg');</script>";
					}
				?></span>
			</div>
			</br>
			<b>Tanári értékelés: (csak tanár látja)</b>
			<div class="user_info">
			Osztályzat:	
			<span id="spinner">
			<select name="adminJegy" id="options">
			  <option value="1">1</option>
			  <option value="2">2</option>
			  <option value="3">3</option>
			  <option value="4">4</option>
			  <option value="5">5</option>
			</select>
			</span>
			<br/>
			<br/>
			
			Szöveges értékelés:
			</br>
			<textarea name="message" id="input" rows="2" cols="20"></textarea>
				
			<br/>
			<br/>
			</div>
			<form action="#" method="POST">
			<b>Csapattag értékelése:</b>
			<div class="user_info">
			Értékelt személy:
			<span id="members">
			<select name="userWho" id="options">
			  <?php
				$neptun = $_SESSION['NEPTUN'];
				$get=mysqli_query($con,"SELECT NAME FROM USER WHERE TEAM_ID='$tid' AND NEPTUN!='$neptun'");
				$option = '';
				 while($row = mysqli_fetch_assoc($get))
				{
				  $option .= '<option value = "'.$row['NAME'].'">'.$row['NAME'].'</option>';
				}

				echo $option; ?>
			</select>
			</span>
			</br>
			</br>
			Osztályzat:	
			<span id="spinner">
			<select name="EvaluateTeammateGrade" id="options">
			  <option value="1">1</option>
			  <option value="2">2</option>
			  <option value="3">3</option>
			  <option value="4">4</option>
			  <option value="5">5</option>
			</select>
			</span>
			<br/>
			<br/>
			
			Szöveges értékelés:
			</br>
			<textarea name="EvaluateTeammateMessage" id="input" rows="2" cols="20"></textarea>
			</div>
			<input id="submit" type="button" value="Küldés"> </input>
			</form>
	
	</div>
	
	
	
</body>

</html>