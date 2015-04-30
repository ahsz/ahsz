<!DOCTYPE html>
<?php 
    session_start();  
    require "check_logged_in.php"; 
    require "config.php"; 
?>
<html>
<head>
    <meta charset="UTF-8"></meta>
    <title>Oktatói felület</title>
    <style media="screen" type="text/css"> 
        textarea { resize: none; } 
    </style>
</head>
<body>
    <?php
        if($_SESSION['TYPE']==1){
            echo "Oktatói jogosultság szükséges a megtekintéshez! Jelenlegi oktatók és elérhetőségük:";
    ?>
    <table border="0">
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
        ?>
    </table>
</body>
</html>

