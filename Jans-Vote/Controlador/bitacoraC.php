<?php
	  include "../Modelo/bitacoraM.php";
	  
//	if($_POST['band']=="VOTOBLANCO"){
	if(isset($_GET['blanco'])){
	//bitacora
	  $idVotante= $_SESSION["idactual"];
		$sql=insertarBitacora($idVotante);
			$result = pg_query($conexion, $sql) ;
				pg_free_result($result);
	//estadistica
	$sql=actualizarEstadistica();
		$result = pg_query($conexion, $sql) ;
			pg_free_result($result);
//			echo $sql1;
//enviar mail de confirmación
			  $sql=cargarDatosVotante($idVotante);
			  $result = pg_query($conexion, $sql) ;
			  $row=pg_fetch_row($result);
			  $para=$row[0];
			  $nombre=$row[1];
			  $apellido=$row[2];

			  //Comprobacion del correo
			$cadena_buscada   = '@';
			$posicion_coincidencia = strpos($para, $cadena_buscada);
			//saltos de linea
			$salto="\r\n\r\n";

			//se puede hacer la comparacion con 'false' o 'true' y los comparadores '===' o '!=='
			if ($posicion_coincidencia === false) {
			    echo "porfavor actualice su correo a uno valido.";
			    } else {
			            echo "Gracias por utilizar Jans-Vote, se enviará un correo a su direccion proporcionada";

			            $titulo    = strtoupper($nombre)." ".strtoupper($apellido).',Su votación a concluido con Exito!!';
			            $mensaje   = 'Este es el documento que avala la participación en este sufragio.'.$salto;
			            $mensaje.='GRACIAS POR CONFIAR EN JANS-VOTE'.$salto;
			            $mensaje.='Si tiene algun inconveniente, favor comunicarse con: stephanie_gar15@hotmail.com';

			            // Cabeceras adicionales
			            $cabeceras = 'To: '."\r\n";
			            $cabeceras .= 'From: MAIL DE CONFIRMACIÓN <stephanie_gar15@hotmail.com>' ."\r\n";
			            //$cabeceras .= 'Cc: birthdayarchive@example.com' . "\r\n";

			            mail($para, $titulo, $mensaje, $cabeceras);
			            }

header("Location: ../Controlador/SalirC.php");
	}


//	if($_POST['band']=="VOTONULO"){
	if(isset($_GET['nulo'])){	
//bitacora
	  $idVotante= $_SESSION["idactual"];
		$sql=insertarBitacora($idVotante);
			$result = pg_query($conexion, $sql) ;
				pg_free_result($result);
				echo $sql;
//estadistica
	$sql=actualizarEstadisticaN();
		$result = pg_query($conexion, $sql) ;
			pg_free_result($result);
			//echo $sql1;


//enviar mail de confirmación
			  $sql=cargarDatosVotante($idVotante);
			  $result = pg_query($conexion, $sql) ;
			  $row=pg_fetch_row($result);
			  $para=$row[0];
			  $nombre=$row[1];
			  $apellido=$row[2];

			  //Comprobacion del correo
			$cadena_buscada   = '@';
			$posicion_coincidencia = strpos($para, $cadena_buscada);
			//saltos de linea
			$salto="\r\n\r\n";

			//se puede hacer la comparacion con 'false' o 'true' y los comparadores '===' o '!=='
			if ($posicion_coincidencia === false) {
			    echo "porfavor actualice su correo a uno valido.";
			    } else {
			            echo "Gracias por utilizar Jans-Vote, se enviará un correo a su direccion proporcionada";

			            $titulo    = strtoupper($nombre)." ".strtoupper($apellido).',Su votación a concluido con Exito!!';
			            $mensaje   = 'Este es el documento que avala la participación en este sufragio.'.$salto;
			            $mensaje.='GRACIAS POR CONFIAR EN JANS-VOTE'.$salto;
			            $mensaje.='Si tiene algun inconveniente, favor comunicarse con: stephanie_gar15@hotmail.com';


			            // Cabeceras adicionales
			            $cabeceras = 'To:'."\r\n";
			            $cabeceras .= 'From: MAIL DE CONFIRMACIÓN <stephanie_gar15@hotmail.com>' ."\r\n";
			            //$cabeceras .= 'Cc: birthdayarchive@example.com' . "\r\n";

			            mail($para, $titulo, $mensaje, $cabeceras);
			            }
header("Location: ../Controlador/SalirC.php");
	}


//Mostrar tabla con las bitacoras
		if($_POST['band']=="BITACORA"){
		$cedula = !empty($_POST['cedulaB'])  ? $_POST['cedulaB'] : '***';
		$periodo = $_POST['periodoB'];
		$sqlB =consultarBitacora($cedula, $periodo);
		$resultB = pg_query($conexion,$sqlB);
		$divBitacora ="<table class='titulos'>
        <tr class='headers'>
		  <th scope='col'>ID &nbsp;</th>
          <th scope='col'>NOMBRE &nbsp;</th>
		  <th scope='col'>CEDULA &nbsp;</th>
          <th scope='col'>FECHA &nbsp;</th>
          <th scope='col'>HORA &nbsp;</th>
		  <th scope='col'>IP &nbsp;</th>
        </tr></table>
				<div class='contiene_tabla'>
		<!-- tabla con scroll -->
		<table class='contenido'> ";

		while($rowB= pg_fetch_array($resultB))
            {
				$divBitacora .=" <tr>
                <TD>".$rowB['idbitacora']."</TD>
				<TD>".$rowB['nombrevotante']." ".$rowB['apellidovotante']."</TD>
                <TD>".$rowB['cedulavotante']."</TD>
                <TD>".$rowB['fecha']."</TD>
				<TD>".$rowB['hora']."</TD>
                <TD>".$rowB['ip']."</TD>
            </tr>";
             }
			 $divBitacora .="</table>";
		echo $divBitacora;
	}
	//Cargar Periodos
	if ($resultPB> 0)
	{	$comboperiodo="";

		while ($row=pg_fetch_array($resultPB))
		{
			$comboperiodo .=" <option value='".$row[0]."'>".$row[0]."</option>";
		}}
	else
	{echo "No hubo resultados";}
?>
