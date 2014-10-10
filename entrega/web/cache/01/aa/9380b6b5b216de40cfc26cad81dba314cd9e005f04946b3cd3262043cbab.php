<?php

/* layout.twig.html */
class __TwigTemplate_01aa9380b6b5b216de40cfc26cad81dba314cd9e005f04946b3cd3262043cbab extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'contenido' => array($this, 'block_contenido'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "﻿<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\"> 
<html lang=\"es\"> 
  <head>
    <title>";
        // line 4
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
\t<meta charset=\"utf8\" />
\t<!-- <link href=\"css/estilos.css\" rel=\"stylesheet\" /> -->
\t<link rel=\"stylesheet\" media=\"(min-width: 481px)\" href=\"./css/maqueta.css\" type=\"text/css\">
 <link rel=\"stylesheet\" media=\"(min-width: 481px)\" href=\"./css/botonera.css\" type=\"text/css\"/>
 <link rel=\"stylesheet\" media=\"(max-width: 480px)\" href=\"./css/maquetaMobile.css\" />
 <link rel=\"stylesheet\" media=\"(max-width: 480px)\" href=\"./css/botoneraMobile.css\" />
 <link rel=\"stylesheet\" href=\"./css/login.css\" type=\"text/css\"/>
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
\t\t\t\t\t<li><a href=\"./controlador.php?action=listarDonantes\">Donantes</a></li>
\t\t\t\t\t<li><a href=\"#\">Colaboradores</a></li>
\t\t\t\t\t<li><a href=\"#\">Como colaborar</a></li>
\t\t\t\t\t<li><a href=\"#\">Contacto</a></li>
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
        // line 50
        $this->displayBlock('contenido', $context, $blocks);
        // line 52
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
\t<form class=\"log\"  method=\"post\" name=\"formulario\"  action=login-pdo.php>
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
Seguinos en: <a href=\"https://www.facebook.com/pages/Banco-Alimentario-La-Plata/87991129502\">Facebook</a> y <a href=\"https://twitter.com/bancoalimlp\">Twitter.</a>
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

    // line 50
    public function block_contenido($context, array $blocks = array())
    {
        // line 51
        echo "      ";
    }

    public function getTemplateName()
    {
        return "layout.twig.html";
    }

    public function getDebugInfo()
    {
        return array (  129 => 51,  126 => 50,  120 => 4,  77 => 52,  75 => 50,  26 => 4,  21 => 1,);
    }
}
