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

    </style>
</head>
<body>
    <?php
        if($_SESSION['TYPE']==1){
            echo "Oktatói jogosultság szükséges a megtekintéshez! Jelenlegi oktatók és elérhetőségük:";
        }
    ?>
</body>
</html>

