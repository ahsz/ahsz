

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
	
	<?php
		session_start(); 
		?>
	//	HTML elemek beolvasása
		var parent = document.getElementById("manage_team");
		var child1 = document.getElementById("create_team");
		var child2 = document.getElementById("selected_team");
		var child3 = document.getElementById("decision");
		var child4 = document.getElementById("news");	
		var team_id = <?php									//csapat azonosító beállítása
			if($_SESSION['def_tid']== -1){
			echo $_SESSION['def_tid'];
			}
			else{
			echo '"still_empty"';	
			}
			?>;
		//megfelelő elemek törlése a DOM-ból
		parent.removeChild(child1);
		parent.removeChild(child2);
		
		
		if (team_id == -1) {
			document.getElementById("main_page").removeChild(child4);
		}
		//státusz mező értékének beállítása, a megfelelő értékre
		document.getElementById("statusz").innerHTML = 
					<?php
						require "config.php";
						ini_set('display_errors', 'on');
						$t_name = "";
		
						//csapatnév lekérése, hogy ki legyen írva az oldal tetejére
						$tid = $_SESSION['def_tid'];		
						if($tid==-1){		//oktatói jogosultság ellenőrzése
							echo '"Oktatói jogosultsággal rendelkezel!";';
						}
						elseif($tid!=0){		//amennyiben nem oktató, tagja-e valamely csapatnak
						$teamname = mysqli_query($con,"SELECT NAME FROM TEAM WHERE ID='$tid'");
						while($row=mysqli_fetch_assoc($teamname))
						{
							$t_name = $row['NAME'];
						}
								if($t_name != null){
									echo '"A '. $t_name.' csapat tagja vagy"'.';';


								}
								else{
									echo '"";';		// ekkor nem tagja egyetlen csapatnak sem

								}
						}
						else{
							echo '"";';
							}
					?>
	
	<?php
		if($t_name != null || $tid == -1){	//amennyiben valamely csapat tagja, vagy oktató, akkor az új csapat létrehozásának elemei törlésre kerülnek
		echo  'parent.removeChild(child3);';
		}
	?>
		

		}
		

		//csapat létrehozás elemei
	function show_create () {
		//document.getElementById("Create").disabled = "false";
	if(document.getElementById('create_team')==null) {
		$('#manage_team').append('<div id="create_team"> <p> <input type="textfield" id="my_team"></input> <input type="submit" id="Create" value="Létrehoz" onclick="new_team()" /> <input type="submit" id="Cancel1" value="Mégsem" onclick="location.reload()" /> </p></div>');
		}
	
	}
	
	//új csapat bejegyzése az adatbázisba
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

				
                          });
		//szükségtelen mezők törlése	
		var parent = document.getElementById("manage_team");
		var child1 = document.getElementById("decision");
		var child2 = document.getElementById("create_team");
		//új elem létrehozása, majd az alábbi üzenet beírása
		var para = document.createElement("p");
		var node = document.createTextNode("Az általad létrehozott csapat: " + teamname);
		para.appendChild(node);
	
		parent.removeChild(child1);
		parent.removeChild(child2);
			
		}


	
	</script>


</head>
<!--  -->
<body>
	
	<div id="main_page">
	

		<p id="subpage_title"> <b>Kezdőlap</b>	</p> <!-- Ez az oldal címe  -->
		
		<div id="manage_team">
		
			<a a href="cs_status.php" style="text-decoration:none; color: black;" target="_self" > <!--  A belső "statusz" szonosítójú elembe kerülő tartalomra kattintva, a csapat státuszra navigál -->
				<div id="statusz">						<!-- amennyiben már valamaely csapat tagja, ebben az elemben jelenik meg a csapat neve  -->
				</div>
			</a>
			
			<div id="decision">				<!-- Új csapat létrehozása, amennyiben még nem tagja egyetlen csapatnak sem -->
<?php
	if ($_SESSION['TYPE']==1) { 
?>
			<input type="submit" id="join1" value="Új csapat létrehozása!" onclick="show_create()" />			<!-- Ezzel a gombbal hívódik meg a "show_create" függvény, amely hozzáadja a szükséges mezőket az oldalhoz  -->
		<!--	<input type="submit" id="join2" value="Csapathoz csatlakozok!" onclick="show_teams()" />  -->
			
			
			</div>
		
			
			
			<div id="create_team">				<!-- Ez tartalmazza a csapat létrehozásához szükséges mezőket -->
			<!-- csak akkor jelenik meg, ha új csapatot akar a felhasználó-->
			
			
			<p>
				
				<input type="textfield" id="my_team"></input>	<!-- ide kell írni a csapatnevet -->
				<input type="submit" id="Create" value="Létrehoz" onclick="new_team()" />	<!-- Ezen gomb megnyomására hívódik meg "new_team"függvény amely eltárolja az adatbázisban a csapatot-->
				<input type="submit" id="Cancel1" value="Mégsem" onclick="location.reload()" />	 <!-- Ezzel a gombbal szakítható meg a csapat létrehozás folyamata -->
				<!-- TODO: Ha választott már csapatot a diák akkor többet ne lássa ezt a legördülő menüt -->
			</p>

			</div>
			
			
			
			
			
			<div id="selected_team">	
			<span id="team_name"> tesztszöveg  </span>	<!-- Ez a mező tartalmazza hogy a csapat létrehozása sikeres volt vagy sikertelen  -->
			
				
			</div>
		</div>
			
		<div class="description">	<!-- Ez a mező csak az alábbi szöveget tartalmazza, nem hajtódik végre rajta művelet  -->
		<p>	Ezen az oldalon keresztül tudsz csapatot létrehozni, amihez később hozzá tudod adni a csapattagjaidat. </p>
<?php } ?> 
		<p>  <font size="5"><b><u>Aktuális információk:</u></b></font>		<!-- Ebbe a mezőbe kerülnek az OKTATÓI üzenetek, listaszerűen, egymás alá. -->
		</br>
			<ul>
					<?php
						$t_id= -1;		//Az oktatók -1-es ID-val vannak jelölve az adatbázisban
				//		$last_messages = 5;
						$new_teacher_array = array();	//ebben az új tömbben lesznek eltárolva a következő sorban levő lekérdezés eredményei
						
						$result=mysqli_query($con,"SELECT M.DATE_CRT, U.NAME, M.MESSAGE FROM MSG_BOARD M, USER U WHERE U.NEPTUN=M.NEPTUN AND M.TEAM_ID='$t_id'"); //tanárok által írt üzenetek lekérdezése
								
						if(!$result)
						{
							echo "ERROR :" . mysqli_error($con). "\n";		//hibaüzenet amennyiben nem sikerült a lekérdezés
						}
							
						while($row=mysqli_fetch_assoc($result))
						{
							$result_string = "<b>".$row['DATE_CRT'].":	"."</b>".$row['MESSAGE'];	//megjelenítés formátumának beállítása: <dátum-idő>: <üzenet>
							array_push($new_teacher_array, $result_string);		//lekérdezések eredményei sorban egymás után bekerülnek a tömbbe a megfelelő formátumban
						}	
						
						for($i = count($new_teacher_array); $i>0; $i--){		//A tömb elemeinek kiírása a listába, amely megjelenik az oldalon
							echo "<li>".$new_teacher_array[$i-1]."</li>";
						}
						
					/*	if (count($new_array) > $last_messages) {
								for ($i = $last_messages; $i > 0; $i--) {
									echo $new_array[count($new_array)-($i)]."</br>";
									}
							}
							
						else{
								for ($i = 0; $i < count($new_array); ++$i) {
									echo $new_array[$i]."</br>";
								}
						}
	*/
					?>

			</ul>
		</p>
		
		

		</div>
		
		<a a href="uzenetek.php" style="text-decoration:none; color: black;" target="_self" >		
		
			<div id="news">			<!-- Ebben a mezőben a csapattagok üzenetei találhatóak. Kattintásra az uzenetek.php-ra navigál a fenti sornak köszönhetően  -->	
			
				<p>
				<b>Legfrissebb üzenetek:</b>
				</br></br>

				
					<?php
						$t_id=$_SESSION['def_tid']; //csapat azonosítója
						$last_messages = 5;			//csak az utolsó 5 üzenet jelenik meg
						$new_array = array();		//üzenetek tárolására szolgál
						
						$result=mysqli_query($con,"SELECT M.DATE_CRT, U.NAME, M.MESSAGE FROM MSG_BOARD M, USER U WHERE U.NEPTUN=M.NEPTUN AND M.TEAM_ID='$t_id'"); //csapat üzeneteinek lekérdezése
						
						if(!$result)
						{
							echo "ERROR :" . mysqli_error($con). "\n";		//hibaüzenet, amennyiben van
						}
							
						while($row=mysqli_fetch_assoc($result))		//eredmények feldolgozása
						{
							$result_string = $row['DATE_CRT']." ".$row['NAME'].": ".$row['MESSAGE'];		//kimeneti formátum beállítása <dátum idő> <küldő neve> : <üzenet>
							array_push($new_array, $result_string); // elemek tömbbe helyezése
						}	
						
						
						if (count($new_array) > $last_messages) {	//utolsó 5 üzenet lekérdezése
								for ($i = $last_messages; $i > 0; $i--) {	
									echo $new_array[count($new_array)-($i)]."</br>";	//üzenetek megjelenítése az oldalon
									}
							}
						else{
								for ($i = 0; $i < count($new_array); ++$i) { //amennyiben nincs 5 üzenet, akkor az összes tömbelem lekérdezése
									echo $new_array[$i]."</br>";		//üzenetek megjelenítése
								}
						}

					?>
					
					</p>
					
					

				
			</div>
		</a>
	
	</div>
	
	
	
	
</body>

</html>
