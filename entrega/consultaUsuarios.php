<!DOCTYPE html>
<html lang="es">
<head>
 <meta charset="utf-8" />
 <link rel="stylesheet" media="(min-width: 481px)" href="./estilos/maqueta.css" type="text/css">
 <link rel="stylesheet" media="(min-width: 481px)" href="./estilos/botonera.css" type="text/css"/>
 <link rel="stylesheet" media="(max-width: 480px)" href="./estilos/maquetaMobile.css" />
 <link rel="stylesheet" media="(max-width: 480px)" href="./estilos/botoneraMobile.css" />
 <link rel="stylesheet" href="./estilos/login.css" type="text/css"/>
 
 
 <title>Sistema Online del Banco Alimentario La Plata</title>
 
</head>
<body>

<?php

//conection:
$db_host="127.0.0.1";
$db_user="grupo_48";
$db_pass="tHVmHSdXZV1Nw99T";
$db_base="grupo_48"; 

$cn = new PDO("mysql:dbname=$db_base;host=$db_host",$db_user,$db_pass);
$query = "SELECT * FROM shadow";
$result=$cn->query($query); 
while($row = mysql_fetch_array($result)) {
	echo $row['nombre'];
	}
?>

</body>
</html>
