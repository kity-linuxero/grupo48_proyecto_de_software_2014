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
	 
	 
		$sql = $this->conexion->prepare("SELECT shadow.id, shadow.nombre, rol.nombreRol, shadow.pass FROM shadow INNER JOIN rol on (shadow.id_rol = rol.id ) WHERE shadow.id='$id'");

		 $sql->execute();
		 
         $listado = $sql->fetchAll(PDO::FETCH_ASSOC);
			
        return $listado;
	 
	 
	}
	
	//Retorna si el usuario ya existe.
	public function existeUsuario($nombreUsuario){
	 
		 $sql = $this->conexion->prepare("SELECT nombre FROM shadow WHERE nombre='$nombreUsuario'");

		 $sql->execute();
		 
         $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
		
			
         if (count($resultado) == 0){ 
			
			
			return false;
		}
		else{
			
			return true;
			}
	} 
	
	
	 public function agregar($n, $r, $p)
     {
         $sql = $this->conexion->prepare("INSERT into shadow
										(nombre, id_rol, pass)
												  VALUES ('$n', '$r', '$p')");
         $sql->execute();
     
	}
	
	 public function borrar($id)
    {
         $sql = $this->conexion->prepare("DELETE from shadow
										WHERE id = '$id'");
         $sql->execute();
     
	}
	
	 public function modificar($id, $n, $r, $p)
     {
         
		 
		 $sql = $this->conexion->prepare("UPDATE shadow
										SET nombre='$n',
											id_rol='$r',
											pass='$p'
										WHERE id = '$id'");
         $sql->execute();
     
	}
	
	 public function verConfiguracion()
     {
         
		$sql = $this->conexion->prepare("SELECT * FROM configuracion");

		 $sql->execute();
		 
         $listado = $sql->fetchAll(PDO::FETCH_ASSOC);
			
        return $listado; 
     
	}
	
 }
