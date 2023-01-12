<?php

session_start();
ob_start();
require('../includes/rotations.php');
require('../class/cl_varios.php');
define('FPDF_FONTPATH', '../includes/font/');

class PDF extends PDF_Rotate {

//Cabecera de página
    function Header() {
        $imagen = "logo_segebuco.png";
        $this->Image('../upload/' . $imagen, 0, 0, 20, 20);
        $this->SetFont('Arial', 'B', 11);
        $this->SetY(15);
        $this->SetX(65);
        $this->MultiCell(135, 5, utf8_decode("RUC: 20532059250"), 0, 'R');
        $this->Cell(180, 5, "Fecha:   27/10/2017", 0, 1, 'R');    
    }

}

$cl_varios = new cl_varios;

$pdf = new PDF('P', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->SetMargins(20, 35, 20);
$pdf->SetAutoPageBreak(true, 30);
$pdf->AddPage();

$pdf->SetTextColor(0, 0, 0);

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetY(35);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(174, 5, "NOTA DE SALIDA #001 - 0000001", 0, 1, 'C');
$pdf->Ln(5);

$pdf->Cell(35, 5, "PUNTO PARTIDA", 0, 0, 'L');
$pdf->Cell(135, 5, ":   AAHH LOS CONQUISTADORES MZ F LT 31 - NUEVO CHIMBOTE", 0, 1, 'L');
$pdf->Cell(35, 5, "PUNTO LLEGADA", 0, 0, 'L');
$pdf->Cell(135, 5, ":   CAL.03 NRO. 264 (SECC. GRAN TRAPECIO) ANCASH - SANTA - SANTA", 0, 1, 'L');

$pdf->Ln(5);
$pdf->Cell(35, 5, "RAZON SOCIAL", 0, 0, 'L');
$pdf->Cell(135, 5, ":   PESQUERA CENTINELA S.A.C.", 0, 1, 'L');
$pdf->Cell(35, 5, "RUC", 0, 0, 'L');
$pdf->Cell(135, 5, ":   20278966004", 0, 1, 'L');

$pdf->Ln(2);
$pdf->Cell(35, 5, "MOTIVO", 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(110, 5, ":  TRABAJOS EN ZONA ROTADISK", 0, 1, 'L');

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(35, 5, "DETALLE DEL ENVIO", 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(12, 5, "CANT.", 1, 0, 'C');
$pdf->Cell(12, 5, "UM.", 1, 0, 'C');
$pdf->Cell(146, 5, "DESCRIPCION", 1, 1, 'C');

$pdf->SetFont('Arial', '', 9);

//inicio de fila 
$cy = $pdf->GetY();
$pdf->Cell(12, 5, "02", 1, 0, 'C');
$pdf->Cell(12, 5, "UND", 1, 0, 'C');
$pdf->SetY($cy);
$pdf->SetX(126);

$cy = $pdf->GetY();
$pdf->SetY($cy);
$pdf->SetX(44);
$pdf->MultiCell(146, 5, utf8_decode("DISCO DE CORTE Ø 7\" INOX"), 1);

$cy = $pdf->GetY();
$pdf->Cell(12, 5, "01", 1, 0, 'C');
$pdf->Cell(12, 5, "UND", 1, 0, 'C');
$pdf->SetY($cy);
$pdf->SetX(126);

$cy = $pdf->GetY();
$pdf->SetY($cy);
$pdf->SetX(44);
$pdf->MultiCell(146, 5, utf8_decode("DISCO PULIFAN Ø 4 1/2\""), 1);

$cy = $pdf->GetY();
$pdf->Cell(12, 5, "01", 1, 0, 'C');
$pdf->Cell(12, 5, "UND", 1, 0, 'C');
$pdf->SetY($cy);
$pdf->SetX(126);

$cy = $pdf->GetY();
$pdf->SetY($cy);
$pdf->SetX(44);
$pdf->MultiCell(146, 5, utf8_decode("DISCO DE DESBASTE Ø 7\""), 1);

$cy = $pdf->GetY();
$pdf->SetY($cy);

$pdf->Ln(5);

// fin de fila

$pdf->Output();
ob_end_flush();
?>
