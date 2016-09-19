<?php    

@session_start(); 

/*
 * En esta clase, se define un array, donde estarán los permisos de cada perfil. En esta misma clase
 * Se validan dichos permisos.
 * 
 * 
 * 
 */

class Permisos {

    private static $accesos = array(
		'administrador' => array('modificarDonante'=>'0', 'bajaDonante'=>'0',
								 'listarDonantes'=>'0', 'altaDonante'=>'0', 
								 'listarEntidades'=>'0', 'bajaEntidad'=>'0',
								 'altaEntidad'=>'0', 'modificarEntidad'=>'0',
								 'listarAlimentos'=>'0', 'bajaAlimento'=>'0', 
								 'altaAlimento'=>'0', 'modificarAlimento'=>'0',
								 'altaDonacion'=>'0',
								 'inicio'=>'0', 'users'=>'0', 'modificarUsuario'=>'0', 'altaUsuario'=>'0',
								 'insertarUsuario'=>'0', 'borrarUsuario' => '0',
								 'generarPedido'=>'0', 'generarEntrega'=>'0', 'mostrarConfiguracion'=>'0',
								 'modificarPedido'=>'0', 'modificarConfiguracion'=>'0',
								 'actualizarPedido'=>'0', 'mostrarAgenda'=>'0',
								 'mostrarPedidos' =>'0', 'borrarDetallePedido' =>'0',
								 'verEntregasRealizadas'=>'0', 'entreFechasPorER'=>'0', 'informePorER'=>'0',
								 'entreFechas' => '0', 'alimentosVencidos'=>'0', 'mostrarEnvio'=>'0',
								 'pedidosConEnvio'=>'0'

								 ),
		'gestion' => array('generarPedido'=>'0', 'generarEntrega'=>'0', 'mostrarAgenda'=>'0',
							'verEntregasRealizadas'=>'0', 'mostrarPedido'=>'0',
							'inicio'=>'0', 'informePorER'=>'0',
							'entreFechas' => '0', 'alimentosVencidos'=>'0',
							'mostrarPedidos'=>'0', 'mostrarEnvio'=>'0',
							'actualizarPedido'=>'0', 'mostrarAgenda'=>'0',
							'pedidosConEnvio'=>'0'
							
							
							),
		'consulta' => array('listarAlimentosSoloStock'=>'0', 'inicio'=>'0',
							'entreFechasPorER'=>'0', 'informePorER'=>'0', 'entreFechas' => '0', 'alimentosVencidos'=>'0'
		
							)
	 );
	 

	public static function tengoPermiso($accionAEjecutar){
	 if (!(isset($_SESSION['USUARIO']))) {
		return false;
	 }
	 elseif (isset(self::$accesos[$_SESSION['USUARIO']['rol']][$accionAEjecutar])) {
		return true;	
		}
		return false;
	}
}
?>
