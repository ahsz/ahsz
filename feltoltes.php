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
<title>Title of the document</title>
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
			$team = $_SESSION['TEAM_ID'];
			$result = mysqli_query($con,"SELECT UPLOAD_DIR FROM TEAM WHERE ID=$team");
			$row = mysqli_fetch_assoc($result);
			$dir = $row['UPLOAD_DIR'];
		}	
	?>
	
	
	<!-- Ezen az oldalon van kód, ami mysql táblából csinál html táblázatot
		http://www.anyexample.com/programming/php/php_mysql_example__display_table_as_html.xml -->
	<?php
	if($_SESSION['TYPE']!=2){
	?>
		<form action="upload.php" method="post" enctype="multipart/form-data">
		Feltöltendő fájl (max 20MB): <br/><br/>
		<input type="file" name="fileToUpload" id="fileToUpload"><br/><br/>
		<input type="submit" value="Feltöltés" name="submit">
		</form><br/><br/>
	<?php
		$dir = "";
		
		$neptun_kod=$_SESSION['NEPTUN'];
		$result=mysqli_query($con,"SELECT ifnull(T.UPLOAD_DIR,'') AS DIRECTORY FROM USER U LEFT JOIN (TEAM T, ROLE R) ON (T.ID=U.TEAM_ID AND R.ID=U.ROLE_ID) WHERE U.NEPTUN='$neptun_kod'");
		if($result->num_rows>0){
				$row=mysqli_fetch_assoc($result);
				$dir = $row['DIRECTORY'];
				echo $dir;
		}
	
	}
	
	$result=mysqli_query($con, "SELECT * FROM FILE WHERE DIRECTORY='$dir'");
	if($result->num_rows>0){
        	echo "<table border=\"1\" width=\"600\"><tr><th>Név</th><th>Dátum</th><th>Feltöltő</th><th>Link</th></tr>";
        	// output data of each row
        	while($row = $result->fetch_assoc()) {
                	$neptun = $row["CRT_BY"];
                	$result2 = mysqli_query($con, "SELECT NAME FROM USER WHERE NEPTUN='$neptun'");
                	$row2 = $result2->fetch_assoc();
                	echo "<tr><td>".$row["NAME"]."</td><td>".$row["DATE_CRT"]."</td><td>".$row2["NAME"]."</td><td><a href=\"uploads/".$dir."/".$row["NAME"]."\">Letöltés</a></td></tr>";
        	}
        	echo "</table>";
	}
	?>
</body>

</html>
