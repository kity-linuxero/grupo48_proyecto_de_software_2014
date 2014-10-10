<?php

/* layoutBack.twig.html */
class __TwigTemplate_56e1b9c824bdc9db4305dff985d19396bff501597b5873c0631127d7942d9155 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'botonera' => array($this, 'block_botonera'),
            'contenido' => array($this, 'block_contenido'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "﻿<!DOCTYPE html> 
<html lang=\"es\"> 

<head>
    <title>";
        // line 5
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
\t<meta charset=\"utf8\" />
\t<!-- <link href=\"css/estilos.css\" rel=\"stylesheet\" /> -->
 <link rel=\"stylesheet\" media=\"(min-width: 481px)\" href=\"./css/maqueta.css\" type=\"text/css\">
 <link rel=\"stylesheet\" media=\"(min-width: 481px)\" href=\"./css/botonera.css\" type=\"text/css\"/>
 <link rel=\"stylesheet\" media=\"(max-width: 480px)\" href=\"./css/maquetaMobile.css\" />
 <link rel=\"stylesheet\" media=\"(max-width: 480px)\" href=\"./css/botoneraMobile.css\" />
 <link rel=\"stylesheet\" href=\"./css/login.css\" type=\"text/css\"/>
 <link rel=\"stylesheet\" href=\"./css/listado.css\" type=\"text/css\"/> 
 
 
</head>
  
<body>
  
 \t<div id=\"global\">

\t\t<div id=\"cabecera\">
\t 
\t\t\t<img src=\"./img/logo.jpg\" alt=\"logo de la fundacion\" />
 
\t\t</div>
\t\t<div id=\"navegacion\">
\t\t\t
\t\t\t<div id = \"menu\">
\t\t\t\t\t\t<ul id=\"boton\"> 
\t\t\t\t\t\t";
        // line 31
        $this->displayBlock('botonera', $context, $blocks);
        // line 33
        echo "\t\t<!-- desde acá se preguntaria por el usuario, o se hace un case o se mapea -->
\t\t\t\t\t\t\t
\t\t<!-- hasta acá -->
\t\t\t\t\t\t</ul>
\t\t\t</div>
\t\t</div>


\t\t<div id=\"principal\"> 
\t\t<!-- Contenido dinámico a mostrar -->
\t\t
\t\t<div>
\t\t\t\t<p>Bienvenido <?php echo \$_SESSION['usuario'];?>. Aqui encontrará las opciones disponibles.</p>
\t\t\t\t<hr>
\t\t\t
\t\t</div>
\t\t
\t\t\t<div>
\t\t\t\t";
        // line 51
        $this->displayBlock('contenido', $context, $blocks);
        // line 53
        echo "\t\t\t</div>
\t\t</div>

\t</div>
\t
\t\t<footer>
\t\tBanco Alimentario La Plata | Seguinos en: <a href=\"https://www.facebook.com/pages/Banco-Alimentario-La-Plata/87991129502\">Facebook</a> y <a href=\"https://twitter.com/bancoalimlp\">Twitter.</a>
\t\t</footer>

\t</body>
</html>
";
    }

    // line 5
    public function block_title($context, array $blocks = array())
    {
        echo "Banco Alimentario La Plata";
    }

    // line 31
    public function block_botonera($context, array $blocks = array())
    {
        // line 32
        echo "\t\t\t\t\t\t";
    }

    // line 51
    public function block_contenido($context, array $blocks = array())
    {
        // line 52
        echo "\t\t\t\t";
    }

    public function getTemplateName()
    {
        return "layoutBack.twig.html";
    }

    public function getDebugInfo()
    {
        return array (  112 => 52,  109 => 51,  105 => 32,  102 => 31,  96 => 5,  81 => 53,  79 => 51,  59 => 33,  57 => 31,  28 => 5,  22 => 1,);
    }
}
