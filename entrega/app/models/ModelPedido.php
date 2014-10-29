<?php

class ModelPedido extends Model
{
	public function __construct($dbname,$dbuser,$dbpass,$dbhost)
	{
		parent::__construct($dbname,$dbuser,$dbpass,$dbhost);
	}
	
	public function getToday()
	{
		$hoy = getdate();
		$d = $hoy['mday']; 		$m = $hoy['mon']; 		$y = $hoy['year'];
		$fecha = "$y-$m-$d"; //el formato en la base de datos
		return $fecha;
	}
	
	public function pedidosHoy()
	{
		$hoy = $this->getToday();
		$sql = $this->conexion->prepare("
			SELECT pedido_modelo.*, turno_entrega.fecha, turno_entrega.hora , entidad_receptora.razon_social, estado_pedido.descripcion
			FROM pedido_modelo INNER JOIN turno_entrega INNER JOIN entidad_receptora INNER JOIN estado_pedido
			WHERE (pedido_modelo.turno_entrega_id=turno_entrega.id)
					AND (turno_entrega.fecha='$hoy')
					AND (entidad_receptora.id=pedido_modelo.entidad_receptora_id)
					AND (pedido_modelo.estado_pedido_id=estado_pedido.id)
										");
		$sql->execute();
		$pedidos = $sql->fetchAll(PDO::FETCH_ASSOC);
		/* CAMPOS DEL ARREGLO QUE DEVUELVE:
numero 	entidad_receptora_id 	fecha_ingreso 	estado_pedido_id 	turno_entrega_id 	con_envio 	id 	fecha 	hora 	razon_social	descripcion
		*/
		return $pedidos;
	}
	 
	public function agregar($pedido, $turno, $alimentos)
	{
		$f = $turno['fecha'];
		$h = $turno['hora'];
		$turno_entrega = $this->conexion->prepare("
			INSERT INTO turno_entrega (fecha, hora)
			VALUES ('$f', '$h')
							");
		$turno_entrega->execute();

		$turno_id = $this->conexion->lastInsertId();
		$fecha_hoy = $this->getToday();
		$er = $pedido['entidad_receptora_id'];
		$estado = $pedido['estado_pedido_id'];
		$envio = $pedido['con_envio'];
	
		$pedido = $this->conexion->prepare("
			INSERT INTO pedido_modelo (entidad_receptora_id, fecha_ingreso, estado_pedido_id, turno_entrega_id, con_envio)
			VALUES ('$er', '$fecha_hoy', '$estado', '$turno_id', '$envio')
											");
		$pedido->execute();
		
		$pedido_id = $this->conexion->lastInsertId();
		
		foreach ($alimentos as $alimento) {
			$detalle = $alimento['id'];
			$cant = $alimento['cant'];
			$sql = $this->conexion->prepare("
				INSERT INTO alimento_pedido ('pedido_numero', 'detalle_alimento_id', 'cantidad')
				VALUES ('$pedido_id', '$detalle', '$cant');
			");
			$sql->execute();
			
			// actualizar cada detalle de alimento agregado
			$update = $this->conexion->prepare("
				UPDATE detalle_alimento
				SET reservado=reservado+'$cant'
				WHERE id='$detalle'
			");
			$update->execute();
		}
	}
	 
}
?>