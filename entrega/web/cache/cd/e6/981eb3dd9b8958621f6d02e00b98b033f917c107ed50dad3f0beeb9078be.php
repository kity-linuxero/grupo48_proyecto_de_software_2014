<?php

/* backend.twig.html */
class __TwigTemplate_cde6981eb3dd9b8958621f6d02e00b98b033f917c107ed50dad3f0beeb9078be extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("layoutBack.twig.html");

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'botonera' => array($this, 'block_botonera'),
            'contenido' => array($this, 'block_contenido'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "layoutBack.twig.html";
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
    public function block_botonera($context, array $blocks = array())
    {
        // line 8
        echo "
\t\t\t\t\t\t\t<li><a href=\"./backend.php\">Home</a></li>
\t\t\t\t\t\t\t<li><a href=\"./backend.php?accion=listarDonantes\">Donantes</a></li>
\t\t\t\t\t\t\t<li><a href=\"./backend.php?accion=listarEntidades\">Entidades Receptoras</a></li>
\t\t\t\t\t\t\t<li><a href=\"./backend.php?accion=listarAlimentos\">Listar Alimentos</a></li>
\t\t\t\t\t\t\t<li><a href=\"../app/logout.php\">Logout</a></li>

";
    }

    // line 18
    public function block_contenido($context, array $blocks = array())
    {
        // line 19
        echo "
\t<p>Bienvenido <?php echo \$_SESSION['usuario']?>. Aquí se presentan las funciones disponibles para usted.</p>
\t<hr>
\t
\t
\t
";
    }

    public function getTemplateName()
    {
        return "backend.twig.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  55 => 19,  52 => 18,  41 => 8,  38 => 7,  33 => 4,  30 => 3,);
    }
}
