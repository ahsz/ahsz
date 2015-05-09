<!DOCTYPE html>
<html>
<head>
        <meta charset="UTF-8">  </meta>
<title>Title of the document</title>
</head>

<body>
<?php
require "config.php";
$mail = $_GET["email"];

$result=mysqli_query($con, "SELECT PASSWORD FROM USER WHERE EMAIL='$mail'");
        if($result->num_rows>0){
                $row=mysqli_fetch_assoc($result);
                $pass = $row['PASSWORD'];
        }
	else{
		echo "A felhasználó nem található az adatbázisunkban.";
		echo "</body>
<script language=\"javascript\" type=\"text/javascript\">

     window.setTimeout('window.location=\"index.html\"; ',2000);

</script>
</html>";
		exit;
	}

$result=mysqli_query($con, "SELECT NAME FROM USER WHERE EMAIL='$mail'");
        if($result->num_rows>0){
                $row=mysqli_fetch_assoc($result);
                $name = $row['NAME'];
        }


$to      = $mail;
$subject = 'Jelszó emlékeztető';
$message = "Kedves $name! \r\n\r\nAz agilis csapat oldalához tartozó jelszavad: $pass \r\n\r\nÜdv.: \r\nAdmin";
$headers = 'From: donotreply@agilissite.tmit.bme.hu' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);
echo "Sikeresen kiküldtük a jelszóemlékeztetőt.";
?>
</body>
<script language="javascript" type="text/javascript">

     window.setTimeout('window.location="index.html"; ',2000);

</script>
</html>

