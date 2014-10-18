<?php

require_once __DIR__ . '/ControllerLogin.php';

 class Controller
 {
	protected $twig; // variable para las plantillas twig
	protected $mE; 	 // variable para la conexión del modelo entidades
	protected $mA; 	 // variable para la conexión del modelo alimentos
	protected $mD; 	 // variable para la conexión del modelo donantes
	protected $mR; 	 // variable para la conexión del modelo recepciones
	
	//configura los parámetros de Twig para el controllerBack
	
	public function __construct($accion)
	{
		if ($accion == 'publico') {
			$this->twig = $this->configTwig();
			$this->mE = new ModelEntidad(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
						 Config::$mvc_bd_clave, Config::$mvc_bd_hostname);	
			$this->mD = new ModelDonante(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
						 Config::$mvc_bd_clave, Config::$mvc_bd_hostname);	
		}	
		elseif (postaTengoPermiso($accion)) {
			$this->twig = $this->configTwig();
			$this->mE = new ModelEntidad(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
						 Config::$mvc_bd_clave, Config::$mvc_bd_hostname);	
			$this->mD = new ModelDonante(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
						 Config::$mvc_bd_clave, Config::$mvc_bd_hostname);	
			$this->mR = new ModelRecepcion(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
						 Config::$mvc_bd_clave, Config::$mvc_bd_hostname);	
			$this->mA = new ModelAlimento(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
						 Config::$mvc_bd_clave, Config::$mvc_bd_hostname);
		} else {
			echo ("<script>window.alert('No tiene permisos para realizar esta operación.');
						   window.location = './index.php';</script>");
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
 
 }
?>
