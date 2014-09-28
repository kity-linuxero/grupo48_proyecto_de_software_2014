<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Alta de Alimentos</title>
    <link rel="stylesheet" media="screen" href="./estilos/form.css" >
	<link rel="stylesheet" media="(max-width: 320px)" href="./estilos/formMobile.css" />
</head>
<body>

<form class="formulario" method="post" name="formulario" >

<ul>
    <li>
         <h2>Alta de Alimentos</h2>
    </li>
    <li>
       
        <input type="text" id="codigo" value=<?php echo $_GET['codigo'] ?> required/>
         <label for="codigo">Código:</label>
    </li>
    <li>
       
        <input type="text" id="nombre" required/>
         <label for="nombre">Descripción:</label>
    </li>
    
    <li>
    <!-- Fecha -->
         
         <input type="text" id="fecha" pattern="\d{1,2}/\d{1,2}/\d{4}" title="Ingrese una fecha válida" placeholder="DD/MM/AAAA" required/>
         <label for="fecha">Fecha de vencimiento</label>
    
    </li>
	<li>
		<textarea id="contenido" cols="40" rows="6" > </textarea>
		<label for="contenido">Contenido:</label>
	</li>
    <li>
        <input type="number" min="0" id="peso">
        <label for="peso">Peso:</label>
    </li>
    
	<li>
        <input type="number" min="0" id="stock" placeholder="0"> 
		<label for="stock">Stock</label>
    </li>
    <li>
       
        <input type="text" id="Reservado" required/>
         <label for="reservado">Reservado:</label>
    </li>    <li>
       
        <input type="text" id="donante" required/>
         <label for="donante">Donante:</label>
    </li>



	<li>
		<button type="submit" name= "boton">Generar Alta</button>
	</li>

</ul>
<div class="obligatorios">*Campos obligatorios</div>

</form>

</body>
</html>
