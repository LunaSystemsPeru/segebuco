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
        $this->MultiCell(135, 5, utf8_decode("DOCUMENTO DE INGRESO MERCADERIA ALMACEN"), 0, 'R');
//        $this->Cell(180, 5, "Fecha:   27/10/2017", 0, 1, 'R');    
    }

}

$cl_varios = new cl_varios;

$q_general = "select i.periodo, i.id, i.fecha, i.proveedor, e.razon_social, td.nombre, td.abreviado, i.serie, i.numero, i.total, i.tc, i.moneda, a.nombre as almacen "
        . "from ingresos as i "
        . "inner join entidad as e on e.ruc = i.proveedor "
        . "inner join tipo_documento as td on td.id = i.tipo_documento "
        . "inner join almacen as a on a.codigo = i.almacen "
        . "where concat (i.periodo, i.id) = '" . $_GET['codigo'] . "' ";
$r_general = $conn->query($q_general);
while ($fila = $r_general->fetch_assoc()) {
    $documento = $fila['nombre'] . ' | ' . $cl_varios->zerofill($fila['serie'], 3) . ' - ' . $cl_varios->zerofill($fila['numero'], 7);
    $fecha = $cl_varios->fecha_mysql_web($fila['fecha']);
    $ruc = $fila['proveedor'];
    $proveedor = $fila['razon_social'];
    $almacen = $fila['almacen'];
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
//$pdf->Cell(174, 5, $documento, 0, 1, 'C');
$pdf->MultiCell(174, 5, utf8_decode($documento), 0, 'L');
$pdf->Ln(5);

$pdf->Cell(35, 5, "PROVEEDOR", 0, 0, 'L');
$pdf->Cell(135, 5, ":   " . $ruc . ' | ' . $proveedor, 0, 1, 'L');
$pdf->Cell(35, 5, "FECHA", 0, 0, 'L');
$pdf->Cell(135, 5, ":   " . $fecha, 0, 1, 'L');

$pdf->Ln(5);
$pdf->Cell(35, 5, "ALMACEN DESTINO", 0, 0, 'L');
$pdf->Cell(135, 5, ":   " . $almacen, 0, 1, 'L');

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(35, 5, "DETALLE DEL INGRESO", 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(12, 5, "CANT.", 1, 0, 'C');
$pdf->Cell(12, 5, "UM.", 1, 0, 'C');
$pdf->Cell(116, 5, "DESCRIPCION", 1, 0, 'C');
$pdf->Cell(15, 5, "P. UNIT", 1, 0, 'C');
$pdf->Cell(18, 5, "PARCIAL", 1, 1, 'C');

$pdf->SetFont('Arial', '', 9);

$subtotal = 0;

$q_detalle_materiales = "select dim.cantidad, dim.costo, concat (m.descripcion, dim.marca) as descripcion "
        . "from detalle_ingreso_material as dim "
        . "inner join material as m on m.idmaterial = dim.material "
        . "where concat(dim.periodo, dim.ingreso) = '" . $_GET['codigo'] . "' "
        . "order by m.descripcion asc";
$r_detalle_material = $conn->query($q_detalle_materiales);
if ($r_detalle_material->num_rows > 0) {
    while ($fila = $r_detalle_material->fetch_assoc()) {
        $subtotal = $subtotal + ($fila['costo'] * $fila['cantidad']);
//inicio de fila 
        $cy = $pdf->GetY();
        $pdf->Cell(12, 5, number_format($fila['cantidad'],2), 1, 0, 'R');
        $pdf->Cell(12, 5, "UND", 1, 0, 'C');
        $pdf->SetY($cy);
        $pdf->SetX(160);
        $pdf->Cell(15, 5, number_format($fila['costo'], 3), 1, 0, 'R');
        $pdf->Cell(18, 5, number_format($fila['costo'] * $fila['cantidad'] * 1.18, 2), 1, 0, 'R');
//        $pdf->Cell(26, 5, $nombre_tipo, 1, 0, 'C');

        $cy = $pdf->GetY();
        $pdf->SetY($cy);
        $pdf->SetX(44);
        $pdf->MultiCell(116, 5, utf8_decode($fila['descripcion']), 1);
        
        
    }
}

$q_detalle_herramientas = "select dth.cantidad, dth.costo, concat (h.descripcion, ' | ', h.marca, ' | ', h.modelo, ' | ', h.serie) as descripcion, dth.tipo "
        . "from detalle_ingreso_herramienta as dth "
        . "inner join herramientas as h on h.idherramientas = dth.herramienta "
        . "where concat(dth.periodo, dth.ingreso) = '" . $_GET['codigo'] . "' "
        . "order by descripcion asc";
$r_detalle_herramienta = $conn->query($q_detalle_herramientas);
if ($r_detalle_herramienta->num_rows > 0) {
    while ($fila = $r_detalle_herramienta->fetch_assoc()) {
        $subtotal = $subtotal + ($fila['costo'] * $fila['cantidad']);        
        $tipo = $fila['tipo'];
        if ($tipo == 0) {
            $nombre_tipo = "ELECTRICA";
        }
        if ($tipo == 1) {
            $nombre_tipo = "MANUAL";
        }
//inicio de fila 
        $cy = $pdf->GetY();
        $pdf->Cell(12, 5, number_format($fila['cantidad'],2), 1, 0, 'R');
        $pdf->Cell(12, 5, "UND", 1, 0, 'C');
        $pdf->SetY($cy);
        $pdf->SetX(160);
        $pdf->Cell(15, 5, number_format($fila['costo'], 3), 1, 0, 'R');
        $pdf->Cell(18, 5, number_format($fila['costo'] * $fila['cantidad'] * 1.18, 2), 1, 0, 'R');
//        $pdf->Cell(26, 5, $nombre_tipo, 1, 0, 'C');

        $cy = $pdf->GetY();
        $pdf->SetY($cy);
        $pdf->SetX(44);
        $pdf->MultiCell(116, 5, utf8_decode($fila['descripcion']), 1);
        
        
    }
}

$q_detalle_botellas = "select dtc.cilindro, c.gas, c.capacidad "
        . "from detalle_ingreso_cilindro as dtc "
        . "inner join cilindros as c on c.codigo = dtc.cilindro "
        . "where concat(dtc.periodo, dtc.ingreso) = '" . $_GET['codigo'] . "' "
        . "order by cilindro asc";
$r_detalle_cilindro = $conn->query($q_detalle_botellas);
if ($r_detalle_cilindro->num_rows > 0) {
    while ($fila = $r_detalle_cilindro->fetch_assoc()) {
//inicio de fila 
        $cy = $pdf->GetY();
        $pdf->Cell(12, 5,"01", 1, 0, 'C');
        $pdf->Cell(12, 5, "BOT", 1, 0, 'C');
        $pdf->SetY($cy);
        $pdf->SetX(160);
        $pdf->Cell(15, 5, '0.000', 1, 0, 'R');
        $pdf->Cell(18, 5, '0.00', 1, 0, 'R');


        $cy = $pdf->GetY();
        $pdf->SetY($cy);
        $pdf->SetX(44);
        $pdf->MultiCell(116, 5, utf8_decode($fila['cilindro'] . ' | ' . $fila['gas'] . ' | ' . $fila['capacidad'] . ' M3'), 1);
        
        
    }
}

$cy = $pdf->GetY();
$pdf->SetY($cy);

$pdf->Ln(5);

$pdf->Cell(120, 5,"sub total " . number_format($subtotal, 2), 1, 1, 'R');
$pdf->Cell(120, 5,"igv " . number_format($subtotal * 0.18, 2), 1, 1, 'R');
$pdf->Cell(120, 5,"total " . number_format($subtotal * 1.18, 2), 1, 1, 'R');

// fin de fila

$pdf->Output();
ob_end_flush();
?>
