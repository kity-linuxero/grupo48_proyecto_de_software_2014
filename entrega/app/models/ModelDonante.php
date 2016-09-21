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
 
 class ModelDonante extends Model
 {
     public function __construct($dbname,$dbuser,$dbpass,$dbhost)
     {
		parent::__construct($dbname,$dbuser,$dbpass,$dbhost);
     }

     public function listar()
     {
         $sql = $this->conexion->prepare('select *
										  from donante
										  order by razon_social');
		
		 $sql->execute();
		 
         $donantes = $sql->fetchAll(PDO::FETCH_ASSOC);

         return $donantes;
     }

     public function agregar($r, $n, $a, $t, $e)
     {
		 $sql_donante = $this->conexion->prepare("INSERT into donante
						(razon_social, apellido_contacto, nombre_contacto, telefono_contacto, mail_contacto)
												  VALUES (:r, :a, :n, :t, :e)
						 ");
		 $sql_donante->bindParam(':r', $r, PDO::PARAM_STR);
		 $sql_donante->bindParam(':a', $a, PDO::PARAM_STR);
		 $sql_donante->bindParam(':n', $n, PDO::PARAM_STR);
		 $sql_donante->bindParam(':t', $t, PDO::PARAM_STR);
		 $sql_donante->bindParam(':e', $e, PDO::PARAM_STR);
         $sql_donante->execute();
     
		}

     public function modificar($i, $r, $n, $a, $t, $e)
     {
		 $sql_donante = $this->conexion->prepare("UPDATE donante
							SET razon_social= :r,
								apellido_contacto= :a,
								nombre_contacto= :n,
								telefono_contacto= :t, 
								mail_contacto= :e
							WHERE id= :i
						");
		 $sql_donante->bindParam(':r', $r, PDO::PARAM_STR);
		 $sql_donante->bindParam(':a', $a, PDO::PARAM_STR);
		 $sql_donante->bindParam(':n', $n, PDO::PARAM_STR);
		 $sql_donante->bindParam(':t', $t, PDO::PARAM_STR);
		 $sql_donante->bindParam(':e', $e, PDO::PARAM_STR);
		 $sql_donante->bindParam(':i', $i, PDO::PARAM_INT);

         $sql_donante->execute();
	 }

     public function eliminar($id)
     {
		$res = $this->obtenerPorID($id);
		
		if ($res!=-1){
			$sql = $this->conexion->prepare("DELETE FROM donante WHERE id= :id");
			$sql->bindParam(':id', $id, PDO::PARAM_INT);
			$sql->execute();
		} else return -1;
	 }
     
	 public function obtenerPorID($id)
	 {
		$sql = $this->conexion->prepare("SELECT *
										 FROM donante
										 WHERE donante.id= :id");
		$sql->bindParam(':id', $id, PDO::PARAM_INT);
		$sql->execute();
		$donante = $sql->fetchAll(PDO::FETCH_ASSOC);
		if (count($donante)==1) 
				return $donante["0"];
		else 	return -1;
	 }

	public function obtenerDonantesActivos()
	{
		$sql = $this->conexion->prepare("SELECT * FROM donante");
		$sql->execute();
		$res = $sql->fetchAll(PDO::FETCH_ASSOC);
		return $res;
	}
	 
     public function validarDatos($r, $n, $a, $t, $e)
     {
         return (is_string($r) &
                 is_string($n) &
                 is_string($a) &
                 is_string($t) &
                 is_string($e));
     }

 }

?>
