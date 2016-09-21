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
