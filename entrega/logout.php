<?php
	session_destroy();
	$_SESSION = array();
	header("location:index.html");
?>
