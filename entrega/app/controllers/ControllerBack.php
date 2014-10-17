<?php

require_once __DIR__ . '/ControllerLogin.php';

 class ControllerBack extends Controller
 {
	
	public function __construct()
	{		
		if (isset($_GET['accion'])) {
			parent::__construct($_GET['accion']);
		} else {
			parent::__construct('inicio');
		}
	}
 
	public function inicio()
     {
		switch (dameRol()) {
			case "administrador":
				//sentencias para usuario administrador
				echo $this->twig->render('backend.twig.html', array('usuario' => dameUsuario()));
			break;
			case "consulta":
				//Sentencias para usuario consulta
				echo $this->twig->render('layoutBackConsulta.twig.html', array('usuario' => dameUsuario()));
			break;
		}
     }
	 
	public function contacto()
    {
		echo $this->twig->render('contacto.twig.html', array('usuario' => $_SESSION['USUARIO']));
    }
    
// ------------------------------------------------------------------------------------------------------------------------------------
// -------------------------------------------- DECLARACION DE FUNCIONES PARA LOS DONANTES --------------------------------------------
// ------------------------------------------------------------------------------------------------------------------------------------
	
	public function listarDonantes()
    {	 
        $params = array('donantes' => $this->mD->listar());
		echo $this->twig->render('abmDonantes.html', array('donantes' => $params['donantes'], 'usuario' => $_SESSION['USUARIO']['userName']));
    }

	public function altaDonante() {

		$params = array(
             'razon_social' => '',
             'nombre' => '',
             'apellido' => '',
             'domicilio' => '',
             'telefono' => '',
             'mail' => '',
         );

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// comprobar campos formulario
             if ($this->mD->validarDatos($_POST['razon_social'],
                      $_POST['nombre'], $_POST['apellido'], $_POST['domicilio'],
                      $_POST['telefono'], $_POST['mail']))
			{
				 $this->mD->agregar($_POST['razon_social'],
                      $_POST['nombre'], $_POST['apellido'], $_POST['domicilio'],
                      $_POST['telefono'], $_POST['mail']);
                 header('Location: backend.php?accion=listarDonantes');
             } else { // mostrar mensaje, lo hiciste mal, llenalo de nuevo
                 $params = array(
                     'razon_social' => $_POST['razon_social'],
                     'nombre' => $_POST['nombre'],
                     'apellido' => $_POST['apellido'],
					 'domicilio' => $_POST['domicilio'],
                     'telefono' => $_POST['telefono'],
                     'mail' => $_POST['mail'],
                 );
                 $params['mensaje'] = 'No se ha podido insertar el alimento. Revisa el formulario';
             }
        }
		echo $this->twig->render('formInsDonante.twig.html', array('params' => $params , 'usuario' => $_SESSION['USUARIO']['userName']));
	}

	public function modificarDonante()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// comprobar campos formulario
             if ($this->mD->validarDatos($_POST['razon_social'],
                      $_POST['nombre'], $_POST['apellido'], $_POST['domicilio'],
                      $_POST['telefono'], $_POST['mail']))
			 {
				 $this->mD->modificar($_GET['id'], $_POST['razon_social'],
                      $_POST['nombre'], $_POST['apellido'], $_POST['domicilio'],
                      $_POST['telefono'], $_POST['mail']);
                 header('Location: backend.php?accion=listarDonantes');
			 }
		}
		if (isset($_GET['id'])) {
			$donante = $this->mD->obtenerPorID($_GET['id']);
		} else {
			header('Location: backend.php?accion=listarDonantes');
		}
		$params = array(
				 'id' => $donante['id'],
				 'razon_social' => $donante['razon_social'],
				 'nombre' => $donante['nombre'],
				 'apellido' => $donante['apellido'],
				 'domicilio' => $donante['domicilio'],
				 'telefono' => $donante['telefono'],
				 'mail' => $donante['mail'],
				);
         echo $this->twig->render('formModDonante.twig.html', array('params' => $params , 'usuario' => $_SESSION['USUARIO']['userName']));					
	}

	public function bajaDonante()
	{	
		if (isset($_GET['id'])) {
			$this->mD->eliminar($_GET['id']);
		}
		header('Location: backend.php?accion=listarDonantes');
	}

// ------------------------------------------------------------------------------------------------------------------------------------
// --------------------------------------- DECLARACION DE FUNCIONES PARA LAS ENTIDADES RECEPTORAS -------------------------------------
// ------------------------------------------------------------------------------------------------------------------------------------
	
    public function listarEntidades()
    {
        $params = array('entidades' => $this->mE->listar()   );
		echo $this->twig->render('abmEntidades.html', array('entidades' => $params['entidades'], 'usuario' => $_SESSION['USUARIO']['userName']));
    }

	public function altaEntidad()
	{
		$params = array(
             'razon_social' => '',
             'telefono' => '',
             'domicilio' => '',
             'estado' => '',
             'necesidad' => '',
             'servicio' => '',
         );
		 
		 $servicios = $this->mE->obtenerServiciosDisponibles();
		 
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// comprobar campos formulario
             if ($this->mE->validarDatos($_POST['razon_social'],
                      $_POST['telefono'], $_POST['domicilio'],
                      $_POST['estado'], $_POST['necesidad'], $_POST['servicio']))
			{
				 $this->mE->agregar($_POST['razon_social'],
                      $_POST['telefono'], $_POST['domicilio'],
                      $_POST['estado'], $_POST['necesidad'], $_POST['servicio']);
                 header('Location: backend.php?accion=listarEntidades');
             } else { // mostrar mensaje, lo hiciste mal, llenalo de nuevo
                 $params = array(
					 'razon_social' => $_POST['razon_social'],
					 'telefono' => $_POST['telefono'],
					 'domicilio' => $_POST['domicilio'],
					 'estado' => $_POST['estado'],
					 'necesidad' => $_POST['necesidad'],
					 'servicio' => $_POST['servicio']
				 );
                 $params['mensaje'] = 'No se ha podido insertar el alimento. Revisa el formulario';
             }
        }
		echo $this->twig->render('formInsEntidad.twig.html', array('params' => $params,
																   'servicios' => $servicios,
																   'usuario' => $_SESSION['USUARIO']['userName']));
	}

	public function modificarEntidad()
	{	
		$servicios = $this->mE->obtenerServiciosDisponibles();

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// comprobar campos formulario
             if ($this->mE->validarDatos($_POST['razon_social'],
                      $_POST['telefono'], $_POST['domicilio'],
                      $_POST['estado'], $_POST['necesidad'], $_POST['servicio']))
			 {
				 $this->mE->modificar($_GET['id'], $_POST['razon_social'],
                      $_POST['telefono'], $_POST['domicilio'],
                      $_POST['estado'], $_POST['necesidad'], $_POST['servicio']);
                 header('Location: backend.php?accion=listarEntidades');
			 }
		}
		
		// comprobar si se recibió un ID en la URL
		if (isset($_GET['id'])) {
			$params = $this->mE->obtenerPorID($_GET['id']);
		} else {
			header('Location: backend.php?accion=listarEntidades');
		}
        echo $this->twig->render('formModEntidad.twig.html', array('params' => $params,
																	'servicios' => $servicios,
																	'usuario' => $_SESSION['USUARIO']['userName']));					
	}

	public function bajaEntidad()
	{
		if (isset($_GET['id'])) {
			$this->mE->eliminar($_GET['id']);
		}
		header('Location: backend.php?accion=listarEntidades');
	}

// ------------------------------------------------------------------------------------------------------------------------------------
// -------------------------------------------- DECLARACION DE FUNCIONES PARA LOS ALIMENTOS--------------------------------------------
// ------------------------------------------------------------------------------------------------------------------------------------

	public function listarAlimentosSoloStock()
	{
		$params = array('alimentos' => $this->mA->listarSoloStock());
		echo $this->twig->render('alimentosConsulta.html', array('alimentos' => $params['alimentos'], 'usuario' => dameUsuario()));
	}


    public function listarAlimentos()
    {
        $params = array('alimentos' => $this->mA->listar()   );
		echo $this->twig->render('abmAlimentos.html', array('alimentos' => $params['alimentos'], 'usuario' => $_SESSION['USUARIO']['userName']));
    }

	public function altaAlimento()
	{
		$params = array(
             'razon_social' => '',
             'telefono' => '',
             'domicilio' => '',
             'estado' => '',
             'necesidad' => '',
             'servicio' => '',
        );
		 
		$donantes = $this->mD->obtenerDonantesActivos();
		 
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// comprobar campos formulario
             if ($this->mE->validarDatos($_POST['descripcion'],
                      $_POST['fecha'], $_POST['contenido'],
                      $_POST['peso'], $_POST['stock'], $_POST['reservado'], $_POST['donante']))
			{
				 $this->mE->agregar($_POST['razon_social'],
                      $_POST['telefono'], $_POST['domicilio'],
                      $_POST['estado'], $_POST['necesidad'], $_POST['servicio']);
                 header('Location: backend.php?accion=listarEntidades');
             } else { // mostrar mensaje, lo hiciste mal, llenalo de nuevo
                 $params = array(
					 'razon_social' => $_POST['razon_social'],
					 'telefono' => $_POST['telefono'],
					 'domicilio' => $_POST['domicilio'],
					 'estado' => $_POST['estado'],
					 'necesidad' => $_POST['necesidad'],
					 'servicio' => $_POST['servicio']
				 );
                 $params['mensaje'] = 'No se ha podido insertar el alimento. Revisa el formulario';
             }
		}
		 echo $this->twig->render('formInsAlimento.twig.html', array('params' => $params,
																		 'donantes' => $donantes,
																		 'usuario' => $_SESSION['USUARIO']['userName']));
	}

	public function modificarAlimento() {
		echo "probando enlace modificarAlimento";
		die;
	}

	public function bajaAlimento() {
		echo "probando enlace bajaAlimento";
		die;
	}

 }
?>