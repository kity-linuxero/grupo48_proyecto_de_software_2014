<?php

/* listadoAlimentos.html */
class __TwigTemplate_06accb5842afb6dffc1ca96721cffafbe026a4f68037f27402115e96b8aac675 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<html>  
    <head>  
\t<meta charset=\"utf-8\"> 
        <title>Listado de Alimentos</title>  
        <link rel=\"stylesheet\" href=\"./estilos/index.css\" type=\"text/css\"/>  
        <link rel=\"stylesheet\" href=\"./estilos/listado.css\" type=\"text/css\"/>  
    </head> 
    <body>  
            <div id =\"cabecera\">
\t\t\t\t<img src=\"./img/logo.jpg\" alt=\"logo de la fundacion\" />
            </div>  
            <div id =\"izquierda\">
\t\t\t\t<a href=\"./index.html\">Log Out</a>
            </div>  
            <div id =\"derecha\">

<table class=\"reference\" style=\"width:100%\">
\t\t<tbody>
\t\t\t<tr>
\t\t\t\t<th>Descripción</th>
\t\t\t\t<th>Fec. de Venc.</th>
\t\t\t\t<th>Contenido</th>
\t\t\t\t<th>Peso</th>
\t\t\t\t<th>Stock</th>
\t\t\t\t<th>Reservado</th>
\t\t\t</tr>

\t\t";
        // line 28
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["alimentos"]) ? $context["alimentos"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["alimento"]) {
            // line 29
            echo "\t\t\t<tr>
\t\t\t       \t<td>";
            // line 30
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["alimento"]) ? $context["alimento"] : null), "codigo"), "html", null, true);
            echo "</td>
\t\t        \t<td>";
            // line 31
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["alimento"]) ? $context["alimento"] : null), "descripcion"), "html", null, true);
            echo "</td>
\t\t\t</tr>
\t\t\t
\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['alimento'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 35
        echo "
\t\t</tbody>
</table>

</body>
</html>
";
    }

    public function getTemplateName()
    {
        return "listadoAlimentos.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  69 => 35,  59 => 31,  55 => 30,  52 => 29,  48 => 28,  19 => 1,);
    }
}
