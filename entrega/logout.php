<?php
session_destroy('usuario');
$_SESSION = array();
header("location:index.html");
?>
