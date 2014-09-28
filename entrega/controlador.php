<?php

require_once './php/Conector.php';
require_once './twig.php';

$action = $_GET["action"];
$parametros = array("twig" => $twig, "post" => $_POST);
call_user_func($action, $parametros);

function listar($parametros){
	$miConexion = Conector::conectar();
	$query = $miConexion->prepare('SELECT * FROM alimento JOIN detalle_alimento WHERE alimento.codigo=detalle_alimento.alimento_codigo');
	$query->execute();
	$result=$query->fetchAll(PDO::FETCH_ASSOC);
	echo $parametros["twig"]->render('listadoAlimentos.html', array("alimentos" => $result));

}

function altaAlimento($parametros){
	$miConexion = Conector::conectar();
	echo "altaAlimento";
}

function altaDonante($parametros){
	$razon=$_POST['razon'];
	$nombre=$_POST['nombre'];
	$apellido=$_POST['apellido'];
	$tel=$_POST['tel'];
	$email=$_POST['email'];
	
	$miConexion = Conector::conectar();
	
	$query = $miConexion->prepare("INSERT INTO donante (razon_social, nombre, apellido, telefono, mail) VALUES('$razon', '$nombre','$apellido','$tel', '$email')");	 
	
	var_dump($query);
	$query->execute();
	die;
}

function altaEntidad($parametros){
	$razon=$_POST['razon'];
	$domicilio=$_POST['domicilio'];
	$servicio=$_POST['servicio'];
	$tel=$_POST['tel'];
	$necesidad=$_POST['necesidad'];
	$estado=$_POST['estado'];
	
	$miConexion = Conector::conectar();
	$query = $miConexion->prepare("INSERT INTO entidad_receptora(razon_social, telefono, domicilio, estado_entidad_id, necesidad_entidad_id, servicio_prestado_id) VALUES ('$razon', '$tel','$domicilio',$estado, $necesidad, $servicio)");	 
	var_dump($query);
	$query->execute();
	die;
}

?>
