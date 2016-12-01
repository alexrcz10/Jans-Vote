<?php
@session_start();
if($_SESSION["prueba"]!="SIP"){
	header("Location: ../Vista/index.php");
	exit();
}
?>
