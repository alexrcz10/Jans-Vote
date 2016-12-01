<?php
session_start();
session_destroy();
header("Location: ../Vista/index.php");
session_start();
$_SESSION["prueba"]="";
?>
