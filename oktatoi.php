<!DOCTYPE html>
<?php 
    session_start();  
    require "check_logged_in.php"; 
    require "config.php"; 
    ini_set('display_errors', 'on');

	function delUser(){ 
        require "config.php"; 
        $user = $_POST['delUser'];
        $delUser = mysqli_query($con,"DELETE FROM USER WHERE NEPTUN='$user'"); 
        $message = "Sikeres felhasználó törlés!"; 
        echo "<script type='text/javascript'>alert('$message');</script>"; 
	} 

	function setAdmin(){
        require "config.php"; 
        $admin = $_POST['setAdmin'];
        $delUser = mysqli_query($con,"UPDATE USER SET TYPE=2 WHERE NEPTUN='$admin'"); 
        $message = "Sikeres oktató hozzáadás!"; 
        echo "<script type='text/javascript'>alert('$message');</script>"; 	
	}

    if(isset($_POST['delUser'])){
        delUser();
    }
    
    if(isset($_POST['setAdmin'])){
    	setAdmin();
    }
    
?>
<html>
<head>
    <meta charset="UTF-8"></meta>
    <title>Oktatói felület</title>
    <style media="screen" type="text/css"> 
        #profile { font-size:120% }
    </style>
</head>
<body>
	<h1>Oktatói felület</h1>
	<br/>
    <?php
        //nem oktató
        if($_SESSION['TYPE']==1){
            echo "Oktatói jogosultság szükséges a megtekintéshez!<br/><br/>Jelenlegi oktatók és elérhetőségük:";
    ?>
    <table border="1">
        <tr>
			<td><b>Név</b></td>
            <td><b>E-mail cím</b></td>
        </tr>
	<?php
            $result=mysqli_query($con,"SELECT ifnull(U.NAME,'') as NAME, ifnull(U.EMAIL,'') as EMAIL FROM USER U WHERE U.TYPE=2");
            while($row = mysqli_fetch_assoc($result))
            {
                echo "<tr>";
                echo "<td>".$row['NAME']."</td>";
                echo "<td>".$row['EMAIL']."</td>";
                echo "</tr>";
            }
        }
        //oktató
        if($_SESSION['TYPE']==2){
	?>
        <b>Felhasználó törlése:</b></br>
    	<form action="#" method="POST"> 
			<select name="delUser" id="del"> 
	<?php 
                $get=mysqli_query($con,"SELECT NEPTUN FROM USER"); 
                $option = ''; 
                while($row = mysqli_fetch_assoc($get)) 
                { 
                    $option .= '<option value = "'.$row['NEPTUN'].'">'.$row['NEPTUN'].'</option>'; 
                } 

                echo $option; 
	?> 
        	</select> 
        	<input type="submit" id="Submit" value="Törlés"  /> 
        </form> 
        </br></br>
        
        <b>Oktatói jogosultság beállítása:</b>
		<form action="#" method="POST"> 
			<select name="setAdmin" id="set"> 
	<?php 
				$get=mysqli_query($con,"SELECT NEPTUN FROM USER WHERE TYPE=1"); 
				$option = ''; 
				while($row = mysqli_fetch_assoc($get)) 
				{ 
					$option .= '<option value = "'.$row['NEPTUN'].'">'.$row['NEPTUN'].'</option>'; 
				} 
        		        echo $option;
	?>
			</select>
			<input type="submit" id="Submit" value="Törlés"  /> 
		</form>
	
    <?php
        }
    ?>
    </table>
</body>
</html>

