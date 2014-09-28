<?php

require_once './php/Conector.php';

try {
	
	$miConexion = Conector::conectar();

	
	$query = "SELECT * FROM shadow where nombre='".$_POST["usuario"]."' and pass='".$_POST["pass"]."';";
	$result=$miConexion->query($query); 
	
	
	$rows = $result->fetch(PDO::FETCH_NUM);
	if($rows > 0) {
		//el login es exitoso
		
		session_start();
		$_SESSION['usuario'] = $_POST["usuario"];
	
		$_SESSION['rol'] = $rows[2];

		
	header("location: backend.php");
	}
	else{
		
	
	 header("location: index.php?mensaje=Error de inicio de sesion");
	}
}
catch(PDOException $e){
	echo "ERROR". $e->getMessage();
	}


?>
