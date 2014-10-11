<?php

require_once './Config.php';
require_once './models/Model.php';
require_once './models/ModelLogin.php';
require_once './controllers/ControllerLogin.php';


if ($_SERVER["REQUEST_METHOD"] == "POST"){
	$usuario= $_POST["usuario"];
	$pass= $_POST["pass"];

	$intentoLogin = ModelLogin::consultar($usuario,$pass);


	
	if (!$intentoLogin)	{
		//echo falló en la autenticación de usuario
		echo "Falló el login. System halted";
		die;
	}
	else{ //login correcto. Hay que verificar el rol
		
		session_start();
		$_SESSION['USUARIO']['userName'] = $_POST["usuario"];
		$_SESSION['USUARIO']['rol']= $intentoLogin[0]['rol'];
				
		header('Location: ../web/backend.php');;
		
			
			
			
			
		}
		
		
		echo "Sesion de consulta";
		
		
		
		
		
	
	}else {
	echo "Acceso no autorizado";
	die;}
	
?>
