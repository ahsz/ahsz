<? php
require "check_logged_in.php";
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">  </meta>
	<link rel="stylesheet" type="text/css" href="main.css">
<title>Agilis csapat - Értékelő rendszer</title>
</head>

<body>

<div id="cim">Tmit porta </div>

<div id="menu">
	<ul >
      <li><a href="kezdolap.php" class="link1" target="kezdolap_frame">Kezdőlap</a></li>
      <li><a href="profil.php" class="link2" target="kezdolap_frame">Profil</a></li>
	  <li><a href="uzenetek.php" class="link3" target="kezdolap_frame">Üzenetek</a></li>
      <li><a href="ertekeles.html" class="link4" target="kezdolap_frame">Értékelés</a></li>
	  <li><a href="cs_status.php" class="link5" target="kezdolap_frame">Csapat státusz</a></li>
	  <li><a href="m_status.html" class="link6" target="kezdolap_frame">Munka státusz</a></li>
      <li><a href="feltoltes.html" class="link7" target="kezdolap_frame">Feltöltés</a></li>
	  <li><a href="logout.php" class="link8">Kijelentkezés</a></li>
	</ul>
    </div>
<iframe src="kezdolap.php" width="1280" height="1024" style="margin-left:200px; margin-top:50px; border:none"  name="kezdolap_frame"></iframe>
</body>

</html>
