<?php
/*
 *	This software is MIT Licensed (see LICENSE)
 *	Copyright (c) 2014-2016 Cristian O. Giambruni, Ezequiel F. Gómez
 */

	session_start();
	session_unset();
	session_destroy(); 
	header('Location: ../web/index.php');
?>
