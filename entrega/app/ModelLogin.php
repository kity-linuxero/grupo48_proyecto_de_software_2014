<?php

 class ModelLogin extends Model
 {
 //    protected $conexion;

     public function __construct($dbname,$dbuser,$dbpass,$dbhost)
     {
		parent::__construct($dbname,$dbuser,$dbpass,$dbhost);
     }


	private function consultar($user,$pass){
			
		$sql = $this->conexion->prepare("SELECT * FROM shadow where nombre='".$user."' and pass='".$pass."';");
		
		$sql->execute();
		 
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        
		
		
        //consulto la cantidad de coincidencias.
        if (!count($resultado)){ 
			
			return 0;
		}
		else{
			return $resultado;
			}
		}


     public function log($user,$pass)
     {
         
         
		
         if(!isset($_SESSION['usuario'])) //si no hay sesión de usuario activa
		{
			
			$consulta = $this->consultar($user,$pass);
			
			
			
			
			if($consulta) {
				//login correcto. 
					
					
			//	session_start();
				$_SESSION['usuario'] = $user;
				
				
				
				
				$_SESSION['rol']= $consulta[0]['rol'];
				
				
				
				

				}
			else{ //login incorrecto
				 
				 
				 
				 return 0;
				}
		}
        
			
         
    // retorna 1
	return 1;
	 
	}
	
	public function esAdministrador($unRol){
		
		
		}

         
}
 ?>
