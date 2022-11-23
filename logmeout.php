<?php
session_start(); //to ensure you are using same session
$_SESSION['logged']=false;
session_destroy(); //destroy the session
header("Location:profile.php");
exit();
?>
