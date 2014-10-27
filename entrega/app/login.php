<?php
session_start();

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
				alert("Usuario y/o contraseña incorrectos. Intente nuevamente con admin/admin o consulta/consulta"); 
				window.location= "../web/index.php";
				</script>;
		');
    }
	else{
		//login correcto. Hay que verificar el rol
		
		
		
		
		
		
		$_SESSION['USUARIO']['userName']= $_POST["usuario"];
		$_SESSION['USUARIO']['rol'] = $intentoLogin[0]['nombreRol'];
		$_SESSION['USUARIO']['id'] = $intentoLogin[0]['id'];

		
		switch (dameRol()) {
			case "administrador":
			//sentencias para usuario administrador
				header('Location: ../web/backend.php');
			break;
			case "consulta":
				//Sentencias para usuario consulta
				header('Location: ../web/backend.php');
			
			break;
			
		
		}
	
	}
}
	
?>
