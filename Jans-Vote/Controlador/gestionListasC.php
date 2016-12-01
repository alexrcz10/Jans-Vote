<?php
	  include "../Modelo/gestionListasM.php";
	  include "lista.php";
	  include "candidato.php";

	 $lista = new Lista();
	 $band = "";
	 $candidato = new Candidato();
	 $divConsultarC="";

	 //datos de la imagen

 	// Lectura y escritura para el propietario, lectura para los demás
 	//chmod("/Applications/XAMPP/xamppfiles/htdocs/jans-vote/Vista/images", 0755);


 	function cargaImagen($nombreimagen)
 	{
 	//comprobamos si ha ocurrido un error.
 		if ($nombreimagen["error"] > 0){
 			?>
 				 <script language="javascript">
 				 alert("No se ha cargado ninguna imagen");
 		 //location.href ="../Vista/paginaAdmin.php";
 				 </script>
 				 <?php
 		} else {
 			//ahora vamos a verificar si el tipo de archivo es un tipo de imagen permitido.
 			//y que el tamano del archivo no exceda los 100kb
 			$permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
 			$limite_kb = 2000;
 			$nombre = $nombreimagen['name'];
 			if (in_array($nombreimagen['type'], $permitidos) && $nombreimagen['size'] <= $limite_kb * 1024){
 				//esta es la ruta donde copiaremos la imagen
 				//recuerden que deben crear un directorio con este mismo nombre
 				//en el mismo lugar donde se encuentra el archivo subir.php
 				$ruta = "../Vista/images/" . $nombreimagen['name'];
 				//comprobamos si este archivo existe para no volverlo a copiar.
 				//pero si quieren pueden obviar esto si no es necesario.
 				//o pueden darle otro nombre para que no sobreescriba el actual.
 				if (!file_exists($ruta)){
 					//aqui movemos el archivo desde la ruta temporal a nuestra ruta
 					//usamos la variable $resultado para almacenar el resultado del proceso de mover el archivo
 					//almacenara true o false
 					$resultado = copy($nombreimagen["tmp_name"],$ruta);
 					if ($resultado){
 							// $lista-> setlistaImagen($ruta);
							return $ruta;

 					//	echo "el archivo ha sido movido exitosamente";
 						?>
 							 <script language="javascript">
 							 alert("la imagen se ha subido exitosamente");
 					 //location.href ="../Vista/paginaAdmin.php";
 							 </script>
 							 <?php
 					} else {
 					//	echo "ocurrio un error al mover el archivo.";
 					?>
 						 <script language="javascript">
 						 alert("la imagen no se ha podido subir, reintente");
 				 //location.href ="../Vista/paginaAdmin.php";
 						 </script>
 						 <?php
 					}
 				} else {
 				//	echo $_FILES['imagen']['name'] . ", este archivo existe";
 					?>
 						 <script language="javascript">
 						 alert("el archivo existe, por favor cambie de nombre a su archivo. Se pondra una imagen existente");
 				 //location.href ="../Vista/paginaAdmin.php";
 						 </script>
 						 <?php
 				}
 			} else {
 				//echo "archivo no permitido, es tipo de archivo prohibido o excede el tamano de $limite_kb Kilobytes";
 				?>
 					 <script language="javascript">
 					 alert("archivo no permitido, es tipo de archivo prohibido o excede el tamano en Kilobytes. Se pondra imagen por defecto");
 			 //location.href ="../Vista/paginaAdmin.php";
 					 </script>
 					 <?php
 			}
 		}

 	}




//Insertar Listas
 //if($_POST['band']=="I"){
	 if(isset($_POST['btninsertarLista'])) {
	  $sqlIDA = cargarIdAdmin();
	  $resultIDA = pg_query ($conexion,$sqlIDA);
	  $row= pg_fetch_row($resultIDA);
	  $lista-> setadministradorId($row[0]);
	  $lista-> setlistaNombre($_POST['nombre']);
	  $lista-> setlistaSlogan($_POST['slogan']);
	  $lista-> setlistaInformacion($_POST['info']);
		$nombre=$_FILES['imagen'];
		$var=cargaImagen($nombre);

		if($var=='')
		{
			$lista->setlistaImagen("");

		}
		else {

				$lista->setlistaImagen($var);

		}
		$sqlIL = $lista ->insertar();
		$resultIL = pg_query($conexion,$sqlIL);

	if($resultIL)
    {  ?>
        <script language="javascript">
        alert("Datos Guardados Correctamente");
		location.href ="../Vista/paginaAdmin.php";
        </script>
        <?php
    } else{
        ?>
        <script language="javascript">
        alert("Error al Guardar los Datos");
		location.href= "../Vista/paginaAdmin.php";
        </script>
        <?php }
}



	//Buscar Modificar Listas
if($_POST['band']=="B"){
	$idL=$_POST['idL'];
	$sqlBL=cargarLista($idL);
	$resultBL = pg_query ($conexion,$sqlBL);
	$rowBL= pg_fetch_row($resultBL);
	$nombre = $rowBL[2];
	$slogan = $rowBL[3];
	$info = $rowBL[5];
	$imagen = $rowBL[4];
	$divModificar ="<div>
		<p><label name='label_nombre'><strong>Nombre:</strong>&nbsp;&nbsp;<input type='text' name='nombreModificar' id='nombreModificar' value='".$nombre."'/></label></p>
		<br><br>
		<p><label name='label_slogan'><strong>Slogan:</strong>&nbsp;&nbsp;		<br><br><textarea type='text' name='sloganModificar' id='sloganModificar' cols='80' rows='2'>".$slogan."</textarea></label></p>

		<p><label name='label_informacion'><strong>Información:</strong></label>
		<br><br>
		   <textarea type='text' name='infoModificar' id='infoModificar' cols='80' rows='2'>".$info."</textarea></p>
		 <br><br>
		<p><label for='imagen'><strong>Imagen: </strong>&nbsp;&nbsp;
		<img class='mini' src='".$imagen."'> <br><br>
		<input name='imagenModificar' id='imagenModificar' size='30'  type='file' /> </label></p>
		  </form>
		  </div>";

	echo $divModificar;
}

	//Modificar Lista
//	if($_POST['band']=="M"){
if(isset($_POST['btnmodificarLista'])) {
	$idL=$_POST['cbNombreModificar'];
	  $sqlIDA = cargarIdAdmin();
	  $resultIDA = pg_query ($conexion,$sqlIDA);
	  $row= pg_fetch_row($resultIDA);
	  $lista-> setadministradorId($row[0]);
	  $lista-> setlistaNombre($_POST['nombreModificar']);
	  $lista-> setlistaSlogan($_POST['sloganModificar']);
	  //$lista-> setlistaImagen("icon big rounded color5 fa-cloud");
	  $lista-> setlistaInformacion($_POST['infoModificar']);

		$nombre=$_FILES['imagenModificar'];
		$var=cargaImagen($nombre);

		if($var=='')
		{//traer el valor actual
		$sqlBL=cargarLista($idL);
		$resultBL = pg_query ($conexion,$sqlBL);
		$rowBL= pg_fetch_row($resultBL);
		$imagen = $rowBL[4];
			$lista->setlistaImagen($imagen);
			$sqlIM =  $lista ->modificar($idL);
			$resultIM = pg_query($conexion,$sqlIM);

		}

		else{
				$lista->setlistaImagen($var);
				$sqlIM =  $lista ->modificar($idL);
				$resultIM = pg_query($conexion,$sqlIM);

		}


	if($resultIM)
    {  ?>
        <script language="javascript">
        alert("Se Modificó Correctamente");
		location.href ="../Vista/paginaAdmin.php";
        </script>
        <?php
    } else{
        ?>
        <script language="javascript">
        alert("Error al Guardar los Datos");
		location.href= "../Vista/paginaAdmin.php";
        </script>
        <?php }
}

// Cargar Listas por Default

		$busEliminarLista = '***';
		$sqlLED =cargarListasEliminar($busEliminarLista);
		$resultLED = pg_query($conexion,$sqlLED);
		$divEliminar ="<table  class='titulos'>
        <tr class='headers'><th scope='col'> OPCIONES</th>
		  <th scope='col'>LISTA ID &nbsp;</th>
          <th scope='col'>NOMBRE LISTA&nbsp;</th>
        </tr></table>
				<div class='contiene_tabla'>
		<!-- tabla con scroll -->
		<table class='contenido'>";

		while($rowLED= pg_fetch_array($resultLED))
            {
				$divEliminar .=" <tr>
                <TD><a href='#' onClick='confirmation(".$rowLED[0].")'>Eliminar</a></TD>
				 <TD>".$rowLED['idlista']."</TD>
                <TD>".$rowLED['nombrelista']."</TD>
            </tr>";
            }
			 $divEliminar .="</table> </div>";

// Cargar Listas Eliminar
	if($_POST['band']=="BE"){
		$busEliminarLista = !empty($_POST['nombreBE'])  ? $_POST['nombreBE'] : '***';
		$sqlLE =cargarListasEliminar($busEliminarLista);
		$resultLE = pg_query($conexion,$sqlLE);
		$divEliminar ="<table  class='titulos'>
        <tr class='headers'><th scope='col'> OPCIONES</th>
		  <th scope='col'>LISTA ID &nbsp;</th>
          <th scope='col'>NOMBRE LISTA&nbsp;</th>
        </tr></table>
				<div class='contiene_tabla'>
		<!-- tabla con scroll -->
		<table class='contenido'>";

		while($rowLE= pg_fetch_array($resultLE))
            {
				$divEliminar .=" <tr>
                <TD><a href='#' onClick='confirmation(".$rowLE[0].")'>Eliminar</a></TD>
				 <TD>".$rowLE['idlista']."</TD>
                <TD>".$rowLE['nombrelista']."</TD>
            </tr>";
             }
			 $divEliminar .="</table></div>";
		echo $divEliminar;
	}

	//Eliminar Lista y su Candidato
	if(isset($_GET['eliminar'])){
	  $idL=$_GET['eliminar'];
		$sqlLE =$lista -> eliminar($idL);
		$resultLE = pg_query($conexion,$sqlLE);
		header("Location: ../Vista/paginaAdmin.php#ChildVerticalTab_13");
	}

	// Cargar tabla Listas por Default
		$busConsultarLista = '***';
		$sqlLC =$lista -> consultar($busConsultarLista);
		$resultLC = pg_query($conexion,$sqlLC);
		$divConsultar ="<table class='titulos'>
        <tr class='headers'><th scope='col'>LISTA ID &nbsp;</th>
          <th scope='col'>NOMBRE LISTA&nbsp;</th>
		  <th scope='col'>SLOGAN LISTA &nbsp;</th>
          <th scope='col'>INFORMACION LISTA&nbsp;</th>
        </tr></table>
				<div class='contiene_tabla'>
				<!-- tabla con scroll -->
				<table class='contenido'> ";

		while($rowLC= pg_fetch_array($resultLC))
            {
				$divConsultar .=" <tr>
				 <TD>".$rowLC['idlista']."</TD>
                <TD>".$rowLC['nombrelista']."</TD>
				<TD>".$rowLC['sloganlista']."</TD>
                <TD>".$rowLC['informacionlista']."</TD>
            </tr>";
             }
		$divConsultar .="</table></div>";

	//Consultar Listas
		if($_POST['band']=="C"){
		$busConsultarLista = !empty($_POST['nombreC'])  ? $_POST['nombreC'] : '***';
		$sqlLC =$lista -> consultar($busConsultarLista);
		$resultLC = pg_query($conexion,$sqlLC);
		$divConsultar ="<table class='titulos'>
        <tr class='headers'><th scope='col'>LISTA ID &nbsp;</th>
          <th scope='col'>NOMBRE LISTA&nbsp;</th>
		  <th scope='col'>SLOGAN LISTA &nbsp;</th>
          <th scope='col'>INFORMACION LISTA&nbsp;</th>
        </tr></table>
				<div class='contiene_tabla'>
				<!-- tabla con scroll -->
				<table class='contenido'> ";

		while($rowLC= pg_fetch_array($resultLC))
            {
				$divConsultar .=" <tr>
				 <TD>".$rowLC['idlista']."</TD>
                <TD>".$rowLC['nombrelista']."</TD>
				<TD>".$rowLC['sloganlista']."</TD>
                <TD>".$rowLC['informacionlista']."</TD>
            </tr>";
             }
			 $divConsultar .="</table></div>";
		echo $divConsultar;
	}

   //Cargar id Lista Modificar
	if ($resultNM> 0)
	{	$combobit="";
		$combobit1="<option value='***'>Ver todos</option>";
		while ($row =pg_fetch_array($resultNM))
		{
			$combobit .=" <option value='".$row['idlista']."'>".$row['idlista']."</option>";
			$combobit1 .=" <option value='".$row['idlista']."'>".$row['nombrelista']."</option>";
		}}
	else
	{echo "No hubo resultados";}


//CANDIDATOS
//insertar o agregar Candidatos
 //if($_POST['band']=="IC"){
if(isset($_POST['btninsertarCandidato'])) {
	$sqlUId=cargarUltimoIdLista();
	$resultUId = pg_query ($conexion,$sqlUId);
	$rowUId= pg_fetch_row($resultUId);
	$idL = $rowUId[0];
	  $candidato-> setlistaId($idL);
	  $candidato-> setcandidatoCedula($_POST['cedulaCandidato']);
	  $candidato-> setcandidatoNombre($_POST['nombreCandidato']);
	  $candidato-> setcandidatoApellido($_POST['apellidoCandidato']);
	  $candidato-> setcandidatoCargo($_POST['cargoCandidato']);
	  $candidato-> setcandidatoCorreo($_POST['correoCandidato']);
	  $candidato-> setcandidatoFacultad($_POST['facultadCandidato']);
	  $candidato-> setcandidatoNivel($_POST['nivelCandidato']);
		$nombre=$_FILES['imagenq'];
	  //$candidato-> setcandidatoImagen("images/profile_placeholder.gif");

	  /* insertando con jquery
	  $candidato-> setlistaId($idL);
	  $candidato-> setcandidatoCedula($_POST['cedulaCa']);
	  $candidato-> setcandidatoNombre($_POST['nombreCa']);
	  $candidato-> setcandidatoApellido($_POST['apellidoCa']);
	  $candidato-> setcandidatoCargo($_POST['cargoCa']);
	  $candidato-> setcandidatoCorreo($_POST['correoCa']);
	  $candidato-> setcandidatoFacultad($_POST['facultadCa']);
	  $candidato-> setcandidatoNivel($_POST['nivelCa']); */

		$var=cargaImagen($nombre);

		if($var=='')
		{
			$candidato->setcandidatoImagen("");

		}
		else {

				$candidato->setcandidatoImagen($var);

		}
	$sqlIC = $candidato ->insertar();
	$resultIC = pg_query($conexion,$sqlIC);


if($resultIC)
	{   ?>
        <script language="javascript">
        alert("Datos Guardados Correctamente");
		location.href ="../Vista/paginaAdmin.php";
        </script>
        <?php
    } else{
        ?>
        <script language="javascript">
        alert("Error al Guardar los Datos");
		location.href= "../Vista/paginaAdmin.php";
        </script>
        <?php }
}

//Cargar tabla de Candidatos por default
	 $busConsultarCandidato =  '***';
	 $sqlCC =$candidato -> consultarCandidatos($busConsultarCandidato);
		$resultCC = pg_query($conexion,$sqlCC);
		$divConsultarC ="<table  class='titulos' >
        <tr class='headers1'><th scope='col'> OPCIONES</th>
		<th scope='col'>NOMBRE LISTA &nbsp;</th>
          <th scope='col'>CEDULA &nbsp;</th>
		  <th scope='col'>NOMBRE &nbsp;</th>
          <th scope='col'>CARGO&nbsp;</th>
		  <th scope='col'>CORREO&nbsp;</th>
          <th scope='col'>FACULTAD&nbsp;</th>
		  <th scope='col'>NIVEL&nbsp;</th>
        </tr> </table>
				<div class='contiene_tabla'>
		<!-- tabla con scroll -->
		<table class='contenido'> ";
		while($rowCC= pg_fetch_array($resultCC))
            {
				$divConsultarC .=" <tr>
				<TD><a href='#' onClick='confirmationCandidato(".$rowCC['idcandidato'].")'>Eliminar</a></TD>
				 <TD>".$rowCC['nombrelista']."</TD>
                <TD>".$rowCC['cedulacandidato']."</TD>
				<TD>".$rowCC['nombrecandidato']." ".$rowCC['apellidocandidato']."</TD>
                <TD>".$rowCC['cargocandidato']."</TD>
                <TD>".$rowCC['correocandidato']."</TD>
				<TD>".$rowCC['facultadcandidato']."</TD>
                <TD>".$rowCC['nivelcandidato']."</TD>
            </tr>";
             }
			 $divConsultarC .="</table></div>";

//Consultar Candidatos x lista, x cedula y Eliminar
 if($_POST['band']=="CC"){
	 $busConsultarCandidato = !empty($_POST['cedulaCC'])  ? $_POST['cedulaCC'] : '***';
	 $busConsultarCandidatoxL =  $_POST['idL'];
	 if($busConsultarCandidatoxL != '***'){
		 $sqlCC =$candidato -> consultarxLista($busConsultarCandidatoxL);
	 }else {
		$sqlCC =$candidato -> consultarCandidatos($busConsultarCandidato);
	 }
		$resultCC = pg_query($conexion,$sqlCC);
		$divConsultarC ="<table  class='titulos' >
        <tr class='headers1'><th scope='col'> OPCIONES</th>
		<th scope='col'>NOMBRE LISTA &nbsp;</th>
          <th scope='col'>CEDULA &nbsp;</th>
		  <th scope='col'>NOMBRE &nbsp;</th>
          <th scope='col'>CARGO&nbsp;</th>
		  <th scope='col'>CORREO&nbsp;</th>
          <th scope='col'>FACULTAD&nbsp;</th>
		  <th scope='col'>NIVEL&nbsp;</th>
        </tr> </table>
				<div class='contiene_tabla'>
		<!-- tabla con scroll -->
		<table class='contenido'> ";
		while($rowCC= pg_fetch_array($resultCC))
            {
				$divConsultarC .=" <tr>
				<TD><a href='#' onClick='confirmationCandidato(".$rowCC['idcandidato'].")'>Eliminar</a></TD>
				 <TD>".$rowCC['nombrelista']."</TD>
                <TD>".$rowCC['cedulacandidato']."</TD>
				<TD>".$rowCC['nombrecandidato']." ".$rowCC['apellidocandidato']."</TD>
                <TD>".$rowCC['cargocandidato']."</TD>
                <TD>".$rowCC['correocandidato']."</TD>
				<TD>".$rowCC['facultadcandidato']."</TD>
                <TD>".$rowCC['nivelcandidato']."</TD>
            </tr>";
             }
			 $divConsultarC .="</table></div>";
			 echo $divConsultarC;
}

	//Eliminar Lista y su Candidato
	if(isset($_GET['eliminarCandidato'])){
	  $idC=$_GET['eliminarCandidato'];
		$sqlLE =$candidato -> eliminar($idC);
		$resultLE = pg_query($conexion,$sqlLE);
		header("Location: ../Vista/paginaAdmin.php#ChildVerticalTab_15");
	}

// Modificar Candidatos muestra en una tabla
	if($_POST['band']=="CBM"){
		$idL=$_POST['idL'];
		$sqlCB = $candidato -> consultarxLista($idL);
		$resultCB = pg_query($conexion,$sqlCB);
		$divCandidatos ="<br><table id='tablamostrarcandidatos' class='titulos'>
		  <tr class='headers2'><th scope='col'>ID &nbsp;</th>
		  <th scope='col'>CEDULA &nbsp;</th>
          <th scope='col'>NOMBRE &nbsp;</th>
		  <th scope='col'>APELLIDO &nbsp;</th>
          <th scope='col'>CARGO&nbsp;</th>
		  <th scope='col'>CORREO&nbsp;</th>
          <th scope='col'>FACULTAD&nbsp;</th>
		  <th scope='col'>NIVEL&nbsp;</th>
		  <th scope='col'>&nbsp;</th>
        </tr></table>
				<div class='contiene_tabla'>
<!-- tabla con scroll -->
<table id='tablamostrarcandidatosParte2'class='contenido'> ";

		while($rowCB= pg_fetch_array($resultCB))
            {
				$divCandidatos .=" <tr>
				 <TD>".$rowCB['idcandidato']." </TD>
				 <TD>".$rowCB['cedulacandidato']."</TD>
                <TD>".$rowCB['nombrecandidato']."</TD>
				<TD>".$rowCB['apellidocandidato']."</TD>
                <TD>".$rowCB['cargocandidato']."</TD>
                <TD>".$rowCB['correocandidato']."</TD>
				<TD>".$rowCB['facultadcandidato']."</TD>
                <TD>".$rowCB['nivelcandidato']."</TD>
				<TD><span class='editar' onclick='transformarEnEditable(this)'>Editar</span></TD>
            </tr>";
             }
			 $divCandidatos .="</table>";
		echo $divCandidatos;
	}

	//Modificar Candidatos
 if($_POST['band']=="MC"){
	 $idCandidatoM = $_POST['idCaM'];
	  $idL=$_POST['idLA'];
	  $candidato-> setlistaId($idL);
	  $candidato-> setcandidatoCedula($_POST['cedulaCaM']);
	  $candidato-> setcandidatoNombre($_POST['nombreCaM']);
	  $candidato-> setcandidatoApellido($_POST['apellidoCaM']);
	  $candidato-> setcandidatoCargo($_POST['cargoCaM']);
	  $candidato-> setcandidatoCorreo($_POST['correoCaM']);
	  $candidato-> setcandidatoFacultad($_POST['facultadCaM']);
	  $candidato-> setcandidatoNivel($_POST['nivelCaM']);
	  //$candidato-> setcandidatoImagen("images/profile_placeholder.gif");
	$sqlIC = $candidato ->modificar($idCandidatoM);
	$resultIC = pg_query($conexion,$sqlIC);
	 if($resultIC)
	{	echo "Se Modifico Correctamente";	}
	else {echo pg_result_error($resultIC)
	;}
}

//Agregar Candidato en Modificar
 if($_POST['band']=="AC"){
	  $idLA = $_POST['idLA'];
	  $candidato-> setlistaId($idLA);
	  $candidato-> setcandidatoCedula($_POST['cedulaCa']);
	  $candidato-> setcandidatoNombre($_POST['nombreCa']);
	  $candidato-> setcandidatoApellido($_POST['apellidoCa']);
	  $candidato-> setcandidatoCargo($_POST['cargoCa']);
	  $candidato-> setcandidatoCorreo($_POST['correoCa']);
	  $candidato-> setcandidatoFacultad($_POST['facultadCa']);
	  $candidato-> setcandidatoNivel($_POST['nivelCa']);

	$sqlIC = $candidato ->insertar();
	$resultIC = pg_query($conexion,$sqlIC);
	 if($resultIC)
	{	echo "Se Agrego Correctamente ";	}
	else {echo pg_result_error($resultIC);}
}
?>
