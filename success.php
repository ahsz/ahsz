<?php 

session_start(); 

if(isset($_SESSION['username']))
{ 
   echo "Szia ".$_SESSION['username'].", sikeres bejelentkezes!"; 
   echo '<a href="frame.html">'. Kezdolap . '</a>';
} 

else{ 
   echo "Kerlek jelentkezz be!"; 
} 

?> 
