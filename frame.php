<?php
require "check_logged_in.php";
?>



<!doctype html>
<html>
<head>

<meta charset="UTF-8">  </meta>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
<title>Agilis csapat</title>
<link rel="stylesheet" href="styles.css" type="text/css" />
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!--
anatine, a free CSS web template by ZyPOP (zypopwebtemplates.com/)

Download: http://zypopwebtemplates.com/

License: Creative Commons Attribution
//-->
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
</head>

<body>

		<section id="body" class="width">
			<aside id="sidebar" class="column-left">

			<header>
				<h1><a href="kezdolap.php">Tmit Porta</a></h1>

				<h2>Agilis hálózati szolgáltatásfejlesztés!</h2>
				
			</header>

			<nav id="mainnav">
  				<ul>
	<li><a href="kezdolap.php" class="link1" target="kezdolap_frame">Kezdőlap</a></li>
	<li><a href="profil.php" class="link2" target="kezdolap_frame">Profil</a></li>
	
	<?php	if($_SESSION['TYPE']==1){	?>
		<li><a href="uzenetek.php" class="link3" target="kezdolap_frame">Üzenetek</a></li>
	<?php	}	if($_SESSION['TYPE']==2){	?>
		<li><a href="uzenetek.php" class="link3" target="kezdolap_frame">Aktuális információk</a></li>
	<?php	}	?>
	
	<li><a href="ertekeles.php" class="link4" target="kezdolap_frame">Értékelés</a></li>
	<li><a href="cs_status.php" class="link5" target="kezdolap_frame">Csapat státusz</a></li>
	<li><a href="m_status.php" class="link6" target="kezdolap_frame">Munka státusz</a></li>
	<li><a href="feltoltes.php" class="link7" target="kezdolap_frame">Feltöltés</a></li>
	<li><a href="teszteredmeny.php" class="link10" target="kezdolap_frame">Teszt eredmények</a></li>
	
	<?php	if($_SESSION['TYPE']==1){	?>
	<li><a href="oktatoi.php" class="link8" target="kezdolap_frame">Oktatók</a></li>
	<?php	}	if($_SESSION['TYPE']==2){	?>
	<li><a href="oktatoi.php" class="link8" target="kezdolap_frame">Oktatói felület</a></li>
	<?php	}	?>	

	<li><a href="logout.php" class="link9">Kijelentkezés</a></li>
                        	</ul>
			</nav>

			
			
			</aside>
			<section id="content" class="column-right">
                		<iframe src="kezdolap.php" width="1280" height="1024" style="border:none"  name="kezdolap_frame"></iframe>
	 

			
			<footer class="clear">
				<p>&copy; 2015 Bundáskenyér. </p>
			</footer>


		</section>

		<div class="clear"></div>

	</section>
	

</body>
</html>
