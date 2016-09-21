<?php
/*
 *	This software is MIT Licensed (see LICENSE)
 *	Copyright (c) 2014-2016 Cristian O. Giambruni, Ezequiel F. Gómez
 */

 // web/index.php

 // carga del modelo y los controladores
 require_once '../app/Config.php';
 require_once '../app/models/Model.php';
 require_once '../app/models/ModelAlimento.php';
 require_once '../app/models/ModelDonante.php';
 require_once '../app/models/ModelEntidad.php';
 require_once '../app/models/ModelLogin.php';
 require_once '../app/models/ModelUsers.php';
 require_once '../app/controllers/Controller.php';
 require_once '../app/controllers/ControllerFront.php';
 require_once '../app/controllers/ControllerBack.php';
 require_once  '../app/twig/lib/Twig/Autoloader.php';


 // enrutamiento
 $map = array(
     'inicio' => array('controller' =>'ControllerFront', 'accion' =>'inicio'),
     'listarDonantes' => array('controller' =>'ControllerFront', 'accion' =>'listarDonantes'),
     'listarEntidades' => array('controller' =>'ControllerFront', 'accion' =>'listarEntidades'),
     'quienesSomos' => array('controller' =>'ControllerFront', 'accion' =>'quienesSomos'),
     'contacto' => array('controller' =>'ControllerFront', 'accion' =>'contacto'),
	 'inicioErr' => array('controller' =>'ControllerFront', 'accion' =>'inicioErr'),
	
 );
$errors=false;
 // Parseo de la ruta
 if (isset($_GET['accion'])) {
     if (isset($map[$_GET['accion']])) {
         $ruta = $_GET['accion'];
     } else {
	 
			Controller::exepciones('','ERROR 404: No existe la ruta ', $_GET['accion']);
				$errors=true;
     }
	} else {
     $ruta = 'inicio';
 }
if(!$errors){
 $controlador = $map[$ruta];
 // Ejecución del controlador asociado a la ruta
 if (method_exists($controlador['controller'],$controlador['accion'])) {
     call_user_func(array(new $controlador['controller'], $controlador['accion']));
 } else {

		Controller::exepciones('','ERROR 404: No existe el controlador ', $controlador['accion']);
			 
 }
 }
?>
