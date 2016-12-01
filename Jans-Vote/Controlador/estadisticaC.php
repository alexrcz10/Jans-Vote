<?php
	  include "../Modelo/estadisticaM.php";
	  include("pData.class");  
	  include("pChart.class");
	  
	//Cargar Periodos		
	if ($resultPE> 0)
	{	$comboperiodoE="";
		while ($row =pg_fetch_array($resultPE))
		{
			$comboperiodoE .="<option value='".$row[0]."'>".$row[0]."</option>";
		}
	}
	else{echo "No hubo resultados";} 
	
	//Tabla Estadística Total
    if($_POST['band']=="ESTADISTICA"){
		 $periodo = $_POST['periodoE'];
		 $sqlE = consultarEstadistica($periodo);
		 $resultE = pg_query($conexion,$sqlE);
		  $divE = "<table class='titulos'>
			<tr class='headers'>
			  <th scope='col'>ID &nbsp;</th>
			  <th scope='col'>	VOTOS NULO &nbsp;</th>
			  <th scope='col'>VOTOS BLANCO &nbsp;</th>
			  <th scope='col'>VOTOS VALIDOS &nbsp;</th>		  
			  <th scope='col'>TOTAL VOTOS &nbsp;</th>
			</tr></table>
					<div class='contiene_tabla'>
			<!-- tabla con scroll -->
			<table class='contenido'> ";    
			  while ($row=pg_fetch_row($resultE))
			  {
				  $divE .=" <tr>
					 <TD>".$row[0]."</TD>
					<TD>".$row[2]."</TD>
					<TD>".$row[3]."</TD>
					<TD>".$row[4]."</TD>
					<TD>".$row[5]."</TD>
				</tr>";
			  }
		  $divE .="</table></div>";
		  echo $divE;
	}
	
	//Tabla Estadística Detallada
    if($_POST['band']=="ESTADISTICAD"){
		$periodo = $_POST['periodoED'];
		$sqlVC = consultarVotosPorCandidato($periodo);
		$resultVC = pg_query($conexion,$sqlVC);
		$divVC = "";
		  
		$divVC = "<table class='titulos'>
		<tr class='headers'>
		  <th scope='col'>LISTA &nbsp;</th>
		  <th scope='col'>	NOMBRE &nbsp;</th>
		  <th scope='col'>CARGO &nbsp;</th>	  
		  <th scope='col'>TOTAL VOTOS &nbsp;</th>
		</tr></table>
				<div class='contiene_tabla'>
		<!-- tabla con scroll -->
		<table class='contenido'> ";    
		while ($row=pg_fetch_row($resultVC))
		  {
			  $divVC .=" <tr>
				 <TD>".$row[1]."</TD>
				<TD>".$row[2]." ".$row[3]."</TD>
				<TD>".$row[4]."</TD>
				<TD>".$row[5]."</TD>
			</tr>";
		  }
		$divVC .="</table></div>";
		echo $divVC;
	}

	// Graficar 
	function graficarPastel($datos, $desc, $tipo){
		 $DataSet = new pData;  
		 $DataSet->AddPoint($datos,"Serie1");   
		 $DataSet->AddPoint($desc,"Serie2");   
		 $DataSet->AddAllSeries();  
		 $DataSet->SetAbsciseLabelSerie("Serie2");  
		  
		 // Inicializar Grafico  
		 $Test = new pChart(500,200);  
		 $Test->drawFilledRoundedRectangle(7,7,493,193,5,240,240,240);  
		 $Test->drawRoundedRectangle(5,5,495,195,5,230,230,230);  
		  
		 // Dibujar Pastel 
		 $Test->setFontProperties("Fonts/tahoma.ttf",8);  
		 $Test->drawPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),190,90,110,PIE_PERCENTAGE,TRUE,50,20,5,2);  
		 $Test->drawPieLegend(370,15,$DataSet->GetData(),$DataSet->GetDataDescription(),250,250,250);  
		 //$Test->Stroke();
		 if($tipo == "T"){
			$Test->Render("pastelT.png"); 			 
		 }if($tipo == "DL"){		 
			$Test->Render("pastelD.png"); 
		 }if($tipo == "DC"){		 
			$Test->Render("pastelDC.png"); 
		 }
	}
	
	//Graficar Totales
	if($_POST['band']=="ESTADISTICAG"){
		$periodo = $_POST['periodoE'];
		$sqlEG = consultarEstadistica($periodo);
		$resultEG = pg_query($conexion,$sqlEG);		
		if (pg_num_rows($resultEG))
       {$row=pg_fetch_row($resultEG);		
		graficarPastel(array($row[4],$row[2],$row[3]),array("Voto Válido","Voto Nulo","Voto Blanco"),"T");
		echo "<img src='../Controlador/pastelT.png'>";		
		}else{ echo "No hubo resultados";}
	}
	
	//Graficar Detallados Listas
	if($_POST['band']=="ESTADISTICADG"){		
		$periodo = $_POST['periodoED'];
		$sqlGL = consultarVotosPorLista($periodo);
		$resultGL = pg_query($conexion,$sqlGL);
		$votos = array();
		$listas = array();
		if (pg_num_rows($resultGL))
       {while ($row=pg_fetch_row($resultGL))
		  {
			array_push($votos, $row[2]);
			array_push($listas, $row[1]);
		  }
		graficarPastel($votos,$listas,"DL");
		echo "<img src='../Controlador/pastelD.png'>";
		}else{ echo "No hubo resultados";}
	}
	
	//Graficar Detallados por Cargos
	if($_POST['band']=="ESTADISTICADCG"){		
		$periodo = $_POST['periodoED'];
		$cargo = $_POST['cargoED'];
		$sqlGL = consultarVotosPorCargo($periodo,$cargo);
		$resultGL = pg_query($conexion,$sqlGL);
		$votos = array();
		$listas = array();
		if (pg_num_rows($resultGL))
       {while ($row=pg_fetch_row($resultGL))
		  {
			array_push($votos, $row[2]);
			array_push($listas, $row[1]);
		  }
		graficarPastel($votos,$listas,"DC");
		echo "<img src='../Controlador/pastelDC.png'>";
		}else{echo "No hubo resultados";}
	}
?>