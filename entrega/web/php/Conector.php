<?php
/*
 * @Cristian
 * Esta clase modifica 
 * 
 * */
class Conector {
	
	const DB_HOST="127.0.0.1";
	const DB_USER="grupo_48";
	const DB_PASS="tHVmHSdXZV1Nw99T";
	const DB_BASE="grupo_48";
		
	//Se conecta y retorna la conexión
	public static function conectar(){
		
		try {
			$cn = new PDO("mysql:dbname=".self::DB_BASE.";host=".self::DB_HOST,self::DB_USER,self::DB_PASS);
		}
		catch(PDOException $e){
			echo "ERROR". $e->getMessage();
		}
	return $cn;
	
	}
	

}
	
	
?>