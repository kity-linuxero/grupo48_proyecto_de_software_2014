<?php
 // web/index.php

 // carga del modelo y los controladores
 require_once __DIR__ . '/../app/Config.php';
 require_once './../app/Model.php';
 require_once './../app/ModelDonante.php';
 require_once './../app/ModelEntidad.php';
 require_once './../app/ModelLogin.php';
 require_once __DIR__ . '/../app/ControllerFront.php';

 // enrutamiento
 $map = array(
     'inicio' => array('controller' =>'ControllerFront', 'accion' =>'inicio'),
     'listarDonantes' => array('controller' =>'ControllerFront', 'accion' =>'listarDonantes'),
     'listarEntidades' => array('controller' =>'ControllerFront', 'accion' =>'listarEntidades'),
     'quienesSomos' => array('controller' =>'ControllerFront', 'accion' =>'quienesSomos'),
     'contacto' => array('controller' =>'ControllerFront', 'accion' =>'contacto'),
	 'mensaje' => array('controller' =>'ControllerFront', 'accion' =>'mensaje'),
	// 'login' => array('controller' =>'ControllerFront', 'accion' =>'login')
 );

 // Parseo de la ruta
 if (isset($_GET['accion'])) {
     if (isset($map[$_GET['accion']])) {
         $ruta = $_GET['accion'];
     } else {
         header('Status: 404 Not Found');
         echo '<html><body><h1>Error 404: No existe la ruta <i>' .
                 $_GET['accion'] .
                 '</p></body></html>';
         exit;
     }
 } else {
     $ruta = 'inicio';
 }

 $controlador = $map[$ruta];
 // Ejecución del controlador asociado a la ruta




 if (method_exists($controlador['controller'],$controlador['accion'])) {
     call_user_func(array(new $controlador['controller'], $controlador['accion']));
 } else {

     header('Status: 404 Not Found');
     echo '<html><body><h1>Error 404: El controlador <i>' .
             $controlador['controller'] .
             '->' .
             $controlador['accion'] .
             '</i> no existe</h1></body></html>';
 }
