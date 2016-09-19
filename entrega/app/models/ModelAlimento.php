<?php

 class ModelAlimento extends Model
 {
     public function __construct($dbname,$dbuser,$dbpass,$dbhost)
     {
		parent::__construct($dbname,$dbuser,$dbpass,$dbhost);
     }

	 public function check_date($str){ // verifica si una fecha del tipo yyyy-mm-dd es correcta
                trim($str);
				$trozos = explode ("-", $str);
				if (count($trozos)==3){
					$año=$trozos[0];
					$mes=$trozos[1];
					$dia=$trozos[2];
					if(checkdate ($mes,$dia,$año)){
						return true;
					}
				}
				return false;
	}

     public function listar()
     {
        $sql = $this->conexion->prepare("
			SELECT detalle_alimento.*, alimento.descripcion, donante.razon_social
			FROM alimento INNER JOIN detalle_alimento ON (alimento.codigo=detalle_alimento.alimento_codigo)
						LEFT JOIN alimento_donante ON (detalle_alimento.id=alimento_donante.detalle_alimento_id)
						LEFT JOIN donante ON (alimento_donante.donante_id=donante.id)
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

	 public function agregarAlimento($desc) // agrega a la tabla alimento si todavia no fue agregado y devuelve el codigo del alimento
	 {
		$sql = $this->conexion->prepare("SELECT codigo FROM alimento WHERE descripcion=(UPPER('$desc'))");
		$sql->execute();
		$res = $sql->fetchAll(PDO::FETCH_ASSOC);
		
		if (count($res) == 0){
			$sql_agregar = $this->conexion->prepare("insert into alimento (descripcion) values (UPPER( :desc ))");
			$sql_agregar->bindParam(':desc', $desc, PDO::PARAM_STR);
			$sql_agregar->execute();
			return $this->conexion->lastInsertId();
		} else {
			return $res["0"]["codigo"];
		}
	 }
	 
     public function agregar($desc, $fec, $cont, $peso, $stock, $reser)
     {
		$alimento_codigo = $this->agregarAlimento($desc);

		$sql_detalle = $this->conexion->prepare("insert into detalle_alimento (alimento_codigo, fecha_vencimiento, contenido, peso_paquete, stock, reservado)
										 values (:alimento_codigo, :fec, :cont, :peso, :stock, :reser)");
		$sql_detalle->bindParam(':alimento_codigo', $alimento_codigo, PDO::PARAM_INT);
		$sql_detalle->bindParam(':fec', $fec, PDO::PARAM_STR);
		$sql_detalle->bindParam(':cont', $cont, PDO::PARAM_INT);
		$sql_detalle->bindParam(':peso', $peso, PDO::PARAM_STR);
		$sql_detalle->bindParam(':stock', $stock, PDO::PARAM_INT);
		$sql_detalle->bindParam(':reser', $reser, PDO::PARAM_INT);
		$sql_detalle->execute();
	}

     public function agregarDonacion($desc, $fec, $cont, $peso, $cant, $don)
     {
		$alimento_codigo = $this->agregarAlimento($desc);

		$sql_detalle = $this->conexion->prepare("insert into detalle_alimento (alimento_codigo, fecha_vencimiento, contenido, peso_paquete, stock, reservado)
										 values (:alimento_codigo, :fec, :cont, :peso, :cant, '0')");

		$sql_detalle->bindParam(':alimento_codigo', $alimento_codigo, PDO::PARAM_INT);
		$sql_detalle->bindParam(':fec', $fec, PDO::PARAM_STR);
		$sql_detalle->bindParam(':cont', $cont, PDO::PARAM_STR);
		$sql_detalle->bindParam(':peso', $peso, PDO::PARAM_STR);
		$sql_detalle->bindParam(':cant', $cant, PDO::PARAM_INT);

		$sql_detalle->execute();
		
		$id_detalle = $this->conexion->lastInsertId(); // detalle_alimento recien creado
		
		$sql_alimento_donante = $this->conexion->prepare("insert into alimento_donante (detalle_alimento_id, donante_id, cantidad)
														  values (:id_detalle, :don, :cant)");
		$sql_detalle->bindParam(':id_detalle', $id_detalle, PDO::PARAM_INT);
		$sql_detalle->bindParam(':don', $don, PDO::PARAM_INT);
		$sql_detalle->bindParam(':cant', $cant, PDO::PARAM_INT);

		$sql_alimento_donante->execute();
	}
	
	
	public function modificar($id, $desc, $fec, $cont, $peso, $stock, $reser)
     {
		$alimento_codigo = $this->agregarAlimento($desc); // si fue modificado lo agrega como nuevo, sino no

		$res = $this->obtenerPorID($id);
		
		if ($res!=-1){
			$sql_detalle = $this->conexion->prepare("UPDATE detalle_alimento 
													 SET alimento_codigo= :alimento_codigo,
														 fecha_vencimiento= :fec,
														 contenido= :cont,
														 peso_paquete= :peso,
														 stock= :stock,
														 reservado= :reser
													 WHERE id = :id");
		$sql_detalle->bindParam(':alimento_codigo', $alimento_codigo, PDO::PARAM_INT);
		$sql_detalle->bindParam(':fec', $fec, PDO::PARAM_STR);
		$sql_detalle->bindParam(':cont', $cont, PDO::PARAM_STR);
		$sql_detalle->bindParam(':peso', $peso, PDO::PARAM_STR);
		$sql_detalle->bindParam(':stock', $stock, PDO::PARAM_INT);
		$sql_detalle->bindParam(':reser', $reser, PDO::PARAM_INT);
		$sql_detalle->bindParam(':id', $id, PDO::PARAM_INT);
													 
		$sql_detalle->execute();
			return 1;
		} else
			return -1;

	}
	
	public function eliminar($id)
    {
		$res = $this->obtenerPorID($id);
		if ($res!=-1){
			$sql_detalle = $this->conexion->prepare("DELETE FROM detalle_alimento WHERE id= :id");
			$sql_detalle->bindParam(':id', $id, PDO::PARAM_INT);

			$sql_detalle->execute();

			$sql_alimento_donante = $this->conexion->prepare("DELETE FROM alimento_donante WHERE detalle_alimento_id= :id");
			$sql_alimento_donante->bindParam(':id', $id, PDO::PARAM_INT);
			$sql_alimento_donante->execute();
		} else return -1;
	}

	public function obtenerAlimentos()
	{
		$sql = $this->conexion->prepare("SELECT * FROM alimento");
		$sql->execute();
		$res = $sql->fetchAll(PDO::FETCH_ASSOC);
		
		return $res;
	}
	
	public function obtenerContenidos()
	{
		$sql = $this->conexion->prepare("SELECT contenido FROM detalle_alimento");
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
			 FROM detalle_alimento LEFT JOIN alimento_donante ON (detalle_alimento.id=alimento_donante.detalle_alimento_id) 
								   LEFT JOIN alimento ON (detalle_alimento.alimento_codigo=alimento.codigo)
			 WHERE (detalle_alimento.id= :id)
			");
		$sql->bindParam(':id', $id, PDO::PARAM_INT);
		$sql->execute();
		$res = $sql->fetchAll(PDO::FETCH_ASSOC);
		if (count($res)==1)
			return $res["0"];
		else return -1;
	}
    
    public function validarDatos($desc, $fec, $cont, $peso, $stock, $reser)
    {
        return (is_string($desc) &
                ($this->check_date($fec)) &
                is_string($cont) &
                is_numeric($peso) &
                is_numeric($stock) &
                is_numeric($reser));
    }
	
    public function validarDatosDonacion($desc, $fec, $cont, $peso, $cant, $don)
    {
        return (is_string($desc) &
                ($this->check_date($fec)) &
                is_string($cont) &
                is_numeric($peso) &
                is_numeric($cant) &
                is_numeric($don));
    }


	public function alcanzaStock($id, $cant)
	{
		$sql = $this->conexion->prepare("
			SELECT stock, reservado
			FROM detalle_alimento
			WHERE id= :id
		");
		$sql->bindParam(':id', $id, PDO::PARAM_INT);
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
						AND (fecha_vencimiento BETWEEN :f1 AND :f2)
					ORDER BY descripcion
				");
		$sql->bindParam(':f1', $f1, PDO::PARAM_STR);
		$sql->bindParam(':f2', $f2, PDO::PARAM_STR);
		$sql->execute();
		 
        $alimentos = $sql->fetchAll(PDO::FETCH_ASSOC);
		
		return $alimentos;
		
	}
	
	public function alimentosVencidosSinEntregar()
	{
		$hoy = $fecha = date('Y-m-d');
		$sql = $this->conexion->prepare("
			SELECT A.descripcion as Descripcion, SUM(D.stock) as Stock, D.fecha_vencimiento as fechaVencimiento
			FROM detalle_alimento as D INNER JOIN alimento as A ON (D.alimento_codigo = A.codigo)
			WHERE (D.fecha_vencimiento < '$hoy') AND (Stock > 0)
			GROUP BY A.descripcion
		");
		$sql->execute();
		$alimentos = $sql->fetchAll(PDO::FETCH_ASSOC);
		
		return $alimentos;
	}
	
 }
