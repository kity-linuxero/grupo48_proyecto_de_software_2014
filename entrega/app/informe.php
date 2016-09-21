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
