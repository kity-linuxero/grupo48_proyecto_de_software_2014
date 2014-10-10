<?php

 class ControllerBack
 {
	//configura los parámetros de Twig para el controllerBack
	private static function configTwig(){
		require_once __DIR__ . '/twig/lib/Twig/Autoloader.php';
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
		echo $twig->render('backend.twig.html');
     }
	 
	public function contacto()
    {
		$twig = $this::configTwig();
		$template =  $twig->loadTemplate('contacto.twig.html');
		echo $template->render(array());
    }
    	 
	public function listarDonantes()
    {	 
		$twig = $this->configTwig();
        $m = new ModelDonante(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                     Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

         $params = array('donantes' => $m->listar()   );

		echo $twig->render('abmDonantes.html', array('donantes' => $params['donantes']));
    }

	public function altaDonante() {
		$twig = $this->configTwig();
        $m = new ModelDonante(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                     Config::$mvc_bd_clave, Config::$mvc_bd_hostname);
		echo "probando enlace altaDonante";
		die;
	}

	public function modificarDonante($id) {
		$twig = $this->configTwig();
        $m = new ModelDonante(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                     Config::$mvc_bd_clave, Config::$mvc_bd_hostname);	

		$params = array('donantes' => $m->modificar($id)   );
		
		echo $twig->render('formDonantes.html', array('donantes' => $params['donantes']));
		
	}

	public function bajaDonante($id) {
		echo "probando enlace bajaDonante con $id";
		die;
	}
	
    public function listarEntidades()
    {
		$twig = $this->configTwig();
        $m = new ModelEntidad(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);
        
        $params = array('entidades' => $m->listar()   );
        
		echo $twig->render('abmEntidades.html', array('entidades' => $params['entidades']));
    }

	public function altaEntidad() {
		echo "probando enlace bajaEntidad";
		die;
	}

	public function modificarEntidad() {
		echo "probando enlace bajaEntidad";
		die;
	}

	public function bajaEntidad() {
		echo "probando enlace bajaEntidad";
		die;
	}
			    
        public function listarAlimentos()
    {
		$twig = $this->configTwig();
        $m = new ModelAlimento(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);
        
        $params = array('alimentos' => $m->listar()   );
        
		echo $twig->render('abmAlimentos.html', array('alimentos' => $params['alimentos']));
    }

		public function bajaAlimento() {
		echo "probando enlace bajaAlimento";
		die;
	}
	

     public function quienesSomos()
     {
         require Config::$plantillas . 'quienesSomos.html';
     }

	 public function logout()
	 {
	 
	 }
	 
 }
?>