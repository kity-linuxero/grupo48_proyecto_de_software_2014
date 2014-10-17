<?php

 class ModelDonante extends Model
 {
     public function __construct($dbname,$dbuser,$dbpass,$dbhost)
     {
		parent::__construct($dbname,$dbuser,$dbpass,$dbhost);
     }

     public function listar()
     {
         $sql = $this->conexion->prepare('select donante.id, donante.razon_social, donante.contacto_id,
												contacto.nombre, contacto.apellido, contacto.domicilio, contacto.telefono, contacto.mail
										  from donante inner join contacto
										  where donante.contacto_id=contacto.id
										  order by razon_social');
		
		 $sql->execute();
		 
         $donantes = $sql->fetchAll(PDO::FETCH_ASSOC);
			
         return $donantes;
     }

     public function agregar($r, $n, $a, $d, $t, $e)
     {
		 $r = htmlspecialchars($r);
         $a = htmlspecialchars($a);
         $n = htmlspecialchars($n);
         $d = htmlspecialchars($d);
         $t = htmlspecialchars($t);
         $e = htmlspecialchars($e);
	
		 $sql_contacto = $this->conexion->prepare("insert into contacto (apellido, nombre, telefono, mail)
													values ('$a', '$n', '$d', '$t', '$e')");
		 $sql_contacto->execute();
	
		 $c = $this->conexion->lastInsertId(); // contacto_id recien creado
		 
         $sql_donante = $this->conexion->prepare("insert into donante (razon_social, contacto_id)
													values ('$r','$c')");
         $sql_donante->execute();
     
		}

     public function modificar($i, $r, $n, $a, $d, $t, $e)
     {
		 $r = htmlspecialchars($r);
         $a = htmlspecialchars($a);
         $n = htmlspecialchars($n);
         $d = htmlspecialchars($d);
         $t = htmlspecialchars($t);
         $e = htmlspecialchars($e);
		 
		 //recuperamos el id del contacto
		 $sql = $this->conexion->prepare("select contacto_id from donante inner join contacto
										  where donante.contacto_id=contacto.id and donante.id=$i");
		 $sql->execute();
		 $res = $sql->fetchAll(PDO::FETCH_ASSOC);
		 $c = $res["0"]["contacto_id"];

		 //actualizamos al contacto con los parametros recibidos en el post
		 $sql_contacto = $this->conexion->prepare("update contacto set nombre='$n', apellido='$a', domicilio='$d', telefono='$t', mail='$e' where id='$c'");
		 $sql_contacto->execute();
	     
		 //actualizamos al donante con los parametros recibidos en el post
		 $sql_donante = $this->conexion->prepare("update donante set razon_social='$r', contacto_id='$c' where id='$i'");
         $sql_donante->execute();
	 }

     public function eliminar($id)
     {
		$sql = $this->conexion->prepare("DELETE FROM donante WHERE id=$id");
		$sql->execute();     
	 }
     
	 public function obtenerPorID($id)
	 {
		$sql = $this->conexion->prepare("select donante.id, donante.razon_social, donante.contacto_id,
												contacto.nombre, contacto.apellido, contacto.domicilio, contacto.telefono, contacto.mail
										  from donante inner join contacto
										  where donante.contacto_id=contacto.id and donante.id=$id");
		$sql->execute();
		$donante = $sql->fetchAll(PDO::FETCH_ASSOC);
		return $donante["0"];
	 }

	public function obtenerDonantesActivos()
	{
		$sql = $this->conexion->prepare("SELECT * FROM donante");
		$sql->execute();
		$res = $sql->fetchAll(PDO::FETCH_ASSOC);
		return $res;
	}
	 
     public function validarDatos($r, $n, $a, $d, $t, $e)
     {
         return (is_string($r) &
                 is_string($n) &
                 is_string($a) &
                 is_string($d) &
                 is_string($t) &
                 is_string($e));
     }

 }
