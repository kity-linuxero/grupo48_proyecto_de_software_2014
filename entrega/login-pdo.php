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
	// $_SESSION['rol'] = $POST["usuario"];

		
	header("location: backend.php");
	}
	else{
		$errmsg_arr[] = 'Username and Password are not found';
		$errflag = true;
		echo "<script type='text/javascript'> alert('Error de login'); </script>";
	
	}
}
catch(PDOException $e){
	echo "ERROR". $e->getMessage();
	}


?>
