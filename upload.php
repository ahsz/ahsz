<?php
echo "Starting";
session_start();
require "config.php";
$target_dir = "uploads/";

$neptun_kod=$_SESSION['NEPTUN'];
$dirname = bin2hex(openssl_random_pseudo_bytes(16));
$time = date("Y-m-d H:i:s");
$shortname = substr(basename($_FILES["fileToUpload"]["name"]),0,30);
$result=mysqli_query($con,"SELECT ifnull(T.ID,'') AS ID, ifnull(T.UPLOAD_DIR,'') AS DIRECTORY FROM USER U LEFT JOIN (TEAM T, ROLE R) ON (T.ID=U.TEAM_ID AND R.ID=U.ROLE_ID) WHERE U.NEPTUN='$neptun_kod'");

if($result->num_rows>0){
        $row=mysqli_fetch_assoc($result);
	echo "<br>";
        if($row['DIRECTORY']=="")
        {
		echo "Creating team directory....<br>";
                $dirname = bin2hex(openssl_random_pseudo_bytes(16));
                $target_dir = $target_dir.$dirname."/";
		mkdir($target_dir);
                $id = $row['ID'];
                mysqli_query($con,"UPDATE TEAM SET UPLOAD_DIR='$dirname' WHERE ID='$id'");
        }
	else{
		$target_dir = $target_dir.$row['DIRECTORY']."/";
		$dirname = $row['DIRECTORY'];
	}
}


$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$fileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if file already exists
if (file_exists($target_file)) {
    echo "A fájl már létezik.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) {
    echo "A fájl túl nagy, maximális méret: 5MB.";
    $uploadOk = 0;
}
// Allow certain file formats
if($fileType != "doc" && $fileType != "docx" && $fileType != "pdf"
&& $fileType != "txt" && $fileType != "zip") {
    echo "Sajnálom, csak doc, docx, pdf, txt és zip fájlok tölthetők fel.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sajnálom a fájlt nem tudtuk feltölteni.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "A fájl ". basename( $_FILES["fileToUpload"]["name"]). " fel lett töltve.";
	mysqli_query($con, "INSERT INTO FILE (NAME, DATE_CRT, CRT_BY, DIRECTORY) VALUES ('$shortname', '$time', '$neptun_kod', '$dirname')");
    } else {
        echo "Sajnálom, hiba történt a feltöltés közben.";
    }
}
?>

