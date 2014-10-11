<?php
 
 class ControllerFront
 {

	//configura los parámetros de Twig para el controllerFront
	private static function configTwig(){
		require_once __DIR__ . '/../twig/lib/Twig/Autoloader.php';
		Twig_Autoloader::register();

		$loader = new Twig_Loader_Filesystem('./../app/twig/templates');

		$twig = new Twig_Environment($loader, array(
			'cache' => 'cache',
			'debug' => 'true'));
		return $twig;
	
	}
 
 
     public function inicio()
     {
		$twig = $this::configTwig();
        $template = $twig->loadTemplate('index.twig.html');
		echo $template->render(array());
     }
	 
	public function contacto()
    {
		$twig = $this::configTwig();
        $template = $twig->loadTemplate('contacto.twig.html');
		echo $template->render(array());
    }
    
   /* public function login()
    {
		
		$intento = New ModelLogin(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario, Config::$mvc_bd_clave, Config::$mvc_bd_hostname);
		$intento->log($_POST);
		
    }*/
	 
	 
	public function mensaje()
    {
		$twig = $this->configTwig();
        $template = $twig->loadTemplate('mensajeFront.twig.html');
		echo $template->render(array('mensaje' => $_GET));
    }
	 
	public function listarDonantes()
    {	 
		$twig = $this->configTwig();
         $m = new ModelDonante(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                     Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

         $params = array('donantes' => $m->listar()   );

		echo $twig->render('listadoDonantes.html', array('donantes' => $params['donantes']));
    }

    public function listarEntidades()
    {
		$twig = $this->configTwig();
        $m = new ModelEntidad(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);
        
        $params = array('entidades' => $m->listar()   );
        
		echo $twig->render('listadoEntidades.html', array('entidades' => $params['entidades']));
    }

     public function quienesSomos()
     {
         require Config::$plantillas . 'quienesSomos.html';
     }

 }
