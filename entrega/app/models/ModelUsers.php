<?php

 class ModelUsers extends Model
 {
     public function __construct($dbname,$dbuser,$dbpass,$dbhost)
     {
		parent::__construct($dbname,$dbuser,$dbpass,$dbhost);
     }

     public function listar()
     {
         
         $sql = $this->conexion->prepare("SELECT shadow.id, shadow.nombre, rol.nombreRol FROM shadow INNER JOIN rol on (shadow.id_rol = rol.id )");
         
		 $sql->execute();
		 
         $listado = $sql->fetchAll(PDO::FETCH_ASSOC);
		
			
        return $listado;
     }
     
     public function usuarioConId($id)
     {
         $sql = $this->conexion->prepare("SELECT nombre FROM `shadow` WHERE id='$id'");

		 $sql->execute();
		 
         $listado = $sql->fetchAll(PDO::FETCH_ASSOC);
			
        return $listado;
     }
     
     public function borrarUsuarioConId($id)
     {
         $sql = $this->conexion->prepare("DELETE FROM shadow WHERE id='$id'");

		 $sql->execute();
		 
         $listado = $sql->fetchAll(PDO::FETCH_ASSOC);
			
        return $listado;
     }
     
     public function listarRoles(){
		 
		 $sql = $this->conexion->prepare("SELECT nombreRol FROM rol");

		 $sql->execute();
		 
         $listado = $sql->fetchAll(PDO::FETCH_ASSOC);
			
        return $listado; 
		
	 }
     
      public function listarUsuarios(){
		 
		 $sql = $this->conexion->prepare("SELECT nombre FROM shadow");

		 $sql->execute();
		 
         $listado = $sql->fetchAll(PDO::FETCH_ASSOC);
			
        return $listado; 
		
	 }
     
	  public function listarRol($id){
		 
		 $sql = $this->conexion->prepare("SELECT id FROM rol WHERE id='$id'");

		 $sql->execute();
		 
         $listado = $sql->fetchAll(PDO::FETCH_ASSOC);
			
        return $listado; 
		
	 }
	 
	 public function listarUsuario($id){
		 
		 $sql = $this->conexion->prepare("SELECT nombre FROM shadow WHERE id='$id'");

		 $sql->execute();
		 
         $listado = $sql->fetchAll(PDO::FETCH_ASSOC);
			
        return $listado; 
		
	 }
	 
	 public function listarPorId($id){
	 
	 
		$sql = $this->conexion->prepare("SELECT shadow.id, shadow.nombre, rol.nombreRol FROM shadow INNER JOIN rol on (shadow.id_rol = rol.id ) WHERE shadow.id='$id'");

		 $sql->execute();
		 
         $listado = $sql->fetchAll(PDO::FETCH_ASSOC);
			
        return $listado;
	 
	 
	} 
	
	 
     
     /*
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
		$sql = $this->conexion->prepare("SELECT detalle_alimento.id,
												alimento.descripcion,
												detalle_alimento.fecha_vencimiento as 'fecha',	
												detalle_alimento.contenido,
												detalle_alimento.peso_paquete as 'peso',
												detalle_alimento.stock, 
												detalle_alimento.reservado,
												alimento_donante.donante_id as 'donante',
												alimento_donante.cantidad
										 FROM detalle_alimento INNER JOIN alimento_donante INNER JOIN alimento
										 WHERE (detalle_alimento.id=alimento_donante.detalle_alimento_id) 
											   AND (detalle_alimento.id='$id') AND (detalle_alimento.alimento_codigo=alimento.codigo)");
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
*/
 }