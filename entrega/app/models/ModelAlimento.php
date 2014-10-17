<?php

 class ModelAlimento extends Model
 {
     public function __construct($dbname,$dbuser,$dbpass,$dbhost)
     {
		parent::__construct($dbname,$dbuser,$dbpass,$dbhost);
     }

     public function listar()
     {
         $sql = $this->conexion->prepare("SELECT detalle_alimento.*, alimento.descripcion, donante.razon_social
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

	 public function agregarAlimento($desc)
	 {
		$sql = $this->conexion->prepare("SELECT codigo FROM alimento WHERE descripcion=(UPPER('$desc'))");
		$sql->execute();
		$res = $sql->fetchAll(PDO::FETCH_ASSOC);
		
		if (count($res) == 0){
			$sql_agregar = $this->conexion->prepare("insert into alimento (descripcion) values (UPPER('$desc'))");
			$sql_agregar->execute();
			return $this->conexion->lastInsertId();
		} else {
			return $res["0"]["codigo"];
		}
	 }
	 
     public function agregar($desc, $fec, $cont, $peso, $stock, $reser, $cant, $don)
     {
		$alimento_codigo = $this->agregarAlimento($desc);

		$sql_detalle = $this->conexion->prepare("insert into detalle_alimento (alimento_codigo, fecha_vencimiento, contenido, peso_paquete, stock, reservado)
										 values ('$alimento_codigo', '$fec', '$cont', '$peso', '$stock', '$reser')");
		$sql_detalle->execute();
		
		$id_detalle = $this->conexion->lastInsertId(); // detalle_alimento recien creado
		
		$sql_alimento_donante = $this->conexion->prepare("insert into donante_alimento (detalle_alimento_id, donante_id, cantidad)
														  values ('$alimento_codigo', '$don', '$cant')");

         return $sql;
     
	}

	public function obtenerAlimentos()
	{
		$sql = $this->conexion->prepare("SELECT * FROM alimento");
		$sql->execute();
		$res = $sql->fetchAll(PDO::FETCH_ASSOC);
		
		return $res;
	}
		
     public function validarDatos($desc, $fec, $cont, $peso, $stock, $reser, $cant, $don)
     {
         return (is_string($desc) &
                 is_string($fec) &
                 is_string($cont) &
                 is_numeric($peso) &
                 is_numeric($stock) &
                 is_numeric($reser) &
                 is_numeric($cant) &
                 is_numeric($don));
     }

 }
