<?php

 class ModelAlimento extends Model
 {
     public function __construct($dbname,$dbuser,$dbpass,$dbhost)
     {
		parent::__construct($dbname,$dbuser,$dbpass,$dbhost);
     }

     public function listar()
     {
         $sql = $this->conexion->prepare("SELECT alimento.*, donante.id, donante.razon_social
										  FROM alimento INNER JOIN detalle_alimento INNER JOIN alimento_donante INNER JOIN donante
										  WHERE alimento.codigo=detalle_alimento.alimento_codigo AND
												detalle_alimento.id=alimento_donante.detalle_alimento_id AND
												alimento_donante.donante_id=donante.id
										  ORDER BY descripcion");

		 $sql->execute();
		 
         $alimentos = $sql->fetchAll(PDO::FETCH_ASSOC);
			
        return $alimentos;
     }
     
     public function listarSoloStock()
     {
         $sql = $this->conexion->prepare("SELECT *
										  FROM alimento INNER JOIN detalle_alimento
										  WHERE alimento.codigo=detalle_alimento.alimento_codigo and detalle_alimento.stock > 0
										  ORDER BY descripcion");

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

     public function validarDatos($desc, $fec, $cont, $peso, $stock, $reser, $don)
     {
         return (is_string($desc) &
                 is_string($fec) &
                 is_string($cont) &
                 is_numeric($peso) &
                 is_numeric($stock) &
                 is_numeric($reser) &
                 is_numeric($don));
     }

 }
