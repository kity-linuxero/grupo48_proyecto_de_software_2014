<?php
/*	session_destroy();
	//$_SESSION = array();
	unset($_SESSION['usuario']);
	unset($_SESSION['rol']); */
	session_unset(); 
	header("location:index.php");
?>
