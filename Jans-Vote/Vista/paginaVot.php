<!DOCTYPE html>
<? include("../Controlador/seguridadC.php");
error_reporting(E_ALL ^ E_NOTICE);//desactiva notice ?>
<html>
<head>
<meta charset="UTF-8">
		<title>JANS-VOTE voto electronico</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
    <link rel="stylesheet" type="text/css" href="css/estilosVot.css " />
    <script src="js/jquery-1.9.1.min.js"></script>
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="js/easyResponsiveTabs.js"></script>
		<!--logo favicon -->
		<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
<link rel="icon" href="/favicon.ico" type="image/x-icon">

		<script src="js/skel.min.js"></script>
		<script src="js/skel-layers.min.js"></script>
		<script src="js/init.js"></script>

		<script languaje="javascript">
		var a=[];//manda el ultimo candidato por cada carton de voto

		//funcion para deshabilitar un candidato si ya se selecciono uno anteriormente

		function habilitaDeshabilita(variable,id)
		{
			if(variable==1)
			{
				a[0]=id;
							document.getElementById(variable).style.display='none';

			}
			if(variable==2)
			{
				a[1]=id;
							document.getElementById(variable).style.display='none';
			}
			if(variable==3)
			{
				a[2]=id;
							document.getElementById(variable).style.display='none';
			}
			if(variable==4)
			{
				a[3]=id;
							document.getElementById(variable).style.display='none';
			}
			if(variable==5)
			{
				a[4]=id;
							document.getElementById(variable).style.display='none';
			}
			if(variable==6)
			{
				a[5]=id;
							document.getElementById(variable).style.display='none';
			}
			if(variable==7)
			{
				a[6]=id;
							document.getElementById(variable).style.display='none';
			}

			function confirma(variable)
			{
					document.getElementById("FinalizarVotacion").style.display='none';

			}

		}
		function myFunction()
		{
						document.getElementById(3).style.display='none';
		}

		// //Confirmacion Finalizar Votación
		// function confirmacionVoto(idreg){
		// if(confirm('Esta seguro que desea finalizar la votación?')){
		// location.href='../Controlador/gestionVotoC.php?idCandidato='+idreg;
		// }else{location.href='../Vista/paginaVot.php';}}
		//
		// //Confirmacion Voto Blanco
		// function confirmacionBlanco(id){
		// if(confirm('Esta seguro que desea finalizar la votación?')){
		// location.href='../Controlador/bitacoraC.php?blanco='+id;
		// }else{location.href='../Vista/paginaVot.php';}}
		//
		// //Confirmacion Voto Nulo
		// function confirmacionNulo(id){
		// if(confirm('Esta seguro que desea finalizar la votación?')){
		// location.href='../Controlador/bitacoraC.php?nulo='+id;
		// }else{location.href='../Vista/paginaVot.php';}}
		//
		// </script>
		<script>


		$(document).ready(
			function(){
				//finalizar votacion
			/*	$("#FinalizarVotacion").click(
					function(){$.post("/jans-vote/Controlador/gestionVotoC.php",{
						band: "votar",
						idCandidato:a
					},function(res){
					alert(res);
				}
				);}
					);*/

//voto blanco
		/*$("#votoBlanco").click(
			function(){
		$.post("/jans-vote/Controlador/bitacoraC.php",{
				band: "VOTOBLANCO"
			},function(res){
					//$("#two").hide();
			alert(res);
		}
		);}
		);*/

	//voto nulo
	/*$("#votoNulo").click(
	function(){
		$.post("/jans-vote/Controlador/bitacoraC.php",{
				band: "VOTONULO"
			},function(res){
				//	$("#two").hide();
			alert(res);
		}
		);}
		);*/



		});//fin .ready

				</script>


</head>

<body class="landing">
	<header id="header">
		<nav id="nav">
			<ul>
				<a class="site-name"style="text-decoration:none" href=""> Pagina para Votación</a> <!-- / #logo-header -->
<br>
<hr>
					<h5>BIENVENIDO: <?php echo "&nbsp;&nbsp".strtoupper($_SESSION["usuarioactual"]); ?> </h5><hr>
					<a id="home" href="index.php"><img id="imagenhome" src="images/home.png"></a><br><hr>
					<a id="salir"  style="text-decoration: none" onclick="location.href='../Controlador/salirC.php'" >Salir</a><hr>

			</ul>



		</nav>
		<hr>

	</header>

<!-- / #main-header -->
			<header id="main-header">
					<a class="site-name"style="text-decoration:none" href=""> Pagina para Votación</a> <!-- / #logo-header -->

					<nav>
						<ul>
							<Li><h5>BIENVENIDO: <?php echo "&nbsp;&nbsp".strtoupper($_SESSION["usuarioactual"]); ?> </h5></li>
							<li><a id="home" href="index.php"><img id="imagenhome" src="images/home.png"></a></li>
							<li><a style="text-decoration: none" onclick="location.href='../Controlador/salirC.php'" >Salir</a></li>
						</ul>
					</nav><!-- / nav -->

				</header><!-- / #main-header -->

				<!-- Candidatos -->
				<section id="two" class="wrapper style2 special">
					<div class="container">
										<?php
										require_once ("../Controlador/gestionVotoC.php");
										echo $divC;
										?>
					</div>
				</section>
					<?php
					require_once ("../Controlador/gestionVotoC.php");
					echo $divF;
					?>
				</section>
    </body>
    </html>
