<?php

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
			FROM pedido_modelo INNER JOIN turno_entrega INNER JOIN entidad_receptora INNER JOIN estado_pedido
			WHERE (pedido_modelo.turno_entrega_id=turno_entrega.id)
					AND (entidad_receptora.id=pedido_modelo.entidad_receptora_id)
					AND (pedido_modelo.estado_pedido_id=estado_pedido.id)
					AND (turno_entrega.fecha='$hoy')
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
			FROM pedido_modelo INNER JOIN turno_entrega INNER JOIN entidad_receptora INNER JOIN estado_pedido
			WHERE (pedido_modelo.turno_entrega_id=turno_entrega.id)
					AND (entidad_receptora.id=pedido_modelo.entidad_receptora_id)
					AND (pedido_modelo.estado_pedido_id=estado_pedido.id)
					AND (turno_entrega.fecha='$d')
			ORDER BY pedido_modelo.numero
		");
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
/*		
Array ( [entidad_receptora_id] => 1 [con_envio] => true )
Array ( [fecha] => 2014-11-01 [hora] => 23:59 )
Array ( ['8'] => 15 ['12'] => 5 ) 
*/	
		try {
			$f = $turno['fecha'];
			$h = $turno['hora'];
			$turno_entrega = $this->conexion->prepare("
				INSERT INTO turno_entrega (fecha, hora)
				VALUES ('$f', '$h')
								");
			$turno_entrega->execute();
		} catch (PDOException $e){
			echo "ERROR". $e->getMessage();
		}

		$turno_id = $this->conexion->lastInsertId();
		$fecha_hoy = $this->getToday();
		$er = $pedido['entidad_receptora_id'];
		$estado = 1; // significa estado NUEVO
		$envio = $pedido['con_envio'];
	
		try {
			$pedido = $this->conexion->prepare("
				INSERT INTO pedido_modelo (entidad_receptora_id, fecha_ingreso, estado_pedido_id, turno_entrega_id, con_envio)
				VALUES ('$er', '$fecha_hoy', '$estado', '$turno_id', '$envio')
												");
			$pedido->execute();
		} catch (PDOException $e){
			echo "ERROR". $e->getMessage();
		}
		
		$pedido_id = $this->conexion->lastInsertId();
		$id_values = array_keys($alimentos); // los indices son los detalle_alimento_id
		
		foreach ($id_values as $id_value) {
			$detalle = $id_value;
			$cant = $alimentos[$id_value];
			
			try {
				$sql = $this->conexion->prepare("
					INSERT INTO alimento_pedido (pedido_numero, detalle_alimento_id, cantidad)
					VALUES ('$pedido_id', '$detalle', '$cant');
				");
				$sql->execute();
			} catch (PDOException $e){
				echo "ERROR". $e->getMessage();
			}
			
			// actualizar cada detalle de alimento agregado
			try {
				$update = $this->conexion->prepare("
					UPDATE detalle_alimento
					SET reservado=reservado+'$cant', stock=stock-'$cant'
					WHERE id='$detalle'
				");
				$update->execute();
			} catch (PDOException $e){
				echo "ERROR". $e->getMessage();
			}
		}
	}
	
	public function fechaMayorQueHoy($fecha){
		$h = strtotime("now");
		$f = strtotime($fecha);
		return ($h<$f);
	}
	
	public function validarDatos($pedido, $turno, $alimentos){
			// se validaran los datos antes de agregar/modificar
						
			return 
			    (is_numeric($pedido['entidad_receptora_id']) &
                 (($pedido['con_envio']==1) or ($pedido['con_envio']==0)) &
                 $this->fechaMayorQueHoy($turno['fecha']) &
				 is_string($turno['hora']) &
                 (count($alimentos)>0));
	}
	
	public function obtenerPorNro($n)
	{
		$sql = $this->conexion->prepare("
			SELECT pedido_modelo.*, turno_entrega.fecha, turno_entrega.hora
			FROM pedido_modelo INNER JOIN turno_entrega
			WHERE (pedido_modelo.numero='$n')
					AND (pedido_modelo.turno_entrega_id=turno_entrega.id)
		");
		$sql->execute();
		$res = $sql->fetchAll(PDO::FETCH_ASSOC);
		return $res["0"];
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
	 
}
?>