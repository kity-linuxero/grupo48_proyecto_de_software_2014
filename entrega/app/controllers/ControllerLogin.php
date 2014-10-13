﻿<?php
/**
 * Libreria para validar un usuario comprobando su usuario y contraseña
 */

/**
 * Veridica si el usuario está logeado
 * @return bool
 */
 
require_once __DIR__ . '/../models/Permisos.php';
 
function estoyLogueado () {
    @session_start(); //inicia sesion (la @ evita los mensajes de error si la session ya está iniciada)
    
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

function soyAdmin(){
	if (estoyLogueado()){
		if ($_SESSION['USUARIO']['rol'] == 'administrador'){
			return true;
			}
			else{ return false;}
				
	}
}

function postaTengoPermiso(){
	
	return (Permisos::tengoPermiso('listarAlimentos'));
	
	}

