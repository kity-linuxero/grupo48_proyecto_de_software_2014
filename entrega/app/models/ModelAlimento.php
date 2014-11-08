<?php

 class ModelAlimento extends Model
 {
     public function __construct($dbname,$dbuser,$dbpass,$dbhost)
     {
		parent::__construct($dbname,$dbuser,$dbpass,$dbhost);
     }

     public function listar()
     {
          $sql = $this->conexion->prepare("
          SELECT detalle_alimento.*, alimento.descripcion, donante.razon_social
		  FROM alimento INNER JOIN detalle_alimento ON (alimento.codigo=detalle_alimento.alimento_codigo)
						INNER JOIN alimento_donante ON (detalle_alimento.id=alimento_donante.detalle_alimento_id)
						INNER JOIN donante ON (alimento_donante.donante_id=donante.id)
		  ORDER BY descripcion
		  ");

		 $sql->execute();
		 
         $alimentos = $sql->fetchAll(PDO::FETCH_ASSOC);
			
        return $alimentos;
     }
     
     public function listarSoloStock()
     {
         $sql = $this->conexion->prepare("
   			  SELECT *
			  FROM alimento INNER JOIN detalle_alimento ON (alimento.codigo=detalle_alimento.alimento_codigo)
			  WHERE (detalle_alimento.stock > 0)
			  ORDER BY descripcion
			 ");

		 $sql->execute();
		 
         $alimentos = $sql->fetchAll(PDO::FETCH_ASSOC);
			
        return $alimentos;
     }

	 public function agregarAlimento($desc) // agrega a la tabla alimento si todavia no fue agregado
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
		
		$sql_alimento_donante = $this->conexion->prepare("insert into alimento_donante (detalle_alimento_id, donante_id, cantidad)
														  values ('$id_detalle', '$don', '$cant')");
		$sql_alimento_donante->execute();

         return $sql;
     
	}

	public function modificar($id, $desc, $fec, $cont, $peso, $stock, $reser, $cant, $donAnt, $donNue)
     {
		$alimento_codigo = $this->agregarAlimento($desc); // si fue modificado lo agrega como nuevo, sino no

		$sql_detalle = $this->conexion->prepare("UPDATE detalle_alimento 
												 SET alimento_codigo='$alimento_codigo',
													 fecha_vencimiento='$fec',
													 contenido='$cont',
													 peso_paquete='$peso',
													 stock='$stock',
													 reservado='$reser'
												 WHERE id='$id'");
		$sql_detalle->execute();
		
		$sql_alimento_donante = $this->conexion->prepare("UPDATE alimento_donante SET cantidad='$cant', donante_id='$donNue'
														  WHERE (detalle_alimento_id='$id') AND (donante_id='$donAnt')");
		$sql_alimento_donante->execute();

	}
	
	public function eliminar($id)
    {
		$sql_detalle = $this->conexion->prepare("DELETE FROM detalle_alimento WHERE id=$id");
		$sql_detalle->execute();

		$sql_alimento_donante = $this->conexion->prepare("DELETE FROM alimento_donante WHERE detalle_alimento_id='$id'");
		$sql_alimento_donante->execute();
	}

	public function obtenerAlimentos()
	{
		$sql = $this->conexion->prepare("SELECT * FROM alimento");
		$sql->execute();
		$res = $sql->fetchAll(PDO::FETCH_ASSOC);
		
		return $res;
	}
	
    public function obtenerPorID($id)
    {
		$sql = $this->conexion->prepare("
			SELECT detalle_alimento.id,
					alimento.descripcion,
					detalle_alimento.fecha_vencimiento as 'fecha',	
					detalle_alimento.contenido,
					detalle_alimento.peso_paquete as 'peso',
					detalle_alimento.stock, 
					detalle_alimento.reservado,
					alimento_donante.donante_id as 'donante',
					alimento_donante.cantidad
			 FROM detalle_alimento INNER JOIN alimento_donante ON (detalle_alimento.id=alimento_donante.detalle_alimento_id) 
								   INNER JOIN alimento ON (detalle_alimento.alimento_codigo=alimento.codigo)
			 WHERE (detalle_alimento.id='$id')
			");
		$sql->execute();
		$res = $sql->fetchAll(PDO::FETCH_ASSOC);
		return $res["0"];
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

	public function alcanzaStock($id, $cant)
	{
		$sql = $this->conexion->prepare("
			SELECT stock, reservado
			FROM detalle_alimento
			WHERE id='$id'
		");
		$sql->execute();
		$detalle = $sql->fetchAll(PDO::FETCH_ASSOC);
		$stock = $detalle['0']['stock'];
		$reser = $detalle['0']['reservado'];
		if ($cant <= ($stock - $reser)){
			return true;
		} else {
			return false;
		}
	}
	
	public function alimentosEntregaDirecta($f1, $f2)
	{
        $sql = $this->conexion->prepare("
					SELECT *
					FROM alimento INNER JOIN detalle_alimento ON (alimento.codigo=detalle_alimento.alimento_codigo)
					WHERE (detalle_alimento.stock > 0)
						AND (fecha_vencimiento BETWEEN '$f1' AND '$f2')
					ORDER BY descripcion
				");

		$sql->execute();
		 
        $alimentos = $sql->fetchAll(PDO::FETCH_ASSOC);
		
		return $alimentos;
		
	}

 }
