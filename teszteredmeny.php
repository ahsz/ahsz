<!DOCTYPE html>

<?php
	session_start();  
    require "check_logged_in.php"; 
    require "config.php"; 
    
	ini_set('display_errors', 'on');

	function save(){
        	require "config.php"; 
				
			$time = $_POST['time'];
			if (!preg_match('/(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})/',$time)){
				echo "HIBA: rossz dátumformátum";
				echo '<a href="teszteredmeny.php">'. Vissza . '</a>'; 
				exit();
				}
				
			$passed = $_POST['passed'];
			if (!preg_match('/\d+/',$passed)){
				echo "HIBA: nem számot adtál meg Passednak";
				echo '<a href="teszteredmeny.php">'. Vissza . '</a>'; 
				exit();
				}		
			
			$failed = $_POST['failed'];
			if (!preg_match('/\d+/',$failed)){
				echo "HIBA: nem számot adtál meg Failednek";
				echo '<a href="teszteredmeny.php">'. Vissza . '</a>'; 
				exit();
				}		

			$inconclusive = $_POST['inconclusive'];	
			if (!preg_match('/\d+/',$inconclusive)){
				echo "HIBA: nem számot adtál meg Inconclusivenak";
				echo '<a href="teszteredmeny.php">'. Vissza . '</a>'; 
				exit();
				}		
				
			$sum= $passed + $failed + $inconclusive;
			
			$neptun_kod=$_SESSION['NEPTUN'];
			$t_id=$_SESSION['TEAM_ID'];

		$saveentry	 = mysqli_query($con,"INSERT INTO TEST VALUES (null,$t_id, STR_TO_DATE('$time ', '%Y-%m-%d %H:%i:%s') , $sum,$passed,$failed,$inconclusive, sysdate(),'$neptun_kod')");
		if($saveentry){
			$message = "Szerepkör sikeresen felvéve!"; 
			echo "<script type='text/javascript'>alert('$message');</script>";
		}
		else{
        		echo "Hiba, probald ujra!" . mysqli_error($con);
        		/*echo '<a href="oktatoi.php">'. Vissza . '</a>';*/
		}
	}
	
	function draw(){
			require "config.php";
			$result=mysqli_query($con,"SELECT ifnull(NUM_OF_TEST,'') AS NPASS, ifnull(NUM_OF_FAIL,'') AS NFAILED, ifnull(NUM_OF_INC,'') as NINC FROM TEST WHERE DATE=STR_TO_DATE('2010-10-10', '%Y-%m-%d')");
			if($result->num_rows>0){
				$row=mysqli_fetch_assoc($result);				
			} else {
				echo "HIBA: " . mysqli_error($con);
				echo '<a href="profil.php">'. Vissza . '</a>'; 
				exit(); 	
			}
	}
	
    if(isset($_POST['time']) && isset($_POST['passed']) && isset($_POST['failed']) && isset($_POST['inconclusive'])){
    	save();
    }
?>

<html>
<head>
	<meta charset="UTF-8">  </meta>
	<title>Profil</title>
	<style media="screen" type="text/css">
	

	
	#profile {
		font-size:120%
	}
	
	div.user_info {
		margin-top : 15px;
	}
	
	textarea {
    		resize: none;
	}
	
	</style>
		
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript">
			  var testRows = [
			['Passed', 4,],
			['Failed', 1],
			['Inconclusive', 3],
		];

		var data = null;

		google.load("visualization", "1", {
			packages: ["corechart", 'table']
		});

		google.setOnLoadCallback(function () {
			data = new google.visualization.DataTable();
			data.addColumn('string', 'Result');
			data.addColumn('number', 'Count');
			data.addRows(testRows);
			drawChart('piechart', 'div_id_1', data, null);
			drawChart('columnChart', 'div_id_2', data, null);
		});

		var columnChart, tableChart;
		document.getElementById('change-btn').onclick=function() {
			/*data.removeRow(0);
			data.removeRow(1);
			data.removeRow(2);
			data.insertRows(0, [['Passed', <?$row['NPASS']?>]]);
			data.insertRows(1, [['Failed', <?$row['NFAILED']?>]]);
			data.insertRows(2, [['Inconclusive', <?$row['NINC']?>]]);*/
			columnChart.draw(data);
			pieChart.draw(data);
		}
				
		function drawChart(chartType, containerID, dataTablo, options) {
			var containerDiv = document.getElementById(containerID);
			var chart = false;
			if (chartType.toUpperCase() == 'BARCHART') {
				chart = new google.visualization.BarChart(containerDiv);
			} else if (chartType.toUpperCase() == 'COLUMNCHART') {
				chart = new google.visualization.ColumnChart(containerDiv);
				columnChart = chart;
			} else if (chartType.toUpperCase() == 'PIECHART') {
				chart = new google.visualization.PieChart(containerDiv);
				pieChart = chart;
			} else if (chartType.toUpperCase() == 'TABLECHART') {
				chart = new google.visualization.Table(containerDiv);
				tableChart = chart;
			}

			if (chart == false) {
				return false;
			}
			chart.draw(dataTablo, options);
		}
    </script>
</head>
<body>
	<h1>Teszt eredmények</h1>


		<div id="profile">
			<table style="width:50%">
				<div class="user_info">
					<tr><td>
					
<?php
	draw();
?>
				<tr><td><br><br></td></tr>
				<div class="user_info">
					<tr><td>
						<b>Utolsó futtatás eredményei</b>
					</td></tr>
				</div>
				<div class="user_info">
					<form form id="form" name="form" method="post" action="#">
						<tr><td>
							Futtatás időpontja(YYYY-MM-DD HH:MM:SS):
						</td><td>
							<input type="text" name="time" class="box" size=30 />
						</td></tr>
						<tr><td>
							Passed:
						</td><td>
							<input type="text" name="passed" class="box" size=30 />
						</td></tr>
						<tr><td>
							Failed:
						</td><td>
							<input type="text" name="failed" class="box" size=30 />
						</td></tr>
						<tr><td>
							Inconclusive:
						</td><td>
							<input type="text" name="inconclusive" class="box" size=30 />
						</td><tr>
						<tr><td/><td>
							<input type="submit" name="Submit" value="Mentés"/>
						</td></tr>
					</form>
				</div>
			</table>
				
		</div>
	</div>
	<button id="change-btn">Draw</button>
	<div id="div_id_1" style="width: 900px; height: 500px;"></div>
	<div id="div_id_2"></div>
</body>

</html>
