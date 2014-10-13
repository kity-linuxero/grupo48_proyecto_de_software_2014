<?php

require_once __DIR__ . '/ControllerLogin.php';

 class ControllerBack
 {
	//configura los parámetros de Twig para el controllerBack
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
	//	echo $twig->render('backend.twig.html', array('usuario' => $_SESSION['usuario']));
		echo $twig->render('backend.twig.html', array('usuario' => dameUsuario()));
     }
	 
	public function contacto()
    {
		$twig = $this::configTwig();
		$template =  $twig->loadTemplate('contacto.twig.html');
		echo $template->render(array());
    }
    
// ------------------------------------------------------------------------------------------------------------------------------------
// -------------------------------------------- DECLARACION DE FUNCIONES PARA LOS DONANTES --------------------------------------------
// ------------------------------------------------------------------------------------------------------------------------------------
	
	public function listarDonantes()
    {	
		if (postaTengoPermiso('listarDonantes')){

			$twig = $this->configTwig();
			$m = new ModelDonante(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                     Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

			$params = array('donantes' => $m->listar());

			echo $twig->render('abmDonantes.html', array('donantes' => $params['donantes'], 'usuario' => dameUsuario()));
	}
	else{
		echo "<script>window.alert('No tiene permisos para realizar esta operación.'); window.location = './index.php';</script>";
    }
    }

	public function altaDonante() {
	if (postaTengoPermiso('listarDonantes')){
		$params = array(
             'razon_social' => '',
             'nombre' => '',
             'apellido' => '',
             'domicilio' => '',
             'telefono' => '',
             'mail' => '',
         );

        $m = new ModelDonante(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                     Config::$mvc_bd_clave, Config::$mvc_bd_hostname);
		$twig = $this->configTwig();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// comprobar campos formulario
             if ($m->validarDatos($_POST['razon_social'],
                      $_POST['nombre'], $_POST['apellido'],
                      $_POST['telefono'], $_POST['mail']))
			{
				 $m->agregar($_POST['razon_social'],
                      $_POST['nombre'], $_POST['apellido'],
                      $_POST['telefono'], $_POST['mail']);
                 header('Location: backend.php?accion=listarDonantes');
             } else {
                 $params = array(
                     'razon_social' => $_POST['razon_social'],
                     'nombre' => $_POST['nombre'],
                     'apellido' => $_POST['apellido'],
                     'telefono' => $_POST['telefono'],
                     'mail' => $_POST['mail'],
                 );
                 $params['mensaje'] = 'No se ha podido insertar el alimento. Revisa el formulario';
             }
        }
		echo $twig->render('formInsDonante.twig.html', array('params' => $params , 'usuario' => dameUsuario()));
		
		}
	else{
		echo "<script>window.alert('No tiene permisos para realizar esta operación.'); window.location = './index.php';</script>";
    }
		
	}

	public function modificarDonante()
	{
	if (postaTengoPermiso('listarDonantes')){
		
		$m = new ModelDonante(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                     Config::$mvc_bd_clave, Config::$mvc_bd_hostname);
		$twig = $this->configTwig();

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// comprobar campos formulario
             if ($m->validarDatos($_POST['razon_social'],
                      $_POST['nombre'], $_POST['apellido'],
                      $_POST['telefono'], $_POST['mail']))
			 {
				 $m->modificar($_GET['id'], $_POST['razon_social'],
                      $_POST['nombre'], $_POST['apellido'],
                      $_POST['telefono'], $_POST['mail']);
                 header('Location: backend.php?accion=listarDonantes');
			 }
		}
		$donante = $m->obtenerPorID($_GET['id']);
		$params = array(
				 'id' => $donante['id'],
				 'razon_social' => $donante['razon_social'],
				 'nombre' => $donante['nombre'],
				 'apellido' => $donante['apellido'],
				 'telefono' => $donante['telefono'],
				 'mail' => $donante['mail'],
				);
         echo $twig->render('formModDonante.twig.html', array('params' => $params , 'usuario' => dameUsuario()));					
	
	}
	else{
		echo "<script>window.alert('No tiene permisos para realizar esta operación.'); window.location = './index.php';</script>";
    }
	
	}

	public function bajaDonante() {
	  if (postaTengoPermiso('listarDonantes')){
		
		$twig = $this->configTwig();
		$m = new ModelDonante(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                     Config::$mvc_bd_clave, Config::$mvc_bd_hostname);
		$m->eliminar($_GET['id']);
		header('Location: backend.php?accion=listarDonantes');
	
	
	
	}
	else{ //NO TIENE PERMISOS PARA REALIZAR ESTA OPERACIÓN.
		echo "<script>window.alert('No tiene permisos para realizar esta operación.'); window.location = './index.php';</script>";
    }
}

// ------------------------------------------------------------------------------------------------------------------------------------
// --------------------------------------- DECLARACION DE FUNCIONES PARA LAS ENTIDADES RECEPTORAS -------------------------------------
// ------------------------------------------------------------------------------------------------------------------------------------
	
    public function listarEntidades()
    {
		$twig = $this->configTwig();
        $m = new ModelEntidad(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);
        
        $params = array('entidades' => $m->listar()   );
        
		echo $twig->render('abmEntidades.html', array('entidades' => $params['entidades'], 'usuario' => dameUsuario()));
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

// ------------------------------------------------------------------------------------------------------------------------------------
// -------------------------------------------- DECLARACION DE FUNCIONES PARA LOS ALIMENTOS--------------------------------------------
// ------------------------------------------------------------------------------------------------------------------------------------

    public function listarAlimentos()
    {
		$twig = $this->configTwig();
        $m = new ModelAlimento(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
                    Config::$mvc_bd_clave, Config::$mvc_bd_hostname);
        
        $params = array('alimentos' => $m->listar()   );
        
		echo $twig->render('abmAlimentos.html', array('alimentos' => $params['alimentos'], 'usuario' => dameUsuario()));
    }

	public function altaAlimento() {
		echo "probando enlace altaAlimento";
		die;
	}

	public function modificarAlimento() {
		echo "probando enlace modificarAlimento";
		die;
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
		echo $twig->render('index.twig.html');
	 }
	 
 }
 
 
 
?>
