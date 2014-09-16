<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
</head>

<?php
  session_start();
?>


<body>
	<h1> En este ejemplo leeremos el contenido del archivo contador.txt, lo mostramos al usuario y lo incrementaremos en 1</h1>
	<h2> Tener en cuenta los permisos del archivo.... </h2>


<?php
$archivo = "contador.txt";
$contador = 0;

$fp = fopen($archivo,"r"); //Solo lectura
$contador = fgets($fp); 
fclose($fp); //cierra el archivo

if (!isset($_SESSION['count'])) {
  $_SESSION['count'] = 0;
  ++$contador; //incrementa cantidad de visitas
} else {
  $_SESSION['count']++;
  
}


$fp = fopen($archivo,"w+"); //reemplaza el archivo. Si no existe lo crea.
fwrite($fp, $contador); //escribo el archivo
fclose($fp); 

echo "Esta página ha sido visitada $contador veces";
?> 


</body>
</html>
