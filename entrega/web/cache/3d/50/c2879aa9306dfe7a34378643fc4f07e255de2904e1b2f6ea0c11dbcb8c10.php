<?php

/* abmDonantes.html */
class __TwigTemplate_3d50c2879aa9306dfe7a34378643fc4f07e255de2904e1b2f6ea0c11dbcb8c10 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("backend.twig.html");

        $this->blocks = array(
            'contenido' => array($this, 'block_contenido'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "backend.twig.html";
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
\t\t\t\t<th>Domicilio</th>
\t\t\t\t<th>Teléfono</th>
\t\t\t\t<th>E-mail</th>
\t\t\t</tr>

\t\t";
        // line 17
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["donantes"]) ? $context["donantes"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["donante"]) {
            // line 18
            echo "\t\t\t<tr>
\t\t\t       \t<td>";
            // line 19
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["donante"]) ? $context["donante"] : null), "razon_social"), "html", null, true);
            echo "</td>
\t\t        \t<td>";
            // line 20
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["donante"]) ? $context["donante"] : null), "nombre"), "html", null, true);
            echo "</td>
\t\t        \t<td>";
            // line 21
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["donante"]) ? $context["donante"] : null), "apellido"), "html", null, true);
            echo "</td>
\t\t        \t<td>";
            // line 22
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["donante"]) ? $context["donante"] : null), "domicilio"), "html", null, true);
            echo "</td>
\t\t        \t<td>";
            // line 23
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["donante"]) ? $context["donante"] : null), "telefono"), "html", null, true);
            echo "</td>
\t\t        \t<td>";
            // line 24
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["donante"]) ? $context["donante"] : null), "mail"), "html", null, true);
            echo "</td>
\t\t        \t<td> <a href=\"./backend.php?accion=modificarDonante&id=";
            // line 25
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["donante"]) ? $context["donante"] : null), "id"), "html", null, true);
            echo "\">
\t\t\t\t\t\t\t<img src=\"./img/lapiz.jpg\" alt=\"lapiz\"></a></td>
\t\t        \t<td> <a href=\"./backend.php?accion=bajaDonante&id=";
            // line 27
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["donante"]) ? $context["donante"] : null), "id"), "html", null, true);
            echo "\">
\t\t\t\t\t\t\t<img src=\"./img/cruz.png\" alt=\"crucecita\"></a></td>

\t\t\t</tr>
\t\t\t
\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['donante'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 33
        echo "\t\t</tbody>
</table>
 
";
    }

    public function getTemplateName()
    {
        return "abmDonantes.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  92 => 33,  80 => 27,  75 => 25,  71 => 24,  67 => 23,  63 => 22,  59 => 21,  55 => 20,  51 => 19,  48 => 18,  44 => 17,  31 => 6,  28 => 5,);
    }
}
