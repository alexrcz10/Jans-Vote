<?php
     /*conexion a la base de datos*/
	 include("conexion.php");

     //Busca el administrador con usuario y contrasena
     $myadministrador = pg_query($conexion,"select usuarioadministrador, nombreadministrador,idadministrador from administrador
     where usuarioadministrador =  '".htmlentities($_POST["usuario"])."'
     and contrasenaadministrador = '".md5(htmlentities($_POST["contrasena"]))."'" );
		$nmyadministrador = pg_num_rows($myadministrador);

	//busca el votante con usuario y contrasena

	$myvotante = pg_query($conexion,"select usuariovotante, nombrevotante,idvotante from votante
  where usuariovotante =  '".htmlentities($_POST["usuario"])."'
  and contrasenavotante = '".md5(htmlentities($_POST["contrasena"]))."'" );
   $nmyvotante = pg_num_rows($myvotante);


     //Si existe el administrador, validamos también la contraseña ingresada y el estado del administrador...
		 if($nmyadministrador != 0 or $nmyvotante !=0 ){
			 session_start();
				 //Guardamos dos variables de sesión que nos auxiliará para saber si se está o no "logueado" un administrador


		  $_SESSION["prueba"]="SIP";

							 if($nmyadministrador){
 							 		$_SESSION["usuarioactual"] = pg_result($myadministrador,0,1); //nombre del usuario logueado.
                  $_SESSION["idactual"] = pg_result($myadministrador,0,2); //id del usuario logueado.
								  $_SESSION["quees"] = "Adm"; //Variables para redirigir
								 header ("Location: ../Vista/paginaAdmin.php");

							 }
								if($nmyvotante){
									$_SESSION["usuarioactual"] = pg_result($myvotante,0,1); //nombre del usuario logueado.
                  $_SESSION["idactual"] = pg_result($myvotante,0,2); //nombre del usuario logueado.
									$_SESSION["quees"] = "vot"; //Variables para redirigir
									header ("Location: ../Vista/paginaVot.php");

								}

					} else{

										echo"<script>alert('El usuario o La contrase\u00f1a no es correcta.');
										window.location.href=\"../Vista/index.php\"</script>";

							 }

     pg_close($conexion);
?>
