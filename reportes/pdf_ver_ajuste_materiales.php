<?php

session_start();
ob_start();
require('../includes/rotations.php');
require('../class/cl_varios.php');
define('FPDF_FONTPATH', '../includes/font/');

require '../class/cl_almacen.php';
require '../class/cl_ajuste.php';
require '../class/cl_ajuste_materiales.php';

class PDF extends PDF_Rotate {

//Cabecera de página
    function Header() {
        $imagen = "logo_segebuco.png";
        $this->Image('../upload/' . $imagen, 15, 10, 20, 20);
        $this->SetFont('Arial', 'B', 11);
        $this->SetY(15);
        $this->SetX(65);
        $this->MultiCell(125, 5, utf8_decode("RUC: 20532059250"), 0, 'R');
    }

}

$cl_varios = new cl_varios;

$cl_ajuste = new cl_ajuste();
$cl_detalle = new cl_ajuste_materiales();
$cl_almacen = new cl_almacen();

$cl_ajuste->setIdAjuste(filter_input(INPUT_GET, 'id'));
$cl_ajuste->setAnio(filter_input(INPUT_GET, 'anio'));
$cl_ajuste->obtener_datos();

$cl_almacen->setCodigo($cl_ajuste->getIdAlmacen());
$cl_almacen->datos_almacen();

$cl_detalle->setIdAjuste($cl_ajuste->getIdAjuste());
$cl_detalle->setAnio($cl_ajuste->getAnio());

$pdf = new PDF('P', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->SetMargins(15, 35, 15);
$pdf->SetAutoPageBreak(true, 30);
$pdf->AddPage();

$pdf->SetTextColor(0, 0, 0);

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetY(35);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(174, 5, "REPORTE DE AJUSTE DE MATERIALES", 0, 1, 'C');
$pdf->Ln(5);

$pdf->Cell(35, 5, "ALMACEN", 0, 0, 'L');
$pdf->Cell(135, 5, ":   " . $cl_almacen->getNombre(), 0, 1, 'L');
$pdf->Cell(35, 5, "USUARIO", 0, 0, 'L');
$pdf->Cell(135, 5, ":   CAL.03 NRO. 264 (SECC. GRAN TRAPECIO) ANCASH - SANTA - SANTA", 0, 1, 'L');

$pdf->Ln(5);
$pdf->Cell(35, 5, "FECHA", 0, 0, 'L');
$pdf->Cell(135, 5, ":   ", 0, 1, 'L');



$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(35, 5, "DETALLE DEL INVENTARIO", 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(12, 5, "ID.", 1, 0, 'C');
$pdf->Cell(12, 5, "UM.", 1, 0, 'C');
$pdf->Cell(96, 5, "DESCRIPCION", 1, 0, 'C');
$pdf->Cell(16, 5, "COSTO", 1, 0, 'C');
$pdf->Cell(16, 5, "Sist.", 1, 0, 'C');
$pdf->Cell(16, 5, "Fisico", 1, 0, 'C');
$pdf->Cell(16, 5, "Diferencia", 1, 1, 'C');

$pdf->SetFont('Arial', '', 9);

$total_diferencia = 0 ;
$a_materiales = $cl_detalle->ver_materiales();
foreach ($a_materiales as $value) {
    $monto_diferencia = ($value['cencontrado'] - $value['csistema']) * $value['costo'];
    $total_diferencia = $total_diferencia + $monto_diferencia;
    //inicio de fila
    $cy = $pdf->GetY();
    $pdf->Cell(12, 5, $value['id_material'], 1, 0, 'C');
    $pdf->Cell(12, 5, "UND", 1, 0, 'C');
    $pdf->SetY($cy);
    $pdf->SetX(106);

    $cy = $pdf->GetY();
    $pdf->SetY($cy);
    $pdf->SetX(39);
    $pdf->MultiCell(96, 5, utf8_decode($value['descripcion']), 1);

    $pdf->SetY($cy);
    $pdf->SetX(135);
    $pdf->Cell(16, 5, $value['costo'], 1, 0, 'C');
    $pdf->Cell(16, 5, $value['csistema'], 1, 0, 'C');
    $pdf->Cell(16, 5, $value['cencontrado'], 1, 0, 'C');
    $pdf->Cell(16, 5, number_format($monto_diferencia, 2) , 1, 1, 'C');
}

$pdf->Cell(12, 5, "", 1, 0, 'C');
$pdf->Cell(12, 5, "", 1, 0, 'C');
$pdf->Cell(96, 5, "", 1, 0, 'C');
$pdf->Cell(16, 5, "", 1, 0, 'C');
$pdf->Cell(32, 5, "Total Diferencia (S/)", 1, 0, 'C');
$pdf->Cell(16, 5, number_format($total_diferencia, 2), 1, 1, 'C');




$pdf->Ln(5);

// fin de fila

$pdf->Output();
ob_end_flush();
?>
