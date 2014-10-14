<?php

/* layoutFront.twig.html */
class __TwigTemplate_8591cf8f11c213201f68817f018426ef32c17a77095053fa37e557c85c543fea extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'estilo' => array($this, 'block_estilo'),
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
        // line 4
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
 ";
        // line 13
        $this->displayBlock('estilo', $context, $blocks);
        // line 16
        echo " 
  </head>
  <body>
    
\t<div id=\"global\">

\t\t<div id=\"cabecera\">
\t\t 
\t\t\t<img src=\"./img/logo.jpg\" alt=\"logo de la fundacion\" />
\t 
\t\t</div>

\t\t<div id=\"navegacion\">

\t\t\t<div id = \"menu\">
\t\t\t\t\t\t<ul id=\"boton\"> 
\t\t\t\t\t\t\t<li><a href=\"./index.php\">Home</a></li>
\t\t\t\t\t\t\t<li><a href=\"#\">Quienes somos</a></li>
\t\t\t\t\t\t\t<li><a href=\"#\">A quien ayudamos</a></li>
\t\t\t\t\t\t\t<li><a href=\"./index.php?accion=listarDonantes\">Donantes</a></li>
\t\t\t\t\t\t\t<li><a href=\"./index.php?accion=listarEntidades\">Entidades Receptoras</a></li>
\t\t\t\t\t\t\t<li><a href=\"#\">Como colaborar</a></li>
\t\t\t\t\t\t\t<li><a href=\"./index.php?accion=contacto\">Contacto</a></li>
\t\t\t\t\t\t\t<li><a href=\"#login\">Login</a></li>
\t\t\t\t\t\t</ul>
\t\t\t</div>
\t\t</div>

\t\t <div id=\"principal\"> 
\t\t 
\t\t\t<!-- Contenido din�mico a mostrar -->
\t\t\t<div>
\t\t\t  <br>
\t\t\t  ";
        // line 49
        $this->displayBlock('contenido', $context, $blocks);
        // line 51
        echo "\t\t\t</div>
\t\t</div>
\t\t\t\t
\t</div>


\t<div id=\"login\" class=\"modalDialog\">
\t\t<div>
\t\t\t<a href=\"#close\" title=\"Close\" class=\"close\">X</a>
\t\t\t<h2>Login</h2>
\t\t\t<p>Inicie sesión para continuar.</p>
\t\t\t
\t\t\t<form class=\"log\"  method=\"post\" name=\"formulario\"  action='./../app/login.php'>
\t\t\t\t<div>
\t\t\t\t\t<input type=\"text\" name=\"usuario\" placeholder=\"Usuario\" required/>
\t\t\t\t</div>
\t\t\t\t<div>
\t\t\t\t\t<input type=\"password\" name=\"pass\" placeholder=\"Contraseña\" required/>
\t\t\t\t</div>
\t\t\t\t<div>
\t\t\t\t\t<button type=\"submit\" name= \"boton\" class=\"button\">Iniciar sesión</button>
\t\t\t\t</div>
\t\t\t</form>
\t\t</div>
\t</div>


\t
\t<footer>
\tBanco Alimentario La Plata | Seguinos en: <a href=\"https://www.facebook.com/pages/Banco-Alimentario-La-Plata/87991129502\">Facebook</a> y <a href=\"https://twitter.com/bancoalimlp\">Twitter.</a>
\t</footer>
  </body>
</html>
";
    }

    // line 4
    public function block_title($context, array $blocks = array())
    {
        echo "Banco Alimentario La Plata";
    }

    // line 13
    public function block_estilo($context, array $blocks = array())
    {
        // line 14
        echo " 
 ";
    }

    // line 49
    public function block_contenido($context, array $blocks = array())
    {
        // line 50
        echo "\t\t\t  ";
    }

    public function getTemplateName()
    {
        return "layoutFront.twig.html";
    }

    public function getDebugInfo()
    {
        return array (  132 => 50,  129 => 49,  124 => 14,  121 => 13,  115 => 4,  78 => 51,  76 => 49,  41 => 16,  39 => 13,  27 => 4,  22 => 1,  40 => 8,  37 => 7,  32 => 4,  29 => 3,);
    }
}
