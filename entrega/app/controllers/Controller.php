<?php
/*
 *	MIT License
 *
 *	Copyright (c) 2014-2016 Cristian O. Giambruni, Ezequiel F. Gómez
 *
 *	Permission is hereby granted, free of charge, to any person obtaining a copy
 *	of this software and associated documentation files (the "Software"), to deal
 *	in the Software without restriction, including without limitation the rights
 *	to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *	copies of the Software, and to permit persons to whom the Software is
 *	furnished to do so, subject to the following conditions:
 *
 *	The above copyright notice and this permission notice shall be included in all
 *	copies or substantial portions of the Software.
 *
 *	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 *	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *	LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *	OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 *	SOFTWARE.
 */

require_once __DIR__ . '/ControllerLogin.php';

 class Controller
 {
	protected $twig; // variable para las plantillas twig
	protected $mE; 	 // variable para la conexión del modelo entidades
	protected $mA; 	 // variable para la conexión del modelo alimentos
	protected $mD; 	 // variable para la conexión del modelo donantes
	protected $us;   // variable para la conexión del modelo usuarios
	protected $mP;   // variable para la conexion del modelo de pedidos
	protected $msj;
	
	//configura los parámetros de Twig para el controllerBack
	
	public function __construct($accion)
	{
		$this->twig = $this->configTwig();
		
		
		if (Model::testConect()){ //si la conexión resulta exitosa
		
			if ($accion == 'publico') {
				$this->mE = new ModelEntidad(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
							 Config::$mvc_bd_clave, Config::$mvc_bd_hostname);	
				$this->mD = new ModelDonante(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
							 Config::$mvc_bd_clave, Config::$mvc_bd_hostname);	
				$this->us = new ModelUsers(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
							 Config::$mvc_bd_clave, Config::$mvc_bd_hostname);
			}	
			elseif (postaTengoPermiso($accion)) {
				$this->mE = new ModelEntidad(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
							 Config::$mvc_bd_clave, Config::$mvc_bd_hostname);	
				$this->mD = new ModelDonante(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
							 Config::$mvc_bd_clave, Config::$mvc_bd_hostname);	
				$this->mA = new ModelAlimento(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
							 Config::$mvc_bd_clave, Config::$mvc_bd_hostname);
				$this->us = new ModelUsers(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
							 Config::$mvc_bd_clave, Config::$mvc_bd_hostname);
				$this->mP = new ModelPedido(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
							 Config::$mvc_bd_clave, Config::$mvc_bd_hostname);
			} 
			else {
				$msj = "Usted no posee permisos para realizar dicha operación";
				echo $this->twig->render('index.twig.html', array('mensaje' => $msj));
			}
		}
	}
	
	private static function configTwig(){
		require_once __DIR__ . '/../twig/lib/Twig/Autoloader.php';
		Twig_Autoloader::register();

		$loader = new Twig_Loader_Filesystem('./../app/twig/templates');

		$twig_temp = new Twig_Environment($loader, array(
			'debug' => 'true'));
		return $twig_temp;
	}
	
		//la siguiente función se usa para el manejo de excepciones
	public static function exepciones($e, $mensajes, $error){
			require_once __DIR__ . '/../twig/lib/Twig/Autoloader.php';
			Twig_Autoloader::register();
		
			$loader = new Twig_Loader_Filesystem('./../app/twig/templates');
			$newTwig = new Twig_Environment($loader, array());
			
			
			echo $newTwig->render('errorBlue.twig.html', array('mensaje' => $mensajes, 'error' => $error));
			
			
	}
	
	public static function xss($text)
	{ 
		// validar texto
		$comment = trim($text);
		 
		// sanitizar texto
		$comment = strip_tags($comment);
		
		return $comment;
	}
	
 }
?>
