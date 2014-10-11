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
         $sql = $this->conexion->prepare('select * from donante order by razon_social');
		
		 $sql->execute();
		 
         $donantes = $sql->fetchAll(PDO::FETCH_ASSOC);

         return $donantes;
     }

     public function agregar($r, $c, $n, $a, $d, $t, $e)
     {
		 $r = htmlspecialchars($r);
         $c = htmlspecialchars($c);
         $n = htmlspecialchars($n);
         $a = htmlspecialchars($a);
         $d = htmlspecialchars($d);
         $t = htmlspecialchars($t);
         $e = htmlspecialchars($e);

         $sql = $this->conexion->prepare("insert into donantes (razon_social, contacto_id, nombre, apellido, domicilio, telefono, mail) values ('" .
                 $r . "'," . $c . "," . $n . "," . $a . "," . $d . "," . $t . "," . $e . ")");

				 
         $sql->execute();

         return $sql;
     
		}

     public function modificar()
     {
		
     
		}

     public function eliminar()
     {
		
     
		}
     
     public function validarDatos($r, $c, $n, $a, $d, $t, $e)
     {
         return (is_string($r) &
                 is_numeric($c) &
                 is_string($n) &
                 is_string($a) &
                 is_string($d) &
                 is_string($t) &
                 is_string($e));
     }

 }
