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

\t<div id=\"cabecera\">
\t 
\t<img src=\"./img/logo.jpg\" alt=\"logo de la fundacion\" />
 
 

\t</div>
\t<div id=\"navegacion\">
\t<div id = \"menu\">
\t\t\t\t<ul id=\"boton\"> 
\t\t\t
\t\t\t\t\t<li><a href=\"./index.php\">Home</a></li>
\t\t\t\t\t<li><a href=\"#\">Quienes somos</a></li>
\t\t\t\t\t<li><a href=\"#\">A quien ayudamos</a></li>
\t\t\t\t\t<li><a href=\"./index.php?accion=listarDonantes\">Donantes</a></li>
\t\t\t\t\t<li><a href=\"./index.php?accion=listarEntidades\">Entidades Receptoras</a></li>
\t\t\t\t\t<li><a href=\"#\">Como colaborar</a></li>
\t\t\t\t\t<li><a href=\"./index.php?accion=contacto\">Contacto</a></li>
\t\t\t\t\t<li><a href=\"#login\">Login</a></li>
\t\t\t\t\t
\t\t\t
\t\t\t\t</ul>
\t</div>
</div>


 <div id=\"principal\"> 
 
 <!-- Contenido din�mico a mostrar -->
\t
    <div>
      ";
        // line 55
        $this->displayBlock('contenido', $context, $blocks);
        // line 57
        echo "    </div>
\t</div>
\t\t\t
\t\t\t
 

 


</div>


<div id=\"login\" class=\"modalDialog\">
\t<div>
\t\t<a href=\"#close\" title=\"Close\" class=\"close\">X</a>
\t\t<h2>Login</h2>
\t\t<p>Inicie sesión para continuar.</p>
\t\t
\t<form class=\"log\"  method=\"post\" name=\"formulario\"  action='./../app/login.php'>
\t\t<div>
\t\t\t<input type=\"text\" name=\"usuario\" placeholder=\"Usuario\" required/>
\t\t</div>
\t\t<div>
\t\t\t<input type=\"password\" name=\"pass\" placeholder=\"Contraseña\" required/>
\t\t</div>
\t\t<div>
\t\t\t<button type=\"submit\" name= \"boton\" class=\"button\">Iniciar sesión</button>
\t\t</div>
\t</form>
\t</div>
</div>


\t
<footer>
Banco Alimentario La Plata | Seguinos en: <a href=\"https://www.facebook.com/pages/Banco-Alimentario-La-Plata/87991129502\">Facebook</a> y <a href=\"https://twitter.com/bancoalimlp\">Twitter.</a>
 </footer>
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

    // line 55
    public function block_contenido($context, array $blocks = array())
    {
        // line 56
        echo "      ";
    }

    public function getTemplateName()
    {
        return "layoutFront.twig.html";
    }

    public function getDebugInfo()
    {
        return array (  144 => 56,  141 => 55,  136 => 14,  133 => 13,  127 => 4,  84 => 57,  82 => 55,  41 => 16,  39 => 13,  27 => 4,  22 => 1,  40 => 8,  37 => 7,  32 => 4,  29 => 3,);
    }
}
