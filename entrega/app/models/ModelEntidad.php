<?php
/*
 *	This software is MIT Licensed (see LICENSE)
 *	Copyright (c) 2014-2016 Cristian O. Giambruni, Ezequiel F. Gómez
 */
 
 class ModelEntidad extends Model
 {
     public function __construct($dbname,$dbuser,$dbpass,$dbhost)
     {
		parent::__construct($dbname,$dbuser,$dbpass,$dbhost);
     }

     public function listar()
     {
         $sql = $this->conexion->prepare(
			 "SELECT entidad_receptora.*, estado_entidad.descripcion as 'estado', necesidad_entidad.descripcion as 'necesidad',
				     servicio_prestado.descripcion as 'servicio'
			  FROM entidad_receptora INNER JOIN estado_entidad ON (entidad_receptora.estado_entidad_id=estado_entidad.id)
					INNER JOIN necesidad_entidad ON (entidad_receptora.necesidad_entidad_id=necesidad_entidad.id)
					INNER JOIN servicio_prestado ON (entidad_receptora.servicio_prestado_id=servicio_prestado.id)
			  ORDER BY entidad_receptora.razon_social");
		
		 $sql->execute();
		 
         $entidades = $sql->fetchAll(PDO::FETCH_ASSOC);
			
         return $entidades;
     }

	 public function listarReducido() // devuelve las entidades en ALTA (estado id=1)
     {
         $sql = $this->conexion->prepare(
			 "SELECT entidad_receptora.id, entidad_receptora.razon_social
			  FROM entidad_receptora
			  WHERE estado_entidad_id='1'
			  ORDER BY entidad_receptora.razon_social");
		
		 $sql->execute();
		 
         $entidades = $sql->fetchAll(PDO::FETCH_ASSOC);
			
         return $entidades;
     }

     public function agregar($r, $t, $d, $e, $n, $s, $lat, $lon) //razon social, telefono, domicilio, necesidad, estado, servicio prestado
     {
		 $sql = $this->conexion->prepare(
			"insert into entidad_receptora (razon_social, telefono, domicilio, estado_entidad_id,
											necesidad_entidad_id, servicio_prestado_id, latitud, longitud)
			 values (:r, :t, :d, :e, :n, :s, :lat, :lon)
		 ");
		 $sql->bindParam(':r', $r, PDO::PARAM_STR);
		 $sql->bindParam(':t', $t, PDO::PARAM_STR);
		 $sql->bindParam(':d', $d, PDO::PARAM_STR);
		 $sql->bindParam(':e', $e, PDO::PARAM_INT);
		 $sql->bindParam(':n', $n, PDO::PARAM_INT);
		 $sql->bindParam(':s', $s, PDO::PARAM_INT);
		 $sql->bindParam(':lat', $lat, PDO::PARAM_STR);
		 $sql->bindParam(':lon', $lon, PDO::PARAM_STR);
		 $sql->execute();
		}
		
     public function modificar($id, $r, $t, $d, $e_id, $n_id, $s_id, $lat, $lon)
     {
		$sql = $this->conexion->prepare("UPDATE entidad_receptora
										 SET razon_social= :r,
											 telefono= :t,
											 domicilio= :d,
											 estado_entidad_id= :e_id,
											 necesidad_entidad_id= :n_id,
											 servicio_prestado_id= :s_id,
											 latitud= :lat,
											 longitud= :lon											 
										 WHERE id= :id
				");
		 $sql->bindParam(':r', $r, PDO::PARAM_STR);
		 $sql->bindParam(':t', $t, PDO::PARAM_STR);
		 $sql->bindParam(':d', $d, PDO::PARAM_STR);
		 $sql->bindParam(':e_id', $e_id, PDO::PARAM_INT);
		 $sql->bindParam(':n_id', $n_id, PDO::PARAM_INT);
		 $sql->bindParam(':s_id', $s_id, PDO::PARAM_INT);
		 $sql->bindParam(':lat', $lat, PDO::PARAM_STR);
		 $sql->bindParam(':lon', $lon, PDO::PARAM_STR);
		 $sql->bindParam(':id', $id, PDO::PARAM_INT);
		 $sql->execute();
	 }

     public function eliminar($id)
     {
		$res = $this->obtenerPorID($id);
	 
		if ($res!=-1){
			$sql = $this->conexion->prepare("DELETE FROM entidad_receptora WHERE id= :id");
			$sql->bindParam(':id', $id, PDO::PARAM_INT);
			$sql->execute();
		} else return -1;
	}
		
	public function obtenerPorID($id)
     {
		$sql = $this->conexion->prepare(
			 "SELECT entidad_receptora.*, estado_entidad.descripcion as 'estado', necesidad_entidad.descripcion as 'necesidad',
				     servicio_prestado.descripcion as 'servicio'
			  FROM entidad_receptora INNER JOIN estado_entidad ON (entidad_receptora.estado_entidad_id=estado_entidad.id)
					INNER JOIN necesidad_entidad ON (entidad_receptora.necesidad_entidad_id=necesidad_entidad.id)
					INNER JOIN servicio_prestado ON (entidad_receptora.servicio_prestado_id=servicio_prestado.id)
			  WHERE (entidad_receptora.id= :id)"
			 );
		 $sql->bindParam(':id', $id, PDO::PARAM_INT);
		 $sql->execute();
		 
         $entidad = $sql->fetchAll(PDO::FETCH_ASSOC);
         
		 if (count($entidad)==1)
			return $entidad["0"];
		 else
			return -1;
     }
	 
	 public function obtenerServiciosDisponibles()
	 {
		$sql = $this->conexion->prepare('SELECT * FROM servicio_prestado');
		$sql->execute();
		$res = $sql->fetchAll(PDO::FETCH_ASSOC);

		return $res;
	 }
     
     public function validarDatos($r, $t, $d, $e, $n, $s, $lat, $lon)
     {
         return (is_string($r) &
                 is_string($t) &
                 is_string($d) &
                 is_numeric($e) &
                 is_numeric($n) &
                 is_numeric($s) &
                 is_numeric($lat) &
                 is_numeric($lon));
     }
     
     public function informePesoPorEntidad($f1, $f2, $pdf)
     {
		$result = $this->conexion->prepare("
			SELECT R.razon_social as Entidad, sum(R.cantidad*R.peso_paquete) as Kilos
			FROM (
					SELECT E.razon_social, A.cantidad, D.peso_paquete
					FROM pedido_modelo as P INNER JOIN turno_entrega as T ON (P.turno_entrega_id=T.id)
											INNER JOIN alimento_pedido as A ON (P.numero=A.pedido_numero)
											INNER JOIN detalle_alimento as D ON (A.detalle_alimento_id=D.id)
											INNER JOIN entidad_receptora as E ON (P.entidad_receptora_id=E.id)
					WHERE (T.fecha >= :f1) AND (T.fecha <= :f2)
				UNION
                    SELECT E.razon_social, A.cantidad, D.peso_paquete
					FROM entrega_directa as P INNER JOIN alimento_entrega_directa as A ON (P.id=A.entrega_directa_id)
											  INNER JOIN detalle_alimento as D ON (A.detalle_alimento_id=D.id)
											  INNER JOIN entidad_receptora as E ON (P.entidad_receptora_id=E.id)
					WHERE (P.fecha >= :f1) AND (P.fecha <= :f2)
				) as R
			GROUP BY R.razon_social
		");
		
		$result->bindParam(':f1', $f1, PDO::PARAM_STR);
		$result->bindParam(':f2', $f2, PDO::PARAM_STR);
		$result->execute();

		if ($pdf=="1"){
			$result = $result->fetchAll(PDO::FETCH_ASSOC);
		}

		return $result;
	}
	 
	 public function informePesoPorDia($f1, $f2, $pdf)
     {
		$result = $this->conexion->prepare("
			SELECT R.fecha AS Fecha, sum( R.cantidad * R.peso_paquete ) AS Kilos
			FROM (

					SELECT T.fecha AS Fecha, A.cantidad, D.peso_paquete
					FROM pedido_modelo AS P
					INNER JOIN turno_entrega AS T ON ( P.turno_entrega_id = T.id )
					INNER JOIN alimento_pedido AS A ON ( P.numero = A.pedido_numero )
					INNER JOIN detalle_alimento AS D ON ( A.detalle_alimento_id = D.id )
					INNER JOIN entidad_receptora AS E ON ( P.entidad_receptora_id = E.id )
					WHERE (T.fecha >= :fecha1)	AND (T.fecha <= :fecha2)
			UNION
					SELECT P.fecha AS Fecha, A.cantidad, D.peso_paquete
					FROM entrega_directa AS P
					INNER JOIN alimento_entrega_directa AS A ON ( P.id = A.entrega_directa_id )
					INNER JOIN detalle_alimento AS D ON ( A.detalle_alimento_id = D.id )
					INNER JOIN entidad_receptora AS E ON ( P.entidad_receptora_id = E.id )
					WHERE (P.fecha >= :fecha1)	AND (P.fecha <= :fecha2)
			) AS R
			GROUP BY R.fecha
		");
		
		$result->bindParam(':fecha1', $f1, PDO::PARAM_STR);
		$result->bindParam(':fecha2', $f2, PDO::PARAM_STR);
		$result->execute();

		if ($pdf=="1"){
			$result = $result->fetchAll(PDO::FETCH_ASSOC);
		}

		return $result;
	 }
 }
