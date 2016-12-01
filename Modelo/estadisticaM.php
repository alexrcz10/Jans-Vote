<?php
      //session_start();
	  include "../Modelo/conexion.php";
	
	//Cargar datos Estadistica
	function consultarEstadistica($periodo){
		$sql = "SELECT idestaditica, idadministrador, votonulo, votoblanco, votovalido, votototal
		FROM estadistica
		WHERE periodoestadistica = ".$periodo.";";
		return $sql; 
	}
	  
	//Cargar Listas Postulantes
    function cargarListas(){
		  $sql="SELECT idlista, nombrelista, sloganlista, imagenlista FROM lista order by idlista ASC;";
		  return $sql;
	}
	  
	// Cargar votos por Candidato
	function consultarVotosPorCandidato($periodo){
			$sql = "SELECT L.idlista,L.nombrelista, C.nombrecandidato, C.apellidocandidato, C.cargocandidato, sum(voto) as votos
			FROM voto V INNER JOIN candidato C ON V.idcandidato = C.idcandidato
			INNER JOIN lista L ON L.idlista = C.idlista		
			WHERE extract(year from V.fechavoto) = ".$periodo."
			GROUP BY  L.idlista,L.nombrelista,C.nombrecandidato, C.apellidocandidato, C.cargocandidato
			ORDER BY  votos DESC, L.idlista;";
		return $sql; 
	}
	
	//Cargar votos por Listas
	function consultarVotosPorLista($periodo){
		$sql = "SELECT L.idlista, L.nombrelista, sum(voto) as votos
			FROM voto V INNER JOIN candidato C ON V.idcandidato = C.idcandidato
			INNER JOIN lista L ON L.idlista = C.idlista		
			WHERE extract(year from V.fechavoto) = ".$periodo."
			GROUP BY  L.idlista,L.nombrelista
			ORDER BY  votos DESC, L.idlista;";
		return $sql;
	}
	
	//Cargar Votos Por Cargo 
	function consultarVotosPorCargo($periodo,$cargo){
			$sql = "SELECT L.idlista, L.nombrelista, sum(voto) as votos
			FROM voto V INNER JOIN candidato C ON V.idcandidato = C.idcandidato
			INNER JOIN lista L ON L.idlista = C.idlista		
			WHERE extract(year from V.fechavoto) = ".$periodo."
			AND C.cargocandidato = '".$cargo."'
			GROUP BY  L.idlista,L.nombrelista
			ORDER BY  votos DESC, L.idlista;";
		return $sql; 
	}	
	
	  //Cargar periodo
	 $sqlPE= "SELECT distinct(periodoestadistica) as ano 
			  FROM estadistica;";
	 $resultPE = pg_query ($conexion,$sqlPE); 
	
	  //Cargar cargo
	 $sqlCE= "SELECT distinct(cargocandidato) as cargos 
			  FROM candidato;";
	 $resultCE = pg_query ($conexion,$sqlPE); 
	
?>