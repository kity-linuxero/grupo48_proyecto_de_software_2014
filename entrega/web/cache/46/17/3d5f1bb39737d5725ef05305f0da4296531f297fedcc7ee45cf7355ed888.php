<?php

/* index.twig.html */
class __TwigTemplate_46173d5f1bb39737d5725ef05305f0da4296531f297fedcc7ee45cf7355ed888 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("layoutFront.twig.html");

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'contenido' => array($this, 'block_contenido'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "layoutFront.twig.html";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = array())
    {
        // line 4
        echo "\tBanco de Alimentos - La Plata
";
    }

    // line 7
    public function block_contenido($context, array $blocks = array())
    {
        // line 8
        echo "\t<p>Bienvenidos a la página web del Banco Alimentario de la ciudad de La Plata.</p>

\t<p> Somos una organización sin fines de lucro que tiene como misión la recuperación de alimentos para generar conciencia ambiental combatiendo el hambre y la desnutrición en la zona del Gran La Plata. </p>


\t<div>
\t\t\t
\t\t\t<img src=\"./img/imagen-banco.jpg\" alt=\"Imagen descriptiva\" class=\"imagenCuerpo\">

\t</div>
";
    }

    public function getTemplateName()
    {
        return "index.twig.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  40 => 8,  37 => 7,  32 => 4,  29 => 3,);
    }
}
