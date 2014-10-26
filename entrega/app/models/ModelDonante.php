<?php

 class ModelDonante extends Model
 {
     public function __construct($dbname,$dbuser,$dbpass,$dbhost)
     {
		parent::__construct($dbname,$dbuser,$dbpass,$dbhost);
     }

     public function listar()
     {
         $sql = $this->conexion->prepare('select *
										  from donante
										  order by razon_social');
		
		 $sql->execute();
		 
         $donantes = $sql->fetchAll(PDO::FETCH_ASSOC);

         return $donantes;
     }

     public function agregar($r, $n, $a, $t, $e)
     {
         $sql_donante = $this->conexion->prepare("INSERT into donante
						(razon_social, apellido_contacto, nombre_contacto, telefono_contacto, mail_contacto)
												  VALUES ('$r', '$a', '$n', '$t', '$e')
						 ");
         $sql_donante->execute();
     
		}

     public function modificar($i, $r, $n, $a, $t, $e)
     {
		 $r = htmlspecialchars($r);
         $a = htmlspecialchars($a);
         $n = htmlspecialchars($n);
         $t = htmlspecialchars($t);
         $e = htmlspecialchars($e);
		 
		 $sql_donante = $this->conexion->prepare("UPDATE donante
							SET razon_social='$r',
								apellido_contacto='$a',
								nombre_contacto='$n',
								telefono_contacto='$t', 
								mail_contacto='$e'
							WHERE id='$i'");

         $sql_donante->execute();
	 }

     public function eliminar($id)
     {
		$sql = $this->conexion->prepare("DELETE FROM donante WHERE id='$id'");
		$sql->execute();
	 }
     
	 public function obtenerPorID($id)
	 {
		$sql = $this->conexion->prepare("SELECT *
										 FROM donante
										 WHERE donante.id='$id'");
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
	 
     public function validarDatos($r, $n, $a, $t, $e)
     {
         return (is_string($r) &
                 is_string($n) &
                 is_string($a) &
                 is_string($t) &
                 is_string($e));
     }

 }

?>
