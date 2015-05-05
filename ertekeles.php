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
		
		$getNeptunForName = mysqli_query($con,"SELECT NEPTUN FROM USER WHERE NAME='$whom'");
		while($row=mysqli_fetch_assoc($getNeptunForName))
		{
			$selectedNeptun = $row['NEPTUN'];
		}
		
		$insertEvaluateTeammate = mysqli_query($con,"INSERT RATE SET NEPTUN_WHO='$who', NEPTUN_WHOM='$selectedNeptun', GRADE=$grade, MESSAGE='$evaluateMsg'");
		$message = "Értékelés sikeresen elküldve!";
		echo "<script type='text/javascript'>alert('$message');</script>";	
	}
	
	function evaluateTeam(){
		require "config.php";
		
		$grade=$_POST['teamGrade'];
		$evaluateMsg=$_POST['teamMessage'];
		$teamname=$_POST['whichTeam'];
		
		$updateEvaluateTeam = mysqli_query($con,"UPDATE TEAM SET GRADE=$grade, MESSAGE='$evaluateMsg' WHERE NAME='$teamname'");
		$message = "Csapat sikeresen értékelve";
		echo "<script type='text/javascript'>alert('$message');</script>";	
	}
	
	function evaluateStudent(){
		require "config.php";
		
		$who=$_SESSION['NEPTUN'];
		$whom=$_POST['whichStudent'];
		$grade=$_POST['studentGrade'];
		$evaluateMsg=$_POST['studentMessage'];
		$insertEvaluateStudent = mysqli_query($con,"INSERT RATE SET NEPTUN_WHO='$who', NEPTUN_WHOM='$whom', GRADE=$grade, MESSAGE='$evaluateMsg'");
		$message = "Diák sikeresen értékelve";
		echo "<script type='text/javascript'>alert('$message');</script>";	
	}
	
	if(isset($_POST['EvaluateTeammateGrade'], $_POST['EvaluateTeammateMessage'], $_POST['userWho'])){
		evaluateTeammate();
	}
	
	if(isset($_POST['whichTeam'], $_POST['teamGrade'], $_POST['teamMessage'])){
		evaluateTeam();
	}
	
	if(isset($_POST['whichStudent'], $_POST['studentGrade'], $_POST['studentMessage'])){
		evaluateStudent();
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

<body>

<div id="page_name"> <b>Értékelés:</b> </div>

		<div id="grade">
			
			<?php
				if($_SESSION['TYPE']==2){
			?>
			<form action="#" method="POST">
			<b>Csapat értékelése:</b>
			<div class="user_info">
			</br>
			Csapat:
			<select name="whichTeam" id="whichTeam">
			  <?php
				
				$get=mysqli_query($con,"SELECT NAME FROM TEAM");
				$option = '';
				 while($row = mysqli_fetch_assoc($get))
				{
				  $option .= '<option value = "'.$row['NAME'].'">'.$row['NAME'].'</option>';
				}

				echo $option; ?>
			</select>
			</br>
			Osztályzat:	
			<span id="teamGrade">
			<select name="teamGrade" id="options">
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
			<textarea name="teamMessage" id="input" rows="2" cols="20"></textarea>
			</br>
			<input type="submit" id="Submit" value="Küldés"  />
			</form>
			</div>
			<br/>
			<br/>
			
			<b>Diák értékelése:</b>
			<div class="user_info">
			</br>
			<form action="#" method="POST">
			Csapat kiválasztása:
			<select name="whichTeamForStudent" id="whichTeamForStudent">
			  <?php
				$get=mysqli_query($con,"SELECT NAME FROM TEAM");
				$option = '';
				 while($row = mysqli_fetch_assoc($get))
				{
				  $option .= '<option value = "'.$row['NAME'].'">'.$row['NAME'].'</option>';
				}

				echo $option; ?>
			</select>
			<input type="submit" id="Submit" value="OK"  />
			</br>
			</form>
			<form action="#" method="POST">
			Diák kiválasztása:
			<select name="whichStudent" id="whichStudent">
			  <?php
				if(isset($_POST['whichTeamForStudent'])){
					$teamNameOfStudent = $_POST['whichTeamForStudent'];
					$teamIdQuery = mysqli_query($con,"SELECT ID FROM TEAM WHERE NAME='$teamNameOfStudent'");
					while($row=mysqli_fetch_assoc($teamIdQuery))
					{
						$teamIdForStudent = $row['ID'];
					}
					
					$get=mysqli_query($con,"SELECT NEPTUN FROM USER WHERE TEAM_ID='$teamIdForStudent'");
					$option = '';
					 while($row = mysqli_fetch_assoc($get))
					{
					  $option .= '<option value = "'.$row['NEPTUN'].'">'.$row['NEPTUN'].'</option>';
					}

					echo $option;
				}?>
			
			</select>
			</br>
			Osztályzat:	
			<span id="studentGrade">
			<select name="studentGrade" id="options">
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
			<textarea name="studentMessage" id="input" rows="2" cols="20"></textarea>
			</br>
			<input type="submit" id="Submit" value="Küldés"  />
			</form>
			</div>
			
			</br>
			</br>
			<b>Diákok értékelése egymásról:</b>
			</b>
			<form action="#" method="POST">
			Csapat kiválasztása:
			<select name="whichTeamToList" id="whichTeamToList">
			  <?php
				$get=mysqli_query($con,"SELECT NAME FROM TEAM");
				$option = '';
				 while($row = mysqli_fetch_assoc($get))
				{
				  $option .= '<option value = "'.$row['NAME'].'">'.$row['NAME'].'</option>';
				}

				echo $option; ?>
			</select>
			<input type="submit" id="Submit" value="OK"/>
			</br>
			</form>
			<?php if(isset($_POST['whichTeamToList'])){ ?>
			</b>
				<table border="1" width="800">
				<tr>
					<td><b>Értékelt</b></td>
					<td><b>Értékelő</b></td>
					<td><b>Jegy</b></td>
					<td><b>Értékelés</b></td>
				</tr>
			
			<?php
			$team = $_POST['whichTeamToList'];
			$teamIdQuery = mysqli_query($con,"SELECT ID FROM TEAM WHERE NAME='$team'");
			while($row2=mysqli_fetch_assoc($teamIdQuery))
			{
				$teamId = $row2['ID'];
			}
			$listTeam = mysqli_query($con,"SELECT RATE.NEPTUN_WHOM as whom, RATE.NEPTUN_WHO AS who, RATE.GRADE as grade, RATE.MESSAGE as msg FROM RATE, USER WHERE USER.TYPE=1 AND USER.TEAM_ID=$teamId AND USER.NEPTUN=RATE.NEPTUN_WHO");
			 while($row = mysqli_fetch_assoc($listTeam))
			{
			  echo "<tr>";
				  echo "<td>".$row['whom']."</td>";
				  echo "<td>".$row['who']."</td>";
				  echo "<td>".$row['grade']."</td>";
				  echo "<td>".$row['msg']."</td>";
			  echo "</tr>";
			}
			} ?>
			
			</br>
			</br>
			<b>Elküldött értékelések:</b>
			</b>
			<form action="#" method="POST">
			Csapat kiválasztása:
			<select name="whichTeamToListSent" id="whichTeamToListSent">
			  <?php
				$get=mysqli_query($con,"SELECT NAME FROM TEAM");
				$option = '';
				 while($row = mysqli_fetch_assoc($get))
				{
				  $option .= '<option value = "'.$row['NAME'].'">'.$row['NAME'].'</option>';
				}

				echo $option; ?>
			</select>
			<input type="submit" id="Submit" value="OK"/>
			</br>
			</form>
			<?php if(isset($_POST['whichTeamToListSent'])){ ?>
			</b>
				<table border="1" width="800">
				<tr>
					<td><b>Értékelt</b></td>
					<td><b>Értékelő</b></td>
					<td><b>Jegy</b></td>
					<td><b>Értékelés</b></td>
				</tr>
			
			<?php
			$team = $_POST['whichTeamToListSent'];
			$teamIdQuery = mysqli_query($con,"SELECT ID FROM TEAM WHERE NAME='$team'");
			while($row2=mysqli_fetch_assoc($teamIdQuery))
			{
				$teamId = $row2['ID'];
			}
			$listTeam = mysqli_query($con,"SELECT RATE.NEPTUN_WHOM as whom, RATE.NEPTUN_WHO AS who, RATE.GRADE as grade, RATE.MESSAGE as msg FROM RATE, USER a, USER b WHERE a.TYPE=2 AND a.NEPTUN=RATE.NEPTUN_WHO AND RATE.NEPTUN_WHOM=b.NEPTUN AND b.TEAM_ID='$teamId'");
			 while($row = mysqli_fetch_assoc($listTeam))
			{
			  echo "<tr>";
				  echo "<td>".$row['whom']."</td>";
				  echo "<td>".$row['who']."</td>";
				  echo "<td>".$row['grade']."</td>";
				  echo "<td>".$row['msg']."</td>";
			  echo "</tr>";
			}
			} ?>
			
			<?php
				}else if($_SESSION['TYPE']==1){
			?>
			<form action="#" method="POST">
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
			
			<b>Csapattag értékelése:</b>
			<div class="user_info">
			Értékelt személy:
			<span id="members">
			<select name="userWho" id="userWho">
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
			<select name="EvaluateTeammateGrade" id="EvaluateTeammateGrade">
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
			<input type="submit" id="Submit" value="Küldés"  />
			</form>
			
			<br/>
			<br/>
			<b>Csapat értékelés:</b>
			<div class="user_info">
			</br>
			<textarea name="TeamEvaluation" id="input" rows="2" cols="20" readonly>Jegy: <?php 
			$tid = $_SESSION['TEAM_ID'];
			$getTeamGradeQuery = mysqli_query($con,"SELECT GRADE FROM TEAM WHERE ID=$tid");
			$row = mysqli_fetch_assoc($getTeamGradeQuery);
			$getTeamGrade = $row['GRADE'];
			if($getTeamGrade!=null){echo $getTeamGrade;}
			?>&#13;&#10;Szöveges értékelés: <?php
			$tid = $_SESSION['TEAM_ID'];
			$getTeamMessageQuery = mysqli_query($con,"SELECT MESSAGE FROM TEAM WHERE ID=$tid");
			$row1 = mysqli_fetch_assoc($getTeamMessageQuery);
			$getTeamMessage = $row1['MESSAGE'];
			if($getTeamMessage!=null){ echo $getTeamMessage;} ?></textarea>
			</div>
			
			<br/>
			<br/>
			<b>Oktató értékelése rólad:</b>
			<div class="user_info">
			</br>
			<textarea name="TeammateEvaluation" id="input" rows="2" cols="20" readonly>Jegy: <?php 
			$myNeptun = $_SESSION['NEPTUN'];
			$getMyGradeQuery = mysqli_query($con,"SELECT RATE.GRADE FROM RATE, USER WHERE USER.TYPE=2 AND RATE.NEPTUN_WHO=USER.NEPTUN AND RATE.NEPTUN_WHOM='$myNeptun'");
			$row = mysqli_fetch_assoc($getMyGradeQuery);
			$getMyGrade = $row['GRADE'];
			if($getTeamGrade!=null){echo $getMyGrade;}
			?>&#13;&#10;Szöveges értékelés: <?php
			$myNeptun = $_SESSION['NEPTUN'];
			$getMyMessageQuery = mysqli_query($con,"SELECT RATE.MESSAGE FROM RATE, USER WHERE USER.TYPE=2 AND RATE.NEPTUN_WHO=USER.NEPTUN AND RATE.NEPTUN_WHOM='$myNeptun'");
			$row1 = mysqli_fetch_assoc($getMyMessageQuery);
			$getMyMessage = $row1['MESSAGE'];
			if($getMyMessage!=null){ echo $getMyMessage;} ?></textarea>
			</div>
			
			<?php
				}
			?>
	
	</div>
	
	
	
</body>

</html>