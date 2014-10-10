<?php

/* mensajeFront.twig.html */
class __TwigTemplate_8c74f9e4a3badce0dade26834d918924d9f9ab9fc414408d26aafe21fc00af1e extends Twig_Template
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
        echo "
<p>
";
        // line 6
        echo twig_escape_filter($this->env, (isset($context["mensaje"]) ? $context["mensaje"] : null), "html", null, true);
        echo "
</p>
";
    }

    public function getTemplateName()
    {
        return "mensajeFront.twig.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  35 => 6,  31 => 4,  28 => 3,);
    }
}
