<?php 

session_start(); 

$redir;

if(isset($_SESSION['username']))
{ 
   echo "Szia ".$_SESSION['username'].", sikeres bejelentkezes!"; 
   echo '<a href="frame.php">'. Kezdolap . '</a>';
   $redir='frame.php';
} 

else{ 
   echo "Kerlek jelentkezz be!"; 
   $redir='index.html';
} 

?> 

<script language="javascript" type="text/javascript">

     window.setTimeout('window.location="<?php echo $redir; ?>"; ',2000);

</script>

