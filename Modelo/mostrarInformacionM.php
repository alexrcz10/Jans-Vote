<?php
      session_start();
	  include "../Modelo/conexion.php";

	  //Cargar Listas Postulantes
      function cargarListas(){
		  $sql="SELECT idlista, nombrelista, sloganlista, imagenlista FROM lista order by idlista ASC;";
		  return $sql;
	  }

	  //Cargar Candidatos
	  function candidatosXLista($id){
		 $sql = "SELECT C.idlista, L.nombrelista,nombrecandidato, apellidocandidato, cargocandidato, imagencandidato
		 FROM candidato C LEFT JOIN LISTA L ON  C.idlista = L.idlista
		 WHERE C.idlista = ".$id."
		 ORDER BY C.idcandidato;";
		return $sql;
	  }
?>
