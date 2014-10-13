<?php

 class ModelEntidad extends Model
 {
 //    protected $conexion;

     public function __construct($dbname,$dbuser,$dbpass,$dbhost)
     {
		parent::__construct($dbname,$dbuser,$dbpass,$dbhost);
     }


     public function listar()
     {
         $sql = $this->conexion->prepare('select * from entidad_receptora join contacto where entidad_receptora.contacto_id=contacto.id order by razon_social');
		
		 $sql->execute();
		 
         $entidades = $sql->fetchAll(PDO::FETCH_ASSOC);

         return $entidades;
     }

     public function agregar()
     {
		
     
		}

     public function modificar()
     {
		
     
		}

     public function eliminar()
     {
		
     
		}
     
     public function validarDatos($n, $e, $p, $hc, $f, $g)
     {
         return (is_string($n) &
                 is_numeric($e) &
                 is_numeric($p) &
                 is_numeric($hc) &
                 is_numeric($f) &
                 is_numeric($g));
     }

 }
