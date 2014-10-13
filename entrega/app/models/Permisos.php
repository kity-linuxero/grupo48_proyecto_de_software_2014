<?php    

//require_once './../controllers/ControllerLogin.php';

class Permisos {


    private static $accesos = array(
	 'administrador' => array('modificarDonante'=>'0', 'bajaDonante'=>'0', 'altaDonante'=>'0', 'listarEntidades'=>'0', 'altaEntidad'=>'0', 'modificarEntidad'=>'0', 'bajaEntidad'=>'0', 'listarAlimentos'=>'0', 'altaAlimento'=>'0', 'modificarAlimento'=>'0', 'bajaAlimento'=>'0', ),
	 'consulta' => array('listarAlimentos'=>'0', 'listarEntidades'=>'0')
	 );
	 
	 
    
     
	public static function tengoPermiso($accionAEjecutar){
	
	
	//print_r(self::$accesos);
	
//	print_r($_SESSION['USUARIO']['rol']);
	//print_r($_SESSION['USUARIO']['rol']['bajaDonante']);
//	print_r(self::$accesos[$_SESSION['USUARIO']['rol'][$accionAEjecutar]]);
	//echo print_r(self::$accesos[$_SESSION['USUARIO']]);
	
	//print_r(self::$accesos[$_SESSION['USUARIO']['rol']][$accionAEjecutar]);
	//die;
		
	if (isset(self::$accesos[$_SESSION['USUARIO']['rol']][$accionAEjecutar])) {
		return true;	
	}
	return false;
}
}
?>
