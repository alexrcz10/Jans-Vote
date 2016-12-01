<?php
      session_start();
	  include "../Modelo/conexion.php";

	  // Cargar datos bitacora
	  function consultarBitacora($cedula, $periodo){
		if($cedula=='***' )
		{
			$sql = "SELECT idbitacora, V.idvotante, V.cedulavotante, V.nombrevotante, V.apellidovotante, fecha, hora, ip
					FROM bitacora B INNER JOIN votante V ON (B.idvotante= V.idvotante)
					WHERE extract(year from fecha) = ".$periodo."
					ORDER BY idbitacora asc;";
		}else{
		$sql = "SELECT idbitacora, V.idvotante, V.cedulavotante, V.nombrevotante, V.apellidovotante, fecha, hora, ip
				FROM bitacora B INNER JOIN votante V ON (B.idvotante= V.idvotante)
				WHERE V.cedulavotante like '%".$cedula . "%' AND extract(year from fecha) = ".$periodo."
				ORDER BY idbitacora asc;" ;
	  }
	  return $sql;
	}

	  //Cargar periodo
	 $sqlPB= "SELECT distinct(extract(year from fecha)) as ano
			  FROM bitacora
			  ORDER BY ano DESC;";
	 $resultPB = pg_query ($conexion,$sqlPB);

    //Insertar en bitacora cuando el voto es blanco o nulo
    function insertarBitacora($idVotante){
      $sql="INSERT INTO bitacora(idvotante, fecha, hora, ip)  VALUES ($idVotante,current_date, current_time, inet_client_addr());";
      return $sql;

    }
//actualizar votos blancos
    function actualizarEstadistica(){
      $sql="UPDATE estadistica SET votoblanco = votoblanco+1,
votototal = votototal+1 where idestaditica=(Select max(idestaditica) from estadistica);";
      return $sql;
    }
//actualizar votos nulos
    function actualizarEstadisticaN(){
      $sql="UPDATE estadistica SET votonulo = votonulo+1,
votototal = votototal+1 where idestaditica=(Select max(idestaditica) from estadistica);";
      return $sql;
    }

    //trae datos para el mail de confirmacion
        function cargarDatosVotante($idactual){
          $sql="SELECT correovotante,nombrevotante,apellidovotante FROM votante  WHERE idvotante=$idactual;";
    			return $sql;
        }

?>
