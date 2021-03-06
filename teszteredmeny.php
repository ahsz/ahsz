<!DOCTYPE html>

<?php
	session_start();  
    require "check_logged_in.php"; 
    require "config.php";    
	ini_set('display_errors', 'on');

	//Globális változók inicializálása
	global $passedcount,$failedcount,$inconclusivecount, $defdate;
	$passedcount=1;
	$failedcount=1;
	$inconclusivecount=1;
	$defdate='1900-00-00';
	
	//Okatató számára csapatválasztás
	function changeTeam(){
		require "config.php";
		$newTeam = $_POST['changeTeam'];
		$result = mysqli_query($con,"SELECT ID FROM TEAM WHERE NAME='$newTeam'");
		$row=mysqli_fetch_assoc($result);
		$_SESSION['TEAM_ID']=$row['ID'];
	}

	//Tesztadatok mentése
	function save(){
        	require "config.php"; 
				
			//Beviteli mező ellenőrzése	
			$time = $_POST['time'];
			if (!preg_match('/(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})/',$time)){
				echo "HIBA: rossz dátumformátum";
				echo '<a href="teszteredmeny.php">'. 'Vissza' . '</a>'; 
				exit();
				}
				
			//Beviteli mező ellenőrzése
			$passed = $_POST['passed'];
			if (!preg_match('/\d+/',$passed)){
				echo "HIBA: nem számot adtál meg Passednak";
				echo '<a href="teszteredmeny.php">'. 'Vissza' . '</a>'; 
				exit();
				}		
			
			//Beviteli mező ellenőrzése
			$failed = $_POST['failed'];
			if (!preg_match('/\d+/',$failed)){
				echo "HIBA: nem számot adtál meg Failednek";
				echo '<a href="teszteredmeny.php">'. 'Vissza' . '</a>'; 
				exit();
				}		
			
			//Beviteli mező ellenőrzése
			$inconclusive = $_POST['inconclusive'];	
			if (!preg_match('/\d+/',$inconclusive)){
				echo "HIBA: nem számot adtál meg Inconclusivenak";
				echo '<a href="teszteredmeny.php">'. 'Vissza' . '</a>'; 
				exit();
				}		
			
			//Szumma számolás
			$sum= $passed + $failed + $inconclusive;
			
			
			$neptun_kod=$_SESSION['NEPTUN'];
			$t_id=$_SESSION['TEAM_ID'];
		
		//Adatbázis query felépítése és elküldése
		$saveentry	 = mysqli_query($con,"INSERT INTO TEST VALUES (null,$t_id, STR_TO_DATE('$time ', '%Y-%m-%d %H:%i:%s') , $sum,$passed,$failed,$inconclusive, sysdate(),'$neptun_kod')");
		if($saveentry){
			$message = "Teszteredmény sikeresen felvéve!"; 
			echo "<script type='text/javascript'>alert('$message');</script>";
		}
		else{
        		echo "Hiba, probald ujra!" . mysqli_error($con);
        		/*echo '<a href="oktatoi.php">'. Vissza . '</a>';*/
		}
	}
	
	//Grafikon inicializálás él update
	function mydraw(){
			require "config.php";
			
			//Ha adott időpontot kér le
			if(isset($_POST['selectDate'])){
				
				$t_id=$_SESSION['TEAM_ID'];	
				$selecteddate=$_POST['selectDate'];
				//Query összerakás
				$result=mysqli_query($con,"SELECT ifnull(NUM_OF_PASS,'') AS NPASS, ifnull(NUM_OF_FAIL,'') AS NFAILED, ifnull(NUM_OF_INC,'') as NINC, ifnull(DATE,'') AS DDATE FROM TEST where TEAM_ID=$t_id and DATE=STR_TO_DATE('$selecteddate', '%Y-%m-%d %H:%i:%s') order by DATE DESC LIMIT 1");
				if($result->num_rows>0){
					$row=mysqli_fetch_assoc($result);
					//Globális változók beállítása, a grafikon ezeket használja
					global $passedcount,$failedcount,$inconclusivecount, $defdate;
					$passedcount=$row['NPASS'];
					$failedcount=$row['NFAILED'];
					$inconclusivecount=$row['NINC'];
					$defdate=$row['DDATE'];
					
				//Ha nincs tesztadat	
				} else {
					echo "HIBA: Nincs tesztadat feltöltve ";
					echo '<a href="teszteredmeny.php">'. 'Vissza' . '</a>'; 
					exit(); 

				}
			
			//Default dátum (legutolsó) lekérés
			}else{
				$t_id=$_SESSION['TEAM_ID'];		
				//Query összerakás
				$result=mysqli_query($con,"SELECT ifnull(NUM_OF_PASS,'') AS NPASS, ifnull(NUM_OF_FAIL,'') AS NFAILED, ifnull(NUM_OF_INC,'') as NINC, ifnull(DATE,'') AS DDATE FROM TEST where TEAM_ID=$t_id order by DATE DESC LIMIT 1");
				if($result->num_rows>0){
					$row=mysqli_fetch_assoc($result);
					//Globális változók beállítása, a grafikon ezeket használja
					global $passedcount,$failedcount,$inconclusivecount, $defdate;
					$passedcount=$row['NPASS'];
					$failedcount=$row['NFAILED'];
					$inconclusivecount=$row['NINC'];
					$defdate=$row['DDATE'];
				
				//Ha nincs tesztadat
				} else {
					global $passedcount,$failedcount,$inconclusivecount, $defdate;
					$passedcount=0;
					$failedcount=0;
					$inconclusivecount=0;
					$defdate='2010-10-10'; 
				}
			} 
	}
	
	//Lekért tesztadatok szöveges kiírása
	function writeDate(){
		//Ha adott időpontot kért le
		if(isset($_POST['selectDate'])){
			$currentTestDate=$_POST['selectDate'];;

			echo "A kiválsztott teszt dátuma: " . $currentTestDate  . nl2br("\n");
			global $passedcount,$failedcount,$inconclusivecount;
			echo  "Passed: "	. $passedcount . nl2br("\n");
			echo  "Failed: " .	$failedcount . nl2br("\n");
			echo  "Inconclusive: "	. $inconclusivecount . nl2br("\n");

		//Default időpont(legutolsó) lekérése
		}  else{
			echo "A legutolsó teszt eredménye:" . nl2br("\n");
			global $passedcount,$failedcount,$inconclusivecount;
			echo  "Passed: " . $passedcount . nl2br("\n");
			echo  "Failed: " .	$failedcount . nl2br("\n");
			echo  "Inconclusive: "	. $inconclusivecount . nl2br("\n");
		}
	}
	
	//Beviteli mezők megadásának ellenőrzése
    if(isset($_POST['time']) && isset($_POST['passed']) && isset($_POST['failed']) && isset($_POST['inconclusive'])){
    	save();
    }
	
	//Csapat választás kezelése oktató számára
	if(isset($_POST['changeTeam'])){
		changeTeam();
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
		

</head>
<body>
<?php
	//Okatató számára csapatválasztás
	if($_SESSION['TYPE']==2){
?>
	<form action="#" method="POST">
	<select name="changeTeam" id="changeTeam">
	<?php
		//legördülő feltöltése adattal
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
	
	
	<h1>Teszt eredmények</h1>


		<div id="profile">
			<table style="width:50%">
				<div class="user_info">
					<tr><td>
					
<?php
	//Grafikon feltöltése adattal
	mydraw();
	//Nem oktató számára az elérhető beviteli mezők
	if($_SESSION['TYPE'] != 2)
	{
?>
				<tr><td><br><br></td></tr>
				<div class="user_info">
					<tr><td>
						<b>Utolsó futtatás eredményei</b>
					</td></tr>
				</div>
				<div class="user_info">
				<!--Beviteli mezők-->
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
<?php
	}
?>	
			<!--Teszteredmény lekérdezés-->
			<div class="user_info">
				<form form id="form" name="form" method="post" action="#">				
						<tr><td>
								Teszt eredményeinek lekérdezése:
							</td><td>
				<select name="selectDate" id="selectDate">
				  <?php
				  //legördülő feltöltése
					$t_id=$_SESSION['TEAM_ID'];	
					$get=mysqli_query($con,"SELECT ifnull(DATE,'') AS DDATE FROM TEST where TEAM_ID=$t_id order by DATE DESC");
					$option = '';
					 while($row = mysqli_fetch_assoc($get))
					{
					  $option .= '<option value = "'.$row['DDATE'].'">'.$row['DDATE'].'</option>';
					}

					echo $option; ?>
				</select>
					</td><td>
						<button type="submit" id="change-btn">Lekérdez</button>
					</td></tr>		
					
					</form>
				</div>
						</table>
			

		</div>
	</div>
				<div class="user_info">
	<?php
		//Teszteredmények szöveges kiírása
		writeDate();
	?>
	</div>
	<!--Grafikon kirajzolás-->
	<div id="div_id_1" style="width: 900px; height: 500px;"></div>
	<!--Grafikon rajzoló google script-->
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript">
			  var testRows = [
			['Passed', <?php echo $passedcount;?>],
			['Failed', <?php echo $failedcount;?>],
			['Inconclusive', <?php echo $inconclusivecount;?>]
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
			data.removeRow(0);
			data.removeRow(0);
			data.removeRow(0);
			data.insertRows(0, [['Passed', <?php echo $passedcount;?>]]);
			data.insertRows(1, [['Failed', <?php echo $failedcount;?>]]);
			data.insertRows(2, [['Inconclusive', <?php echo $inconclusivecount;?>]]);
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
	
</body>

</html>
