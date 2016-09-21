<?php
/*
 *	This software is MIT Licensed (see LICENSE)
 *	Copyright (c) 2014-2016 Cristian O. Giambruni, Ezequiel F. Gómez
 */

 require('./lib/fpdf/fpdf.php');
 require_once './Config.php';
 require_once './models/Model.php';
 require_once './models/ModelEntidad.php';
 require_once './models/ModelAlimento.php';
 
class PDF extends FPDF
{
// Cargar los datos
function LoadData($file)
{
    // Leer las líneas del fichero
    $lines = file($file);
    $data = array();
    foreach($lines as $line)
        $data[] = explode(';',trim($line));
    return $data;
}

// Cabecera de página
function Header()
{
	global $title;
	// Logo
    $this->Image('../web/img/logo.jpg',10,8,33);
    // Lucida bold 15
    $this->SetFont('arial','B',15);
    // Calculamos ancho y posición del título.
    $w = $this->GetStringWidth($title)+6;
    $this->SetX((210-$w)/2);
    // Colores de los bordes, fondo y texto
    $this->SetDrawColor(40,40,40);
    $this->SetFillColor(230,230,0);
    $this->SetTextColor(255,255,255);
    // Ancho del borde (1 mm)
    $this->SetLineWidth(1);
    // Título
    $this->Cell($w,9,$title,1,1,'C',true);
    // Salto de línea
    $this->Ln(10);
}

// Pie de página
function Footer()
{
    // Posición a 1,5 cm del final
    $this->SetY(-15);
    // Arial itálica 8
    $this->SetFont('Arial','I',8);
    // Color del texto en gris
    $this->SetTextColor(128);
    // Número de página
    $this->Cell(0,10,'Página '.$this->PageNo(),0,0,'C');
}

// Tabla coloreada
function Tablita($header, $params)
{
    // Colores, ancho de línea y fuente en negrita
    $this->SetFillColor(0,160,230);
    $this->SetTextColor(255);
    $this->SetDrawColor(0,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    // Cabecera
    $w = array(60, 60);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $this->Ln();
    // Restauración de colores y fuentes
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Datos
    $fill = false;
    foreach($params as $row)
    {
        $this->Cell($w[0],6,$row[$header['0']],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row[$header['1']],'LR',0,'R',$fill);
        $this->Ln();
        $fill = !$fill;
    }
    // Línea de cierre
    $this->Cell(array_sum($w),0,'','T');
}
}
$mE = new ModelEntidad(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
							 Config::$mvc_bd_clave, Config::$mvc_bd_hostname);	
$mA = new ModelAlimento(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario,
							 Config::$mvc_bd_clave, Config::$mvc_bd_hostname);	

							 $print = $_GET['print'];

$f1 = $_GET['f1'];
$f2 = $_GET['f2'];

if	($print	== 'informePorER'){
	$params = $mE->informePesoPorEntidad($f1, $f2, "1");
	$title = "Informe Kilos entregados por Entidad";
}
if ($print == 'entreFechas'){
	$params = $mE->informePesoPorDia($f1, $f2, "1");
	$title = "Informe de peso por día";
}
if ($print == 'alimentosPorVencer'){
	$params = $mA->alimentosVencidosSinEntregar();
	$title = "Alimentos a punto de vencer sin entregar";
}

/*Array ( [0] => Array ( [fecha] => 2014-11-06 [Kilos] => 6.00 ) ) */
$id_values = array_keys($params['0']); // los indices son los detalle_alimento_id
$pdf = new PDF();
// Títulos de las columnas
$header = array($id_values['0'], $id_values['1']);
// Carga de datos
$pdf->SetFont('Arial','',14);
$pdf->AddPage();
$pdf->Tablita($header,$params);
$pdf->Output('informe.pdf', 'I');


?>
