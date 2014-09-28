<?php

require_once './php/Conector.php';
require_once './twig.php';

$action = $_GET["action"];
$parametros = array("twig" => $twig, "post" => $_POST);
call_user_func($action, $parametros);

function listar($parametros){
	$miConexion = Conector::conectar();
	$query = $miConexion->prepare('SELECT codigo,descripcion FROM alimento');
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
	
	//$query = $miConexion->prepare('INSERT INTO donante (razon_social, nombre, apellido, telefono, mail) VALUES ($_POST['razon'], $_POST['nombre'],$_POST['apellido'],$_POST['tel'], $_POST['email']'););
	$query = $miConexion->prepare("INSERT INTO donante (razon_social, nombre, apellido, telefono, mail) VALUES('$razon', '$nombre','$apellido','$tel', '$email')");	 
	
	var_dump($query);
	$query->execute();
	die;
}

?>
