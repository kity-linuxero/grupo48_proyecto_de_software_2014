<?php

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
			  FROM entidad_receptora INNER JOIN estado_entidad INNER JOIN necesidad_entidad INNER JOIN servicio_prestado
			  WHERE (entidad_receptora.estado_entidad_id=estado_entidad.id) AND
				 (entidad_receptora.necesidad_entidad_id=necesidad_entidad.id) AND
				 (entidad_receptora.servicio_prestado_id=servicio_prestado.id)
			  ORDER BY entidad_receptora.razon_social");
		
		 $sql->execute();
		 
         $entidades = $sql->fetchAll(PDO::FETCH_ASSOC);
			
         return $entidades;
     }

     public function agregar($r, $t, $d, $e, $n, $s) //razon social, telefono, domicilio, necesidad, estado, servicio prestado
     {
		 $r = htmlspecialchars($r);
         $t = htmlspecialchars($t);
         $d = htmlspecialchars($d);
         $s = htmlspecialchars($s);
         $n = htmlspecialchars($n);
         $e = htmlspecialchars($e);

		 $sql = $this->conexion->prepare(
			"insert into entidad_receptora (razon_social, telefono, domicilio, estado_entidad_id,
											necesidad_entidad_id, servicio_prestado_id)
			 values ('$r', '$t', '$d', '$e', '$n', '$s')");
		 $sql->execute();
		}
		
	public function agregarContacto($id, $a, $n, $t, $e) //le agrega un contacto a esta entidad
	{
		 $a = htmlspecialchars($a);
         $n = htmlspecialchars($n);
         $t = htmlspecialchars($t);
         $e = htmlspecialchars($e);
		 
         $sql_contacto = $this->conexion->prepare("insert into contacto (apellido, nombre, telefono, mail)
													values ('$a','$n', '$t','$m')");

		 $c = $this->conexion->lastInsertId(); // contacto_id recien creado

         $sql = $this->conexion->prepare("update entidad_receptora set contacto_id='$c' where id='$id'");
		 
         $sql->execute();
	 }

     public function modificar($id, $r, $t, $d, $e_id, $n_id, $s_id)
     {
		$sql = $this->conexion->prepare("UPDATE entidad_receptora
										 SET razon_social='$r',
											 telefono='$t',
											 domicilio='$d',
											 estado_entidad_id='$e_id',
											 necesidad_entidad_id='$n_id',
											 servicio_prestado_id='$s_id'											 
										 WHERE id='$id'");
		$sql->execute();
	 }

	 public function modificarContacto($id, $a, $n, $t, $e) // modifica un contacto existente
	{
		 $a = htmlspecialchars($a);
         $n = htmlspecialchars($n);
         $t = htmlspecialchars($t);
         $e = htmlspecialchars($e);
		 
         $sql = $this->conexion->prepare("UPDATE contacto SET apellido='$a', nombre='$n', telefono='$t', mail='$m'
										  WHERE id='$id'");
         $sql->execute();
	 }
	 
     public function eliminar($id)
     {
		$sql = $this->conexion->prepare("DELETE FROM entidad_receptora WHERE id='$id'");
		
		$sql->execute();
	}
		
	public function obtenerPorID($id)
     {
         $sql = $this->conexion->prepare(
			 "SELECT entidad_receptora.*, estado_entidad.descripcion as 'estado', necesidad_entidad.descripcion as 'necesidad',
				     servicio_prestado.descripcion as 'servicio'
			  FROM entidad_receptora INNER JOIN estado_entidad INNER JOIN necesidad_entidad INNER JOIN servicio_prestado
			  WHERE (entidad_receptora.estado_entidad_id=estado_entidad.id) AND
					(entidad_receptora.necesidad_entidad_id=necesidad_entidad.id) AND
					(entidad_receptora.servicio_prestado_id=servicio_prestado.id) AND (entidad_receptora.id=$id)"
			 );
		
		 $sql->execute();
		 
         $entidad = $sql->fetchAll(PDO::FETCH_ASSOC);
         return $entidad["0"];
     }
	 
	 public function obtenerServiciosDisponibles()
	 {
		$sql = $this->conexion->prepare('SELECT * FROM servicio_prestado');
		$sql->execute();
		$res = $sql->fetchAll(PDO::FETCH_ASSOC);

		return $res;
	 }
     
     public function validarDatos($r, $t, $d, $e, $n, $s)
     {
         return (is_string($r) &
                 is_string($t) &
                 is_string($d) &
                 is_numeric($e) &
                 is_numeric($n) &
                 is_numeric($s));
     }

 }
