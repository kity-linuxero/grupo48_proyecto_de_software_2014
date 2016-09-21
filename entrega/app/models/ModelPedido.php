<?php
/*
 *	This software is MIT Licensed (see LICENSE)
 *	Copyright (c) 2014-2016 Cristian O. Giambruni, Ezequiel F. Gómez
 */
 
class ModelPedido extends Model
{
	public function __construct($dbname,$dbuser,$dbpass,$dbhost)
	{
		parent::__construct($dbname,$dbuser,$dbpass,$dbhost);
	}
	
	public function getTomorrow($n)
	{
		$proximaFecha = time() + ($n * 24 * 60 * 60);
		$fecha = date('Y-m-d', $proximaFecha);
		return $fecha;

	}
	
	public function getToday()
	{
		$fecha = date('Y-m-d');
		return $fecha;
	}
	
	public function obtenerHasta()
	{
		$conf = ModelUsers::verConfiguracion();
		$dias = $conf['0']['valor'];
		return $dias;
	}

	public function pedidosAlerta()
	{
		$hoy = $this->getToday();		// obtenemos la fecha de hoy
		$sql = $this->conexion->prepare("
			SELECT pedido_modelo.*, turno_entrega.fecha, turno_entrega.hora , entidad_receptora.razon_social, estado_pedido.descripcion
			FROM pedido_modelo INNER JOIN turno_entrega ON (pedido_modelo.turno_entrega_id=turno_entrega.id)
							   INNER JOIN entidad_receptora ON (entidad_receptora.id=pedido_modelo.entidad_receptora_id)
							   INNER JOIN estado_pedido ON (pedido_modelo.estado_pedido_id=estado_pedido.id)
			WHERE (turno_entrega.fecha='$hoy')
			ORDER BY pedido_modelo.numero
										");
		$sql->execute();
		$pedidos = $sql->fetchAll(PDO::FETCH_ASSOC);
		/* CAMPOS DEL ARREGLO QUE DEVUELVE:
numero 	entidad_receptora_id 	fecha_ingreso 	estado_pedido_id 	turno_entrega_id 	con_envio 	id 	fecha 	hora 	razon_social	descripcion
		*/
		return $pedidos;
	}
	
	public function mostrarDia($d) // se utiliza para mostrar los pedidos de UN dia segun la agenda de turnos
	{		
		$sql = $this->conexion->prepare("
			SELECT pedido_modelo.*, turno_entrega.fecha, turno_entrega.hora , entidad_receptora.razon_social, estado_pedido.descripcion
			FROM pedido_modelo INNER JOIN turno_entrega ON (pedido_modelo.turno_entrega_id=turno_entrega.id)
							   INNER JOIN entidad_receptora ON (entidad_receptora.id=pedido_modelo.entidad_receptora_id)
							   INNER JOIN estado_pedido ON (pedido_modelo.estado_pedido_id=estado_pedido.id)
			WHERE (turno_entrega.fecha = :d)
			ORDER BY pedido_modelo.numero
		");
		$sql->bindParam(':d', $d, PDO::PARAM_STR);
		$sql->execute();
		$pedidos = $sql->fetchAll(PDO::FETCH_ASSOC);

		return $pedidos;
	}
	
	public function verPedidosConEnvio($d) // se utiliza para mostrar los pedidos de UN dia segun la agenda de turnos
	{		
		$sql = $this->conexion->prepare("
			SELECT pedido_modelo.*, turno_entrega.fecha, turno_entrega.hora , entidad_receptora.razon_social, estado_pedido.descripcion
			FROM pedido_modelo INNER JOIN turno_entrega ON (pedido_modelo.turno_entrega_id=turno_entrega.id)
							   INNER JOIN entidad_receptora ON (entidad_receptora.id=pedido_modelo.entidad_receptora_id)
							   INNER JOIN estado_pedido ON (pedido_modelo.estado_pedido_id=estado_pedido.id)
			WHERE (turno_entrega.fecha = :d) AND (pedido_modelo.con_envio = 1) AND
				  ((pedido_modelo.estado_pedido_id=1) OR (pedido_modelo.estado_pedido_id=2) OR (pedido_modelo.estado_pedido_id=3))
			ORDER BY pedido_modelo.numero
		");
		// en la consulta de arriba, con_envio=1 significa que el pedido incluye envio
		// y los estado_pedido_id = 1, 2 y 3, significan "nuevo", "en espera" y "en proceso", por ende, todavia no fueron entregados
		
		$sql->bindParam(':d', $d, PDO::PARAM_STR);
		$sql->execute();
		$pedidos = $sql->fetchAll(PDO::FETCH_ASSOC);

		return $pedidos;
	}
	
	public function alimentosEntregaDirecta()
	{
		$hoy = $this->getToday();		// obtenemos la fecha de hoy
		$n = $this->obtenerHasta();		// recuperamos la cantidad de dias configurable para mostrar
		$hasta = $this->getTomorrow($n);	// obtenemos la fecha hasta donde se hara la consulta
		
		$detalles = ModelAlimento::alimentosEntregaDirecta($hoy, $hasta);
		return $detalles;
	}

	
	public function agregar($pedido, $turno, $alimentos)
	{

			$f = $turno['fecha'];
			$h = $turno['hora'];
			$turno_entrega = $this->conexion->prepare("
				INSERT INTO turno_entrega (fecha, hora)
				VALUES (:f, :h)
								");
			$turno_entrega->bindParam(':f', $f, PDO::PARAM_STR);
			$turno_entrega->bindParam(':h', $h, PDO::PARAM_STR);
			$turno_entrega->execute();
			
			$turno_id = $this->conexion->lastInsertId();
			$fecha_hoy = $this->getToday();
			$er = $pedido['entidad_receptora_id'];
			$estado = 1; // significa estado NUEVO
			$envio = $pedido['con_envio'];
		
				$pedido = $this->conexion->prepare("
					INSERT INTO pedido_modelo (entidad_receptora_id, fecha_ingreso, estado_pedido_id, turno_entrega_id, con_envio)
					VALUES ('$er', '$fecha_hoy', '$estado', '$turno_id', :envio)
													");
				$pedido->bindParam(':envio', $envio, PDO::PARAM_INT);
				$pedido->execute();
				
				$pedido_id = $this->conexion->lastInsertId();
				$id_values = array_keys($alimentos); // los indices son los detalle_alimento_id
				
				foreach ($id_values as $id_value) {
					$detalle = $id_value;
					$cant = $alimentos[$id_value];
					
						$sql = $this->conexion->prepare("
							INSERT INTO alimento_pedido (pedido_numero, detalle_alimento_id, cantidad)
							VALUES ('$pedido_id', :detalle, :cant);
						");
						$sql->bindParam(':detalle', $detalle, PDO::PARAM_INT);
						$sql->bindParam(':cant', $cant, PDO::PARAM_INT);
						$sql->execute();
						// actualizar cada detalle de alimento agregado
							$update = $this->conexion->prepare("
								UPDATE detalle_alimento
								SET reservado = reservado + :cant, stock = stock - :cant
								WHERE id = :detalle
							");
							$update->bindParam(':cant', $cant, PDO::PARAM_INT);
							$update->bindParam(':detalle', $detalle, PDO::PARAM_INT);
							$update->execute();
						}
	}

	public function actualizar($pedido, $turno)
	{
			$f = $turno['fecha'];
			$h = $turno['hora'];
			$t = $pedido['turno_entrega_id'];

			$turno_entrega = $this->conexion->prepare("
				UPDATE turno_entrega SET fecha = :f, hora = :h
				WHERE id = :t
								");
			$turno_entrega->bindParam(':f', $f, PDO::PARAM_STR);
			$turno_entrega->bindParam(':h', $h, PDO::PARAM_STR);
			$turno_entrega->bindParam(':t', $t, PDO::PARAM_INT);
			$turno_entrega->execute();

			$nro = $pedido['numero'];
			$er = $pedido['entidad_receptora_id'];
			$estado = $pedido['estado_pedido_id'];
			$envio = $pedido['con_envio'];
		
				$pedido = $this->conexion->prepare("
					UPDATE pedido_modelo SET entidad_receptora_id = :er, estado_pedido_id = :estado, con_envio = :envio
					WHERE numero = :nro
				");
				$pedido->bindParam(':er', $er, PDO::PARAM_INT);
				$pedido->bindParam(':estado', $estado, PDO::PARAM_INT);
				$pedido->bindParam(':envio', $envio, PDO::PARAM_INT);
				$pedido->bindParam(':nro', $nro, PDO::PARAM_INT);
				$pedido->execute();
	}
	
	public function eliminarDetallePedido($nro, $id)
	{
		$cantidad = $this->conexion->prepare("
				SELECT cantidad FROM alimento_pedido
				WHERE (pedido_numero = :nro) AND (detalle_alimento_id = :id) ");
		$cantidad->bindParam(':nro', $nro, PDO::PARAM_INT);
		$cantidad->bindParam(':id', $id, PDO::PARAM_INT);
		$cantidad->execute();
		
		$cant = $cantidad->fetchAll(PDO::FETCH_ASSOC);
		$cant = $cant['0']['cantidad'];
		
		$detalle = $this->conexion->prepare("
				UPDATE detalle_alimento
				SET reservado = reservado - $cant, stock = stock + $cant
				WHERE id = $id
			");
		$detalle->execute();

		$pedido = $this->conexion->prepare("
				DELETE FROM alimento_pedido
				WHERE (pedido_numero = :nro) AND (detalle_alimento_id = :id) ");
		$pedido->bindParam(':nro', $nro, PDO::PARAM_INT);
		$pedido->bindParam(':id', $id, PDO::PARAM_INT);
		$pedido->execute();
		

		$p = $this->obtenerDetallesPedido($nro);
		if ($p == -1){
			$this->eliminarPedido($nro);
			return -1;
		} else
			return 1;
	}
	
	public function eliminarPedido($nro)
	{
		$pedido = $this->conexion->prepare("
				DELETE FROM pedido_modelo
				WHERE (numero = :nro)
			");
		$pedido->bindParam(':nro', $nro, PDO::PARAM_INT);
		$pedido->execute();
	}
	
	public function agregarEntrega($entidad, $alimentos)
	{
		$fecha_hoy = $this->getToday();
	
			$entrega = $this->conexion->prepare("
				INSERT INTO entrega_directa (entidad_receptora_id, fecha)
				VALUES (:entidad, '$fecha_hoy')
					");
			$entrega->bindParam(':entidad', $entidad, PDO::PARAM_INT);
			$entrega->execute();
			$entrega_id = $this->conexion->lastInsertId();
			$id_values = array_keys($alimentos); // los indices son los detalle_alimento_id
			
			foreach ($id_values as $id_value) {
				$detalle = $id_value;
				$cant = $alimentos[$id_value];
				
					$sql = $this->conexion->prepare("
						INSERT INTO alimento_entrega_directa (entrega_directa_id, detalle_alimento_id, cantidad)
						VALUES ('$entrega_id', :detalle, :cant);
					");
					$sql->bindParam(':detalle', $detalle, PDO::PARAM_INT);
					$sql->bindParam(':cant', $cant, PDO::PARAM_INT);
					$sql->execute();
					// actualizar cada detalle de alimento agregado
						$update = $this->conexion->prepare("
							UPDATE detalle_alimento
							SET stock = stock - :cant
							WHERE id = :detalle
						");
						$update->bindParam(':detalle', $detalle, PDO::PARAM_INT);
						$update->bindParam(':cant', $cant, PDO::PARAM_INT);
						$update->execute();
			}
	}
	
	public function fechaMayorQueHoy($fecha)
	{
		$h = strtotime("now");
		$f = strtotime($fecha);
		$res = (($h<$f) or ($h=$f));
		return $res;
	}
	
	public function obtenerPorNro($n)
	{
		$sql = $this->conexion->prepare("
			SELECT pedido_modelo.*, turno_entrega.fecha, turno_entrega.hora
			FROM pedido_modelo INNER JOIN turno_entrega ON (pedido_modelo.turno_entrega_id=turno_entrega.id)
			WHERE (pedido_modelo.numero = :n)
		");
		$sql->bindParam(':n', $n, PDO::PARAM_INT);
		$sql->execute();
		$res = $sql->fetchAll(PDO::FETCH_ASSOC);
		if (count($res)>0){
			return $res['0'];
		}
		else return -1;
	}
	
	public function obtenerDetallesPedido($n)
	{
		$sql = $this->conexion->prepare("
				SELECT A.descripcion, DA.contenido, AP.cantidad, 
					   PM.numero AS pedido_numero, DA.id AS detalle_alimento_id
				FROM pedido_modelo AS PM INNER JOIN alimento_pedido AS AP ON (PM.numero = AP.pedido_numero)
				INNER JOIN detalle_alimento AS DA ON (AP.detalle_alimento_id = DA.id)
				INNER JOIN alimento AS A ON (DA.alimento_codigo = A.codigo)
				WHERE PM.numero = :n
			");
		$sql->bindParam(':n', $n, PDO::PARAM_INT);
		$sql->execute();
		$res = $sql->fetchAll(PDO::FETCH_ASSOC);
		if (count($res)>0){
			return $res;
		}
		else return -1;
	}
	
	public function listarEstadosPosibles()
	{
		$sql = $this->conexion->prepare("
			SELECT *
			FROM estado_pedido
		");
		$sql->execute();
		$res = $sql->fetchAll(PDO::FETCH_ASSOC);
		
		return $res;
	}
	
	public function todosLosPedidos()
	{
		$sql = $this->conexion->prepare("
			SELECT pedido_modelo.*, turno_entrega.fecha, turno_entrega.hora , entidad_receptora.razon_social, estado_pedido.descripcion
			FROM pedido_modelo INNER JOIN turno_entrega ON (pedido_modelo.turno_entrega_id=turno_entrega.id)
							   INNER JOIN entidad_receptora ON (entidad_receptora.id=pedido_modelo.entidad_receptora_id)
							   INNER JOIN estado_pedido ON (pedido_modelo.estado_pedido_id=estado_pedido.id)
			ORDER BY pedido_modelo.numero
		");
		$sql->execute();
		$res = $sql->fetchAll(PDO::FETCH_ASSOC);
		return $res;
	}
	
	public function entregasRealizadas()
	{
		$sql = $this->conexion->prepare("
				SELECT entrega_directa.*, entidad_receptora.razon_social
				FROM entrega_directa INNER JOIN entidad_receptora ON entrega_directa.entidad_receptora_id=entidad_receptora.id
				ORDER BY entrega_directa.id
			");
		$sql->execute();
		$res = $sql->fetchAll(PDO::FETCH_ASSOC);
		return $res;
	}
	
	public function validarDatosPedido($pedido, $turno, $alimentos){
		// se validaran los datos antes de agregar/modificar
		$res = (is_numeric($pedido['entidad_receptora_id']) &
                 (($pedido['con_envio']==1) or ($pedido['con_envio']==0)) &
                 $this->fechaMayorQueHoy($turno['fecha']) &
				 is_string($turno['hora']) &
                 (count($alimentos)>0));
        if ($res) {
			foreach ($alimentos as $alimento){
				$res = $res & (is_numeric($alimento));
			}
			$id_values = array_keys($alimentos); // los indices son los detalle_alimento_id
			
			foreach ($id_values as $id_value) {
				$sql = $this->conexion->prepare("
						SELECT stock FROM detalle_alimento WHERE id = :id_value
				");
				$sql->bindParam(':id_value', $id_value, PDO::PARAM_INT);
				$sql->execute();
				$temp = $sql->fetchAll(PDO::FETCH_ASSOC);
				$res = $res & ($alimentos[$id_value]<=$temp['0']['stock']);
			}
		}
		return $res;
	}
	
	public function validarDatosEntrega($entidad_id, $alimentos){
		// se validaran los datos antes de agregar/modificar
		$res = (is_numeric($entidad_id) & (count($alimentos)>0));
        if ($res) {
			foreach ($alimentos as $alimento){
				$res = $res & (is_numeric($alimento));
			}
			$id_values = array_keys($alimentos); // los indices son los detalle_alimento_id
			
			foreach ($id_values as $id_value) {
				$detalle = $id_value;
				$sql = $this->conexion->prepare("
						SELECT stock FROM detalle_alimento WHERE id = :id_value
				");
				$sql->bindParam(':id_value', $id_value, PDO::PARAM_INT);
				$sql->execute();
				$temp = $sql->fetchAll(PDO::FETCH_ASSOC);
				$res = $res & ($alimentos[$id_value]<=$temp['0']['stock']);
			}
		}
		return $res;
	}
	
	
	public function validarDatosSinCantidad($pedido, $turno)
	{
		$res = (is_numeric($pedido['entidad_receptora_id']) &
				 (($pedido['con_envio']==1) or ($pedido['con_envio']==0)) &
				 $this->fechaMayorQueHoy($turno['fecha']) &
				 is_string($turno['hora']));
		return $res;
	}
	

}
?>
