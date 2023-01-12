<?php

session_start();
ob_start();
include('../class/cl_conectar.php');
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
        $this->MultiCell(135, 5, utf8_decode("DOCUMENTO DE TRASLADO DE MERCADERIA"), 0, 'R');
//        $this->Cell(180, 5, "Fecha:   27/10/2017", 0, 1, 'R');    
    }

}

$cl_varios = new cl_varios;

$q_general = "select t.periodo, t.codigo, t.fecha, td.nombre, td.abreviado, t.serie, t.numero, t.usuario, ao.nombre as origen, ad.nombre as destino "
                . "from traslado as t "
                . "inner join tipo_documento as td on td.id = t.documento "
                . "inner join almacen as ao on ao.codigo = t.origen "
                . "inner join almacen as ad on ad.codigo = t.destino "                
                . "where concat (t.periodo, t.codigo) = '" . $_GET['codigo'] . "' ";
$r_general = $conn->query($q_general);
while ($fila = $r_general->fetch_assoc()) {
    $documento = $fila['nombre'] . ' | ' . $cl_varios->zerofill($fila['serie'], 3) . ' - ' . $cl_varios->zerofill($fila['numero'], 7);
    $fecha = $cl_varios->fecha_mysql_web($fila['fecha']);
    $aorigen = $fila['origen'];
    $adestino = $fila['destino'];
}

$pdf = new PDF('P', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->SetMargins(20, 35, 20);
$pdf->SetAutoPageBreak(true, 30);
$pdf->AddPage();

$pdf->SetTextColor(0, 0, 0);

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetY(35);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(174, 5, "NOTA DE TRASLADO ENTRE ALMACENES", 0, 1, 'C');
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(35, 5, "DOCUMENTO", 0, 0, 'L');
$pdf->Cell(135, 5, ":   " . $documento, 0, 1, 'L');
$pdf->Cell(35, 5, "ALMACEN ORIGEN", 0, 0, 'L');
$pdf->Cell(135, 5, ":   " . $aorigen, 0, 1, 'L');
$pdf->Ln(2);
$pdf->Cell(35, 5, "ALMACEN DESTINO", 0, 0, 'L');
$pdf->Cell(135, 5, ":   " . $adestino, 0, 1, 'L');
$pdf->Cell(35, 5, "FECHA", 0, 0, 'L');
$pdf->Cell(135, 5, ":   " . $fecha, 0, 1, 'L');

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(35, 5, "DETALLE DEL TRASLADO", 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(12, 5, "CANT.", 1, 0, 'C');
$pdf->Cell(12, 5, "UM.", 1, 0, 'C');
$pdf->Cell(146, 5, "DESCRIPCION", 1, 1, 'C');
//$pdf->Cell(26, 5, "TIPO", 1, 1, 'C');

$pdf->SetFont('Arial', '', 9);

$q_detalle_materiales = "select dtm.cantidad, dtm.costo, m.descripcion "
        . "from detalle_traslado_material as dtm "
        . "inner join material as m on m.idmaterial = dtm.id_material "
        . "where concat(dtm.periodo, dtm.id_traslado) = '" . $_GET['codigo'] . "' "
        . "order by descripcion asc";

$r_detalle_materiales = $conn->query($q_detalle_materiales);
if ($r_detalle_materiales->num_rows > 0) {
    while ($fila = $r_detalle_materiales->fetch_assoc()) {
//inicio de fila 
        $cy = $pdf->GetY();
        $pdf->Cell(12, 5, $fila['cantidad'], 1, 0, 'C');
        $pdf->Cell(12, 5, "UND", 1, 0, 'C');
        $pdf->SetY($cy);
        $pdf->SetX(170);
//        $pdf->Cell(26, 5, $nombre_tipo, 1, 0, 'C');

        $cy = $pdf->GetY();
        $pdf->SetY($cy);
        $pdf->SetX(44);
        $pdf->MultiCell(146, 5, utf8_decode($fila['descripcion']), 1);
        
        
    }
}

$q_detalle_herramientas = "select dth.cantidad, concat (h.descripcion, ' | ', h.marca, ' | ', h.modelo, ' | ', h.serie) as descripcion, dth.tipo "
        . "from detalle_traslado_herramienta as dth "
        . "inner join herramientas as h on h.idherramientas = dth.herramienta "
        . "where concat(dth.periodo, dth.traslado) = '" . $_GET['codigo'] . "' "
        . "order by descripcion asc";
$r_detalle_herramienta = $conn->query($q_detalle_herramientas);
if ($r_detalle_herramienta->num_rows > 0) {
    while ($fila = $r_detalle_herramienta->fetch_assoc()) {
        $tipo = $fila['tipo'];
        if ($tipo == 0) {
            $nombre_tipo = "ELECTRICA";
        }
        if ($tipo == 1) {
            $nombre_tipo = "MANUAL";
        }
//inicio de fila 
        $cy = $pdf->GetY();
        $pdf->Cell(12, 5, $fila['cantidad'], 1, 0, 'C');
        $pdf->Cell(12, 5, "UND", 1, 0, 'C');
        $pdf->SetY($cy);
        $pdf->SetX(170);
//        $pdf->Cell(26, 5, $nombre_tipo, 1, 0, 'C');

        $cy = $pdf->GetY();
        $pdf->SetY($cy);
        $pdf->SetX(44);
        $pdf->MultiCell(146, 5, utf8_decode($fila['descripcion']), 1);
        
        
    }
}

$q_detalle_botellas = "select dtc.cilindro, c.gas, c.capacidad "
        . "from detalle_traslado_cilindro as dtc "
        . "inner join cilindros as c on c.codigo = dtc.cilindro "
        . "where concat(dtc.periodo, dtc.traslado) = '" . $_GET['codigo'] . "' "
        . "order by cilindro asc";
$r_detalle_cilindro = $conn->query($q_detalle_botellas);
if ($r_detalle_cilindro->num_rows > 0) {
    while ($fila = $r_detalle_cilindro->fetch_assoc()) {
//inicio de fila 
        $cy = $pdf->GetY();
        $pdf->Cell(12, 5,"01", 1, 0, 'C');
        $pdf->Cell(12, 5, "BOT", 1, 0, 'C');


        $cy = $pdf->GetY();
        $pdf->SetY($cy);
        $pdf->SetX(44);
        $pdf->MultiCell(146, 5, utf8_decode($fila['cilindro'] . ' | ' . $fila['gas'] . ' | ' . $fila['capacidad'] . ' M3'), 1);
        
        
    }
}

$cy = $pdf->GetY();
$pdf->SetY($cy);

$pdf->Ln(5);

// fin de fila

$pdf->Output();
ob_end_flush();
?>
