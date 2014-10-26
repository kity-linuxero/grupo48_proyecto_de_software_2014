<?php    

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
								  'inicio'=>'0', 'users'=>'0', 'modificarUsuario'=>'0'),
		 'consulta' => array('listarAlimentosSoloStock'=>'0', 'inicio'=>'0')
	 );
	 

	public static function tengoPermiso($accionAEjecutar){
		
	 if (isset(self::$accesos[$_SESSION['USUARIO']['rol']][$accionAEjecutar])) {
		return true;	
		}
		return false;
	}
}
?>
