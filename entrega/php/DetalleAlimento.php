<?php
/*
 * @Cristian
 * 
 * 
 * */
class DetalleAlimento {
	
	private $codigo;
	private $descripcion;
	private $fechVenc;
	private $contenido;
	private $peso;
	private $stock;
	private $reservado;
	
	public function getAlimentoCodigo(){
			return $this->codigo;
	}
	
	public function setAlimentoCodigo($unParametro){
		$this->codigo= $unParametro;
	
	}
	
	public function getFechaVencimiento(){
			return $this->fechVenc;
	}
	
	public function setFechaVencimiento($unParametro){
		$this->fechVenc= $unParametro;
	
	}
	
	public function getFechaVencimiento(){
			return $this->fechVenc;
	}
	
	public function setFechaVencimiento($unParametro){
		$this->fechVenc= $unParametro;
	
	}
	
	public function getContenido(){
			return $this->contenido;
	}
	
	public function setContenido($unParametro){
		$this->contenido= $unParametro;
	}
	
	public function getPesoUnitario(){
			return $this->peso;
	}
	
	public function setPesoUnitario($unParametro){
		$this->peso= $unParametro;
	
	}
	
	public function getStock(){
			return $this->stock;
	}
	
	public function setStock($unParametro){
		$this->stock= $unParametro;
	
	}
	
	public function getReservado(){
			return $this->reservado;
	}
	
	public function setReservado($unParametro){
		$this->reservado= $unParametro;
	
	}
	
		
	
	}
	

	
	
	
?>
