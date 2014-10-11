<?php

 class Model
 {
     protected $conexion;

     public function __construct($dbname,$dbuser,$dbpass,$dbhost)
     {
       
       try {
			$this->conexion = new PDO("mysql:dbname=".$dbname.";host=".$dbhost,$dbuser,$dbpass);
			$this->conexion->exec("set names utf8");
		}
		catch(PDOException $e){
			echo "ERROR". $e->getMessage();
		}
		
		
       
     }


/*

     public function validarDatos($n, $e, $p, $hc, $f, $g)
     {
         return (is_string($n) &
                 is_numeric($e) &
                 is_numeric($p) &
                 is_numeric($hc) &
                 is_numeric($f) &
                 is_numeric($g));
     }*/

 }
