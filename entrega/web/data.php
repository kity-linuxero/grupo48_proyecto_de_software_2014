<?php

try{
	$con= new PDO("mysql:dbname=".'grupo_48'.";host=".'localhost','grupo_48','tHVmHSdXZV1Nw99T');

	}
	
	catch(PDOException $e){
		echo "hola";
		echo $e;
		die;
	}


//mysql_select_db("demo", $con);

// $result = mysql_query("SELECT name, val FROM web_marketing");

// WHERE (T.fecha>='2013-01-01') AND (T.fecha<='2016-01-01')


$f1= $_GET['f1'];
$f2= $_GET['f2'];


$result = $con->prepare("
			SELECT E.razon_social , sum(A.cantidad*D.peso_paquete) as Kilos
			FROM pedido_modelo as P INNER JOIN turno_entrega as T ON (P.turno_entrega_id=T.id)
					INNER JOIN alimento_pedido as A ON (P.numero=A.pedido_numero)
					INNER JOIN detalle_alimento as D ON (A.detalle_alimento_id=D.id)
					INNER JOIN entidad_receptora as E ON (P.entidad_receptora_id=E.id)
			
			WHERE (T.fecha>='$f1') AND (T.fecha<='$f2')
			
			GROUP BY E.razon_social
			
		");
$result->execute();



$rows = array();

foreach ($result as $valor) {
			$row[0] = $valor[0];  //editado, fallo al transcribir. La gráfica sigue sin aparecer.
			$row[1] = $valor[1];
			array_push($rows,$row);
		}


echo json_encode($rows, JSON_NUMERIC_CHECK);
die;
?> 
