<?php

//creamos la sesion
session_start();

//validamos si se ha hecho o no el inicio de sesion correctamente

//si no se ha hecho la sesion nos regresará a login.php
if(!isset($_SESSION['usuario'])) 
{
  header('Location: index.html'); 
  exit();
}
?>



<!DOCTYPE html>
<html lang="es">  
    <head>  
	<meta charset="utf-8"> 
        <title>Banco de alimentos La Plata - Backend</title>  
        <link rel="stylesheet" media="(min-width: 481px)" href="./estilos/maqueta.css" type="text/css">
		<link rel="stylesheet" media="(min-width: 481px)" href="./estilos/botonera.css" type="text/css"/>
		<link rel="stylesheet" media="(max-width: 480px)" href="./estilos/maquetaMobile.css" />
		<link rel="stylesheet" media="(max-width: 480px)" href="./estilos/botoneraMobile.css" />
        
        
        
    </head>  
    <body>  
        <div id ="global">  <a href="logout.php" id=log class="boton">Logout</a>
        
            
            <div id ="cabecera">
		
				<h3>Backend - Panel de control</h3></div>  
            <div id ="menu"><p>Bienvenido
						<?php echo $_SESSION['usuario'];;?> 
            </p></div>

			<div id ="navegacion">
				<ul id="boton"> 
			
					<li><a href="./altaDonantes.html">ABM de Donantes</a></li>
					<li><a href="">ABM de Entidades receptoras</a></li>
					<li><a href="./altaAlimentos.html">ABM de alimentos</a></li>
					<li><a href="">ABM de turnos de entrega</a></li>
					<li><a href="">ABM de Servicios prestados</a></li>
					<li><a href="">Confección y entrega de pedidos</a></li>
					<li><a href="">Consulta de stock de alimentos</a></li>
					<li><a href="./controlador.php?action=listar">Listado de alimentos</a></li>
			
				</ul>
			
			
			<!-- <footer>Usuario registrado</footer> -->
			
			</div>

            <div id ="centro">
				
            </div>
			
            <!-- Pie de página -->
            <div id ="pie">
			
			<script> type="text/javascript">
				var d = new Date();
				document.write(d.getDate()+'/');document.write(d.getMonth()+'/')/document.write(d.getFullYear());
			</script> 
			</div>  
        </div>  
        
        
        
        
        
        
    </body>  
</html>  

