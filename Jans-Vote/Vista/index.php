<!DOCTYPE html>

<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>JANS-VOTE voto electronico</title>

		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<!--logo favicon -->
		<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
<link rel="icon" href="/favicon.ico" type="image/x-icon">

		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<script src="js/jquery.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-layers.min.js"></script>
		<script src="js/init.js"></script>
         <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->

      <noscript>
			<link rel="stylesheet" href="css/skel.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-xlarge.css" />
		</noscript>

<!--Mostrar y quitar capa login -->
       <script type="text/javascript">

function mostrar(){
	document.getElementById('flotante').style.display='block';
}
function ocultar(){
	document.getElementById('flotante').style.display='none';
}

function direccionarAD(){
	location.href="../Vista/paginaAdmin.php";}

	function direccionarVO(){
location.href="../Vista/paginaVot.php";}
</script>

         <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Scrolling Nav JavaScript -->
    <script src="js/jquery.easing.min.js"></script>
    <script src="js/scrolling-nav.js"></script>


	</head>
    <?php
							error_reporting(E_ALL ^ E_NOTICE);//desactiva notice
              include "../Controlador/mostrarInformacionC.php";
						//	define ('SITE_ROOT', realpath(dirname(__FILE__)));//path absoluto
	?>

	<body class="landing">
		<!-- Header -->
			<header id="header">
				<nav id="nav">
					<ul>
		<!-- Comprobacion lOGIN -->
						<?php
						@session_start();
							if($_SESSION["prueba"]!="SIP"){
								echo "<li><a onClick='mostrar();' class='button special'>Iniciar Sesión</a></li>";
							}
						else
								{
									if($_SESSION["quees"] == "Adm")
								{echo "<li><a onClick= 'direccionarAD()' class='button special'>Pagina administrador</a></li>
											<li><a onClick= 'direccionarVO()' style=display:none class='button special'>Pagina Votante</a></li>";
									}
									if($_SESSION["quees"] == "vot")
								{echo "<li><a onClick= 'direccionarVO()'  class='button special'>Pagina Votante</a></li>
									<li><a onClick= 'direccionarAD()'  style=display:none class='button special'>Pagina administrador</a></li>
									";
									}
								}
						?>
					</ul>
				</nav>
			</header>

		<!-- Banner -->
			<section id="banner">
				<h2>JANS-VOTE</h2>
				<p>Bienvenidos al Sitio Web para Votación Electrónica de la FEUCE</p>
				<ul class="actions">
					<li>
						<a href="#inf" class="button big page-scroll">Conoce más</a>
					</li>
				</ul>
			</section>
<!-- Antecedentes -->
			<section id="inf" class="wrapper style2 special">
          <div class="container">
           <header class="major"> <p>Durante nuestros años como estudiantes de la PUCE hemos ejercido nuestro derecho al voto siguiendo el proceso habitual de votación electoral que se maneja en el Ecuador, el cual tiene como aspectos negativos, la ineficiencia en el conteo de los votos, el daño ambiental ocasionado por el uso de una gran cantidad de papel, entre otros.
Por esta razón nos hemos motivado a realizar una automatización de este proceso brindando una forma accesible, eficiente, segura y amigable con el medio ambiente.
</p></header></div>
            </section>

		<!-- Listas postulantes -->
			<section id="listas" class="wrapper style1 special">
				<div class="container">
					<header class="major">
						<h2>LISTAS POSTULANTES</h2>
						<p>Conoce más acerca de las Listas</p>
					</header>
				<div class="row 50%">
                <?php
                echo $divLP;
                ?>
					</div>
				</div>
			</section>

		<!-- Candidatos -->
			<section id="candidatos" class="wrapper style2 special">
				<div class="container">
					<header class="major">
						<h2>CANDIDATOS</h2>
						<p>Aqui podrás conocer los candidatos de cada lista</p>
					</header>
									<?php echo $divC;?>
				</div>
			</section>


		<!-- Footer -->
			<footer id="footer">
				<div class="container">
					<section class="links">
						<div class="row">
							<section class="3u 6u(medium) 12u$(small)">
								<br>
								<a href="http://www.feuce.ec"><img style="width:150px;  " src="../Controlador/pdf/feuce1.png"  ></></a>
								<br>
									<li><a href="http://www.feuce.ec/bolsa-de-empleos/">Bolsa de empleos</a></li>
									<li><a href="http://www.feuce.ec/cronograma-de-actividades/">Cronograma de actividades</a></li>
									<li><a href="http://www.feuce.ec/galeria-de-imagenes/">Galeria de imagenes</a></li>

							</section>
							<section class="3u 6u(large) 12u$(small)">
								<a href="http://www.puce.edu.ec"><img style="width:300px; height:80px;" src="../Controlador/pdf/puce.png"  ></></a>
<br>
									<li><a href="http://www.puce.edu.ec/portal/content/P%C3%A1gina%20principal%20PUCEVirtual/345?link=oln30.redirect">Puce Virtual</a></li>
									<li><a href="http://www.puce.edu.ec/intranet/">Intranet / Mail </a></li>

							</section>
							<section class="3u$ 6u$(medium) 12u$(small)">
								<h3>VISUALIZAR LOS RESULTADOS</h3>
										<li><a href="../Controlador/pdf/resultados.php">PDF Votaciones</a></li>
										<br>
								<li><a href="#header" class="page-scroll">Inicio</a></li>
								<li><a href="#listas"class="page-scroll">Conoce las Listas</a></li>
								<li><a href="#candidatos"class="page-scroll">Conoce sus Candidatos</a></li>


								</ul>
							</section>
						</div>
					</section>
					<div class="row">
						<div class="8u 12u$(medium)">
							<ul class="copyright">
								<li>&copy; 2016•TODOS LOS DERECHOS RESERVADOS•</li>
								<li>Design: <a href="http://templated.co">TEMPLATED</a></li>
							</ul>
						</div>
						<div class="4u$ 12u$(medium)">
							<ul class="icons">
								<li>
									<a href="https://www.facebook.com/Feuce-Q-792578187487689/?fref=ts"class="icon rounded fa-facebook"><span class="label">Facebook</span></a>
								</li>
								<li>
									<a href="https://twitter.com/search?q=FeuceQ"class="icon rounded fa-twitter"><span class="label">Twitter</span></a>
								</li>

							</ul>
						</div>
					</div>
				</div>

			</footer>
<!-- Ventana emergente login-->
<div id="flotante" style="display:none">Ventana de Inicio de Sesión:
<img src="images/cerrar.png"  onClick="ocultar();"  style="position: absolute; top: 0; right: 0; cursor: pointer;" />
<form action="../Modelo/inicioSesionM.php" method="post" id="form1">
<table class="tablalog" style="border:"0"; width: 100%">

<tr>
<td width="50" align="center">Usuario</td>
<td>
<input type="text" name="usuario"  id="usuario" size="10"/> </td>
</tr>
<tr>
<td align="center">Contraseña</td>
<td>
<input  type="password" name="contrasena" id="contrasena" size="10"/> </td>
</tr>

<tr>

<td align="center"></td>
<td width="50">
<input type="submit"  value="Entrar"/> </td>
</tr>
</table>
</form>
</div>
	</body>
</html>
