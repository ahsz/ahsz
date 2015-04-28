<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">  </meta>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<title>Kezdőlap</title>

	<style>
		#select_team {
			margin-left: 200px;
			text-indent: 50px;
		}

		#selected_team {
			margin-left: 200px;
			text-indent: 50px;
			visibility: hidden;
		}
		
		div {
		}
		
		
		#main_page {
		
		}
		
		#subpage_title {
			text-align: center;
			font-size: 200%;
		}
		
		
		div.description p {
			text-indent: 50px;
			padding-left: 30px;
		}
		
		#news {
		margin-left: 80px;
		}
		
		p {
			margin-top: 80px;
			margin-bottom: 10px;

		}
		
		li {
		margin-left: 100px;
		margin-bottom: 20px;
		}
		
		#decision{
			display: inline-block;
		}
		
		#statusz{
			display: inline-block;
			color: green;
			font-weight: bold;
		}
		
		#selected_team{
			display: inline-block;
		}
		
		
		#select_team {
			display: inline-block;
			margin-left: 200px;
			text-indent: 50px;
		}


		
	</style>
	
	<script>
	var clicked = false;

	
	
	window.onload = function () {
	//	document.getElementById("Create").disabled = "true";
	//	document.getElementById("create_team").style.visibility = "hidden";
		var parent = document.getElementById("manage_team");
		var child1 = document.getElementById("create_team");
		var child2 = document.getElementById("selected_team");
		var child3 = document.getElementById("decision");
		parent.removeChild(child1);
		parent.removeChild(child2);
		
		document.getElementById("statusz").innerHTML = 
					<?php
						session_start(); 
					require "config.php";
					ini_set('display_errors', 'on');
	
					//csapatnév lekérése, hogy ki legyen írva az oldal tetejére
					$tid = $_SESSION['TEAM_ID'];
					$teamname = mysqli_query($con,"SELECT NAME FROM TEAM WHERE ID='$tid'");
					while($row=mysqli_fetch_assoc($teamname))
					{
						$t_name = $row['NAME'];
					}
							if($tid != null){
								echo '"A '. $t_name.' csapat tagja vagy"'.';';


							}
							else{
								echo '"'.'"'.';';
								//$noTeamMsg = "Még nincsen csapatod! Kérlek csatlakozz egy csapathoz!";
								//echo "<script type='text/javascript'>alert('$noTeamMsg');</script>";
							}
	?>
	
	<?php
		if($tid != null){
		echo  'parent.removeChild(child3);';
		}
	?>
		


		
		
		
	//	document.getElementById("Submit").disabled = "true";
	//document.getElementById("select_team").style.visibility = "hidden";
		
		
		}
		
/*	function show_teams () {
		//document.getElementById("Submit").disabled = "false";
			
		if (clicked == false){
			//document.getElementById("select_team").style.visibility = "visible";
			clicked = true;
			document.getElementById("decision").style.visibility = "hidden";
			}
		
		}
		*/
		
	function show_create () {
		//document.getElementById("Create").disabled = "false";
	if(document.getElementById('create_team')==null) {
		$('#manage_team').append('<div id="create_team"> <p> <input type="textfield" id="my_team"></input> <input type="submit" id="Create" value="Létrehoz" onclick="new_team()" /> <input type="submit" id="Cancel1" value="Mégsem" onclick="location.reload()" /> </p></div>');
		}
	
	}
	function new_team() {

			$('#manage_team').append('<div id="selected_team"> <span id="team_name"> tesztszöveg  </span></div>')
		
		
		document.getElementById("Create").disabled = "false";
		//document.getElementById("create_team").style.visibility = "visible";
		var teamname = document.getElementById("my_team").value;
		$.ajax({
                              type:"post",
                              url:"handle_new_team.php",
                              data:"team="+teamname,
			      success:function(data){
						var status = document.getElementById("team_name");
						if (data=="OK"){
							status.innerHTML = "<b>Sikeresen létrehoztad a csapatot!</b>";
							status.style.color = "green";
							}
						else{
							status.innerHTML = "<b>A csapatot nem sikerült létrehozni!</b>";
							status.style.color = "red";
							}
							
						document.getElementById("selected_team").style.visibility="visible";
						
                              },
				error: function (jqXHR, textStatus, errorThrown)
						{
							var status = document.getElementById("team_name");
							status.innerHTML = "<b>Hiba a kapcsolatban!</b>";
							status.style.color = "red";
							
							
						document.getElementById("selected_team").style.visibility="visible";
						}
				
				/*var child1 = document.getElementById("decision");

				parent.removeChild(child1);
				parent.removeChild(child2);
				parent.removeChild(child3);*/
				
                          });
			
		var parent = document.getElementById("manage_team");
		var child1 = document.getElementById("decision");
		var child2 = document.getElementById("create_team");


		var para = document.createElement("p");
		var node = document.createTextNode("Az általad létrehozott csapat: " + teamname);
		para.appendChild(node);
	
		parent.removeChild(child1);
		parent.removeChild(child2);

			
			
		//	document.getElementById("Create").disabled = "false";
			
		}


	
	</script>


</head>

<body>
	
	<div id="main_page">
	

		<p id="subpage_title"> <b>Kezdőlap</b>	</p> 
		
		<div id="manage_team">
		
			<div id="statusz">

				
			
			</div>
		
			<div id="decision">				

			<input type="submit" id="join1" value="Új csapat létrehozása!" onclick="show_create()" />
		<!--	<input type="submit" id="join2" value="Csapathoz csatlakozok!" onclick="show_teams()" />  -->
			
			
			</div>
		
			
			
			<div id="create_team">
			<!-- csak akkor jelenik meg, ha új csapatot akar a felhasználó-->
			
			
			<p>
				
				<input type="textfield" id="my_team"></input>
				<input type="submit" id="Create" value="Létrehoz" onclick="new_team()" />
				<input type="submit" id="Cancel1" value="Mégsem" onclick="location.reload()" />
				<!-- TODO: Ha választott már csapatot a diák akkor többet ne lássa ezt a legördülő menüt -->
			</p>

			</div>
			
			
			
			
			
			<div id="selected_team">
			<span id="team_name"> tesztszöveg  </span>
			
				
			</div>
		</div>
			
		<div class="description">
		<p>	Ezen az oldalon keresztül tudsz csapatot létrehozni, amihez később hozzá tudod adni a csapattagjaidat. </p>

		<p>  Aktuális információk:
		<ul>
			<li> A következő Demo időpontja: 2015.05.13	</li>
			<li> Az utolsó előadás 05.14-én lesz, ekkor lesz a félév értékelése</li>

		</ul>
		</p>
		
		

		</div>
		
		<div id="news">
		
			<p>
			<b>Legfrissebb üzenetek:</b>
			</br></br>

			
				<?php
					
					$t_id=$_SESSION['TEAM_ID'];
					$last_messages = 5;
					
					$result=mysqli_query($con,"SELECT M.DATE_CRT, U.NAME, M.MESSAGE FROM MSG_BOARD M, USER U WHERE U.NEPTUN=M.NEPTUN AND M.TEAM_ID='$t_id'");
					
					if(!$result)
					{
						echo "ERROR :" . mysqli_error($con). "\n";		
					}
						
					while($row=mysqli_fetch_assoc($result))
					{
						$result_string = $row['DATE_CRT']." ".$row['NAME'].": ".$row['MESSAGE'];
						$new_array[] = $result_string; // Inside while loop
					}	
					
					
					if (count($new_array) > $last_messages) {
						    for ($i = $last_messages-1; $i >= 0; $i--) {
								echo $new_array[count($new_array)-($i)]."</br>";
								}
						}
					else{
						    for ($i = 0; $i < count($new_array); ++$i) {
								echo $new_array[$i]."</br>";
							}
					}

				?>
				
				</p>
				
				

			
		</div>
		
	
	</div>
	
	
	
	
</body>

</html>
