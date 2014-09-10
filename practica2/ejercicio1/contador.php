<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
</head>
<body>
	<h1> En este ejemplo leeremos el contenido del archivo contador.txt, lo mostramos al usuario y lo incrementaremos en 1</h1>
	<h2> Tener en cuenta los permisos del archivo.... </h2>
<?php
$archivo = "contador.txt";
$contador = 0;

$fp = fopen($archivo,"r");
$contador = fgets($fp);
fclose($fp);

++$contador;

$fp = fopen($archivo,"w+");
fwrite($fp, $contador);
fclose($fp);

echo "Esta página ha sido visitada $contador veces";
?> 
</body>
</html>
