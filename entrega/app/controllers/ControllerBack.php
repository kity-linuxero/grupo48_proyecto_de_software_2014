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
require_once __DIR__ . '/Controller.php';
@session_start(); 

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
	
	protected function revisarMensajes()
	{
		if (isset($_COOKIE['mensaje'])){
			$this->msj = $_COOKIE['mensaje'];
			setcookie('mensaje', 'content', 1);
		}
	}
	
	protected function setMensaje($m)
	{
		setcookie('mensaje', $m);
	}
 
	public function inicio()
     {
		$this->revisarMensajes();
		$pedidosHoy = $this->mP->pedidosAlerta();
		$alimentos = $this->mP->alimentosEntregaDirecta();
		echo $this->twig->render('layoutBackUser.twig.html', array('params' => $pedidosHoy, 
																   'usuario' => dameUsuarioYRol(),
																   'alimentos'=> $alimentos,
																   'inicio' => '1',
																   'mensaje'=>$this->msj));
     }
	 
	public function contacto()
    {
		echo $this->twig->render('contacto.twig.html', array('usuario' => dameUsuarioYRol()));
    }

	public function check_date($str){ // verifica si una fecha del tipo yyyy-mm-dd es correcta
                trim($str);
				$trozos = explode ("-", $str);
				if (count($trozos)==3){
					$año=$trozos[0];
					$mes=$trozos[1];
					$dia=$trozos[2];
					if(checkdate ($mes,$dia,$año)){
						return true;
					}
				}
				return false;
	} 

    
// ------------------------------------------------------------------------------------------------------------------------------------
// -------------------------------------------- DECLARACION DE FUNCIONES PARA LOS DONANTES --------------------------------------------
// ------------------------------------------------------------------------------------------------------------------------------------
	
	public function listarDonantes()
    {	
		$this->revisarMensajes();
        $params = array('donantes' => $this->mD->listar());
		echo $this->twig->render('abmDonantes.html', array('donantes' => $params['donantes'], 'usuario' => dameUsuarioYRol(), 'mensaje' => $this->msj ));
    }

	public function altaDonante() {


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// comprobar campos formulario
			$_POST['razon_social'] = $this->xss($_POST['razon_social']);
            $_POST['nombre'] = $this->xss($_POST['nombre']);
			$_POST['apellido'] = $this->xss($_POST['apellido']);
            $_POST['telefono'] = $this->xss($_POST['telefono']);
			$_POST['mail'] = $this->xss($_POST['mail']);
		
            if ($this->mD->validarDatos($_POST['razon_social'],
                      $_POST['nombre'], $_POST['apellido'],
                      $_POST['telefono'], $_POST['mail']))
			{
				$this->mD->agregar($_POST['razon_social'],
                      $_POST['nombre'], $_POST['apellido'],
                      $_POST['telefono'], $_POST['mail']);
				$this->setMensaje("El donante fue agregado con éxito");
                header('Location: ./backend.php?accion=listarDonantes');
            } else {
                $params = array(
					 'razon_social' => $_POST['razon_social'],
					 'nombre_contacto' => $_POST['nombre'],
					 'apellido_contacto' => $_POST['apellido'],
					 'telefono_contacto' => $_POST['telefono'],
					 'mail_contacto' => $_POST['mail']
					);
				$this->msj = "Revise los campos ingresados";
            }
        } else {
			$params = array(
				 'razon_social' => (''),
				 'nombre_contacto' => (''),
				 'apellido_contacto' => (''),
				 'telefono_contacto' => (''),
				 'mail_contacto' => (''),
				);
		}
		echo $this->twig->render('formDonante.twig.html', array('params' => $params ,
																'usuario' => dameUsuarioYRol(), 
																'accion' => ("alta"),
																'mensaje' => $this->msj));
	}

	public function modificarDonante()
	{
		if (isset($_GET['id'])) {
			$id = $this->xss($_GET['id']);
			$donante = $this->mD->obtenerPorID($id);
			if ($donante==-1) {
				$this->setMensaje("Error de selección de Donante.");
                header('Location: ./backend.php?accion=listarDonantes');
			}				
		} else {
			$this->setMensaje("Error de selección de Donante.");
            header('Location: ./backend.php?accion=listarDonantes');
		}

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// comprobar campos formulario
			$_POST['razon_social'] = $this->xss($_POST['razon_social']);
            $_POST['nombre'] = $this->xss($_POST['nombre']);
			$_POST['apellido'] = $this->xss($_POST['apellido']);
            $_POST['telefono'] = $this->xss($_POST['telefono']);
			$_POST['mail'] = $this->xss($_POST['mail']);
			
            if ($this->mD->validarDatos($_POST['razon_social'],
                      $_POST['nombre'], $_POST['apellido'],
                      $_POST['telefono'], $_POST['mail']))
			{
				 $this->mD->modificar($id, $_POST['razon_social'],
                      $_POST['nombre'], $_POST['apellido'],
                      $_POST['telefono'], $_POST['mail']);
				$this->setMensaje("El donante fue modificado con éxito");
                header('Location: ./backend.php?accion=listarDonantes');
			} else { // mostrar mensaje, lo hiciste mal, llenalo de nuevo
				$this->msj = 'No se ha podido modificar al donante. Revisa el formulario';
				$params = array(
					 'razon_social' => $_POST['razon_social'],
					 'nombre_contacto' => $_POST['nombre'],
					 'apellido_contacto' => $_POST['apellido'],
					 'telefono_contacto' => $_POST['telefono'],
					 'mail_contacto' => $_POST['mail']
				);
			}
		} else {
			$params = array(
					 'id' => $donante['id'],
					 'razon_social' => $donante['razon_social'],
					 'nombre_contacto' => $donante['nombre_contacto'],
					 'apellido_contacto' => $donante['apellido_contacto'],
					 'telefono_contacto' => $donante['telefono_contacto'],
					 'mail_contacto' => $donante['mail_contacto'],
					);
		}
         echo $this->twig->render('formDonante.twig.html', array('params' => $params ,
																 'usuario' => dameUsuarioYRol(),
																 'accion' => "modificar",
																 'mensaje' => $this->msj));					
	}

	public function bajaDonante()
	{	
		if (isset($_GET['id'])) {
			$id = $this->xss($_GET['id']);
			$resultado = $this->mD->eliminar($id);
			if ($resultado==-1)
				$this->setMensaje("Error de eliminación de Donante.");
			else {
				$this->setMensaje("Donante eliminado con éxito.");
			}
		} else 
			$this->setMensaje("Error.");
        header('Location: ./backend.php?accion=listarDonantes');
	}

// ------------------------------------------------------------------------------------------------------------------------------------
// --------------------------------------- DECLARACION DE FUNCIONES PARA LAS ENTIDADES RECEPTORAS -------------------------------------
// ------------------------------------------------------------------------------------------------------------------------------------
	
    public function listarEntidades()
    {
		$this->revisarMensajes();
        $params = array('entidades' => $this->mE->listar());
		echo $this->twig->render('abmEntidades.html', array('entidades' => $params['entidades'], 'usuario' => dameUsuarioYRol(), 'mensaje'=>$this->msj));
    }

	public function altaEntidad()
	{
		$servicios = $this->mE->obtenerServiciosDisponibles();
		 
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
            $_POST['telefono'] = $this->xss($_POST['telefono']);
			$_POST['domicilio'] = $this->xss($_POST['domicilio']);
            $_POST['estado'] = $this->xss($_POST['estado']);
			$_POST['necesidad'] = $this->xss($_POST['necesidad']);
			$_POST['servicio'] = $this->xss($_POST['servicio']);
			$_POST['lat'] = $this->xss($_POST['lat']);
			$_POST['lon'] = $this->xss($_POST['lon']);
		
            if ($this->mE->validarDatos($_POST['razon_social'],
                      $_POST['telefono'], $_POST['domicilio'],
                      $_POST['estado'], $_POST['necesidad'], $_POST['servicio'],
					  $_POST['lat'], $_POST['lon']))
			{
				 $this->mE->agregar($_POST['razon_social'],
                      $_POST['telefono'], $_POST['domicilio'],
                      $_POST['estado'], $_POST['necesidad'], $_POST['servicio'],
					  $_POST['lat'], $_POST['lon']);
                 $this->setMensaje("La Entidad Receptora se agregó con éxito");
				 header('Location: ./backend.php?accion=listarEntidades');
            } else { // mostrar mensaje, lo hiciste mal, llenalo de nuevo
                $this->msj = 'No se ha podido agregar la Entidad Receptora. Revise el formulario';
				$params = array('razon_social' => $_POST['razon_social'], 
								'telefono' => $_POST['telefono'], 
								'domicilio' => $_POST['domicilio'], 
								'estado' => $_POST['estado'], 
								'necesidad' => $_POST['necesidad'],
								'servicio' => $_POST['servicio'],
								'latitud' => $_POST['lat'],
								'longitud' => $_POST['lon']);
             }
        } else 	$params = array('razon_social' => "", 
								'telefono' => "", 
								'domicilio' => "", 
								'estado' => "", 
								'necesidad' => "",
								'servicio' => "",
								'latitud' => "",
								'longitud' => "");

		echo $this->twig->render('formEntidad.twig.html', array('params' => $params,
																'servicios' => $servicios,
																'usuario' => dameUsuarioYRol(),
																'accion' => "alta",
																'mensaje' => $this->msj));
	}

	public function modificarEntidad()
	{	
		$servicios = $this->mE->obtenerServiciosDisponibles();

		if (isset($_GET['id'])) {
			$id = $this->xss($_GET['id']);
			$params = $this->mE->obtenerPorID($id);
			if ($params==-1){
                 $this->setMensaje("Error al buscar la Entidad Receptora a modificar");
				 header('Location: ./backend.php?accion=listarEntidades');
			}
		} else {
			 $this->setMensaje("Error al buscar la Entidad Receptora a modificar");
			 header('Location: ./backend.php?accion=listarEntidades');
		}
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// comprobar campos formulario
            $_POST['telefono'] = $this->xss($_POST['telefono']);
			$_POST['domicilio'] = $this->xss($_POST['domicilio']);
            $_POST['estado'] = $this->xss($_POST['estado']);
			$_POST['necesidad'] = $this->xss($_POST['necesidad']);
			$_POST['servicio'] = $this->xss($_POST['servicio']);
			$_POST['lat'] = $this->xss($_POST['lat']);
			$_POST['lon'] = $this->xss($_POST['lon']);
		
             if ($this->mE->validarDatos($_POST['razon_social'],
                      $_POST['telefono'], $_POST['domicilio'],
                      $_POST['estado'], $_POST['necesidad'], $_POST['servicio'],
					  $_POST['lat'], $_POST['lon']))
			 {
				 $this->mE->modificar($id, $_POST['razon_social'],
                      $_POST['telefono'], $_POST['domicilio'],
                      $_POST['estado'], $_POST['necesidad'], $_POST['servicio'],
                      $_POST['lat'], $_POST['lon']);
                 $this->setMensaje("La Entidad Receptora se modificó con éxito");
				 header('Location: ./backend.php?accion=listarEntidades');
			 } else {
                $this->msj = 'No se ha podido modificar la Entidad Receptora. Revise el formulario';
				$params = array('razon_social' => $_POST['razon_social'], 
								'telefono' => $_POST['telefono'], 
								'domicilio' => $_POST['domicilio'], 
								'estado' => $_POST['estado'], 
								'necesidad' => $_POST['necesidad'],
								'servicio' => $_POST['servicio'],
								'latitud' => $_POST['lat'],
								'longitud' => $_POST['lon']);
             }
		}
		
        echo $this->twig->render('formEntidad.twig.html', array('params' => $params,
																'servicios' => $servicios,
																'usuario' => dameUsuarioYRol(),
																'accion' => "modificar",
																'mensaje' => $this->msj));					
	}

	public function bajaEntidad()
	{	
		if (isset($_GET['id'])) {
			$id = $this->xss($_GET['id']);
			$resultado = $this->mE->eliminar($id);
			if ($resultado==-1)
				$this->setMensaje("Error de eliminación de Entidad Receptora.");
			else
				$this->setMensaje("Entidad Receptora eliminada con éxito.");
		} else
			$this->setMensaje("Error al entrar a la opción de borrado.");
		header('Location: ./backend.php?accion=listarEntidades');

	}
	
// ------------------------------------------------------------------------------------------------------------------------------------
// -------------------------------------------- DECLARACION DE FUNCIONES PARA LOS ALIMENTOS--------------------------------------------
// ------------------------------------------------------------------------------------------------------------------------------------

	public function listarAlimentosSoloStock()
	{
		$params = array('alimentos' => $this->mA->listarSoloStock());
		echo $this->twig->render('alimentosConsulta.html',
								  array('alimentos' => $params['alimentos'], 'usuario' => dameUsuarioYRol(), 'mensaje' => $this->msj));
	}


    public function listarAlimentos()
    {
		$this->revisarMensajes();
        $params = array('alimentos' => $this->mA->listar());
		echo $this->twig->render('abmAlimentos.html',
								  array('alimentos' => $params['alimentos'], 'usuario' => dameUsuarioYRol(), 'mensaje' => $this->msj));
    }

	public function altaAlimento()
	{
		$alimentos = $this->mA->obtenerAlimentos();
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$params = array('descripcion' => $this->xss($_POST['descripcion']),
							'contenido' => $this->xss($_POST['contenido']),
							'peso' => $this->xss($_POST['peso']),
							'stock' => $this->xss($_POST['stock']),
							'fecha' => $this->xss($_POST['fecha']),
							'reservado' => $this->xss($_POST['reservado']));
            if ($this->mA->validarDatos($params['descripcion'],
                      $params['fecha'], $params['contenido'],
                      $params['peso'], $params['stock'], $params['reservado']))
			{
				 $this->mA->agregar($params['descripcion'],
                      $params['fecha'], $params['contenido'],
                      $params['peso'], $params['stock'], $params['reservado']);
                 $this->setMensaje("El alimento fue agregado con éxito");
				 header('Location: ./backend.php?accion=listarAlimentos');
             } else {
                 $this->msj = 'No se ha podido insertar el alimento. Revisa el formulario';
             }
		} else {
			$params = array('descripcion' => "",
							'contenido' => "",
							'peso' => "0",
							'stock' => "0",
							'fecha' => "",
							'reservado' => "0");
		}
		echo $this->twig->render('formAlimento.twig.html', array('params' => $params,
																 'alimentos' => $alimentos,
																 'usuario' => dameUsuarioYRol(),
																 'accion' => "alta",
																 'mensaje' => $this->msj));
	}

	public function altaDonacion()
	{
		$donantes = $this->mD->obtenerDonantesActivos();
		$contenidos = $this->mA->obtenerContenidos();
		$alimentos = $this->mA->obtenerAlimentos();
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$params = array('descripcion' => $this->xss($_POST['descripcion']),
							'contenido' => $this->xss($_POST['contenido']),
							'peso' => $this->xss($_POST['peso']),
							'fecha' => $this->xss($_POST['fecha']),
							'cantidad' => $this->xss($_POST['cantidad']),
							'donante' => $this->xss($_POST['donante']));
             if ($this->mA->validarDatosDonacion($params['descripcion'],
                      $params['fecha'], $params['contenido'],
                      $params['peso'], $params['cantidad'], $params['donante']))
			{
				 $this->mA->agregarDonacion($params['descripcion'],
                      $params['fecha'], $params['contenido'],
                      $params['peso'], $params['cantidad'], $params['donante']);
                 $this->setMensaje("La donación fue agregada con éxito");
				 header('Location: ./backend.php?accion=listarAlimentos');
             } else {
                 $this->msj = 'No se ha podido insertar el alimento. Revisa el formulario';
             }
		} else {
			$params = array('descripcion' => "",
							'fecha' => "",
							'contenido' => "",
							'peso' => "0",
							'cantidad' => "1",
							'donante' => "" );
		}
		echo $this->twig->render('formDonacion.twig.html', array('params' => $params,
																 'donantes' => $donantes,
																 'alimentos' => $alimentos,
																 'contenidos' => $contenidos,
																 'usuario' => dameUsuarioYRol(),
																 'mensaje' => $this->msj));
	}

	public function modificarAlimento()
	{
		if (isset($_GET['id'])){
			$id = $this->xss($_GET['id']);
			$params = $this->mA->obtenerPorID($id);
			if ($params==-1){
				$this->setMensaje("Error al buscar el detalle de alimento a modificar");
				header('Location: ./backend.php?accion=listarAlimentos');
			}
		} else {
			$this->setMensaje("Error al buscar el detalle de alimento a modificar");
			header('Location: ./backend.php?accion=listarAlimentos');
		}

		$alimentos = $this->mA->obtenerAlimentos();
		 
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$params = array('descripcion' => $this->xss($_POST['descripcion']),
							'contenido' => $this->xss($_POST['contenido']),
							'peso' => $this->xss($_POST['peso']),
							'stock' => $this->xss($_POST['stock']),
							'fecha' => $this->xss($_POST['fecha']),
							'reservado' => $this->xss($_POST['reservado']));
			 if ($this->mA->validarDatos($params['descripcion'],
					  $params['fecha'], $params['contenido'],
					  $params['peso'], $params['stock'], $params['reservado']))
			{
				 $this->mA->modificar($id, $params['descripcion'],
					  $params['fecha'], $params['contenido'],
					  $params['peso'], $params['stock'], $params['reservado']);
                 $this->setMensaje("La modificación fue realizada con éxito");
				 header('Location: ./backend.php?accion=listarAlimentos');
			 } else { // mostrar mensaje, lo hiciste mal, llenalo de nuevo
				 $this->msj = 'No se ha podido modificar el alimento. Revise el formulario';
			 }
		} else {
			$params = array('id' => $id,
							'descripcion' => $params['descripcion'],
							'contenido' => $params['contenido'],
							'peso' => $params['peso'],
							'stock' => $params['stock'],
							'fecha' => $params['fecha'],
							'reservado' => $params['reservado']);
		}
		 echo $this->twig->render('formAlimento.twig.html', array('params' => $params,
																  'alimentos' => $alimentos,
																  'usuario' => dameUsuarioYRol(),
																  'accion' => "modificar",
																  'mensaje' => $this->msj));
	}

	public function bajaAlimento()
	{
		if (isset($_GET['id'])){
			$id = $this->xss($_GET['id']);
			$res = $this->mA->eliminar($id);
			if ($res==-1)
				$this->setMensaje("Error al eliminar el detalle de alimento");
			else
				$this->setMensaje("El alimento fue eliminado con éxito.");
		} else
			$this->setMensaje("Error al entrar a la opción de eliminación de alimento.");
		header('Location: ./backend.php?accion=listarAlimentos');
	}


// ------------------------------------------------------------------------------------------------------------------------------------
// -------------------------------------------- DECLARACION DE FUNCIONES PARA USUARIOS ------------------------------------------------
// ------------------------------------------------------------------------------------------------------------------------------------
	
	//para listar los usuarios de sistema
	public function users()
	{
		$this->revisarMensajes();
		$params = array('users' => $this->us->listar());
		echo $this->twig->render('abmUsers.html', array('users' => $params['users'], 'usuario' => dameUsuarioYRol(), 'mensaje' => $this->msj));
	}
	
	public function bajaUsuario()
	{
		if (isset($_GET['id'])) {
			$id = $this->xss($_GET['id']);
			$res = $this->us->borrar($id);
			if ($res==-1)
				$this->setMensaje("Error al eliminar el usuario.");
			else
				$this->setMensaje("Usuario eliminado con éxito");
		}
		else
			$this->setMensaje("Error al entrar a la opción de eliminación de usuario.");
		header('Location: ./backend.php?accion=users');
	}
	
	public function modificarUsuario($id)
	{
		if (isset($_GET['id'])) {
			$id = $this->xss($_GET['id']);
			$params = array('users' => $this->us->listarPorId($id));
			if ($params==-1){
				$this->setMensaje("Error al eliminar el usuario.");
				header('Location: ./backend.php?accion=users');
			}
		} else {
			$this->setMensaje("Error al entrar a la opción de eliminación de usuario.");
			header('Location: ./backend.php?accion=users');
		}
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$nombre = $this->xss($_POST['nombre']);
			$rol = $this->xss($_POST['rol']);
			$p1 = $this->xss($_POST['p1']);
			$this->us->modificar($id, $nombre, $rol, $p1);
			$this->setMensaje("Usuario modificado con éxito.");
			header('Location: ./backend.php?accion=users');
		} else {
			echo $this->twig->render('formModUser.twig.html', array('users' => $params['users'], 'usuario' => dameUsuarioYRol(), 'mensaje' => $this->msj));
		}
	}
	
	public function altaUsuario($id)
	{
		$id = $this->xss($id);
		$params = array('users' => '');
		echo $this->twig->render('formInsUser.twig.html', array('users' => $params['users'], 'usuario' => dameUsuarioYRol(), 'mensaje' => $this->msj));
	}
	
	public function insertarUsuario()
	{
		if (($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['p1'])) && (isset($_POST['p2']))) {
			$p1 = $this->xss($_POST['p1']);
			$p2 = $this->xss($_POST['p2']);
			if ($p1==$p2) {
				$nombre = $this->xss($_POST['nombre']);
				$rol = $this->xss($_POST['rol']);
				// comprueba que el usuario no exista ya
				if (!$this->us->existeUsuario($nombre)){
					 $this->us->agregar($nombre, $rol, $p1);
					 $this->setMensaje("El usuario se ha agregado correctamente.");
				}
				else { // mostrar mensaje, lo hiciste mal, llenalo de nuevo
					 $this->setMensaje("El usuario ya existe");
				}
			} else $this->setMensaje("Las contraseñas dadas no son iguales");			
		}
		header('Location: ./backend.php?accion=users');
	}
	
	public function borrarUsuario($id)
	{
	//comprueba que el usuario no intente borrarse a sí mismo
		if (isset($_GET['id'])) {
			$id = $this->xss($_GET['id']);
			if ($_SESSION['USUARIO']['id']!=$id){
					$res = $this->us->borrar($id);
					if ($res==-1){
						$this->setMensaje("Error al eliminar el usuario.");
					} else{
						$this->us->borrar($id);
						$this->setMensaje("Se ha borrado con éxito.");
						}
			} else
				$this->setMensaje("No puede eliminarse usted mismo.");
		}
		else
			$this->setMensaje("Error al entrar a la opción de eliminación de usuario.");
		header('Location: ./backend.php?accion=users');
	}
	
	public function modificarConfiguracion()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$d = $this->xss($_POST['dias']);
			$lat = $this->xss($_POST['lat']);
			$lon = $this->xss($_POST['lon']);
			$dato1 = $this->xss($_POST['dato1']);
			$dato2 = $this->xss($_POST['dato2']);
			$dato3 = $this->xss($_POST['dato3']);
			$dato4 = $this->xss($_POST['dato4']);
			
			$this->us->modificarConfig($d, $lat, $lon, $dato1, $dato2, $dato3, $dato4);
			$this->setMensaje("Se ha modificado la configuración.");
			header('Location: ./backend.php');
		} else {
			$configuracion = $this->us->verConfiguracion();
			echo $this->twig->render('formConfig.twig.html', array('config' => $configuracion, 'usuario' => dameUsuarioYRol(), 'mensaje' => $this->msj));
		}
	}	
					

// ------------------------------------------------------------------------------------------------------------------------------------
// --------------------------------------- DECLARACION DE FUNCIONES PARA LOS PEDIDOS/ENTREGAS -----------------------------------------
// ------------------------------------------------------------------------------------------------------------------------------------
	
	public function mostrarPedidos()
	{
		$this->revisarMensajes();
		$pedidos = $this->mP->todosLosPedidos();
		echo $this->twig->render('listadoPedidos.twig.html', array('pedidos' => $pedidos, 'usuario' => dameUsuarioYRol(), 'mensaje' => $this->msj));
	}
	
	public function generarPedido()
    {
		$entidades = $this->mE->listarReducido(); // devuelve arreglo de arreglos con (id, razon_social)
		$detalles = $this->mA->listarSoloStock();
		$pedido = array('entidad_receptora_id'=>"",
						'fecha_ingreso'=>"",
						'estado_pedido_id'=>"",
						'con_envio'=>"0");
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$pedido = array('entidad_receptora_id' => $this->xss($_POST['entidad']),
							'con_envio' => $this->xss($_POST['con_envio']));
			$turno = array('fecha' => $this->xss($_POST['fecha']),
						   'hora' => $this->xss($_POST['hora']));
			if (isset($_POST['cantidad'])) 
			{
				if ($this->mP->validarDatosPedido($pedido, $turno, $_POST['cantidad'])){
					$this->mP->agregar($pedido, $turno, $_POST['cantidad']);
					$this->setMensaje("El pedido se generó correctamente");
					header('Location: ./backend.php?accion=mostrarPedidos');
				} else {
					$this->msj = "Revisar los datos ingresados";
				}
			} else {
					$this->msj = "No se seleccionó ningún alimento para agregar al pedido, revise los datos ingresados.";
			}
		}
		echo $this->twig->render('formPedido.twig.html', array('pedido' => $pedido,
															   'entidades' => $entidades,
															   'detalles' => $detalles,
															   'usuario' => dameUsuarioYRol(),
															   'mensaje' => $this->msj));
	}
	
	public function actualizarPedido() // debe recibir $_GET['nro']
    {
		$entidades = $this->mE->listarReducido(); // devuelve arreglo de arreglos con (id, razon_social)
		$estados = $this->mP->listarEstadosPosibles();
		if (isset($_GET['nro']))
		{
			$id_pedido = $this->xss($_GET['nro']);
			$pedido = $this->mP->obtenerPorNro($id_pedido);
			if ($pedido == -1){
				$this->setMensaje("Numero incorrecto de pedido");
				header('Location: ./backend.php?accion=mostrarPedidos');
			}
			$detallesPedidos = $this->mP->obtenerDetallesPedido($id_pedido);
			if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$pedido['entidad_receptora_id'] = $this->xss($_POST['entidad']);
				$pedido['con_envio'] = $this->xss($_POST['con_envio']);
				$pedido['estado_pedido_id'] = $this->xss($_POST['estado']);
				$turno = array('fecha'=>$this->xss($_POST['fecha']), 'hora'=>$this->xss($_POST['hora']));
				if ($this->mP->validarDatosSinCantidad($pedido, $turno))
				{
					$this->mP->actualizar($pedido, $turno);
					$this->setMensaje("El pedido se actualizó correctamente");
					header('Location: ./backend.php?accion=mostrarPedidos');
				} else
					$this->msj = "Revisar los datos ingresados";
			}
			echo $this->twig->render('formActPedido.twig.html',  array('pedido' => $pedido,
																	   'entidades' => $entidades,
																	   'detalles' => $detallesPedidos,
																	   'estados' => $estados,
																	   'usuario' => dameUsuarioYRol(),
																	   'mensaje' => $this->msj));
		} else {
			$this->setMensaje("Error al intentar acceder a la actualización de pedidos");
			header('Location: ./backend.php?accion=mostrarPedidos');
		}
	}
	
	public function borrarDetallePedido()
	{
		if ((isset($_GET['id'])) && (isset($_GET['nro']))) {
			$id = $this->xss($_GET['id']);
			$nro = $this->xss($_GET['nro']);
			$resultado = $this->mP->eliminarDetallePedido($nro, $id);
			if ($resultado == 1) {
				$this->setMensaje("Alimento borrado del Pedido con éxito.");
			} elseif ($resultado == -1) {
				$this->setMensaje("Se eliminó el Pedido a falta de alimentos en él.");
				header('Location: ./backend.php?accion=mostrarPedidos');
				return;
			}
		} else
			$this->setMensaje("Error al entrar a la opción de borrado.");
		header('Location: ./backend.php?accion=actualizarPedido&nro='.$nro);
	}
	
	public function generarEntrega()
    {
		$entidades = $this->mE->listarReducido(); // devuelve arreglo de arreglos con (id, razon_social)
		$detalles = $this->mP->alimentosEntregaDirecta();
		$entidad = "";
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$entidad = $this->xss($_POST['entidad']);
			if (isset($_POST['cantidad'])) 
			{
				if ($this->mP->validarDatosEntrega($entidad, $_POST['cantidad']))
				{
					$this->mP->agregarEntrega($entidad, $_POST['cantidad']);
					$this->setMensaje("La entrega fue agregada con éxito.");
					header('Location: ./backend.php?accion=verEntregasRealizadas');
				} else {
					$this->msj = "Verificar los datos ingresados.";
				}
			} else {
				$this->msj = "No se seleccionó ningún alimento para agregar a la entrega.";
			}
		} 
		echo $this->twig->render('formEntrega.twig.html', array('entrega' => array('entidad_receptora_id' => $entidad),
																'entidades' => $entidades,
																'detalles' => $detalles,
																'usuario' => dameUsuarioYRol(),
																'accion' => "alta",
																'mensaje' => $this->msj));
	}

	public function verEntregasRealizadas()
	{
		$this->revisarMensajes();
		$entregas = $this->mP->entregasRealizadas();
		echo $this->twig->render('listado.entregas.twig.html', array('params' => $entregas, 'usuario' => dameUsuarioYRol(), 'mensaje' => $this->msj));
	}
	
	public function mostrarAgenda()
    {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$dia = $this->xss($_POST['fecha']);
			if ($this->check_date($dia)) {
				$pedidos = $this->mP->mostrarDia($dia);
				echo $this->twig->render('agenda.twig.html', array('usuario' => dameUsuarioYRol(), 'seleccion' => '11', 'pedidos' => $pedidos, 'mensaje' => $this->msj));
				return;
			} else {
				$this->msj="Error al ingresar la fecha";
			}
		} 
		echo $this->twig->render('agenda.twig.html', array('usuario' => dameUsuarioYRol(), 'seleccion' => '10', 'mensaje' => $this->msj));
	}
	
	public function pedidosConEnvio()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$dia = $this->xss($_POST['fecha']);
			if ($this->check_date($dia)) {
				$pedidos = $this->mP->verPedidosConEnvio($dia);
				echo $this->twig->render('agenda.twig.html', array('usuario' => dameUsuarioYRol(), 'seleccion' => '21', 'pedidos' => $pedidos, 'mensaje' => $this->msj));
				return;
			} else {
				$this->msj="Error al ingresar la fecha";
			}
		} 
		echo $this->twig->render('agenda.twig.html', array('usuario' => dameUsuarioYRol(), 'seleccion' => '20', 'mensaje' => $this->msj));
	}

// ------------------------------------------------------------------------------------------------------------------------------------
// --------------------------------------------- DECLARACION DE FUNCIONES PARA INFORMES -----------------------------------------------
// ------------------------------------------------------------------------------------------------------------------------------------
	
	public function entreFechas()
	{
		if ((isset($_POST['fecha1'])) && (isset($_POST['fecha2']))){ //si les llega las fecha por POST
			$f1 = $this->xss($_POST['fecha1']);
			$f2 = $this->xss($_POST['fecha2']);
			$params = $this->mE->informePesoPorDia($f1, $f2, "0");
			echo $this->twig->render('formInformes.twig.html', array('usuario' => dameUsuarioYRol(),
																	 'informe' => 1,
																	 'params' => $params,
																	 'fechas' => array('fecha1' => $f1, 'fecha2' => $f2),
																	 'mensaje' => $this->msj));
		} 
		else{
			echo $this->twig->render('formInformes.twig.html', array('usuario' => dameUsuarioYRol(), 'informe' => '1', 'mensaje' => $this->msj));
		}
	}
	
	public function informePorER(){

		if ((isset($_POST['fecha1'])) && (isset($_POST['fecha2']))){ //si les llega las fecha por POST
			$f1 = $this->xss($_POST['fecha1']);
			$f2 = $this->xss($_POST['fecha2']);
			
			$params = $this->mE->informePesoPorEntidad($f1, $f2, "0");
			
			echo $this->twig->render('formInformes.twig.html', array('usuario' => dameUsuarioYRol(),
																	 'informe' => '0',
																	 'params' => $params,
																	 'fechas' => array('fecha1' => $f1, 'fecha2' => $f2),
																	 'mensaje' => $this->msj));
		}
		else{
			echo $this->twig->render('formInformes.twig.html', array('usuario' => dameUsuarioYRol(), 'informe' => '0', 'mensaje' => $this->msj));
		}
	}
/*
	public function informePorERJSON()
	{
		header("content-type: application/json"); 
		$f1= $this->xss($_GET['f1']);
		$f2= $this->xss($_GET['f2']);
		$consulta= $this->mE->informePesoPorEntidad($f1, $f2, "1");
		$rows = array();
		
		foreach ($consulta as $valor) {
				$row[0] = $valor[0];  
				$row[1] = $valor[1];
				array_push($rows,$row);
		}
		echo json_encode($rows, JSON_NUMERIC_CHECK); //lo pasa a formato JSON
	}*/
		
	public function alimentosVencidos(){
		
		$alpv = $this->mA->alimentosVencidosSinEntregar();
		
		echo $this->twig->render('formInformes.twig.html', array('usuario' => dameUsuarioYRol(), 'informe' => '3', 'alimentos' => $alpv, 'mensaje' => $this->msj));
		
		}

	
// ------------------------------------------------------------------------------------------------------------------------------------
// --------------------------------------------- DECLARACION DE FUNCIONES PARA ENVIOS -------------------------------------------------
// ------------------------------------------------------------------------------------------------------------------------------------
	
	private function obtenerClima($lat, $lon, $dias){
		
		$weather= array();
		
		try {
			$html = file_get_contents("http://api.openweathermap.org/data/2.5/forecast/daily?lat=".$lat."&lon=".$lon."&cnt=".$dias."&mode=json&lang=sp&units=metric");
		}
		catch (Exception $e) {
			$weather['error']= "Error ".$e;
			return $weather;
		}
		$json = json_decode($html);

		$dias--; //porque el array comienza de 0
		
		$weather['ciudad']= $json->city->name;
		$weather['temp'] = $json->list[$dias]->temp->day;
		$weather['tempMax'] = $json->list[$dias]->temp->max;
		$weather['tempMin'] = $json->list[$dias]->temp->min;
		$weather['presion'] = $json->list[$dias]->pressure;
		$weather['humedad'] = $json->list[$dias]->humidity;
		$weather['descripcion'] = $json->list[$dias]->weather[0]->description;
		//url del ícono
		$weather['url'] = "http://openweathermap.org/img/w/".$json->list[$dias]->weather[0]->icon.".png";

		return $weather;
		
	}
	
		//OpenWeather tiene hasta 16 días de pronóstico extendido. Si la cantidad de días es mayor, se retorna false
	private function calcularFechasPronosticoExtendido($fecha){

		//$hoy = strtotime("today");
		
		$hoy= $this->mP->getToday();
		$hoy= strtotime($hoy);
		
		if ($this->check_date($fecha)){
		
			$fecha= strtotime($fecha);
			
			$cant = ($fecha-$hoy)/86400;
			//$cant = abs($cant);
			$dias = floor($cant);

			return $cant;
	}}
	
	
	public function mostrarEnvio()
	{
		$pedido = $this->xss($_GET['pedido']);
		
		$con= $this->mP->obtenerPorNro($pedido);
		
		$entidad= $this->mE->obtenerPorID($con['entidad_receptora_id']);
		
		
		$cantDias= $this->calcularFechasPronosticoExtendido($con['fecha']);
		
		if (($cantDias >= 0) && ($cantDias < 17)){
			$clima= $this->obtenerClima($entidad['latitud'], $entidad['longitud'], $cantDias);
		}
		elseif ($cantDias >= 17) $clima['error']= "Aún no hay datos sobre el pronóstico extendido.";
			else $clima['error']= "Error al recuperar los datos del clima: La fecha ha pasado.";
		echo $this->twig->render('envios.twig.html', array('usuario' => dameUsuarioYRol(), 'pedido' => $con, 'entidad' => $entidad, 'mensaje' => $this->msj, 'latitud' => $_SESSION['USUARIO']['lat'], 'longitud' => $_SESSION['USUARIO']['lon'], 'clima' => $clima));
	}
	

	

}
?>
