<?php 

session_start(); 
if(!isset($_SESSION['username']))
{ 
   echo "Kerlek jelentkezz be!";
   exit();
} 

?> 