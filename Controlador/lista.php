<?php
class Lista{
	
	var $listaId;
	var $listaNombre;
	var $listaSlogan;
	var $listaImagen;
	var $listaInformacion;
	var $administradorId;
	
	//Constructor
	public function Lista() {
    }
	
	public function getlistaId() {
        return $this->$listaId;
    }
 
    public function setlistaId($listaId) {
        $this->listaId = $listaId;
    }
     
    public function getlistaNombre() {
        return $this->listaNombre;
    }
 
    public function setlistaNombre($listaNombre) {
        $this->listaNombre = $listaNombre;
    }
 
    public function getlistaSlogan() {
        return $this->listaSlogan;
    }
 
    public function setlistaSlogan($listaSlogan) {
        $this->listaSlogan = $listaSlogan;
    }
 
    public function getlistaImagen() {
        return $this->listaImagen;
    }
 
    public function setlistaImagen($listaImagen) {
        $this->listaImagen = $listaImagen;
    }
 
    public function getlistaInformacion() {
        return $this->listaInformacion;
    }
 
    public function setlistaInformacion($listaInformacion) {
        $this->listaInformacion = $listaInformacion;
    }

    public function getadministradorId() {
        return $this->administradorId;
    }
 
    public function setadministradorId($administradorId) {
        $this->administradorId = $administradorId;
    }


	public function insertar(){
        $query="INSERT INTO lista ( idadministrador, nombrelista, sloganlista, informacionlista, 
            imagenlista)
                VALUES(".$this->administradorId.",
                       '".$this->listaNombre."',
                       '".$this->listaSlogan."',
					   '".$this->listaInformacion."',
                       '".$this->listaImagen."');";
        return $query;
    }
	
	public function modificar($listaId){
        $query="UPDATE lista SET idadministrador =".$this->administradorId.",
                       nombrelista ='".$this->listaNombre."',
                       sloganlista ='".$this->listaSlogan."',
					   informacionlista ='".$this->listaInformacion."',
                       imagenlista ='".$this->listaImagen."'
					   WHERE idlista = ".$listaId.";";
        return $query;
    }
	
	public function eliminar($listaId){
        $query="DELETE FROM lista WHERE idlista = ".$listaId.";";
        return $query;
    }
	
	 function consultar($listaNombre){
		 if($listaNombre=='***' )
		{
			 $query = "SELECT idlista, nombrelista, sloganlista,informacionlista  
					   FROM lista 
					   ORDER BY idlista ASC";
		}
		else{
			 $query = "SELECT idlista, nombrelista, sloganlista,informacionlista 
			 FROM lista 
			 WHERE nombrelista like '%".$listaNombre . "%'
			 ORDER BY idlista ASC";
		}
		return $query; 
	}	
}
?>