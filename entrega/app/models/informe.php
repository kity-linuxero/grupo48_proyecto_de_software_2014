<?php

require_once __DIR__ . '/../Config.php';

$dbname= Config::$mvc_bd_nombre;
$dbuser= Config::$mvc_bd_usuario;
$dbpass= Config::$mvc_bd_clave;
$dbhost= Config::$mvc_bd_hostname;


try {
			$con = new PDO("mysql:dbname=".$dbname.";host=".$dbhost,$dbuser,$dbpass);
			$con->exec("set names utf8");    //  lo desactive porque dejo de funcionar
			
		}
		catch(PDOException $e){
			
			echo "LPM";
			die;
			//Controller::exepciones($e, 'Hubo un error al intentar conectarse a la base de datos.', '');
			//return false;
		}

$f1= $_GET['f1'];
$f2= $_GET['f2'];
$consulta= $_GET['informe'];
$result;
//$con->informePesoPorEntidad($f1, $f2);

if ($consulta == 'torta'){
$result = $con->prepare("
			SELECT R.razon_social , sum(R.cantidad*R.peso_paquete) as Kilos
			FROM (
					SELECT E.razon_social, A.cantidad, D.peso_paquete
					FROM pedido_modelo as P INNER JOIN turno_entrega as T ON (P.turno_entrega_id=T.id)
											INNER JOIN alimento_pedido as A ON (P.numero=A.pedido_numero)
											INNER JOIN detalle_alimento as D ON (A.detalle_alimento_id=D.id)
											INNER JOIN entidad_receptora as E ON (P.entidad_receptora_id=E.id)
					WHERE (T.fecha>='$f1') AND (T.fecha<='$f2')
				UNION
                    SELECT E.razon_social, A.cantidad, D.peso_paquete
					FROM entrega_directa as P INNER JOIN alimento_entrega_directa as A ON (P.id=A.entrega_directa_id)
											  INNER JOIN detalle_alimento as D ON (A.detalle_alimento_id=D.id)
											  INNER JOIN entidad_receptora as E ON (P.entidad_receptora_id=E.id)
					WHERE (P.fecha>='$f1') AND (P.fecha<='$f2')
				) as R
			GROUP BY R.razon_social
		");
}elseif($consulta == 'barra'){ //acá va la consulta para el gráfico de barra.
	//por ahora es la misma consulta
	$result = $con->prepare("
			SELECT R.razon_social , sum(R.cantidad*R.peso_paquete) as Kilos
			FROM (
					SELECT E.razon_social, A.cantidad, D.peso_paquete
					FROM pedido_modelo as P INNER JOIN turno_entrega as T ON (P.turno_entrega_id=T.id)
											INNER JOIN alimento_pedido as A ON (P.numero=A.pedido_numero)
											INNER JOIN detalle_alimento as D ON (A.detalle_alimento_id=D.id)
											INNER JOIN entidad_receptora as E ON (P.entidad_receptora_id=E.id)
					WHERE (T.fecha>='$f1') AND (T.fecha<='$f2')
				UNION
                    SELECT E.razon_social, A.cantidad, D.peso_paquete
					FROM entrega_directa as P INNER JOIN alimento_entrega_directa as A ON (P.id=A.entrega_directa_id)
											  INNER JOIN detalle_alimento as D ON (A.detalle_alimento_id=D.id)
											  INNER JOIN entidad_receptora as E ON (P.entidad_receptora_id=E.id)
					WHERE (P.fecha>='$f1') AND (P.fecha<='$f2')
				) as R
			GROUP BY R.razon_social
		");
	
	}

$result->execute();
$rows = array();

foreach ($result as $valor) {
			$row[0] = $valor[0];  //editado, fallo al transcribir. La gráfica sigue sin aparecer.
			$row[1] = $valor[1];
			array_push($rows,$row);
		}


echo json_encode($rows, JSON_NUMERIC_CHECK);

?> 
