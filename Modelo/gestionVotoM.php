<?php
  session_start();
	  include "../Modelo/conexion.php";

//Cargar Listas Postulantes
      function cargarListas(){
      $sql="SELECT idlista, nombrelista, sloganlista, imagenlista FROM lista order by idlista ASC;";
      return $sql;
    }
//Cargar Candidatos por lista
	  function candidatosXLista($id){
		 $sql = "SELECT C.idlista, L.nombrelista,nombrecandidato, apellidocandidato, cargocandidato, imagencandidato
		 FROM candidato C LEFT JOIN LISTA L ON  C.idlista = L.idlista
		 WHERE C.idlista = ".$id."order by cargocandidato ASC ;";
		return $sql;
	  }
//Cargar Cargos
      function cargarCargos(){
      $sql="SELECT distinct cargocandidato FROM candidato;";
      return $sql;
    }

//Funcion para cargar datos de los cargos por papeletas
      function cargarP1($cargo1,$cargo2){
      $sql="SELECT  nombrecandidato,cargocandidato,imagencandidato,idlista,idcandidato,apellidocandidato FROM candidato
       WHERE  (cargocandidato='$cargo1' OR cargocandidato='$cargo2')
       ORDER BY idlista,cargocandidato asc;";
      return $sql;
    }

//insertar voto en tabla voto
		function insertarVoto($idVotante,$idCandidato){
			$sql="INSERT INTO voto(idvotante, idcandidato, voto,fechavoto )  VALUES ($idVotante,$idCandidato, 1,current_date);";
			return $sql;
		}

//Actualiza la estadistica con los votos nuevos
		function actualizarEstadisticaV(){
			$sql="UPDATE estadistica SET votovalido = votovalido+1,
votototal = votototal+1 where idestaditica=(Select max(idestaditica) from estadistica);";
			return $sql;
		}

//trae datos para el mail de confirmacion
    function cargarDatosVotante($idactual){
      $sql="SELECT correovotante,nombrevotante,apellidovotante FROM votante  WHERE idvotante=$idactual;";
			return $sql;
    }
  //confirmar si el votante ya ha votado o no
      function confirmarVoto($idactual){
        $sql="SELECT * FROM bitacora  WHERE idvotante=$idactual;";
  			return $sql;
      }

//Insertar en bitacora cuando finaliza votacion
    function insertarBitacora($idVotante){
      $sql="INSERT INTO bitacora(idvotante, fecha, hora, ip)  VALUES ($idVotante,current_date, current_time, inet_client_addr());";
      return $sql;

    }

?>
