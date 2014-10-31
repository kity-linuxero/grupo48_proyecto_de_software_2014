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
	
	public function pedidosHoy() // pedidosAlerta()
	{
		$hoy = $this->getToday();
//		$hasta = $this->mP->obtenerHasta();     esto nos devuelve la fecha de n dias en adelante, n se busca en la tabla Config
		$sql = $this->conexion->prepare("
			SELECT pedido_modelo.*, turno_entrega.fecha, turno_entrega.hora , entidad_receptora.razon_social, estado_pedido.descripcion
			FROM pedido_modelo INNER JOIN turno_entrega INNER JOIN entidad_receptora INNER JOIN estado_pedido
			WHERE (pedido_modelo.turno_entrega_id=turno_entrega.id)
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

/*		
Array ( [entidad_receptora_id] => 1 [con_envio] => true )
Array ( [fecha] => 2014-11-01 [hora] => 23:59 )
Array ( ['8'] => 15 ['12'] => 5 ) 
*/	
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
		if ($pedido['con_envio']) {
			$envio = 1; }
		else { $envio = 0; }
	
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
	
	public function fechaMayorQueHoy($fecha){
		$h = strtotime("now");
		$f = strtotime($fecha);
		return ($h<$f);
	}
	
	public function validarDatos($pedido, $turno, $alimentos){
			// se validaran los datos antes de agregar/modificar
						
			return
			    (is_numeric($pedido['entidad_receptora_id']) &
                 (($pedido['con_envio']==true) or ($pedido['con_envio']==false)) &
                 $this->fechaMayorQueHoy($turno['fecha']) &
				 is_string($turno['hora']) &
                 (count($alimentos)>0));
	}
	 
}
?>
