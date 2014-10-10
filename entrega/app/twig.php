<?php

		require_once __DIR__ . '/twig/lib/Twig/Autoloader.php';
		Twig_Autoloader::register();

		$loader = new Twig_Loader_Filesystem('./../app/twig/templates');

		$twig = new Twig_Environment($loader, array(
			'cache' => 'cache',
			'debug' => 'true'));

?>
