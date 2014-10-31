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
				$pedidosHoy = $this->mP->pedidosHoy();
				echo $this->twig->render('layoutBackAdmin.twig.html', array('params' => $pedidosHoy, 'usuario' => dameUsuario(), 'inicio' => '1'));
			break;
			case "consulta":
				//Sentencias para usuario consulta
				$pedidosHoy = $this->mP->pedidosHoy();
				echo $this->twig->render('layoutBackConsulta.twig.html', array('params' => $pedidosHoy, 'usuario' => dameUsuario(), 'inicio' => '1'));
			break;
			case "gestion":
				//Sentencias para usuario consulta
				$pedidosHoy = $this->mP->pedidosHoy();
				echo $this->twig->render('layoutBackGestion.twig.html', array('params' => $pedidosHoy, 'usuario' => dameUsuario(), 'inicio' => '1'));
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
				 'razon_social' => (''),
				 'nombre_contacto' => (''),
				 'apellido_contacto' => (''),
				 'telefono_contacto' => (''),
				 'mail_contacto' => (''),
				);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// comprobar campos formulario
             if ($this->mD->validarDatos($_POST['razon_social'],
                      $_POST['nombre'], $_POST['apellido'],
                      $_POST['telefono'], $_POST['mail']))
			{
				 $this->mD->agregar($_POST['razon_social'],
                      $_POST['nombre'], $_POST['apellido'],
                      $_POST['telefono'], $_POST['mail']);
                 header('Location: backend.php?accion=listarDonantes');
             } else { // mostrar mensaje, lo hiciste mal, llenalo de nuevo
                 $params['mensaje'] = 'No se ha podido insertar el donante. Revisa el formulario';
             }
        } else {
				// todavia nada
		}
		echo $this->twig->render('formDonante.twig.html', array('params' => $params ,
																'usuario' => $_SESSION['USUARIO']['userName'], 
																'accion' => ("alta")));
	}

	public function modificarDonante()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// comprobar campos formulario
             if ($this->mD->validarDatos($_POST['razon_social'],
                      $_POST['nombre'], $_POST['apellido'],
                      $_POST['telefono'], $_POST['mail']))
			 {
				 $this->mD->modificar($_GET['id'], $_POST['razon_social'],
                      $_POST['nombre'], $_POST['apellido'],
                      $_POST['telefono'], $_POST['mail']);
                 header('Location: backend.php?accion=listarDonantes');
			} else { // mostrar mensaje, lo hiciste mal, llenalo de nuevo
				$params['mensaje'] = 'No se ha podido modificar al donante. Revisa el formulario';
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
				 'nombre_contacto' => $donante['nombre_contacto'],
				 'apellido_contacto' => $donante['apellido_contacto'],
				 'telefono_contacto' => $donante['telefono_contacto'],
				 'mail_contacto' => $donante['mail_contacto'],
				);
         echo $this->twig->render('formDonante.twig.html', array('params' => $params ,
																 'usuario' => $_SESSION['USUARIO']['userName'],
																 'accion' => "modificar"));					
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
		$params = array();
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
                 $params['mensaje'] = 'No se ha podido insertar la entidad receptora. Revisa el formulario';
             }
        }
		echo $this->twig->render('formEntidad.twig.html', array('params' => $params,
																'servicios' => $servicios,
																'usuario' => $_SESSION['USUARIO']['userName'],
																'accion' => "alta"));
	}

	public function modificarEntidad()
	{	
		$params = array('razon_social' => "", 
						'telefono' => "", 
						'domicilio' => "", 
						'estado' => "", 
						'necesidad' => "",
						'servicio' => "");
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
			 } else { // mostrar mensaje, lo hiciste mal, llenalo de nuevo
                 $params['mensaje'] = 'No se ha podido modificar la entidad receptora. Revisa el formulario';
             }
		}
		
		// comprobar si se recibió un ID en la URL
		if (isset($_GET['id'])) {
			$params = $this->mE->obtenerPorID($_GET['id']);
		} else {
			header('Location: backend.php?accion=listarEntidades');
		}
        echo $this->twig->render('formEntidad.twig.html', array('params' => $params,
																'servicios' => $servicios,
																'usuario' => $_SESSION['USUARIO']['userName'],
																'accion' => "modificar"));					
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
        $params = array('alimentos' => $this->mA->listar());
//		print_r($params); die;
		echo $this->twig->render('abmAlimentos.html', array('alimentos' => $params['alimentos'], 'usuario' => $_SESSION['USUARIO']['userName']));
    }

	public function altaAlimento()
	{
		$params = array('descripcion' => "",
						'contenido' => "",
						'peso' => "",
						'stock' => "",
						'reservado' => "",
						'cantidad' => "",
						'donante' => "" );
		
		$donantes = $this->mD->obtenerDonantesActivos();

		$alimentos = $this->mA->obtenerAlimentos();
		 
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// comprobar campos formulario
             if ($this->mA->validarDatos($_POST['descripcion'],
                      $_POST['fecha'], $_POST['contenido'],
                      $_POST['peso'], $_POST['stock'], $_POST['reservado'], $_POST['cantidad'], $_POST['donante']))
			{
				 $this->mA->agregar($_POST['descripcion'],
                      $_POST['fecha'], $_POST['contenido'],
                      $_POST['peso'], $_POST['stock'], $_POST['reservado'], $_POST['cantidad'], $_POST['donante']);
                 header('Location: backend.php?accion=listarAlimentos');
             } else { // mostrar mensaje, lo hiciste mal, llenalo de nuevo
                 $params['mensaje'] = 'No se ha podido insertar el alimento. Revisa el formulario';
             }
		}
		 echo $this->twig->render('formAlimento.twig.html', array('params' => $params,
																  'donantes' => $donantes,
																  'alimentos' => $alimentos,
																  'usuario' => $_SESSION['USUARIO']['userName'],
																  'accion' => "alta"));
	}

	public function modificarAlimento()
	{
		$params = array();

		$donantes = $this->mD->obtenerDonantesActivos();

		$alimentos = $this->mA->obtenerAlimentos();
		 
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// comprobar campos formulario
             if ($this->mA->validarDatos($_POST['descripcion'],
                      $_POST['fecha'], $_POST['contenido'],
                      $_POST['peso'], $_POST['stock'], $_POST['reservado'], $_POST['cantidad'], $_POST['donante']))
			{
				 $donAnt = $this->mA->obtenerPorID($_GET['id']);
				 $this->mA->modificar($_GET['id'], $_POST['descripcion'],
                      $_POST['fecha'], $_POST['contenido'],
                      $_POST['peso'], $_POST['stock'], $_POST['reservado'], $_POST['cantidad'], $donAnt['donante'], $_POST['donante']);
                 header('Location: backend.php?accion=listarAlimentos');
             } else { // mostrar mensaje, lo hiciste mal, llenalo de nuevo
                 $params['mensaje'] = 'No se ha podido modificar el alimento. Revisa el formulario';
             }
		}
		// comprobar si se recibió un ID en la URL
		if (isset($_GET['id'])) {
			$params = $this->mA->obtenerPorID($_GET['id']);
		} else {
			header('Location: backend.php?accion=listarAlimentos');
		}
		 echo $this->twig->render('formAlimento.twig.html', array('params' => $params,
																  'donantes' => $donantes,
																  'alimentos' => $alimentos,
																  'usuario' => $_SESSION['USUARIO']['userName'],
																  'accion' => "modificar"));
	}

	public function bajaAlimento() {
		if (isset($_GET['id'])) {
			$this->mA->eliminar($_GET['id']);
		}
		header('Location: backend.php?accion=listarAlimentos');
	}


// ------------------------------------------------------------------------------------------------------------------------------------
// -------------------------------------------- DECLARACION DE FUNCIONES PARA USUARIOS ------------------------------------------------
// ------------------------------------------------------------------------------------------------------------------------------------
	
	//para listar los usuarios de sistema
	public function users() {
	
	$params = array('users' => $this->us->listar());
	
	
		echo $this->twig->render('abmUsers.html', array('users' => $params['users'], 'usuario' => dameUsuario()));
	}
	
	public function bajaUsuario() {
		if (isset($_GET['id'])) {
			
			
			$this->mA->eliminar($_GET['id']);
		}
		header('Location: backend.php?accion=users');
	}
	
	public function modificarUsuario($id){
		
		
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			
			
			
			$this->us->modificar($_GET['id'], $_POST['nombre'], $_POST['rol'], $_POST['p1']);
			header('Location: backend.php?accion=users');
			
			
		} else{
			$params = array('users' => $this->us->listarPorId($id));
			echo $this->twig->render('formModUser.twig.html', array('users' => $params['users']));
		}

		
	}
	
	public function altaUsuario($id){
		
		$params = array('users' => 'hola');
		echo $this->twig->render('formInsUser.twig.html', array('users' => $params['users']));
	
	}
	
	public function insertarUsuario(){
		
	
		 
		if (($_SERVER['REQUEST_METHOD'] == 'POST') && ($_POST['p1']==$_POST['p2'])) {
			// comprueba que el usuario no exista ya
			if (!$this->us->existeUsuario($_POST['nombre'])){
				 $this->us->agregar($_POST['nombre'], $_POST['rol'], $_POST['p1']);
				 /*header('Location: backend.php?accion=users');*/
				 $params = array('users' => $this->us->listar());
				 echo $this->twig->render('abmUsers.html', array('users' => $params['users'], 'mensaje' => 'El usuario se ha agregado correctamente.'));
				 /* 'usuario' => dameUsuario())*/
			}
            else { // mostrar mensaje, lo hiciste mal, llenalo de nuevo
                 header('Location: backend.php?accion=users#err2');
             }
		}
	}
	
	public function borrarUsuario($id){
		
		//comprueba que el usuario no intente borrarse a sí mismo
		if ($_SESSION['USUARIO']['id']!=$id){
				 $this->us->borrar($id);
				 header('Location: backend.php?accion=users');
			}
            else { // mostrar mensaje, lo hiciste mal, llenalo de nuevo
                 header('Location: backend.php?accion=users#err1');
             }
	}

// ------------------------------------------------------------------------------------------------------------------------------------
// --------------------------------------- DECLARACION DE FUNCIONES PARA LOS PEDIDOS/ENTREGAS -----------------------------------------
// ------------------------------------------------------------------------------------------------------------------------------------
	
	public function generarPedido()
    {
		$entidades = $this->mE->listarReducido(); // devuelve arreglo de arreglos con (id, razon_social)
		$detalles = $this->mA->listarSoloStock();
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//[entidad] => 1 [fecha] => 2014-10-01 [hora] => 12:12 [cantidad] => Array ( ['7'] => 1) [con_envio] => 0) 
			$pedido = array('entidad_receptora_id'=>$_POST['entidad'],
							'con_envio'=>$_POST['con_envio'],
							);
			$turno = array('fecha'=>$_POST['fecha'], 'hora'=>$_POST['hora']);
			if ($this->mP->validarDatos($pedido, $turno, $_POST['cantidad'])){
				$this->mP->agregar($pedido, $turno, $_POST['cantidad']);
                 header('Location: backend.php?accion=inicio');
			} else {
				// se llama al Home y se le envia un error
				echo "error al ingresar los datos"; die;
			}
		} else {
			// revisar los campos porque estos son los que van a rellenar el modificar porque usan el mismo formPedido
			$pedido = array('entidad_receptora_id'=>"",
							'fecha_ingreso'=>"",
							'estado_pedido_id'=>"",
							'con_envio'=>"",
							);
			echo $this->twig->render('formPedido.twig.html', array('pedido' => $pedido,
																   'entidades' => $entidades,
																   'detalles' => $detalles,
																   'usuario' => $_SESSION['USUARIO']['userName'],
																   'accion' => "alta"));
		}
	}
	
	public function generarEntrega()
    {
		echo "sitio en proceso de construccion"; die;
	}

	}
?>
