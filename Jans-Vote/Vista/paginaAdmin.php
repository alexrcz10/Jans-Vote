<!DOCTYPE html>
<?php include("../Controlador/seguridadC.php");?>

<script type="text/javascript">
//ocultar las secciones
$(document).ready(ocultar());
</script>
<html>
<head>
<meta charset="UTF-8">
		<title>JANS-VOTE voto electronico</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<link rel="stylesheet" type="text/css" href="css/estiloAd.css " />
		<link href="css/scrolling-nav.css" rel="stylesheet">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<!--logo favicon -->
		<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
<link rel="icon" href="/favicon.ico" type="image/x-icon">


    <script src="js/jquery-1.9.1.min.js"> </script>
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="http://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
	<script src="http://jqueryvalidation.org/files/dist/additional  methods.min.js"></script>
    <script src="js/easyResponsiveTabs.js"></script>

    <style type="text/css" rel="stylesheet">
        body {
            background: #F5F5F5;
        }
        #container {
            width: 940px;
            margin: 0 auto;
        }
        @media only screen and (max-width: 768px) {
            #container {
                width: 90%;
                margin: 0 auto;
            }
        }
    </style>


	<!-- Validación -->

 <script>
jQuery.validator.setDefaults({
  debug: true,
  success: "valid"
});
jQuery.validator.addMethod("letters", function(value, element)
{
return this.optional(element) || /^[a-z ñáéíóú," "]+$/i.test(value);
}, " FORMATO INVALIDO");
jQuery.validator.addMethod("lettersNumbers", function(value, element)
{
return this.optional(element) || /^[a-z ñáéíóú," ",0-9]+$/i.test(value);
}, " FORMATO INVALIDO");
//Insertar Lista
 $(function() {
  $( "#insertarLista" ).validate({
    rules: {
	nombre:{lettersNumbers:true,
	required: true},
    },
    messages: {
	nombre:{required:" INGRESE UN NOMBRE"},
      },
          submitHandler: function(form) {
            form.submit();
        }
    });
  });
// Agregar Candidato
 $(function() {
  $( "#insertarCandidatos" ).validate({
    rules: {
	cedulaCandidato:{number: true,
	required: true,
	minlength: 10,
	maxlength: 10},
	nombreCandidato:{letters:true,
	required: true},
	apellidoCandidato:{letters:true,
	required: true},
	correoCandidato:{email: true,
	required:true},
	facultadCandidato:{lettersNumbers: true,
	required:true},
	nivelCandidato:{number: true,
	required:true},
    },
    messages: {
		cedulaCandidato:{number:" FORMATO INVALIDO",
		 required: " INGRESE CEDULA",
		 minlength:" INGRESE 10 DIGITOS",
		 maxlength:" INGRESE 10 DIGITOS"},
		nombreCandidato:{required: " INGRESE NOMBRE"},
		apellidoCandidato:{required: " INGRESE APELLIDO"},
		correoCandidato:{email: " INGRESE UN CORREO VÁLIDO",
		 required:" INGRESE CORREO"},
		facultadCandidato:{required: " INGRESE FACULTAD"},
		nivelCandidato:{number: " FORMATO INVALIDO",
		 required:" INGRESE NIVEL"},
      },
          submitHandler: function(form) {
            form.submit();
        }
    });
  });
 </script>

<?php
	$cargos = array('PRESIDENTE', 'VICEPRESIDENTE', 'CONSEJO ACADEMICO PRIMER CONSEJO PRINCIPAL', 'CONSEJO ACADEMICO PRIMER CONSEJO SUPLENTE','CONSEJO ACADEMICO SEGUNDO CONSEJO PRINCIPAL','CONSEJO ACADEMICO SEGUNDO SUPLENTE','CONSEJO SUPERIOR PRINCIPAL','CONSEJO SUPERIOR SUPLENTE','PRIMER VOCAL PRINCIPAL','PRIMER VOCAL SUPLENTE','SEGUNDO VOCAL PRINCIPAL','SEGUNDO VOCAL SUPLENTE','TERCER VOCAL PRINCIPAL','TERCER VOCAL SUPLENTE');
?>

    <!--Mostrar y quitar agregar candidatos -->
       <script type="text/javascript">


function mostrar(){
	document.getElementById('agregarCandidatos').style.display='block';
}

function ocultar(){
	document.getElementById('agregarCandidatos').style.display='none';
		document.getElementById('btnsModificar').style.display='none';
		document.getElementById('btnEliminar').style.display='none';
}
function mostrarCandidatosM(){
	document.getElementById('agregarCandidatosModificar').style.display='block';
	document.getElementById('tablamostrarcandidatos').style.display='none';
	document.getElementById('tablamostrarcandidatosParte2').style.display='none';
	document.getElementById('botonesmodificar').style.display='none';

}
function ocultarAgregarCandidato(){
document.getElementById('agregarCandidatosModificar').style.display='none';
}


function mostrarBtnModificar(){
	document.getElementById('btnsModificar').style.display='block';
}
function mostrarBtnEliminar(){
	document.getElementById('btnEliminar').style.display='block';
}
function confirmation(idreg){//Confirmacion Eliminar Lista
if(confirm('Esta seguro que desea eliminar esta lista y sus candidatos asociados?')){
location.href='../Controlador/gestionListasC.php?eliminar='+idreg;
}}
function confirmationCandidato(idreg){//Confirmacion Eliminar Candidato
if(confirm('Esta seguro que desea eliminar este candidato?')){
location.href='../Controlador/gestionListasC.php?eliminarCandidato='+idreg;
}}

var editando=false;

function transformarEnEditable(nodo){
//El nodo recibido es SPAN
if (editando == false) {
var nodoTd = nodo.parentNode; //Nodo TD
var nodoTr = nodoTd.parentNode; //Nodo TR
var nodoContenedorForm = document.getElementById('contenedorForm'); //Nodo DIV
var nodosEnTr = nodoTr.getElementsByTagName('TD');
var id = nodosEnTr[0].textContent; var cedula = nodosEnTr[1].textContent;
var nombre = nodosEnTr[2].textContent; var apellido = nodosEnTr[3].textContent;
var cargo = nodosEnTr[4].textContent; var correo = nodosEnTr[5].textContent;
var facultad = nodosEnTr[6].textContent;var nivel = nodosEnTr[7].textContent;
var opciones = nodosEnTr[8].textContent;


//Mostrar los datos en inputs q puedan ser editados
var nuevoCodigoHtml = '<TD><input type="text" name="idCandidatoM" id="idCandidatoM" value="'+id+'" readonly="readonly"</TD>'+
				 '<TD><input type="text" name="cedulaCandidatoM" id="cedulaCandidatoM" value="'+cedula+'"/></TD>'+
                '<TD><input type="text" name="nombreCandidatoM" id="nombreCandidatoM" value="'+nombre+'"/></TD>'+
				'<TD><input type="text" name="apellidoCandidatoM" id="apellidoCandidatoM" value="'+apellido+'"/></TD>'+
				//combocargo+
                '<TD><input type="text" name="cargoCandidatoM" id="cargoCandidatoM" value="'+cargo+'"/></TD>'+
                '<TD><input type="text" name="correoCandidatoM" id="correoCandidatoM" value="'+correo+'"/></TD>'+
				'<TD><input type="text" name="facultadCandidatoM" id="facultadCandidatoM" value="'+facultad+'"/></TD>'+
                '<TD><input type="text" name="nivelCandidatoM" id="nivelCandidatoM" value="'+nivel+'"/></TD> <TD>En edición</TD>';

nodoTr.innerHTML = nuevoCodigoHtml;
editando = "true";}
else {alert ('Solo se puede editar una línea. Recargue la página para poder editar otra'+ document.querySelector('#idCandidatoM').value);
}}

var id = document.querySelector('#idCandidatoM').value;
var cedula = document.querySelector('#cedulaCandidatoM').value;
var nombre = document.querySelector('#nombreCandidatoM').value;
var apellido = document.querySelector('#apellidoCandidatoM').value;
var cargo = document.querySelector('#cargoCandidatoM').value;
var correo = document.querySelector('#correoCandidatoM').value;
var facultad = document.querySelector('#facultadCandidatoM').value;
var nivel = document.querySelector('#nivelCandidatoM').value;

var idCandidatoM = document.getElementById('idCandidatoM');
var cedulaCandidatoM = document.getElementById('cedulaCandidatoM');
var nombreCandidatoM = document.getElementById('nombreCandidatoM');
var apellidoCandidatoM = document.getElementById('apellidoCandidatoM');
var cargoCandidatoM = document.getElementById('cargoCandidatoM');
var correoCandidatoM = document.getElementById('correoCandidatoM');
var facultadCandidatoM= document.getElementById('facultadCandidatoM');
var nivelCandidatoM = document.getElementById('nivelCandidatoM');

idCandidatoM.value = id;
cedulaCandidatoM.value = cedula;
nombreCandidatoM.value = nombre;
apellidoCandidatoM.value = apellido;
cargoCandidatoM.value = cargo;
correoCandidatoM.value = correo;
facultadCandidatoM.value= facultad;
nivelCandidatoM.value = nivel;

function anular(){
window.location.reload();
}
</script>

<script>
	$(document).ready( //Crud Lista
		function(){
		/*$("#btninsertarLista").click(
			function(){	$.post("/jans-vote/Controlador/gestionListasC.php",
			{
			nombrelista: $("#nombre").val(),
			sloganlista: $("#slogan").val(),
			infolista: $("#info").val(),
			imagenlista: $("#imagen").val().split('\\').pop(),
			band: "I"
			},function(res){
			alert(res);
			});});*/
		$("#btnbuscarLista").click(

			function(){$.post("/jans-vote/Controlador/gestionListasC.php",{
			idL: $("#cbNombreModificar").val(),
			band: "B"
			},function(res){
			$("#contenedor").html(res);
			}
			);}
		);
		/*$("#btnmodificarLista").click(
			function(){	$.post("/jans-vote/Controlador/gestionListasC.php",
			{
			idL: $("#cbNombreModificar").val(),
			nombrelistaM: $("#nombreModificar").val(),
			sloganlistaM: $("#sloganModificar").val(),
			infolistaM: $("#infoModificar").val(),
			band: "M"
			},function(res){
			alert(res);
			});});*/
		$("#btnbuscarListaE").click(
			function(){$.post("/jans-vote/Controlador/gestionListasC.php",{
			nombreBE: $("#nombreEliminar").val(),
			band: "BE"
			},function(res){
			$("#contenedorE").html(res);
			}
			);}
		);
		$("#btnbuscarListaC").click(
			function(){$.post("/jans-vote/Controlador/gestionListasC.php",{
			nombreC: $("#nombreConsultar").val(),
			band: "C"
			},function(res){
			$("#contenedorC").html(res);
			}
			);}
		);

		// crud Candidatos
		/*$("#btninsertarCandidato").click(
			function(){$.post("/jans-vote/Controlador/gestionListasC.php",{
			cedulaCa: $("#cedulaCandidato").val(),
			nombreCa: $("#nombreCandidato").val(),
			apellidoCa: $("#apellidoCandidato").val(),
			cargoCa: $("#cargoCandidato").val(),
			correoCa: $("#correoCandidato").val(),
			facultadCa: $("#facultadCandidato").val(),
			nivelCa: $("#nivelCandidato").val(),
			band: "IC"
			},function(res){
			alert(res);
			}
			);}
		);*/ //Buscar Candidato Consultar
		$("#btnbuscarCandidatoC").click(
			function(){$.post("/jans-vote/Controlador/gestionListasC.php",{
			cedulaCC: $("#cedulaConsultarC").val(),
			idL: $("#cbNombreConsultarC").val(),
			band: "CC"
			},function(res){
			$("#contenedorCC").html(res);
			}
			);}
		);//Buscar Candidato Modificar

		$("#btnbusmodificarCandidato").click(
			function(){$.post("/jans-vote/Controlador/gestionListasC.php",{
			idL: $("#cbNombreModificar").val(),
			band: "CBM"
			},function(res){
			$("#contenedorCM").html(res);
			$("#botonesmodificar").show();
			}
			);}
		);//Modificar Candidato Tabla
		$("#btnAceptarCandidatoM").click(
			function(){$.post("/jans-vote/Controlador/gestionListasC.php",{
			idLA:$("#cbNombreModificar").val(),
			idCaM: $("#idCandidatoM").val(),
			cedulaCaM: $("#cedulaCandidatoM").val(),
			nombreCaM: $("#nombreCandidatoM").val(),
			apellidoCaM: $("#apellidoCandidatoM").val(),
			cargoCaM: $("#cargoCandidatoM").val(),
			correoCaM: $("#correoCandidatoM").val(),
			facultadCaM: $("#facultadCandidatoM").val(),
			nivelCaM: $("#nivelCandidatoM").val(),
			band: "MC"
			},function(res){
			alert(res);
			}
			);}
		);//Agregar Candidato - Modificar Lista
		$("#btnAgregarCandidato").click(
			function(){$.post("/jans-vote/Controlador/gestionListasC.php",{
			idLA:$("#cbNombreModificar").val(),
			cedulaCa: $("#cedulaCandidatoModificar").val(),
			nombreCa: $("#nombreCandidatoModificar").val(),
			apellidoCa: $("#apellidoCandidatoModificar").val(),
			cargoCa: $("#cargoCandidatoModificar").val(),
			correoCa: $("#correoCandidatoModificar").val(),
			facultadCa: $("#facultadCandidatoModificar").val(),
			nivelCa: $("#nivelCandidatoModificar").val(),
			band: "AC"
			},function(res){
			alert(res);
			}
			);}
		);//Mostrar Bitacora
		$("#btnbuscarBitacora").click(
			function(){$.post("/jans-vote/Controlador/bitacoraC.php",{
			cedulaB: $("#cedulaBitacora").val(),
			periodoB: $("#cbPeriodoBitacora").val(),
			band: "BITACORA"
			},function(res){
			$("#contenedorBitacora").html(res);
			}
			);}
		);//Mostrar Estadistica Total
		$("#btnbuscarEstadistica").click(
			function(){$.post("/jans-vote/Controlador/estadisticaC.php",{
			periodoE: $("#cbPeriodoEstadistica").val(),
			band: "ESTADISTICA"
			},function(res){
			$("#contenedorEstadistica").html(res);
			}
			);}
		);
		//Mostrar Estadistica Detallada
		$("#btnbuscarEstadisticaD").click(
			function(){$.post("/jans-vote/Controlador/estadisticaC.php",{
			periodoED: $("#cbPeriodoEstadisticaD").val(),
			band: "ESTADISTICAD"
			},function(res){
			$("#contenedorEstadisticaD").html(res);
			}
			);}
		);//Graficar Estadistica Total
		$("#btngraficarEstadistica").click(
			function(){$.post("/jans-vote/Controlador/estadisticaC.php",{
			periodoE: $("#cbPeriodoEstadisticaG").val(),
			band: "ESTADISTICAG"
			},function(res){
			$("#contenedorEstadisticaG").html(res);
			}
			);}
		);//Graficar Estadistica Detallada por Listas
		$("#btnbuscarEstadisticaDG").click(
			function(){$.post("/jans-vote/Controlador/estadisticaC.php",{
			periodoED: $("#cbPeriodoEstadisticaDG").val(),
			band: "ESTADISTICADG"
			},function(res){
			$("#contenedorEstadisticaDG").html(res);
			}
			);}
		);//Graficar Estadistica Detallada por Cargo
		$("#btnbuscarEstadisticaDCG").click(
			function(){$.post("/jans-vote/Controlador/estadisticaC.php",{
			periodoED: $("#cbPeriodoEstadisticaDCG").val(),
			cargoED: $("#cargoCandidatoG").val(),
			band: "ESTADISTICADCG"
			},function(res){
			$("#contenedorEstadisticaDCG").html(res);
			}
			);}
		);
	}
	);
	</script>

</head>

<body>
    <div id="container">

        <h1 id="headerpa">Pagina de Administrador</h1>
				<h5>BIENVENIDO: <?php echo "&nbsp;&nbsp".strtoupper($_SESSION["usuarioactual"]); ?> </h5>

				  <a class="button special"; onclick="location.href='../Controlador/salirC.php'" >Salir</a>
        	<div id="divider">&nbsp;</div>
					<a id="home" href="index.php"><img id="imagenhome" src="images/home.png"></a>
        <br/>
        <br/>
        <br/>
        <!--Horizontal Tab-->
        <div id="parentHorizontalTab">
            <ul class="resp-tabs-list hor_1">
                <li>Gestionar listas</li>
                <li>Bitácora</li>
                <li>Estadísticas</li>
            </ul>
            <div class="resp-tabs-container hor_1">
                <div>
                    <p>
                        <!--vertical Tabs-->
                        <div id="ChildVerticalTab_1">
                            <ul class="resp-tabs-list ver_1">
                                <li>Ingresar una lista</li>
                                <li>Modificar una lista</li>
                                <li>Eliminar una lista</li>
                                <li>Consultar listas</li>
								<li>Consultar  y Eliminar Candidatos</li>
                            </ul>
                            <div class="resp-tabs-container ver_1">
                                <!--DIV INSERTAR-->
                                <div>
<form id="insertarLista" action="../Controlador/gestionListasC.php" enctype="multipart/form-data"  method="post" name="insertarLista">

   <h3 align="center">Ingresar datos de una nueva lista:</h3> <br><br>

  <p>
	  <label name="label_nombre"><strong>Nombre:</strong>&nbsp;&nbsp;<input type="text" name="nombre" id="nombre" value=""/></label>
	  <i name = "nomValid" id = "nomValid" class="fa fa-check" style="display:none"></i>
  </p>
<br><br>
	<p>
	<label name="label_slogan"><strong>Slogan: </strong>&nbsp;&nbsp;<br><br>
	<textarea type="text" name="slogan" id="slogan" cols="80" rows="2"></textarea></label>
	</p>
<br><br>
	<p>
	<label name="label_informacion"><strong>Información:</strong></label><br><br>
	<textarea type="text" name="info" id="info" cols="80" rows="2"></textarea>
	</p>
<br><br>
	<p>
	<label ><strong>Imagen: </strong>&nbsp;&nbsp;
	<input name="imagen" id="imagen" size="30"  type="file" /></label>
	</p>
<br>

	<input type="submit" name="btninsertarLista" id="btninsertarLista" value="Guardar" />
<br>

<!--BOTON PARA MOSTRAR EDICION CANDIDATOS-->
<a href="#agregarCandidatos" style="text-decoration:none">
<input type="button" class="button page-scroll" value="Agregar Candidatos" onclick="mostrar()"/></a>

</form>


                                <!-- Pagina Candidatos -->
<div id="agregarCandidatos" style="display:none">

<form action="../Controlador/gestionListasC.php" enctype="multipart/form-data" method="post" id="insertarCandidatos">
<h3 align="center">Ingresar datos de un nuevo Candidato:</h3> <br><br>

	<p>
	<label name="label_cedula"><strong>Cedula:</strong>&nbsp;&nbsp;
	<input type="text" name="cedulaCandidato" id="cedulaCandidato" value=""/></label>
	</p>
<br><br>
	<p><label name="label_nombre"><strong>Nombre: </strong>&nbsp;&nbsp;
	<input type="text" name="nombreCandidato" id="nombreCandidato" value=""/></label>
	</p>
<br><br>
	<p>
	<label name="label_apellido"><strong>Apellido:</strong></label>&nbsp;&nbsp;
	<input type="text" name="apellidoCandidato" id="apellidoCandidato" value=""/>
	</p>
<br><br>
	<p>
	<label name="label_cargo"><strong>Cargo:</strong>&nbsp;&nbsp;
	<select name="cargoCandidato" id="cargoCandidato" value = "">
        <?php foreach ($cargos as $cargo){
			echo "<option value = '".$cargo."'>".$cargo."</option>";
		}?></select></label>
	</p>
<br><br>
	<p>
	<label name="label_correo"><strong>Correo:</strong>&nbsp;&nbsp;
	<input type="text" name="correoCandidato" id="correoCandidato" value=""/></label>
	</p>
<br><br>
	<p>
	<label name="label_facultad"><strong>Facultad: </strong>&nbsp;&nbsp;
	<input type="text" name="facultadCandidato" id="facultadCandidato" value=""/></label>
	</p>
<br><br>
	<p>
	<label name="label_nivel"><strong>Nivel:</strong></label>&nbsp;&nbsp;
	<input type="text" name="nivelCandidato" id="nivelCandidato" value=""/>
	</p>
<br><br>
<p>
<label ><strong>Imagen Candidato: </strong>&nbsp;&nbsp;
<input name="imagenq" id="imagenq" size="30"  type="file" /></label>
</p>

<br><br>
	<input type="submit" name="btninsertarCandidato" id="btninsertarCandidato" value="Guardar Candidato"/>
</form>
</div>
</div>

                                <!--Modificar-->
<div id="modificarLista">
<form id="modificarLista"  enctype="multipart/form-data" action="../Controlador/gestionListasC.php" method="post" name="modificarLista">
<h3 align="center">Modificar datos de una lista:</h3>
<br><br>

	<p>
	<label name="label_nombre"><strong>Seleccione la lista:</strong>&nbsp;&nbsp;
	<select name="cbNombreModificar" id="cbNombreModificar" value = "" onchange="btnbuscarLista.click()">
		<option selected>Escoja una lista</option>
        <?php require_once ("../Controlador/gestionListasC.php");
		echo $combobit; ?>
	</select>
	<input type="button" style="display:none" name="btnbuscarLista" id="btnbuscarLista" value="Buscar" onclick="mostrarBtnModificar()"/></label>
	</p>
<br><br>
	<p id = "contenedor"> </p>

	<div id = "btnsModificar" style="display:none">
	<br><input type='submit' name='btnmodificarLista' id='btnmodificarLista' value='Guardar'/> <br>

	<a href="#agregarCandidatosModificar" style="text-decoration:none">
	<input type='button' name='agreagarCandidato' id='agreagarCandidato' value='Agregar Candidato' onclick="mostrarCandidatosM()"/></a><br>

	<!--Eventos de display-->
	<input type='button' name='btnbusmodificarCandidato' id='btnbusmodificarCandidato' onclick="ocultarAgregarCandidato()" value='Modificar Candidatos'/><br>

		  </form>
		  </div> <p id = "contenedorCM"> </p>
		  <div id="contenedorForm"></div>

		  <div id = "botonesmodificar" style="display:none">
		  <input type="hidden" name="idCandidatoM" value="">
		  <input type="hidden" name="cedulaCandidatoM" value="">
		  <input type="hidden" name="nombreCandidatoM" value="">
		  <input type="hidden" name="apellidoCandidatoM" value="">
		  <input type="hidden" name="cargoCandidatoM" value="">
		  <input type="hidden" name="correoCandidatoM" value="">
		  <input type="hidden" name="facultadCandidatoM" value="">
		  <input type="hidden" name="nivelCandidatoM" value="">
		   <p>'Pulse Aceptar para guardar los cambios o cancelar para anularlos'</p>
			<input type='button' name='btnAceptarCandidatoM' id='btnAceptarCandidatoM' value="Aceptar"> <br> <input type="button" name='btnCancelarCandidatoM' id='btnCancelarCandidatoM' value="Cancelar" onclick = "anular()">
		  </div>

	<div id="agregarCandidatosModificar" style="display:none">
	<form action="../Modelo/inicioSesionM.php" method="post" id="insertarCandidatosM">
	<h3 align="center">Ingresar datos de un nuevo Candidato:</h3> <br><br>

	  <p><label name="label_cedula"><strong>Cedula:</strong>&nbsp;&nbsp;<input type="text" name="cedulaCandidatoModificar" id="cedulaCandidatoModificar" value=""/></label></p>
	<br><br>

	<p><label name="label_nombre"><strong>Nombre: </strong>&nbsp;&nbsp;<input type="text" name="nombreCandidatoModificar" id="nombreCandidatoModificar" value=""/></label></p>
	<br><br>

	<p><label name="label_apellido"><strong>Apellido:</strong></label>&nbsp;&nbsp;
	   <input type="text" name="apellidoCandidatoModificar" id="apellidoCandidatoModificar" value=""/></p>
	 <br><br>
	<p><label name="label_cargo"><strong>Cargo:</strong>&nbsp;&nbsp;  <select name="cargoCandidatoModificar" id="cargoCandidatoModificar" value = "">
        <?php foreach ($cargos as $cargo){
			echo "<option value = '".$cargo."'>".$cargo."</option>";
		}?></select></label></p>
	<br><br>
	<p><label name="label_cargo"><strong>Correo:</strong>&nbsp;&nbsp;<input type="text" name="correoCandidatoModificar" id="correoCandidatoModificar" value=""/></label></p>
	<br><br>
	<p><label name="label_facultad"><strong>Facultad: </strong>&nbsp;&nbsp;<input type="text" name="facultadCandidatoModificar" id="facultadCandidatoModificar" value=""/></label></p>
	<br><br>

	<p><label name="label_nivel"><strong>Nivel:</strong></label>&nbsp;&nbsp;<input type="text" name="nivelCandidatoModificar" id="nivelCandidatoModificar" value=""/></p>
	 <br><br>
	   <p><label for="imagenCModificar"><strong>Imagen: </strong>&nbsp;&nbsp;
	<input name="imagenCModificar" id="imagenCModificar" size="30"  type="file" /> </label></p>
	<br> <br>
	<input type="button" name="btnAgregarCandidato" id="btnAgregarCandidato" value="Guardar Candidato"/>
	</form>
	</div>
	</div>
                                   <!--Eliminar-->
                                <div id="eliminarLista">
                                    <form id="eliminar"  enctype="multipart/form-data" action="" method="post" name="formulario1">

   <h3 align="center">Eliminar una lista:</h3> <br>
   <br>

  <p><label name="label_nombre"><strong>Nombre:</strong>&nbsp;&nbsp;<input type="text" name="nombreEliminar" id="nombreEliminar" value=""/>&nbsp;
  <input type="button" name="btnbuscarListaE" id="btnbuscarListaE" value="Buscar" onclick="mostrarBtnEliminar()"/>
    &nbsp;</label>
  </p>
<br><br> <div id = "contenedorE"> <?php echo $divEliminar;?></div>
	<div id = "btnEliminar" style="display:none">
		<br>
		  </form>
		  </div>
                                </div>


                                 <!--Consultar-->
                                <div id="consultarLista">
                                    <form id="consultar"  enctype="multipart/form-data" action="" method="post" name="formulario1">

   <h3 align="center">Consultar lista:</h3> <br>
   <br>

  <p><label name="label_nombre"><strong>Nombre:</strong>&nbsp;&nbsp;<input type="text" name="nombreConsultar" id="nombreConsultar" value=""/>&nbsp;
  <input type="button" name="btnbuscarListaC" id="btnbuscarListaC" value="Buscar" />
    &nbsp;</label>
  </p>
<br><br> <div id = "contenedorC"> <?php echo $divConsultar;?></div>
		  </form>
                                </div>
								<!--Consultar Candidatos-->
                                <div id="consultarCandidatos">
                                    <form id="consultar"  enctype="multipart/form-data" action="" method="post" name="formulario1">

   <h3 align="center">Consultar Candidatos:</h3> <br>
   <br>

  <p><label name="label_nombre"><strong>Por Cedula:</strong>&nbsp;&nbsp;<input type="text" name="cedulaConsultarC" id="cedulaConsultarC" value=""/>&nbsp;<br><br>
   <p><label name="label_nombre"><strong>Por Lista:</strong>&nbsp;&nbsp;

		 <select name="cbNombreConsultarC" id="cbNombreConsultarC" value = "" ></br>
       </br> <?php require_once ("../Controlador/gestionListasC.php");
		echo $combobit1; ?></select></br>
   <br><input type="button" name="btnbuscarCandidatoC" id="btnbuscarCandidatoC" value="Ver Candidato/s" />
    &nbsp;</label>
  </p>
<br><br> <div id = "contenedorCC"> <?php echo $divConsultarC;?></div>
		  </form>
                                </div>

                            </div>
                        </div>
                    </p>
                    <p>Gestionar Listas</p>
                </div>
                <div>
                   <h3 align="center">Bitacora:</h3> <br>
   <br>

  <p><label name="label_cedula"><strong>Cedula:</strong>&nbsp;&nbsp;<input type="text" name="cedulaBitacora" id="cedulaBitacora" value=""/>&nbsp;</label>
  <br><br><label name="label_periodo"><strong>Período:</strong>&nbsp;&nbsp;</label>
    <select name="cbPeriodoBitacora" id="cbPeriodoBitacora" value = "" >
        <?php require_once ("../Controlador/bitacoraC.php");
		echo $comboperiodo; ?>
	</select>
 </br>
 <input type="button" name="btnbuscarBitacora" id="btnbuscarBitacora" value="Buscar" />

  </p>
  <br><br> <p id = "contenedorBitacora"> </p>
                    <p>BITACORA</p>
                </div>
                <div>
				<!--vertical Tabs-->
                        <div id="ChildVerticalTab_3">
                            <ul class="resp-tabs-list ver_3">
                                <li>Datos</li>
                                <li>Gráficos</li>
																<li>Emitir Resultados</li>
                            </ul>
                            <div class="resp-tabs-container ver_3">

							<!--DATOS-->
							<div id = "DatosEstadistica">

								<form id="datosEstadisticaF"  enctype="multipart/form-data" action="" method="post" name="datosEstadisticaF">
								<h3 align="center">Datos Estadísticos:</h3> <br>
								<h3 align="center">Totales:</h3>
								<label name="label_periodo"><strong>Período:</strong>&nbsp;&nbsp;</label>
								<select name="cbPeriodoEstadistica" id="cbPeriodoEstadistica" value = "" ></br>
							    </br> <?php require_once ("../Controlador/estadisticaC.php");
								echo $comboperiodoE; ?></select>
								<input type="button"  name="btnbuscarEstadistica" id="btnbuscarEstadistica" value="Buscar"/></br>
								<p id = "contenedorEstadistica"></p>

								<br><h3 align="center">Detallados:</h3>
								<label name="label_periodo"><strong>Período:</strong>&nbsp;&nbsp;</label>
								<select name="cbPeriodoEstadisticaD" id="cbPeriodoEstadisticaD" value = "" ></br>
							    </br> <?php require_once ("../Controlador/estadisticaC.php");
								echo $comboperiodoE; ?></select>

								<input type="button"  name="btnbuscarEstadisticaD" id="btnbuscarEstadisticaD" value="Buscar"/></br>
								<p id = "contenedorEstadisticaD"></p>

								</form>

							</div>
							<!--GRAFICOS-->
								<div id = "GraficosEstadistica">
								<form id="graficosEstadisticaF"  enctype="multipart/form-data" action="" method="post" name="graficosEstadisticaF">
								<h3 align="center">Gráficos:</h3> <br>
								<h3 align="center">Totales:</h3>
								<label name="label_periodo"><strong>Período:</strong>&nbsp;&nbsp;</label>
								<select name="cbPeriodoEstadisticaG" id="cbPeriodoEstadisticaG" value = "" ></br>
							    </br> <?php require_once ("../Controlador/estadisticaC.php");
								echo $comboperiodoE;
								?></select>
								<input type="button"  name="btngraficarEstadistica" id="btngraficarEstadistica" value="Graficar"/></br>
								<p id = "contenedorEstadisticaG" name = "contenedorEstadisticaG"></p>

								<br><h3 align="center">Detallados:</h3>
								<label><strong>Por Lista:</strong>&nbsp;&nbsp;</label><br>
								<label name="label_periodo"><strong>Período:</strong>&nbsp;&nbsp;</label>
								<select name="cbPeriodoEstadisticaDG" id="cbPeriodoEstadisticaDG" value = "" ></br>
							    </br> <?php require_once ("../Controlador/estadisticaC.php");
								echo $comboperiodoE; ?></select>

								<input type="button"  name="btnbuscarEstadisticaDG" id="btnbuscarEstadisticaDG" value="Graficar"/></br>
								<p id = "contenedorEstadisticaDG"></p>

								<label><strong>Por Cargo:</strong>&nbsp;&nbsp;</label><br>
								<label name="label_periodo"><strong>Período:</strong>&nbsp;&nbsp;</label>
								<select name="cbPeriodoEstadisticaDCG" id="cbPeriodoEstadisticaDCG" value = "" ></br>
							    </br> <?php require_once ("../Controlador/estadisticaC.php");
								echo $comboperiodoE; ?></select>
								<p>
								<label name="label_cargo"><strong>Cargo:</strong>&nbsp;&nbsp;
								<select name="cargoCandidatoG" id="cargoCandidatoG" value = "">
									<option value = "PRESIDENTE">PRESIDENTE Y VICEPRESIDENTE</option>
									<option value = "CONSEJO SUPERIOR PRINCIPAL">CONSEJO SUPERIOR PRINCIPAL Y SUPLENTE</option>
									<option value = "CONSEJO ACADEMICO PRIMER CONSEJO PRINCIPAL">PRIMER CONSEJO ACADEMICO PRINCIPAL Y SUPLENTE</option>		<option value = "CONSEJO ACADEMICO SEGUNDO CONSEJO PRINCIPAL">SEGUNDO CONSEJO ACADEMICO PRINCIPAL Y SUPLENTE</option>
									<option value = "PRIMER VOCAL PRINCIPAL">PRIMER VOCAL PRINCIPAL Y SUPLENTE</option>
									<option value = "SEGUNDO VOCAL PRINCIPAL">SEGUNDO VOCAL PRINCIPAL Y SUPLENTE</option>
									<option value = "TERCER VOCAL PRINCIPAL">TERCER VOCAL PRINCIPAL Y SUPLENTE</option>
								</select></label>
								<input type="button"  name="btnbuscarEstadisticaDCG" id="btnbuscarEstadisticaDCG" value="Graficar"/></br>
								<p id = "contenedorEstadisticaDCG"></p>
								</p>
								</form>
								</div>


								<!--EMITIR RESULTADOS-->
									<div id = "EmitirResultadosEstadistica">
											<br><h3 align="center">Emisión de resultados</h3>
									<!--<center><input type="button" name="Emitir Resultados" value="Finalizar Votaciones" onclick="mostrarResultados()"></></center>
									--><img  src="../Controlador/pdf/jans.png" id="imgJans"></>
									<img  src="../Controlador/pdf/feuce.jpg" id="imgFeuce"></><br><br><br>
									<a href="../Controlador/pdf/resultados.php">Visualizar PDF</a>
									</div>


							</div>
							</div>
                  ESTADISTICAS
                </div>
            </div>
        </div>
        </div>

	<!--Plug-in Initialisation-->
	<script type="text/javascript">
    $(document).ready(function() {
        //Horizontal Tab
        $('#parentHorizontalTab').easyResponsiveTabs({
            type: 'default', //Types: default, vertical, accordion
            width: 'auto', //auto or any width like 600px
            fit: true, // 100% fit in a container
            tabidentify: 'hor_1', // The tab groups identifier
            activate: function(event) { // Callback function if tab is switched
                var $tab = $(this);
                var $info = $('#nested-tabInfo');
                var $name = $('span', $info);
                $name.text($tab.text());
                $info.show();
            }
        });

        // Child Tab Gestionar Listas
        $('#ChildVerticalTab_1').easyResponsiveTabs({
            type: 'vertical',
            width: 'auto',
            fit: true,
            tabidentify: 'ver_1', // The tab groups identifier
            activetab_bg: '#fff', // background color for active tabs in this group
            inactive_bg: '#F5F5F5', // background color for inactive tabs in this group
            active_border_color: '#c1c1c1', // border color for active tabs heads in this group
            active_content_border_color: '#5AB1D0' // border color for active tabs contect in this group so that it matches the tab head border
        });

		  // Child Tab Estadísticas
        $('#ChildVerticalTab_3').easyResponsiveTabs({
            type: 'vertical',
            width: 'auto',
            fit: true,
            tabidentify: 'ver_3', // The tab groups identifier
            activetab_bg: '#fff', // background color for active tabs in this group
            inactive_bg: '#F5F5F5', // background color for inactive tabs in this group
            active_border_color: '#c1c1c1', // border color for active tabs heads in this group
            active_content_border_color: '#5AB1D0' // border color for active tabs contect in this group so that it matches the tab head border
        });
    });
</script>
</body>
</html>
