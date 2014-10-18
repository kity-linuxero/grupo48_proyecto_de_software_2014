<?php

 class Model
 {
     protected $conexion;

     public function __construct($dbname,$dbuser,$dbpass,$dbhost)
     {
       try {
			$this->conexion = new PDO("mysql:dbname=".$dbname.";host=".$dbhost,$dbuser,$dbpass);
			$this->conexion->exec("set names utf8");    //  lo desactive porque dejo de funcionar
		}
		catch(PDOException $e){
			echo "ERROR". $e->getMessage();
		}
     }

 }
