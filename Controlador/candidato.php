<?php
class Candidato{

	var $candidatoId;
	var $candidatoCedula;
	var $candidatoNombre;
	var $candidatoApellido;
	var $candidatoCargo;
	var $candidatoImagen;
	var $candidatoCorreo;
	var $candidatoFacultad;
	var $candidatoNivel;
	var $listaId;

	// Getter y Setter
	public function getcandidatoId() {
        return $this->$candidatoId;
    }

    public function setcandidatoId($candidatoId) {
        $this->candidatoId = $candidatoId;
    }

	public function getcandidatoCedula() {
        return $this->$candidatoCedula;
    }

    public function setcandidatoCedula($candidatoCedula) {
        $this->candidatoCedula = $candidatoCedula;
    }

    public function getcandidatoNombre() {
        return $this->candidatoNombre;
    }

    public function setcandidatoNombre($candidatoNombre) {
        $this->candidatoNombre = $candidatoNombre;
    }

    public function getcandidatoApellido() {
        return $this->candidatoApellido;
    }

    public function setcandidatoApellido($candidatoApellido) {
        $this->candidatoApellido = $candidatoApellido;
    }

    public function getcandidatoCargo() {
        return $this->candidatoCargo;
    }

    public function setcandidatoCargo($candidatoCargo) {
        $this->candidatoCargo = $candidatoCargo;
    }

    public function getcandidatoImagen() {
        return $this->candidatoImagen;
    }

    public function setcandidatoImagen($candidatoImagen) {
        $this->candidatoImagen = $candidatoImagen;
    }

    public function getcandidatoCorreo() {
        return $this->candidatoCorreo;
    }

    public function setcandidatoCorreo($candidatoCorreo) {
        $this->candidatoCorreo = $candidatoCorreo;
    }

	    public function getcandidatoFacultad() {
        return $this->candidatoFacultad;
    }

    public function setcandidatoFacultad($candidatoFacultad) {
        $this->candidatoFacultad = $candidatoFacultad;
    }

    public function getcandidatoNivel() {
        return $this->candidatoNivel;
    }

    public function setcandidatoNivel($candidatoNivel) {
        $this->candidatoNivel = $candidatoNivel;
    }

		public function getlistaId() {
        return $this->$listaId;
    }

    public function setlistaId($listaId) {
        $this->listaId = $listaId;
    }

		public function insertar(){
        $query="INSERT INTO candidato ( idlista, cedulacandidato, nombrecandidato, apellidocandidato,
            cargocandidato, correocandidato, facultadcandidato, nivelcandidato,
            imagencandidato)
                VALUES(".$this->listaId.",
                       '".$this->candidatoCedula."',
                       '".$this->candidatoNombre."',
					   '".$this->candidatoApellido."',
                       '".$this->candidatoCargo."',
                       '".$this->candidatoCorreo."',
					   '".$this->candidatoFacultad."',
					   '".$this->candidatoNivel."',
                       '".$this->candidatoImagen."');";
        return $query;
    }

	public function modificar($candidatoId){
        $query="UPDATE candidato SET idlista =".$this->listaId.",
                       cedulacandidato ='".$this->candidatoCedula."',
                       nombrecandidato ='".$this->candidatoNombre."',
					   apellidocandidato ='".$this->candidatoApellido."',
                       cargocandidato ='".$this->candidatoCargo."',
                       correocandidato ='".$this->candidatoCorreo."',
					   facultadcandidato ='".$this->candidatoFacultad."',
					   nivelcandidato ='".$this->candidatoNivel."'
					   WHERE idcandidato= ".$candidatoId.";";
        return $query;
    }

	public function eliminar($candidatoId){
        $query="DELETE FROM candidato WHERE idcandidato = ".$candidatoId.";";
        return $query;
    }

	function consultarxLista($idLista){
	    $query = "SELECT lista.idlista,lista.nombrelista, idcandidato, cedulacandidato, nombrecandidato, apellidocandidato,cargocandidato, correocandidato, facultadcandidato, nivelcandidato
					   FROM candidato INNER JOIN lista ON (candidato.idlista = lista.idlista)
					   WHERE lista.idlista = ".$idLista."
					   ORDER BY nombrecandidato ASC";
		return $query;
	}

	 function consultarCandidatos($candidatoCedula){
		 if($candidatoCedula=='***' )
		{
			 $query = "SELECT lista.idlista,lista.nombrelista, idcandidato, cedulacandidato, nombrecandidato, apellidocandidato,cargocandidato, correocandidato, facultadcandidato, nivelcandidato
					   FROM candidato INNER JOIN lista ON (candidato.idlista = lista.idlista)
					   ORDER BY idlista ASC";
		}
		else{
			 $query = "SELECT lista.idlista,lista.nombrelista, idcandidato, cedulacandidato, nombrecandidato, apellidocandidato,cargocandidato, correocandidato, facultadcandidato, nivelcandidato
		     FROM candidato INNER JOIN lista ON (candidato.idlista = lista.idlista)
			 WHERE cedulacandidato like '%".$candidatoCedula . "%'
			 ORDER BY idlista ASC";
		}
		return $query;
	}
}
?>
