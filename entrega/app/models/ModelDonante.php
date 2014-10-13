<?php

 class ModelDonante extends Model
 {
 //    protected $conexion;

     public function __construct($dbname,$dbuser,$dbpass,$dbhost)
     {
		parent::__construct($dbname,$dbuser,$dbpass,$dbhost);
     }

     public function listar()
     {
         $sql = $this->conexion->prepare('select * from donante inner join contacto where donante.contacto_id=contacto.id order by razon_social');
		
		 $sql->execute();
		 
         $donantes = $sql->fetchAll(PDO::FETCH_ASSOC);
			
         return $donantes;
     }

     public function agregar($r, $n, $a, $t, $e)
     {
		 $r = htmlspecialchars($r);
         $n = htmlspecialchars($n);
         $a = htmlspecialchars($a);
         $t = htmlspecialchars($t);
         $e = htmlspecialchars($e);
	
		 $sql_contacto = $this->conexion->prepare("insert into contacto (apellido, nombre, telefono, mail)
													values ('$a', '$n', '$t', '$e')");
		 $sql_contacto->execute();
	
		 $c = $this->conexion->lastInsertId();
		 
         $sql_donante = $this->conexion->prepare("insert into donante (razon_social, contacto_id)
													values ('$r','$c')");
         $sql_donante->execute();

         return $sql_donante;
     
		}

     public function modificar($id)
     {
		
     
		}

     public function eliminar($id)
     {
		$sql = $this->conexion->prepare("DELETE FROM donante WHERE id=$id");
		$sql->execute();     
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
