<?php
      session_start();
	  include "../Modelo/conexion.php";
	
	 //Cargar id del Administrador
	 function cargarIdAdmin(){
		 $sql = "SELECT idadministrador from administrador where nombreadministrador = '".$_SESSION["usuarioactual"] ."';";
		 return $sql;
	 }
	 
	 //Cargar nombres (Modificar)
	 $sqlNM= "SELECT idlista, nombrelista from lista;";
	 $resultNM = pg_query ($conexion,$sqlNM);
	 
	 //Cargar lista (Modificar)
	 function cargarLista($idLista){
     $sqlIM="SELECT * from lista where idlista = '".$idLista."';" ;
	 return $sqlIM;
	 }
	 
	 //Cargar id lista (modificar)
	 function cargarIdLista($nombreLista){
     $sqlIDM="SELECT idlista from lista where nombrelista = '".$nombreLista."';" ;
	 return $sqlIDM;
	 }
	 
	 //Cargar listas (Eliminar)
	 function cargarListasEliminar($busEliminarLista){
	 if($busEliminarLista=='***' )
	{
		 $sql = "select idlista, nombrelista from lista order by idlista asc";
	}else{
    $sql = "select idlista, nombrelista from lista where nombrelista like '%".$busEliminarLista . "%' order by idlista asc" ;
	 }
	return $sql; 
	}
	 //Cargar id de ultima lista ingresada
	 function cargarUltimoIdLista(){
	 $sql = "SELECT max(idlista) from lista;";
	 return $sql;
	 }
?>