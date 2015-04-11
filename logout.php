<?php

session_start();

session_unset(); 
session_destroy(); 

echo 'Sikeres kijelentkezes!';

?>

<script language="javascript" type="text/javascript">

     window.setTimeout('window.location="index.html"; ',2000);

</script>