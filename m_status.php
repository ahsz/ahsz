<?php
	session_start(); 
	require "check_logged_in.php";
	require "config.php";
	
	if(isset($_POST['changeTeam'])){
		$newTeam = $_POST['changeTeam'];
		$result = mysqli_query($con,"SELECT ID FROM TEAM WHERE NAME='$newTeam'");
		$row=mysqli_fetch_assoc($result);
		$_SESSION['TEAM_ID']=$row['ID'];
	}
?>
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
	<link rel="stylesheet" type="text/css" href="m_status.css">
	<script type="text/javascript" src='https://www.google.com/jsapi?autoload={"modules":[{"name":"visualization","version":"1.1","packages":["corechart"]}]}'></script>
	<script type="text/javascript">
		var gitUrl;
		var nevek = [];
		var dT = [];
		// A linket és a névpárokat a DB-ből átadjuk a kliens oldalnak.
		function reqListener () {
		  console.log(this.responseText);
		}

		var oReq = new XMLHttpRequest();
		oReq.onload = function() {
			//This is where you handle what to do with the response.
			//The actual data is found on this.responseText
			var responseData = JSON.parse(this.responseText);
			gitUrl = responseData.url;
			nevek = responseData.nevek;
			console.log(responseData);
			console.log(gitUrl);
			console.log(nevek);
			
			initializeChart();
		};
		oReq.open("get", "m_status_getData.php", true);
		oReq.send();
		
		/**
		 * Chartok alapbeállítása, oszlopainak megadása, lekérdezés indítása
		 */
		function initializeChart() {
			dT[0] = new google.visualization.DataTable();
			dT[0].addColumn({ type: 'string', label: 'User' });
			dT[0].addColumn({ type: 'number', label: 'Commitok' });
			dT[1] = new google.visualization.DataTable();
			dT[1].addColumn({ type: 'string', label: 'User' });
			dT[1].addColumn({ type: 'number', label: 'Hozzáadott sorok' });
			dT[1].addColumn({ type: 'number', label: 'Törölt sorok' });
			dT[1].addColumn({ type: 'number', label: 'Új sorok' });
			dT[2] = new google.visualization.DataTable();
			dT[2].addColumn({ type: 'date', label: 'Hét' });
			dT[3] = new google.visualization.DataTable();
			dT[3].addColumn({ type: 'date', label: 'Hét' });
			
			var script = document.createElement('script');  
			script.src = gitUrl + 'stats/contributors?callback=gitRoot';
			document.getElementsByTagName('head')[0].appendChild(script);
		}
		/**
		 * Git-es username kicserélése rendes névre
		 */
		function getRealName(gitNev) {
			for (var i = 0; i < nevek.length; i++) 
				if(nevek[i].GITHUB_NAME == gitNev)
					return nevek[i].NAME;
			return gitNev;
		}
		/**
		 * Git API válaszán keresztül a projekt alapinfóinak lekérdezése
		 */
		function gitRoot(response) {
			var data = response.data;
			if(data.length > 1) {
				// bejegyzések felhasználónként
				for (var i = 0; i < data.length; i++) {
					var user = getRealName(data[i].author.login);
					
					// commit eloszlásos adatok
					var commits = data[i].total;
					dT[0].addRow([user,commits]);
					dT[0].sort([0,1]);
					
					// commitonkénti átlagok
					var lineA = 0;
					var lineD = 0;
					var lineC = 0;
					for(var j = 0; j < data[i].weeks.length; j++) {
						lineA += data[i].weeks[j].a;
						lineD += data[i].weeks[j].d;
						lineC += data[i].weeks[j].a - data[i].weeks[j].d;
					}
					// kerekítés
					lineA = Math.round( 100 * lineA / commits ) / 100;
					lineD = Math.round( 100 * lineD / commits ) / 100;
					lineC = Math.round( 100 * lineC / commits ) / 100;
					dT[1].addRow([user,lineA,lineD,lineC]);
					dT[1].sort([0,1]);
					
					// sormódosítások hetente
					if(dT[2].getNumberOfRows() == 0)
						for(var j = 0; j < data[i].weeks.length; j++) 
							dT[2].addRow([new Date(data[i].weeks[j].w * 1000)]);
					
					var columnIndex = dT[2].addColumn({ type: 'number', label: user });
					
					for(var j = 0; j < data[i].weeks.length; j++) {
						// ne legyen negatív, mert esztétikailag elrontja az egészet
						var newLines = data[i].weeks[j].a - data[i].weeks[j].d;
						if(newLines < 0) newLines = 0;
						dT[2].setValue(j, columnIndex, newLines);
					}
					
					// commitok hetente
					if(dT[3].getNumberOfRows() == 0)
						for(var j = 0; j < data[i].weeks.length; j++) 
							dT[3].addRow([new Date(data[i].weeks[j].w * 1000)]);
					
					var columnIndex = dT[3].addColumn({ type: 'number', label: user });
					
					for(var j = 0; j < data[i].weeks.length; j++) {
						dT[3].setValue(j, columnIndex, data[i].weeks[j].c);
					}
				}
				drawChart();
			}
			// debug info kiiratás
			console.log(data);
			console.log(dT);
		}
		


		/**
		 * Google chartok kirajzoltatása
		 */
		function drawChart() {
			var charts = [];
			var options = [];
			charts[0] = new google.visualization.PieChart(document.getElementById('chart_commit'));
			charts[1] = new google.visualization.ColumnChart(document.getElementById('chart_linePerCommit'));
			charts[2] = new google.visualization.BarChart(document.getElementById('chart_linePerWeek'));
			charts[3] = new google.visualization.BarChart(document.getElementById('chart_commitPerWeek'));
			
			options[0] = {
			 title: "Commitok aránya",
			 pieHole: 0.4,
			 height: 350,
			};
			options[1] = {
			 title: "Commitonkénti átlagos értékek",
			 height: 350,
			};
			options[2] = {
			 title: "Új sorok száma adott kezdetű héten",
			 height: 400,
			 legend: { position: 'top', maxLines: 3 },
			 bar: { groupWidth: '75%' },
			 isStacked: true
			};
			options[3] = {
			 title: "Commitok adott kezdetű héten",
			 height: 400,
			 legend: { position: 'top', maxLines: 3 },
			 bar: { groupWidth: '75%' },
			 isStacked: true
			};
			
			for(var i = 0; i < charts.length; i++)
					charts[i].draw(dT[i], options[i]);
			
		}
	</script>
	
</head>

<body>
	<?php
		if($_SESSION['TYPE']==2){
	?>
		<form action="#" method="POST">
		<select name="changeTeam" id="changeTeam">
		<?php
			$result = mysqli_query($con,"SELECT NAME FROM TEAM");
			while($row=mysqli_fetch_assoc($result))
			{
			  echo '<option value = "'.$row['NAME'].'">'.$row['NAME'].'</option>';
			}
		?>
		</select>
		<input type="submit" id="Submit" value="Mehet"  />
		</form>
	<?php
		}
	?>


	<div style="margin-left:200">
	
	<br><br>
	<h1>Munka státusz</h1>
	</div>
	<div id="chart_commit" style="width: 600px; height: 350px;"></div> <br>
	<div id="chart_linePerCommit" style="width: 600px; height: 350px;"></div>
	<div id="chart_linePerWeek" style="width: 1000px; height: 400px;"></div>
	<div id="chart_commitPerWeek" style="width: 1000px; height: 400px;"></div>
	
	<h1>Commit log</h1>
	<iframe src="commit_tree.php" width="500" height="400" frameBorder="0"></iframe>	
	
</body>

</html>
