<?php

      include "../Modelo/conexion.php";
	  include "../Modelo/gestionVotoM.php";


//Confirmacion Finalizar Votación
echo "<script>
function confirmacionVoto(idreg){
if(confirm('Esta seguro que desea finalizar la votación?')){
location.href='../Controlador/gestionVotoC.php?idCandidato='+idreg;
}else{location.href='../Vista/paginaVot.php';}}

//Confirmacion Voto Blanco
function confirmacionBlanco(id){
if(confirm('Esta seguro que desea finalizar la votación?')){
location.href='../Controlador/bitacoraC.php?blanco='+id;
}else{location.href='../Vista/paginaVot.php';}}

//Confirmacion Voto Nulo
function confirmacionNulo(id){
if(confirm('Esta seguro que desea finalizar la votación?')){
location.href='../Controlador/bitacoraC.php?nulo='+id;
}else{location.href='../Vista/paginaVot.php';}}

</script>";

$divC="";
$divF="";
$consulta=confirmarVoto($_SESSION["idactual"]);
$resultado=pg_query($conexion,$consulta);
if (pg_fetch_row($resultado)==0)
{

  $divC ="<header class='major'>
							<h2>CANDIDATOS</h2>
							<h1>Aqui podrás conocer los candidatos de cada lista</h1>
					<input type='button' name='votoBlanco' id='votoBlanco' onClick='confirmacionBlanco(2)' value='Votar en blanco' />
					<input type='button' name='votoNulo' id='votoNulo' onClick='confirmacionNulo(3)' value='Votar Nulo'  />
						</header>";
            //MOSTRAR CANDIDATOS POR TABLAS DE ELECCION
            //CARTON DE PRESIDENTES Y VICEPRESIDENTES:
  $arr=["PRESIDENTE","VICEPRESIDENTE"];
  //$divC = "";
      $varSection=1;//PRESIDENTES Y VICEPRESIDENTES
      $divC .= "<h3>PRESIDENTE Y VICEPRESIDENTE</h3> <section   class='profiles'>
            <div id='".$varSection."' class='row'>";
      $sqlC = cargarP1($arr[0],$arr[1]);
      $resultC = pg_query($conexion,$sqlC);
      $lista = "";
      $separa ="";
      $idcandidato="";
    while ($rowC=pg_fetch_row($resultC))
      {
        $listan = $lista;
        $nombre = strtoupper($rowC[0]." ".$rowC[5]);
        $cargo = $rowC[1];
        $imagen = $rowC[2];
        $lista = $rowC[3];
        $idcandidato=$rowC[4];
        if($lista != $listan){
          $separa = "<div  class= '4u 12u$(medium)'><section  class= 'box' ><H1>LISTA $lista</H1><hr>";
        }else{$separa ="";}
      $divC .= $separa."  <section>
              <img style='width:100px; height:100px; ' src='".$imagen."' alt='' />
              <h4>".$nombre."</h4>
              <p style='font-size:20px;color:red'>".$cargo."</p>
            </section>";
            if($lista==$listan)
            {

              $divC.= " <input type='button' class='button small'id='finalizarVoto' value='votar'
              onclick='habilitaDeshabilita(".$varSection.",".$idcandidato.")' > </section></div>";
            }
      }
      $divC .= " </div></section>";

//CARTON DE CONSEJO SUPERIOR:
  $arr=["CONSEJO SUPERIOR PRINCIPAL","CONSEJO SUPERIOR SUPLENTE"];
      $varSection=2;//Consejo superior
      $divC .= "<h3>CONSEJO SUPERIOR</h3> <section class='profiles'>
            <div id='".$varSection."' class='row'>";
      $sqlC = cargarP1($arr[0],$arr[1]);
      $resultC = pg_query($conexion,$sqlC);
      $lista = "";
      $separa ="";
      $idcandidato="";
    while ($rowC=pg_fetch_row($resultC))
      {
        $listan = $lista;
        $nombre = strtoupper($rowC[0]." ".$rowC[5]);
        $cargo = $rowC[1];
        $imagen = $rowC[2];
        $lista = $rowC[3];
        $idcandidato=$rowC[4];
        if($lista != $listan){
          $separa = "<div class= '4u 12u$(medium)'><section  class= 'box' ><H1>LISTA $lista</H1><hr><H1>Principal</H1> ";
        }else{$separa ="<H1>Suplente</H1> ";}
      $divC .= $separa." <section>
              <img style='width:100px; height:100px; ' src='".$imagen."' alt='' />
              <h4>".$nombre."</h4>
              <p style='font-size:20px;color:red'>".$cargo."</p>
            </section>";
            if($lista==$listan)
            {
              $divC.= " <input type='button' class='button small'id='finalizarVoto' value='votar'
              onclick='habilitaDeshabilita(".$varSection.",".$idcandidato.")' ></section></div>";
            }
      }
      $divC .= " </div></section>";



//CARTON DE CONSEJO ACADEMICO PRIMER CONSEJO:
      $arr=["CONSEJO ACADEMICO PRIMER CONSEJO PRINCIPAL","CONSEJO ACADEMICO PRIMER CONSEJO SUPLENTE"];
      $varSection=3;//Consejo Academico PRIMER CONSEJO
          $divC .= "<h3>CONSEJO ACADEMICO</h3><hr><h3>PRIMER CONSEJO</h3> <section   class='profiles'>
                <div id='".$varSection."'  class='row'>";
        $sqlC = cargarP1($arr[0],$arr[1]);
          $resultC = pg_query($conexion,$sqlC);
          $lista = "";
          $separa ="";
          $idcandidato="";
        while ($rowC=pg_fetch_row($resultC))
          {
            $listan = $lista;
            $nombre = strtoupper($rowC[0]." ".$rowC[5]);
            $cargo = $rowC[1];
            $imagen = $rowC[2];
            $lista = $rowC[3];
            $idcandidato=$rowC[4];

            if($cargo=="CONSEJO ACADEMICO PRIMER CONSEJO PRINCIPAL"  )
           {
             $divC .= $separa."<div class= '4u 12u$(medium)'><section  class= 'box' >
             <H1>LISTA $lista</H1><hr>
                     <img style='width:100px; height:100px; '  src='".$imagen."' alt='' />
                     <h4>".$nombre."</h4>
                     <p style='font-size:20px;color:red'>".$cargo."</p>";
            }

            if($cargo=="CONSEJO ACADEMICO PRIMER CONSEJO SUPLENTE"  )
           {
             $divC .= $separa."
                     <img style='width:100px; height:100px; ' src='".$imagen."' alt='' />
                     <h4>".$nombre."</h4>
                     <p style='font-size:20px;color:red'>".$cargo."</p>
                 ";
                 $divC.= " <input type='button' class='button small'id='finalizarVoto' value='votar'
                 onclick='habilitaDeshabilita(".$varSection.",".$idcandidato.")' ></section></div> ";

            }
          }
          $divC .= " </div></section>";


//CARTON DE CONSEJO ACADEMICO SEGUNDO CONSEJO:
        $arr=["CONSEJO ACADEMICO SEGUNDO CONSEJO PRINCIPAL","CONSEJO ACADEMICO SEGUNDO CONSEJO SUPLENTE"];
        $varSection=4;//Consejo Academico SEGUNDO CONSEJO
            $divC .= "<h3>SEGUNDO CONSEJO</h3> <section   class='profiles'>
                  <div id='".$varSection."' class='row'>";
          $sqlC = cargarP1($arr[0],$arr[1]);
            $resultC = pg_query($conexion,$sqlC);
            $lista = "";
            $separa ="";
            $idcandidato="";
          while ($rowC=pg_fetch_row($resultC))
            {
              $listan = $lista;
              $nombre = strtoupper($rowC[0]." ".$rowC[5]);
              $cargo = $rowC[1];
              $imagen = $rowC[2];
              $lista = $rowC[3];
              $idcandidato=$rowC[4];

              if($cargo=="CONSEJO ACADEMICO SEGUNDO CONSEJO PRINCIPAL"  )
             {

               $divC .= $separa."<div class= '4u 12u$(medium)'><section  class= 'box' >
               <H1>LISTA $lista</H1><hr>
                       <img style='width:100px; height:100px; ' src='".$imagen."' alt='' />
                       <h4>".$nombre."</h4>
                       <p style='font-size:20px;color:red'>".$cargo."</p>";

              }

              if($cargo=="CONSEJO ACADEMICO SEGUNDO CONSEJO SUPLENTE"  )
             {
               $divC .= $separa."
                       <img style='width:100px; height:100px; ' src='".$imagen."' alt='' />
                       <h4>".$nombre."</h4>
                       <p style='font-size:20px;color:red'>".$cargo."</p>
                   ";
                   $divC.= " <input type='button' class='button small'id='finalizarVoto' value='votar'
                    onclick='habilitaDeshabilita(".$varSection.",".$idcandidato.")' ></section></div> ";

              }

            }
        $divC .= " </div></section>";

//CARTON DE VOCALES PRIMER :
        $arr=["PRIMER VOCAL PRINCIPAL","PRIMER VOCAL SUPLENTE"];
        $varSection=5;//CONSEJO PRIMER VOCAL
        $divC .= "<h3>CONSEJO VOCALES</h3><hr><h3>PRIMER CONSEJO</h3> <section   class='profiles'>
              <div id='".$varSection."'  class='row'>";
          $sqlC = cargarP1($arr[0],$arr[1]);
            $resultC = pg_query($conexion,$sqlC);
            $lista = "";
            $separa ="";
            $idcandidato="";
          while ($rowC=pg_fetch_row($resultC))
            {
              $listan = $lista;
              $nombre = strtoupper($rowC[0]." ".$rowC[5]);
              $cargo = $rowC[1];
              $imagen = $rowC[2];
              $lista = $rowC[3];
              $idcandidato=$rowC[4];

              if($cargo=="PRIMER VOCAL PRINCIPAL"  )
             {

               $divC .= $separa."<div class= '4u 12u$(medium)'><section  class= 'box' >
               <H1>LISTA $lista</H1><hr>
                       <img style='width:100px; height:100px; ' src='".$imagen."' alt='' />
                       <h4>".$nombre."</h4>
                       <p style='font-size:20px;color:red'>".$cargo."</p>";

              }

              if($cargo=="PRIMER VOCAL SUPLENTE"  )
             {
               $divC .= $separa."
                       <img style='width:100px; height:100px; ' src='".$imagen."' alt='' />
                       <h4>".$nombre."</h4>
                       <p style='font-size:20px;color:red'>".$cargo."</p>
                   ";
                   $divC.= " <input type='button' class='button small'id='finalizarVoto' value='votar'
                    onclick='habilitaDeshabilita(".$varSection.",".$idcandidato.")' ></section></div> ";

              }

            }
$divC.="</div></section>";
//CARTON DE VOCALES SEGUNDO :
          $arr=["SEGUNDO VOCAL PRINCIPAL","SEGUNDO VOCAL SUPLENTE"];
          $varSection=6;// VOCAL SEGUNDO CONSEJO
          $divC .= "<h3>SEGUNDO CONSEJO</h3> <section   class='profiles'>
                <div id='".$varSection."'  class='row'>";
            $sqlC = cargarP1($arr[0],$arr[1]);
              $resultC = pg_query($conexion,$sqlC);
              $lista = "";
              $separa ="";
              $idcandidato="";
            while ($rowC=pg_fetch_row($resultC))
              {
                $listan = $lista;
                $nombre = strtoupper($rowC[0]." ".$rowC[5]);
                $cargo = $rowC[1];
                $imagen = $rowC[2];
                $lista = $rowC[3];
                $idcandidato=$rowC[4];

                if($cargo=="SEGUNDO VOCAL PRINCIPAL"  )
               {

                 $divC .= $separa."<div class= '4u 12u$(medium)'><section  class= 'box' >
                 <H1>LISTA $lista</H1><hr>
                         <img style='width:100px; height:100px; ' src='".$imagen."' alt='' />
                         <h4>".$nombre."</h4>
                         <p style='font-size:20px;color:red'>".$cargo."</p>";

                }

                if($cargo=="SEGUNDO VOCAL SUPLENTE"  )
               {
                 $divC .= $separa."
                         <img style='width:100px; height:100px; ' src='".$imagen."' alt='' />
                         <h4>".$nombre."</h4>
                         <p style='font-size:20px;color:red'>".$cargo."</p>
                     ";
                     $divC.= " <input type='button' class='button small'id='finalizarVoto' value='votar'
                      onclick='habilitaDeshabilita(".$varSection.",".$idcandidato.")' ></section></div> ";

                }

              }
        $divC.="</div></section>";
//CARTON DE VOCALES TERCER :
        $arr=["TERCER VOCAL PRINCIPAL","TERCER VOCAL SUPLENTE"];
        $varSection=7;//VOCAL TERCER CONSEJO
        $divC .= "<h3>TERCER CONSEJO</h3> <section   class='profiles'>
              <div id='".$varSection."'  class='row'>";
          $sqlC = cargarP1($arr[0],$arr[1]);
            $resultC = pg_query($conexion,$sqlC);
            $lista = "";
            $separa ="";
            $idcandidato="";
          while ($rowC=pg_fetch_row($resultC))
            {
              $listan = $lista;
              $nombre = strtoupper($rowC[0]." ".$rowC[5]);
              $cargo = $rowC[1];
              $imagen = $rowC[2];
              $lista = $rowC[3];
              $idcandidato=$rowC[4];

              if($cargo=="TERCER VOCAL PRINCIPAL"  )
             {

               $divC .= $separa."<div class= '4u 12u$(medium)'><section  class= 'box' >
               <H1>LISTA $lista</H1><hr>
                       <img style='width:100px; height:100px; ' src='".$imagen."' alt='' />
                       <h4>".$nombre."</h4>
                       <p style='font-size:20px;color:red'>".$cargo."</p>";

              }

              if($cargo=="TERCER VOCAL SUPLENTE"  )
             {
               $divC .= $separa."
                       <img style='width:100px; height:100px; ' src='".$imagen."' alt='' />
                       <h4>".$nombre."</h4>
                       <p style='font-size:20px;color:red'>".$cargo."</p>
                   ";
                   $divC.= " <input type='button' class='button small'id='finalizarVoto' value='votar'
                    onclick='habilitaDeshabilita(".$varSection.",".$idcandidato.")' ></section></div> ";

              }
$divF="<input type='button' name='FinalizarVotacion' id='FinalizarVotacion'  onClick='confirmacionVoto(a)' value='finalizar Voto' />";

}

//FinalizarVoto boton
// if($_POST['band']=="votar")
if(isset($_GET['idCandidato'])){
	$idCandidato=  explode(',',$_GET['idCandidato']);

   //$idCandidato= $_POST['idCandidato'];
    $idVotante= $_SESSION["idactual"];

//Recorre el arreglo de todos los votos efectuados e inserta un voto para cada uno.
           	for($i = 0; $i < count($idCandidato); $i++) {
               $sql=insertarVoto($idVotante,$idCandidato[$i]);
           			$result = pg_query($conexion, $sql) ;
           				pg_free_result($result);
           			//echo $sql;
           }

//Insertar en voto valido Estadistica
  $sql=actualizarEstadisticaV();
  $result = pg_query($conexion, $sql) ;
  pg_free_result($result);
  //echo $sql;


//Insertar en bitacora
$sql=insertarBitacora($idVotante);
$result = pg_query($conexion, $sql) ;
pg_free_result($result);
//echo $sql;

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

    echo "Porfavor actualice su correo a uno válido.";
    } else {
            echo "Gracias por utilizar Jans-Vote, se enviará un correo a su direccion proporcionada";

            $titulo    = strtoupper($nombre)." ".strtoupper($apellido).',Su votación a concluido con Exito!';
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


}
else
{

  $consulta=confirmarVoto($_SESSION["idactual"]);
  $resultado=pg_query($conexion,$consulta);
  while ($row=pg_fetch_row($resultado))
    {
      $fecha=$row[2];
      $hora=$row[3];

    }
echo "<h1>Su voto ya ha sido efectuado: </h1> Fecha: ".$fecha." Hora: ".$hora;

}

?>
