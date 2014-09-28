<?php

require_once './php/ValidadorSesion.php';

$sesion= ValidadorSesion::validar();

if(!$sesion){
	header('Location: index.html'); 
	
  exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Alta de Donantes</title>

    <link rel="stylesheet" media="screen" href="./estilos/form.css" >
    <link rel="stylesheet" media="(max-width: 320px)" href="./estilos/formMobile.css" />
    
    
</head>
<body>

<form class="formulario" method="post" name="formulario" action="./controlador.php?action=altaDonante">
<ul>
    <li>
         <h2>Alta de Donantes</h2>

		<!-- Fechass -->
         <span class="textoChico">Fecha de alta<input type="text" name="fecha" pattern="\d{1,2}/\d{1,2}/\d{4}" title="Ingrese una fecha válida" placeholder="DD/MM/AAAA" ></span>      
    </li>
    <li>
        <label for="razon">*Razón Social:</label>
        <input type="text" id="razon" name="razon"required/>
    </li>
    <li>
        <label for="nombre">*Nombre:</label>
        <input type="text" id="nombre" name="nombre" required/>
    </li>
    <li>
        <label for="apellido">*Apellido:</label>
        <input type="text" id="apellido" name="apellido"required/>
    </li>
    
    <li>
        <label for="tel">Teléfono:</label>
        <input type="text" id="tel" name="tel">
    </li>
    
	<li>
		<label for="email">Email:</label>
		<input type="email" id="email" name="email" />
		<span class="form_hint">Ejemplo "direccion@dominio.com"</span>
	</li>

	
	

<li>
    <button type="submit" name= "boton">Generar Alta</button>
</li>

</ul>
<div class="obligatorios">*Campos obligatorios</div>


</form>



</body>
</html>
