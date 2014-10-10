<?php

/* contacto.twig.html */
class __TwigTemplate_606662ee3026bfc12017f001e97157064c81cff9a22ed13dcab6482a0c1808ba extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("layoutFront.twig.html");

        $this->blocks = array(
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
    public function block_contenido($context, array $blocks = array())
    {
        // line 4
        echo "<p>
Email: bancodealimentos@gmail.com
Tel: 0221 - 4847209
<hr>
Banco de Alimentos La Plata
</p>

";
    }

    public function getTemplateName()
    {
        return "contacto.twig.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  31 => 4,  28 => 3,);
    }
}
