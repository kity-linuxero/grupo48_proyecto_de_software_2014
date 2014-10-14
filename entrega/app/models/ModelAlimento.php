<?php

 class ModelAlimento extends Model
 {
     protected $conexion;

     public function __construct($dbname,$dbuser,$dbpass,$dbhost)
     {
		parent::__construct($dbname,$dbuser,$dbpass,$dbhost);
     }

     public function listar()
     {
         $sql = $this->conexion->prepare("select * from alimento INNER JOIN detalle_alimento where alimento.codigo=detalle_alimento.alimento_codigo order by descripcion");

		 $sql->execute();
		 
         $alimentos = $sql->fetchAll(PDO::FETCH_ASSOC);
			
        return $alimentos;
     }
     
     public function listarSoloStock()
     {
         $sql = $this->conexion->prepare("select * from alimento INNER JOIN detalle_alimento where alimento.codigo=detalle_alimento.alimento_codigo and detalle_alimento.stock > 0 order by descripcion");

		 $sql->execute();
		 
         $alimentos = $sql->fetchAll(PDO::FETCH_ASSOC);
			
        return $alimentos;
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

     public function validarDatos($n, $e, $p, $hc, $f, $g)
     {
         return (is_string($n) &
                 is_numeric($e) &
                 is_numeric($p) &
                 is_numeric($hc) &
                 is_numeric($f) &
                 is_numeric($g));
     }

 }
