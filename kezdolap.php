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
		
		p {
		}
		
		#create_team {
			margin-left: 200px;
			text-indent: 50px;
		}


		
	</style>
	
	<script>
	var clicked = false;

	
	
	window.onload = function () {
	//	document.getElementById("Create").disabled = "true";
		document.getElementById("create_team").style.visibility = "hidden";
		
	//	document.getElementById("Submit").disabled = "true";
	document.getElementById("select_team").style.visibility = "hidden";
		
		
		}
		
	function show_teams () {
		//document.getElementById("Submit").disabled = "false";
			
		if (clicked == false){
			document.getElementById("select_team").style.visibility = "visible";
			clicked = true;
			document.getElementById("decision").style.visibility = "hidden";
			}
		
		}
		
	function show_create () {
		//document.getElementById("Create").disabled = "false";
				if (clicked == false){
			document.getElementById("create_team").style.visibility = "visible";
			clicked = true;
			document.getElementById("decision").style.visibility = "hidden";
			}
	}
	function new_team() {

		
		document.getElementById("Create").disabled = "false";
		document.getElementById("create_team").style.visibility = "visible";
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
				var child2 = document.getElementById("select_team");
				var child3 = document.getElementById("create_team");
				parent.removeChild(child1);
				parent.removeChild(child2);
				parent.removeChild(child3);*/
				
                          });
			
		var parent = document.getElementById("main_page");
		var child1 = document.getElementById("decision");
		var child2 = document.getElementById("select_team");
		var child3 = document.getElementById("create_team");
		var para = document.createElement("p");
		var node = document.createTextNode("Az általad létrehozott csapat: " + teamname);
		para.appendChild(node);
		parent.insertBefore(para,child3);	
		parent.removeChild(child1);
		parent.removeChild(child2);
		parent.removeChild(child3);
			
			
		//	document.getElementById("Create").disabled = "false";
			
		}
	
	
	function your_team()	{
		var teamname = document.getElementById("options").value;
//		document.getElementById("team_name").innerHTML = teamname;
//		document.getElementById("selected_team").style.visibility = "visible";
		
//		document.getElementById("options").disabled = true;
//		document.getElementById("select_team").style.visibility = "hidden";
		
		var parent = document.getElementById("main_page");
		var child1 = document.getElementById("decision");
		var child2 = document.getElementById("select_team");
		var child3 = document.getElementById("create_team");
		var para = document.createElement("p");
		var node = document.createTextNode("Az általad választott csapat: " + teamname);
		para.appendChild(node);
		parent.insertBefore(para,child3);	
		parent.removeChild(child1);
		parent.removeChild(child2);
		parent.removeChild(child3);
		
		
		}

	
	</script>


</head>

<body style="background-color:lightgreen">
	
	<div id="main_page">
		<p id="subpage_title"> <b>Kezdőlap</b>	</p> 

	<div id="decision">
	<input type="submit" id="join1" value="Új csapat létrehozása!" onclick="show_create()" />
	<input type="submit" id="join2" value="Csapathoz csatlakozok!" onclick="show_teams()" />
	
	
	</div>
	
		<div id="select_team">
		<!-- csak akkor jelenik meg, ha még nem választott csapatot a felhasználó-->
		Válassz csapatot!
		
		<p>
			<select name="formCsapat" id="options">
			   <?php
	
			  session_start(); 
			  require "config.php";
	
			  $result=mysqli_query($con,"SELECT NAME FROM TEAM");

			  if(!$result)
			  {
				echo "ERROR :" . mysqli_error($con);
			  }
				
			  while($row=mysqli_fetch_assoc($result))
			  {
			  ?>
			  <option value="<? echo $row['NAME']; ?>"><? echo $row['NAME']; ?></option>
			  <?php
			  }
			  ?>

			</select>
			<input type="submit" id="Submit" value="Kiválaszt" onclick="your_team()" />
			<input type="submit" id="Cancel2" value="Mégsem" onclick="location.reload()" />
			<!-- TODO: Ha választott már csapatot a diák akkor többet ne lássa ezt a legördülő menüt -->
		</p>

		</div>
		
		<div id="create_team">
		<!-- csak akkor jelenik meg, ha még nem választott csapatot a felhasználó-->
		
		
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
		
			
		<div class="description">
		<p>  Ez az Agilis csapat oldala!
			</br>
			<br/>Reméljük mindenki elégedett lesz a munkánkkal! :)
			</br>
			</br>
			</p>
		<p>  A csapattagok:
		<br/>Tuba
		</br>Dodi
		</br>Husi
		</br>Kerémi
		</br>Kónya
		<br>SzMarci
		</br>Lali
		</p>
		<p>  Ide még kérülhet bármilyen  egyéb szöveg
		</p>
		</div>
	
	</div>
	
	
	
	
</body>

</html>