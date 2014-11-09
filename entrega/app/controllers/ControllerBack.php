<?php

require_once __DIR__ . '/ControllerLogin.php';
require_once __DIR__ . '/Controller.php';

 class ControllerBack extends Controller
 {
	var $info;
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
		$pedidosHoy = $this->mP->pedidosAlerta();
		echo $this->twig->render('layoutBackUser.twig.html', array('params' => $pedidosHoy, 'usuario' => dameUsuarioYRol(), 'inicio' => '1'));
     }
	 
	public function contacto()
    {
		echo $this->twig->render('contacto.twig.html', array('usuario' => dameUsuarioYRol()));
    }

	public function check_date($str){ // verifica si una fecha del tipo yyyy-mm-dd es correcta
                trim($str);
                $trozos = explode ("-", $str);
                $año=$trozos[0];
                $mes=$trozos[1];
                $dia=$trozos[2];     

                if(checkdate ($mes,$dia,$año)){
					return true;
                } else {
					return false;
                }
	} 

    
// ------------------------------------------------------------------------------------------------------------------------------------
// -------------------------------------------- DECLARACION DE FUNCIONES PARA LOS DONANTES --------------------------------------------
// ------------------------------------------------------------------------------------------------------------------------------------
	
	public function listarDonantes()
    {	 
        $params = array('donantes' => $this->mD->listar());
		echo $this->twig->render('abmDonantes.html', array('donantes' => $params['donantes'], 'usuario' => dameUsuarioYRol()));
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
																'usuario' => dameUsuarioYRol(), 
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
																 'usuario' => dameUsuarioYRol(),
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
		echo $this->twig->render('abmEntidades.html', array('entidades' => $params['entidades'], 'usuario' => dameUsuarioYRol()));
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
																'usuario' => dameUsuarioYRol(),
																'accion' => "alta"));
	}

	public function modificarEntidad()
	{	
		$params = array('razon_social' => "", 
						'telefono' => "", 
						'domicilio' => "", 
						'estado' => "", 
						'necesidad' => "",
						'servicio' => "",
						'latitud' => "",
						'longitud' => "");
						
		$servicios = $this->mE->obtenerServiciosDisponibles();

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// comprobar campos formulario
             if ($this->mE->validarDatos($_POST['razon_social'],
                      $_POST['telefono'], $_POST['domicilio'],
                      $_POST['estado'], $_POST['necesidad'], $_POST['servicio']))
			 {
				 $this->mE->modificar($_GET['id'], $_POST['razon_social'],
                      $_POST['telefono'], $_POST['domicilio'],
                      $_POST['estado'], $_POST['necesidad'], $_POST['servicio'],
                      $_POST['lat'], $_POST['lon']);
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
																'usuario' => dameUsuarioYRol(),
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
		echo $this->twig->render('abmAlimentos.html', array('alimentos' => $params['alimentos'], 'usuario' => dameUsuarioYRol()));
    }

	public function altaAlimento()
	{
		$params = array('descripcion' => "",
						'contenido' => "",
						'peso' => "0",
						'stock' => "0",
						'fecha' => "",
						'reservado' => "0",
						'cantidad' => "1");
		
		$alimentos = $this->mA->obtenerAlimentos();

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// comprobar campos formulario
             if ($this->mA->validarDatos($_POST['descripcion'],
                      $_POST['fecha'], $_POST['contenido'],
                      $_POST['peso'], $_POST['stock'], $_POST['reservado']))
			{
				 $this->mA->agregar($_POST['descripcion'],
                      $_POST['fecha'], $_POST['contenido'],
                      $_POST['peso'], $_POST['stock'], $_POST['reservado']);
                 header('Location: backend.php?accion=listarAlimentos');
             } else { // mostrar mensaje, lo hiciste mal, llenalo de nuevo
                 $params['mensaje'] = 'No se ha podido insertar el alimento. Revisa el formulario';
             }
		}
		 echo $this->twig->render('formAlimento.twig.html', array('params' => $params,
																  'alimentos' => $alimentos,
																  'usuario' => dameUsuarioYRol(),
																  'accion' => "alta"));
	}

	public function altaDonacion()
	{
		$params = array('descripcion' => "",
						'contenido' => "",
						'peso' => "0",
						'reservado' => "0",
						'cantidad' => "1",
						'donante' => "" );
		
		$donantes = $this->mD->obtenerDonantesActivos();
		$contenidos = $this->mA->obtenerContenidos();
		$alimentos = $this->mA->obtenerAlimentos();
//		 print_r($contenidos); die;
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// comprobar campos formulario
             if ($this->mA->validarDatosDonacion($_POST['descripcion'],
                      $_POST['fecha'], $_POST['contenido'],
                      $_POST['peso'], $_POST['cantidad'], $_POST['donante']))
			{
				 $this->mA->agregarDonacion($_POST['descripcion'],
                      $_POST['fecha'], $_POST['contenido'],
                      $_POST['peso'], $_POST['cantidad'], $_POST['donante']);
                 header('Location: backend.php?accion=listarAlimentos');
             } else { // mostrar mensaje, lo hiciste mal, llenalo de nuevo
                 $params['mensaje'] = 'No se ha podido insertar el alimento. Revisa el formulario';
             }
		}
		 echo $this->twig->render('formDonacion.twig.html', array('params' => $params,
																  'donantes' => $donantes,
																  'alimentos' => $alimentos,
																  'contenidos' => $contenidos,
																  'usuario' => dameUsuarioYRol() 
																  ));
	}

	public function modificarAlimento()
	{
		$params = $this->mA->obtenerPorID($_GET['id']);

		$alimentos = $this->mA->obtenerAlimentos();
		 
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// comprobar campos formulario
			 if ($this->mA->validarDatos($_POST['descripcion'],
					  $_POST['fecha'], $_POST['contenido'],
					  $_POST['peso'], $_POST['stock'], $_POST['reservado']))
			{
				 $donAnt = $this->mA->obtenerPorID($_GET['id']);
				 $this->mA->modificar($_GET['id'], $_POST['descripcion'],
					  $_POST['fecha'], $_POST['contenido'],
					  $_POST['peso'], $_POST['stock'], $_POST['reservado']);
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
																  'alimentos' => $alimentos,
																  'usuario' => dameUsuarioYRol(),
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
	public function users()
	{
		$params = array('users' => $this->us->listar());
		echo $this->twig->render('abmUsers.html', array('users' => $params['users'], 'usuario' => dameUsuarioYRol()));
	}
	
	public function bajaUsuario()
	{
		if (isset($_GET['id'])) {
			$this->mA->eliminar($_GET['id']);
		}
		header('Location: backend.php?accion=users');
	}
	
	public function modificarUsuario($id)
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$this->us->modificar($_GET['id'], $_POST['nombre'], $_POST['rol'], $_POST['p1']);
			header('Location: backend.php?accion=users');
		} else{
			$params = array('users' => $this->us->listarPorId($id));
			echo $this->twig->render('formModUser.twig.html', array('users' => $params['users'], 'usuario' => dameUsuarioYRol()));
		}
	}
	
	public function altaUsuario($id)
	{
		$params = array('users' => 'hola');
		echo $this->twig->render('formInsUser.twig.html', array('users' => $params['users'], 'usuario' => dameUsuarioYRol()));
	}
	
	public function insertarUsuario()
	{
		if (($_SERVER['REQUEST_METHOD'] == 'POST') && ($_POST['p1']==$_POST['p2'])) {
			// comprueba que el usuario no exista ya
			if (!$this->us->existeUsuario($_POST['nombre'])){
				 $this->us->agregar($_POST['nombre'], $_POST['rol'], $_POST['p1']);
				 /*header('Location: backend.php?accion=users');*/
				 $params = array('users' => $this->us->listar());
				 echo $this->twig->render('abmUsers.html', array('users' => $params['users'],
																 'mensaje' => 'El usuario se ha agregado correctamente.',
																 'usuario' => dameUsuarioYRol()));
				 /* 'usuario' => dameUsuario())*/
			}
            else { // mostrar mensaje, lo hiciste mal, llenalo de nuevo
                 $params = array('users' => $this->us->listar());
				 echo $this->twig->render('abmUsers.html', array('users' => $params['users'], 'mensaje' => 'El usuario ya existe.', 'usuario' => dameUsuarioYRol()));
				 
             }
		}
	}
	
	public function borrarUsuario($id){
		
		//comprueba que el usuario no intente borrarse a sí mismo
		if ($_SESSION['USUARIO']['id']!=$id){
				 $this->us->borrar($id);
				 $params = array('users' => $this->us->listar());
				 echo $this->twig->render('abmUsers.html', array('users' => $params['users'], 'mensaje' => 'Se ha borrado con éxito.', 'usuario' => dameUsuarioYRol()));
			}
            else { // mostrar mensaje, lo hiciste mal, llenalo de nuevo
                 /*header('Location: backend.php?accion=users#err1');*/
				/*header('Location: backend.php');*/
				 $params = array('users' => $this->us->listar());
				 echo $this->twig->render('abmUsers.html', array('users' => $params['users'], 'mensaje' => 'No puede eliminarse usted mismo.', 'usuario' => dameUsuarioYRol()));
             }
	}
	
	public function modificarConfiguracion()
	{
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				$this->us->modificarConfig($_POST['dias'],$_POST['lat'], $_POST['lon']);
				$pedidosHoy = $this->mP->pedidosAlerta();
				echo $this->twig->render('layoutBackUser.twig.html', array('params' => $pedidosHoy,
																		   'usuario' => dameUsuarioYRol(),
																		   'inicio' => '1',
																		   'mensaje' => 'Se ha modificado la configuración'));
			} else {
				$configuracion= $this->us->verConfiguracion();
				echo $this->twig->render('formConfig.twig.html', array('config' => $configuracion, 'usuario' => dameUsuarioYRol()));
			}

	}	
					

// ------------------------------------------------------------------------------------------------------------------------------------
// --------------------------------------- DECLARACION DE FUNCIONES PARA LOS PEDIDOS/ENTREGAS -----------------------------------------
// ------------------------------------------------------------------------------------------------------------------------------------
	
	public function generarPedido()
    {
		$entidades = $this->mE->listarReducido(); // devuelve arreglo de arreglos con (id, razon_social)
		$detalles = $this->mA->listarSoloStock();
		$pedido = array('entidad_receptora_id'=>"",
						'fecha_ingreso'=>"",
						'estado_pedido_id'=>"",
						'con_envio'=>"0",
						);
		$msj = "";
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
// Array ( [entidad] => 1 [fecha] => 2014-10-29 [hora] => 12:59 [cantidad] => Array ( [8] => 5 [12] => 5 ) [con_envio] => 0 [boton] => )  
			if (isset($_POST['cantidad'])) 
			{
				$pedido = array('entidad_receptora_id'=>$_POST['entidad'],
								'con_envio'=>$_POST['con_envio'],
								);
				$turno = array('fecha'=>$_POST['fecha'], 'hora'=>$_POST['hora']);
				if ($this->mP->validarDatos($pedido, $turno, $_POST['cantidad'])){
					$this->mP->agregar($pedido, $turno, $_POST['cantidad']);
					 header('Location: backend.php?accion=inicio');
				} else {
					// se llama al Home y se le envia un error
					$msj = "Revisar los datos ingresados";
				}
			} else {
					$msj = "No se seleccionó ningún alimento para agregar al pedido";
			}
		}
		echo $this->twig->render('formPedido.twig.html', array('pedido' => $pedido,
															   'entidades' => $entidades,
															   'detalles' => $detalles,
															   'usuario' => dameUsuarioYRol(),
															   'mensaje' => $msj));
	}
	
	public function actualizarPedido() // debe recibir $_GET['nro']
    {
		$entidades = $this->mE->listarReducido(); // devuelve arreglo de arreglos con (id, razon_social)
		$estados = $this->mP->listarEstadosPosibles();
		$msj = "";
		if (isset($_GET['nro']))
		{
			$id_pedido = $_GET['nro'];
			$pedido = $this->mP->obtenerPorNro($id_pedido);
			if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$pedido['entidad_receptora_id'] = $_POST['entidad'];
				$pedido['con_envio'] = $_POST['con_envio'];
				$pedido['estado_pedido_id'] = $_POST['estado'];
				$turno = array('fecha'=>$_POST['fecha'], 'hora'=>$_POST['hora']);
				if ($this->mP->validarDatosSinCantidad($pedido, $turno))
				{
					$this->mP->actualizar($pedido, $turno);
					$msj = "El pedido se actualizó correctamente";
					$pedidos = $this->mP->todosLosPedidos();
					echo $this->twig->render('listadoPedidos.twig.html', array('pedidos' => $pedidos, 'usuario' => dameUsuarioYRol()));
					return;
				} else {
					$msj = "Revisar los datos ingresados";
				}
			}
			echo $this->twig->render('formActPedido.twig.html',  array('pedido' => $pedido,
																	   'entidades' => $entidades,
																	   'estados' => $estados,
																	   'usuario' => dameUsuarioYRol(),
																	   'mensaje' => $msj));
		} else {
			$msj = "Numero incorrecto de pedido";
			$pedidos = $this->mP->todosLosPedidos();
			echo $this->twig->render('listadoPedidos.twig.html', array('pedidos' => $pedidos, 'usuario' => dameUsuarioYRol()));
		}
	}
	
	
	public function mostrarPedidos()
	{
		$pedidos = $this->mP->todosLosPedidos();
		echo $this->twig->render('listadoPedidos.twig.html', array('pedidos' => $pedidos, 'usuario' => dameUsuarioYRol()));
	}
	
	public function generarEntrega()
    {
		$entidades = $this->mE->listarReducido(); // devuelve arreglo de arreglos con (id, razon_social)
		$detalles = $this->mP->alimentosEntregaDirecta();
		$entidad = "";
		$msj = "";
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (isset($_POST['cantidad'])) 
			{
				$entidad = $_POST['entidad'];
				$this->mP->agregarEntrega($entidad, $_POST['cantidad']);
				$msj = "La entrega fue agregada con éxito";
				echo $this->twig->render('layoutBackUser.twig.html', array('usuario' => dameUsuarioYRol(), 'mensaje' => $msj));
				return;
			} else {
				$msj = "No se seleccionó ningún alimento para agregar a la entrega";
			}
		} 
		echo $this->twig->render('formEntrega.twig.html', array('entrega' => array('entidad' => $entidad),
																'entidades' => $entidades,
																'detalles' => $detalles,
																'usuario' => dameUsuarioYRol(),
																'accion' => "alta",
																'mensaje' => $msj));
	}

	public function verEntregasRealizadas()
	{
		$entregas = $this->mP->entregasRealizadas();
		echo $this->twig->render('listado.entregas.twig.html', array('params' => $entregas, 'usuario' => dameUsuarioYRol(),));
	}
	
	public function mostrarAgenda()
    {
		$msj = "";
		if (isset($_GET['d']))
		{
			$dia = $_GET['d'];
			if ($this->check_date($dia)) {
				$pedidos = $this->mP->mostrarDia($dia);
				echo $this->twig->render('agenda.twig.html', array('usuario' => dameUsuarioYRol(), 'seleccion' => '1', 'pedidos' => $pedidos));
				return;
			} else {
				$msj="Error al ingresar la fecha";
			}
		} 
		echo $this->twig->render('agenda.twig.html', array('usuario' => dameUsuarioYRol(), 'mensaje' => $msj));
	}

// ------------------------------------------------------------------------------------------------------------------------------------
// --------------------------------------------- DECLARACION DE FUNCIONES PARA INFORMES -----------------------------------------------
// ------------------------------------------------------------------------------------------------------------------------------------

	public function entreFechasPorER(){
		
		echo $this->twig->render('formInformes.twig.html', array('usuario' => dameUsuarioYRol(), 'informe' => '0'));
		
		
	}
	
	public function entreFechas(){
		
		echo $this->twig->render('formInformes.twig.html', array('usuario' => dameUsuarioYRol(), 'informe' => '1'));
		
		
	}
	
	
	
	public function informePorER(){

		
	/*
		$informe= json_encode($this->mE->informePesoPorEntidad($_POST['fecha1'], $_POST['fecha2']), JSON_NUMERIC_CHECK);
		
		setcookie("informe", $informe);*/
		echo $this->twig->render('formInformes.twig.html', array('usuario' => dameUsuarioYRol(), 'informe' => '0'));
		
	}
	
	
	
	public function informePorERJSON(){
			
			header("content-type: application/json"); 
			
			$f1= $_GET['f1'];
			$f2= $_GET['f2'];
			
			$consulta= $this->mE->informePesoPorEntidad($f1, $f2);
			
			$rows = array();

			foreach ($consulta as $valor) {
					$row[0] = $valor[0];  
					$row[1] = $valor[1];
					array_push($rows,$row);
			}

			
			
			echo json_encode($rows, JSON_NUMERIC_CHECK); //lo pasa a formato JSON
			
			//echo $_GET['callback']. '('. json_encode($array) . ')';    
			//die;
		
			
			
		}
	
	




}
?>
