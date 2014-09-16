<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
</head>

<body>
<?php
$usr = $_REQUEST["user"];
$pass = $_REQUEST["pass"];

$file = fopen("usuarios.dat","r");

$usuario = trim(fgetss($file)); //si no ponemos el trim no funca
$password = trim(fgetss($file));

fclose($file);

if ($usr==$usuario && $pass==$password ) {
		echo "Correcto"; 
		
		session_start(); //inicia una sesión
		setcookie("cookieNombre", $usr); //Setea una cookie con el nombre del usuario
}

else{
		echo "Incorrecto";
}
	



?> 



</body>

</html>