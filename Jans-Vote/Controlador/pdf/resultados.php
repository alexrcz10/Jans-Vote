<?php
require('fpdf.php');
class PDF extends FPDF
{
//Cabecera de página
   function Header()
   {
    $this->Image("feuce.jpg" , 6 ,10, 30 , 20 , "JPG");
    $this->Image("jans.png" , 35 ,8, 25 , 20 , "PNG");
    $this->SetFont('Arial','B',15);
    $this->Cell(50);
    $this->SetTextColor(0,63,130);
    $this->Cell(150,10,'RESULTADOS DE LAS ELECCIONES POR JANS-VOTE',1,0,'C');
    $this->Ln(20);
   }
   //Pie de página
   function Footer()
   {$this->SetY(-10);//1 cm antes del final
    $this->SetFont('Arial','I',8);
    $this->Cell(0,10,'Pag '.$this->PageNo().'/{nb}',0,0,'C');
   }

//Funcion para mostrar los totales en tabla
function TablaTotalesGeneral($header)
{
//Colores, ancho de línea y fuente en negrita
$this->SetFillColor(51,51,51);
$this->SetTextColor(255);
$this->SetDrawColor(128,0,0);
$this->SetLineWidth(.3);
 $this->SetFont('','B',10);

//Cabecera
for($i=0;$i<count($header);$i++)
$this->Cell(48,7,$header[$i],1,0,'C',1);
$this->Ln();
//Restauración de colores y fuentes
$this->SetFillColor(224,235,255);
$this->SetTextColor(0);
$this->SetFont('');
//Datos
//Cargar datos Estadistica general
$conexion= pg_connect("host=localhost port=5432 dbname=JansVote user=postgres password=jansvote") or die ("No se pudo conectar con la base de datos");

function consultarEstadistica($periodo){
  $sql = "SELECT idestaditica, idadministrador, votonulo, votoblanco, votovalido, votototal
  FROM estadistica
  WHERE periodoestadistica = ".$periodo.";";
  return $sql;
}
function consultaPeriodo(){
  $sql = "SELECT  extract(year from current_date ) ;";
  $conexion= pg_connect("host=localhost port=5432 dbname=JansVote user=postgres password=jansvote") or die ("No se pudo conectar con la base de datos");

  $result = pg_query($conexion,$sql);
  $row=pg_fetch_row($result);
  return $row[0];
}

//conexion
$sqlE = consultarEstadistica(consultaPeriodo());//Cambiar
$resultE = pg_query($conexion,$sqlE);
   while ($row=pg_fetch_row($resultE))
   {
     $fill=false;

  $this->Cell(48,6,$row[2],'LR',0,'C',$fill);
  $this->Cell(48,6,$row[3],'LR',0,'C',$fill);
  $this->Cell(48,6,$row[4],'LR',0,'C',$fill);
  $this->Cell(48,6,$row[5],'LR',0,'C',$fill);
  $this->Ln();
  $this->Cell(192,0,'','T');
   }

}
// funcion para mostrar los totales a detalle en Tabla
function TablaTotalesDetalle($header,$periodo,$cargo)
{
  //Colores, ancho de línea y fuente en negrita
  $this->SetFillColor(51,51,51);
  $this->SetTextColor(255);
  $this->SetDrawColor(128,0,0);
  $this->SetLineWidth(.3);
  $this->SetFont('','B');
  //Cabecera

  for($i=0;$i<count($header);$i++)
  $this->Cell(48,7,$header[$i],1,0,'C',1);
  $this->Ln();
  //Restauración de colores y fuentes
  $this->SetFillColor(224,235,255);
  $this->SetTextColor(0);

  $sql = "SELECT L.nombrelista as nombrelista, C.nombrecandidato as nombrecandidato , C.apellidocandidato as apellidocandidato, sum(voto) as votos
    FROM voto V INNER JOIN candidato C ON V.idcandidato = C.idcandidato
    INNER JOIN lista L ON L.idlista = C.idlista
    WHERE extract(year from V.fechavoto) = ".$periodo."
    and C.cargocandidato='".$cargo."'

    GROUP BY  nombrelista,nombrecandidato,apellidocandidato
    ORDER BY  votos DESC, nombreLista;";


$fill=false;
$i=0;

$conexion= pg_connect("host=localhost port=5432 dbname=JansVote user=postgres password=jansvote") or die ("No se pudo conectar con la base de datos");
$consulta=pg_exec($conexion,$sql);
$numregs=pg_numrows($consulta);
while($i<$numregs)
{
$nombrel=pg_result($consulta,$i,'nombrelista');
$nombrec=pg_result($consulta,$i,'nombrecandidato');
$apellidoc=pg_result($consulta,$i,'apellidocandidato');
$votos=pg_result($consulta,$i,'votos');
  $this->Cell(48,6,$nombrel,'LR',0,'L',$fill);
  $this->Cell(48,6,$nombrec,'LR',0,'L',$fill);
  $this->Cell(48,6,$apellidoc,'LR',0,'L',$fill);
  $this->Cell(48,6,$votos,'LR',0,'C',$fill);
$this->Ln();
    $fill=!$fill;
    $i++;
}
  $this->Cell(193,0,'','T');

}

function comprobar()
{
  $conexion= pg_connect("host=localhost port=5432 dbname=JansVote user=postgres password=jansvote") or die ("No se pudo conectar con la base de datos");
  $sql="SELECT * FROM Bitacora;";
  $result = pg_query($conexion,$sql);
  $row=pg_fetch_row($result);
  return $row[0];

}

}


//creacion del pdf
$pdf=new PDF();
$pdf->AliasNbPages();//maximo de paginas existentes
//Títulos de las columnas
//Primera página
$pdf->AddPage();
//totales de los votos:
if($pdf->comprobar()!=null)
{
$pdf->Cell(0,50, "VOTOS TOTALES GENERAL", 0, 0, 'C');
$pdf->Ln(10);
//TOTALES DE VOTOS CON GRAFICA
$pdf->Ln(20);
$header=array('VOTOS NULOS','VOTOS BLANCOS','VOTOS VALIDOS','TOTAL VOTOS');
$pdf->TablaTotalesGeneral($header);
//imagen de totales en general
$pdf->Image('../pastelT.png' , 20 ,80, 100 , 50,'PNG');

$pdf->Ln(80);
$pdf->SetFont('','B');
//TOTALES A DETALLE POR CARGO
$pdf->Cell(0,0, "VOTOS TOTALES A DETALLE (POR CARGO)", 0, 0, 'C');
$pdf->Ln(10);
$header=array('LISTA','NOMBRE','APELLIDO','TOTAL VOTOS');
$sqlE = "SELECT DISTINCT cargocandidato FROM candidato ORDER BY cargocandidato";
$conexion= pg_connect("host=localhost port=5432 dbname=JansVote user=postgres password=jansvote") or die ("No se pudo conectar con la base de datos");

$resultE = pg_query($conexion,$sqlE);
   while ($row=pg_fetch_row($resultE))
   {
     $pdf->SetFont('Arial','',10);
     $pdf->Write(5,'Resultados para: '.$row[0]);
          $pdf->Ln(5);
     $pdf->TablaTotalesDetalle($header,consultaperiodo(),$row[0]);
     $pdf->Ln(10);
}

}
else {
  $pdf->SetTextColor(255,0,0);
  $pdf->Cell(0,40, "LAS ELECCIONES AUN NO HAN FINALIZADO", 0, 0, 'C');
}
//imprimir
$pdf->isFinished = true;
$pdf->Output();
?>
