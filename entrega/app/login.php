<?php

require_once './Config.php';
require_once './Model.php';
require_once './ModelLogin.php';

$usuario= $_POST["usuario"];
$pass= $_POST["pass"];

$intentoLogin = New ModelLogin(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario, Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

$resultado= $intentoLogin->log($usuario,$pass);

session_start();



if (!$resultado)	{
	//echo falló en la autenticación de usuario
	echo "Falló el login. System halted";
	die;
	}
	else{ //login correcto. Hay que verificar el rol
		
		
			if($_SESSION['rol']=='administrador'){
			
			
			
			
		}
		else{ //co
		
			//echo "Sesion de consulta";
			
		}
		
		
		
		//echo $_SESSION['rol'];
		header('Location: ../web/backend.php');
	
	}
	
?>
