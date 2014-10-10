<!DOCTYPE html>
<html lang="es">
<head>
 <meta charset="utf-8" />
 <link rel="stylesheet" media="(min-width: 481px)" href="./estilos/maqueta.css" type="text/css">
 <link rel="stylesheet" media="(min-width: 481px)" href="./estilos/botonera.css" type="text/css"/>
 <link rel="stylesheet" media="(max-width: 480px)" href="./estilos/maquetaMobile.css" />
 <link rel="stylesheet" media="(max-width: 480px)" href="./estilos/botoneraMobile.css" />
 <link rel="stylesheet" href="./estilos/login.css" type="text/css"/>
 
 
<title>Sistema Online del Banco Alimentario La Plata</title>
 
</head>
<body>
 <div id="global">
	  <?php 
 if(isset($_GET["mensaje"]))
	echo $_GET["mensaje"];?>
 <div id="cabecera">
	 
 <img src="./img/logo.jpg" alt="logo de la fundacion" />
 
 

 </div>
 <div id="navegacion">
	<div id = "menu">
				<ul id="boton"> 
			
					<li><a href="./index.php">Home</a></li>
					<li><a href="#">Quienes somos</a></li>
					<li><a href="#">A quien ayudamos</a></li>
					<li><a href="./controlador.php?action=listarDonantes">Donantes</a></li>
					<li><a href="#">Colaboradores</a></li>
					<li><a href="#">Como colaborar</a></li>
					<li><a href="#">Contacto</a></li>
					<li><a href="#login">Login</a></li>
					
			
				</ul>
			</div>
	</div>
 <div id="principal">
<p>Bienvenidos a la página web del Banco Alimentario de la ciudad de La Plata.</p>

<p> Somos una organización sin fines de lucro que tiene como misión la recuperación de alimentos para generar conciencia ambiental combatiendo el hambre y la desnutrición en la zona del Gran La Plata. </p>


</div>
			
			<img src="./img/imagen-banco.jpg" alt="Imagen descriptiva" class="imagenCuerpo">

 </div>
 

 

 </div>
 
 <div id="login" class="modalDialog">
	<div>
		<a href="#close" title="Close" class="close">X</a>
		<h2>Login</h2>
		<p>Inicie sesión para continuar.</p>
		
		<form class="log"  method="post" name="formulario"  action=login-pdo.php>
		 <div>
			<input type="text" name="usuario" placeholder="Usuario" required/>
		</div>
		<div>
			<input type="password" name="pass" placeholder="Contraseña" required/>
		</div>
		
		<div>
    <button type="submit" name= "boton" class="button">Iniciar sesión</button>
    
    
</div>
		
		</form>
		
		
		
	</div>
</div>
<footer>
Seguinos en: <a href="https://www.facebook.com/pages/Banco-Alimentario-La-Plata/87991129502">Facebook</a> y <a href="https://twitter.com/bancoalimlp">Twitter.</a>
 </footer>
</body>
</html>
