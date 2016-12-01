<?php
      //session_start();
	  include "../Modelo/mostrarInformacionM.php";

	  //Cargar listas
	  $sqlLP = cargarListas();
	  $resultLP = pg_query($conexion,$sqlLP);
      if (pg_num_rows($resultLP))
      {
          $divLP="";
          while ($row=pg_fetch_row($resultLP))
          {
              $nombre = strtoupper($row[1]);
              $slogan = strtoupper($row[2]);
			  $imagen = $row[3];
			  $divLP .= "<div class= '4u 12u$(medium)'>
							<section  class= 'box'>
							<img class='mini' src='".$imagen."' alt='' />
								<h3>".$nombre."</h3>
								<p>".$slogan."</p>
							</section></div>";
          }
      }
      else{echo "No hubo resultados";}


	//Cargar Candidatos
	  $sqlLPC = cargarListas();
	  $resultLPC = pg_query($conexion,$sqlLPC);
	  $divC = "";
      if (pg_num_rows($resultLPC))
      {
		  while ($row=pg_fetch_row($resultLPC))
          {
			  $id = $row[0];
              $nombre = strtoupper($row[1]);
			  $sqlC = candidatosXLista($id);
			  $resultC = pg_query($conexion,$sqlC);
			  $divC .= "<h3>CANDIDATOS PARA ".$nombre."</h3> <section class='profiles'>
							<div id='cand1' class='row'>";
			while ($rowC=pg_fetch_row($resultC))
			  {
				  $nombre = strtoupper($rowC[2]." ".$rowC[3]);
				  $cargo = strtoupper($rowC[4]);
				  $imagen = $rowC[5];
				  $divC .= "  <section class='2u 6u(medium) 12u(xsmall) profile'>
									<img style='width:100px; height:100px; ' src='".$imagen."' alt='' />
									<br><br><br><br><br><left><h4>".$nombre."</h4></left>
									<p>".$cargo."</p>
								</section>";
			  }
			  $divC .= "</div></section>";
          }
	  }
      else{echo "No hubo resultados";}

?>
