<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Modificación de Alimentos</title>
    <link rel="stylesheet" media="screen" href="./estilos/form.css" >
	<link rel="stylesheet" media="(max-width: 320px)" href="./estilos/formMobile.css" />
</head>
<body>

<form class="formulario" method="post" name="formulario" >

<ul>
    <li>
         <h2>Modificación de Alimentos</h2>
    </li>

    <li>
       
        <input type="text" id="nombre" value=<?php echo $_GET['p2'] ?> required/>
         <label for="nombre">Descripción:</label>
    </li>
    
    <li>
    <!-- Fecha -->
         
         <input type="text" id="fecha" pattern="\d{1,2}/\d{1,2}/\d{4}" title="Ingrese una fecha válida" placeholder="DD/MM/AAAA" value=<?php echo $_GET['p3'] ?> required/>
         <label for="fecha">Fecha de vencimiento</label>
    
    </li>
	<li>
		<input type="text" id="contenido" value=<?php echo $_GET['p4'] ?> > </textarea>
		<label for="contenido">Contenido:</label>
	</li>
	<li>
        <input type="number" min="0" id="peso" step="0.1" value=<?php echo $_GET['p5'] ?> > 
		<label for="peso">Peso</label>
    </li>
    
	<li>
        <input type="number" min="0" id="stock" value=<?php echo $_GET['p6'] ?> > 
		<label for="stock">Stock</label>
    </li>
    <li>
       
        <input type="text" id="Reservado" value=<?php echo $_GET['p7'] ?> required/>
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
