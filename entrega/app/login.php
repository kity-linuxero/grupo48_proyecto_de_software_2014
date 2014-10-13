<?php

require_once './Config.php';
require_once './models/Model.php';
require_once './models/ModelLogin.php';
require_once './controllers/ControllerLogin.php';


if ($_SERVER["REQUEST_METHOD"] == "POST"){
	$usuario= $_POST["usuario"];
	$pass= $_POST["pass"];

	$intentoLogin = ModelLogin::consultar($usuario,$pass);
	
	if ($intentoLogin == 0)	{
		//echo falló en la autenticación de usuario
		echo('		
				<script type="text/javascript">; 
				alert("Usuario y/o contraseña incorrectos. Intente nuevamente."); 
				window.location= "../web/index.php";
				</script>;
		');
    }
	else{
		//login correcto. Hay que verificar el rol
		session_start();
		$_SESSION['usuario'] = $_POST["usuario"];
		$_SESSION['rol'] = $intentoLogin[0]['rol'];

		header('Location: ../web/backend.php');
		}
}
	
?>
