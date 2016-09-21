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
 
 class ModelLogin extends Model
 {

     public function __construct($dbname,$dbuser,$dbpass,$dbhost)
     {
		parent::__construct($dbname,$dbuser,$dbpass,$dbhost);
     }


	public static function consultar($user,$pass){

		$user = Model::xss($user);
		$pass = Model::xss($pass);

		$cn= New ModelLogin(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario, Config::$mvc_bd_clave, Config::$mvc_bd_hostname);
		
		
		$sql = $cn->conexion->prepare("SELECT * FROM shadow INNER JOIN rol on (shadow.id_rol = rol.id ) where (nombre = :user) and (pass = :pass)");
		$sql->bindParam(':user', $user, PDO::PARAM_STR);
		$sql->bindParam(':pass', $pass, PDO::PARAM_STR);
		$sql->execute();
		 
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        
           
        //consulto la cantidad de coincidencias.
        if (count($resultado) == 0){ 
			
			return 0;
		}
		else{
			return $resultado;
			}
	}
	
	public static function obtenerCoordenadas(){
		
		$cn= New ModelLogin(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario, Config::$mvc_bd_clave, Config::$mvc_bd_hostname);
		$sql = $cn->conexion->prepare("SELECT valor FROM configuracion WHERE clave='latitud' or clave='longitud'");
		$sql->execute();
		 
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        
        
        
		return $resultado;
		
	}



}     

 ?>
