<?php

//conection:
$db_host="127.0.0.1";
$db_user="grupo_48";
$db_pass="tHVmHSdXZV1Nw99T";
$db_base="grupo_48"; 

try {
	$cn = new PDO("mysql:dbname=$db_base;host=$db_host",$db_user,$db_pass);
	$query = "SELECT * FROM shadow where nombre='".$_POST["usuario"]."' and pass='".$_POST["pass"]."';";
	$result=$cn->query($query); 
	
	/*
	//display information:
	echo "<br>Variables Recibidas:";
	echo"<br>Usuario: <strong>". $_POST["usuario"]."</strong>";
	echo"<br>PASS: <strong>". $_POST["pass"]."</strong>";
	

	
	echo "<br> El query que hicimos fue ". $query;

	echo "<br> El n&uacute;mero de resultados fue " . $result->rowCount();
	*/
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
		$doc =& JFactory::getDocument();
		$doc->setMetaData('refresh', '5;url=index.php', 'true');
	}
	
	/*
	echo "<br> <br>Objeto resultado ";
	print_r($result);
	
	echo "<br> <br>Elementos resultado ";
	
	print_r($result->fetchAll());*/
	
	}
catch(PDOException $e){
	echo "ERROR". $e->getMessage();
	}


?>
