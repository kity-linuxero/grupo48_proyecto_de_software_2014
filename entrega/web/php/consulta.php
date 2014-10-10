<?php

    $gbd = new PDO('mysql:host=localhost;dbname=grupo_48', 'grupo_48', 'tHVmHSdXZV1Nw99T');
try {
//	echo "<table>"
    foreach($gbd->query('SELECT codigo,descripcion FROM alimento') as $consulta) {
               //print_r($consulta);
			   echo $consulta[0]." ".$consulta[1];
			   echo "<br>";
			}   
//	echo "</table>";
			   
throw new Exception("hola!");

			   
} catch (Exception $e) {
   print "¡Error!: " . $e->getMessage() . "<br/>";
   die();
}
?>
