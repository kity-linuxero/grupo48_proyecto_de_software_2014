<?php
/*
 * @Cristian
 * Esta clase modifica 
 * 
 * */
class ValidadorSesion {
	
		
	//Se conecta y retorna la conexión
	public static function validar(){
		
		//creamos la sesion
		session_start();

		//validamos si se ha hecho o no el inicio de sesion correctamente

		//si no se ha hecho la sesion nos regresará false
		if(!isset($_SESSION['usuario'])) 
		{
			session_destroy();
			echo "hoola";
			
			return false;
			//header('Location: index.html'); 
	
		}
		else{
		//	echo "chau";
		//	die;
			return true;
			}
	
	}
	
	
	}
	

	
	
	
?>
