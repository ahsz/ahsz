<?php 

session_start(); 

if(isset($_SESSION['username']))
{ 
   echo "Hello ".$_SESSION['username'].", sikeres bejelentkezés!."; 
   echo '<a href="frame.html">'. Kezdőlap . '</a>';
} 

else{ 
   echo "Kérlek jelentkezz be!"; 
} 

?> 
