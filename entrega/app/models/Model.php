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
			
			
			Twig_Autoloader::register();
		
			$loader = new Twig_Loader_Filesystem('./../app/twig/templates');
			$twig = new Twig_Environment($loader, array('debug' => 'true'));
			
			
			
			
	
			echo $twig->render('errorBlue.twig.html', array('mensaje' => 'Hubo un error al intentar conectarse a la base de datos.'));
			die;
			
			
		}
     }

 }
