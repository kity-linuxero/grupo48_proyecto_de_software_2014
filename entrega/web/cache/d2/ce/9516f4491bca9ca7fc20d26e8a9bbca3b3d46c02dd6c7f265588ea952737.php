<?php

/* listadoDonantes.html */
class __TwigTemplate_d2ce9516f4491bca9ca7fc20d26e8a9bbca3b3d46c02dd6c7f265588ea952737 extends Twig_Template
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

    // line 5
    public function block_contenido($context, array $blocks = array())
    {
        // line 6
        echo "<table class=\"reference\" style=\"width:100%\">
\t\t<tbody>
\t\t\t<tr>
\t\t\t\t<th>Razón Social</th>
\t\t\t\t<th>Nombre</th>
\t\t\t\t<th>Apellido</th>
\t\t\t\t<th>Teléfono</th>
\t\t\t\t<th>E-mail</th>
\t\t\t</tr>

\t\t";
        // line 16
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["donantes"]) ? $context["donantes"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["donante"]) {
            // line 17
            echo "\t\t\t<tr>
\t\t\t       \t<td>";
            // line 18
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["donante"]) ? $context["donante"] : null), "razon_social"), "html", null, true);
            echo "</td>
\t\t        \t<td>";
            // line 19
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["donante"]) ? $context["donante"] : null), "nombre"), "html", null, true);
            echo "</td>
\t\t        \t<td>";
            // line 20
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["donante"]) ? $context["donante"] : null), "apellido"), "html", null, true);
            echo "</td>
\t\t        \t<td>";
            // line 21
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["donante"]) ? $context["donante"] : null), "telefono"), "html", null, true);
            echo "</td>
\t\t        \t<td>";
            // line 22
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["donante"]) ? $context["donante"] : null), "mail"), "html", null, true);
            echo "</td>
\t\t\t</tr>
\t\t\t
\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['donante'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 26
        echo "
\t\t</tbody>
</table>
 
";
    }

    public function getTemplateName()
    {
        return "listadoDonantes.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  76 => 26,  66 => 22,  62 => 21,  58 => 20,  54 => 19,  50 => 18,  47 => 17,  43 => 16,  31 => 6,  28 => 5,);
    }
}
