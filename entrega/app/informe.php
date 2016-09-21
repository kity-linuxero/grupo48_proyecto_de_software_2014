<?php
/*
 *	This software is MIT Licensed (see LICENSE)
 *	Copyright (c) 2014-2016 Cristian O. Giambruni, Ezequiel F. Gómez
 */

/*
 * INFORMES
 * 
 */

require_once __DIR__ . '/Config.php';
require_once __DIR__ . '/models/Model.php';
require_once __DIR__ . '/models/ModelEntidad.php';

$f1= Model::xss($_GET['f1']);
$f2= Model::xss($_GET['f2']);
$consulta= Model::xss($_GET['informe']);

$con = new ModelEntidad(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
							 Config::$mvc_bd_clave, Config::$mvc_bd_hostname);	


if ($consulta == 'torta'){
	
	$result= $con->informePesoPorEntidad($f1, $f2, 0);
}
elseif($consulta == 'barra'){ //acá va la consulta para el gráfico de barra.

		$result= $con->informePesoPorDia($f1, $f2, 0);
	
	}
	$rows = array();

	foreach ($result as $valor) {
				$row[0] = $valor[0]; 
				$row[1] = $valor[1];
				array_push($rows,$row);
	}


	echo json_encode($rows, JSON_NUMERIC_CHECK);

?> 
