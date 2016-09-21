<?php
/*
 *	MIT License
 *
 *	Copyright (c) 2014-2016 Cristian O. Giambruni, Ezequiel F. Gómez
 *
 *	Permission is hereby granted, free of charge, to any person obtaining a copy
 *	of this software and associated documentation files (the "Software"), to deal
 *	in the Software without restriction, including without limitation the rights
 *	to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *	copies of the Software, and to permit persons to whom the Software is
 *	furnished to do so, subject to the following conditions:
 *
 *	The above copyright notice and this permission notice shall be included in all
 *	copies or substantial portions of the Software.
 *
 *	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 *	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *	LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *	OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 *	SOFTWARE.
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
