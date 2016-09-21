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

/**
 * Libreria para validar un usuario comprobando su usuario y contraseña
 */

/**
 * Veridica si el usuario está logeado
 */
 
require_once __DIR__ . '/../models/Permisos.php';
@session_start(); //inicia sesion (la @ evita los mensajes de error si la session ya está iniciada)

function estoyLogueado () {

    if (!isset($_SESSION['USUARIO'])) return false; //no existe la variable $_SESSION['USUARIO']. No logeado.
    if (!is_array($_SESSION['USUARIO'])) return false; //la variable no es un array $_SESSION['USUARIO']. No logeado.
    if (empty($_SESSION['USUARIO']['userName'])) return false; //no tiene almacenado el usuario en $_SESSION['USUARIO']. No logeado.

    //cumple las condiciones anteriores, entonces es un usuario validado
    return true;
}

/**
  * Retorna el nombre del usuario
  */
function dameUsuario(){

if (estoyLogueado()){
	
	return($_SESSION['USUARIO']['userName']);
}

}

function dameRol(){
	
	if (estoyLogueado()){

	return($_SESSION['USUARIO']['rol']);
	}

}

function dameUsuarioYRol(){
	if (estoyLogueado()){
	$usr = array('user' => $_SESSION['USUARIO']['userName'], 'rol' => $_SESSION['USUARIO']['rol']);
	return $usr;
	}
}

function soyAdmin(){
	if (estoyLogueado()){
		if ($_SESSION['USUARIO']['rol'] == 'administrador'){
			return true;
			}
			else{ return false;}
				
	}
}

function postaTengoPermiso($unaAccion){
	
	return (Permisos::tengoPermiso($unaAccion));
	
}

?>
