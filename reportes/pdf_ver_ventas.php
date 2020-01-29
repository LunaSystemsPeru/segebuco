<?php

ob_start();

include('../class/cl_conectar.php');
require('../includes/rotations.php');
require('../class/cl_varios.php');
$c_varios = new cl_varios();

define('FPDF_FONTPATH', '../includes/font/');
$codigo = filter_input(INPUT_GET, 'planilla');

global $conn;
//mysqli_set_charset($conn, "utf8");
$query = "select v.codigo, v.periodo, v.fecha_factura,  v.serie, v.numero, v.total, v.pagado, v.estado, td.abreviado as tido, dtgm.atributo as moneda, v.tipo_cambio, e.razon_social as cliente, v.orden_cliente "
        . "from ventas as v "
        . "inner join tipo_documento as td on td.id = v.tipo_documento "
        . "inner join detalle_tabla_general as dtgm on dtgm.general = 5 and dtgm.id = v.moneda "
        . "inner join clientes as c on c.id = v.cliente "
        . "inner join entidad as e on e.ruc = c.ruc "
        . "where year(v.fecha_factura) = '2017' "
        . "order by v.numero desc";
//echo $query;
$resultado = $conn->query($query);

function acentos($cadena) {
    $search = explode(",", "á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,Ã¡,Ã©,Ã­,Ã³,Ãº,Ã±,ÃÃ¡,ÃÃ©,ÃÃ­,ÃÃ³,ÃÃº,ÃÃ±,Ã“,Ã ,Ã‰,Ã ,Ãš,â€œ,â€ ,Â¿,ü");
    $replace = explode(",", "á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,Ó,Á,É,Í,Ú,\",\",¿,&uuml;");
    $resultado = str_replace($search, $replace, $cadena);

    return $resultado;
}

$pdf = new fPDF('L', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 10);
$pdf->AddPage();


$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(50, 5, "REPORTE DE VENTAS ANUAL");

$pdf->Ln();
$pdf->SetFillColor(129, 129, 129); //Gris tenue de cada fila
$pdf->SetTextColor(255, 255, 255); //Color del texto: Negro

$pdf->Cell(8, 5, "Item.", 1, 0, 'C', 1);
$pdf->Cell(20, 5, "Codigo", 1, 0, 'C', 1);
$pdf->Cell(28, 5, "Documento", 1, 0, 'C', 1);
$pdf->Cell(20, 5, "Fecha", 1, 0, 'C', 1);
$pdf->Cell(23, 5, "Nro. Orden", 1, 0, 'C', 1);
$pdf->Cell(70, 5, "Cliente", 1, 0, 'C', 1);
$pdf->Cell(25, 5, "Total M.F.", 1, 0, 'C', 1);
$pdf->Cell(25, 5, "Total S/", 1, 0, 'C', 1);
$pdf->Cell(25, 5, "Pagado M.F.", 1, 0, 'C', 1);
$pdf->Cell(20, 5, "Estado", 1, 0, 'C', 1);
$pdf->Cell(8, 5, "Item.", 1, 1, 'C', 1);

$pdf->SetFont('Arial', '', 8);
$pdf->SetFillColor(229, 229, 229); //Gris tenue de cada fila
$pdf->SetTextColor(3, 3, 3); //Color del texto: Negro
$item = 1;
$suma_ventas = 0;
$suma_total = 0;
$suma_pagado = 0;
$bandera = false;
if ($resultado->num_rows > 0) {
    $zona = "";
    $zona_nueva = "";
    while ($value = $resultado->fetch_assoc()) {
        $vestado = $value['estado'];
        $codigo = $value['periodo'] . $c_varios->zerofill($value['codigo'], 3);
        $documento = $value['tido'] . '/ ' . $c_varios->zerofill($value['serie'], 3) . '-' . $c_varios->zerofill($value['numero'], 7);
        $totalme = $value['total'];
        $tc = $value['tipo_cambio'];
        $total_soles = $totalme * $tc;
        $suma_ventas = $suma_ventas + $totalme;
        $suma_total = $suma_total + $total_soles;
        $suma_pagado = $suma_pagado + $value['pagado'];
        if ($vestado == 0) {
            $activo = true;
            $cliente = $value['cliente'];
            $hestado = '- - -';
        }
        if ($vestado == 1) {
            $activo = true;
            $cliente = $value['cliente'];
            $hestado = 'Pagado';
        }
        if ($vestado == 2) {
            $activo = false;
            $cliente = '****  ANULADO  ****';
            $hestado = 'Anulado';
        }

        $pdf->Cell(8, 5, $item, 0, 0, 'C', $bandera);
        $pdf->Cell(20, 5, $codigo, 0, 0, 'C', $bandera);
        $pdf->Cell(28, 5, $documento, 0, 0, 'C', $bandera);
        $pdf->Cell(20, 5, $c_varios->fecha_mysql_web($value['fecha_factura']), 0, 0, 'C', $bandera);
        $pdf->Cell(23, 5, $value['orden_cliente'], 0, 0, 'C', $bandera);
        $pdf->Cell(70, 5, $cliente, 0, 0, 'L', $bandera);
        if ($value['estado'] == 2) {
            $pdf->Cell(25, 5, '-', 0, 0, 'R', $bandera);
            $pdf->Cell(25, 5, '-', 0, 0, 'R', $bandera);
        } else {
            $pdf->Cell(8, 5, $value['moneda'], 0, 0, 'R', $bandera);
            $pdf->Cell(17, 5, number_format($totalme, 2, '.', ','), 0, 0, 'R', $bandera);
            $pdf->Cell(8, 5, "S/", 0, 0, 'R', $bandera);
            $pdf->Cell(17, 5, number_format($total_soles, 2, '.', ','), 0, 0, 'R', $bandera);
        }
        if ($value['pagado'] == 0) {
            $pdf->Cell(25, 5, '-', 0, 0, 'R', $bandera);
        } else {
            $pdf->Cell(8, 5, $value['moneda'], 0, 0, 'R', $bandera);
            $pdf->Cell(17, 5, number_format($value['pagado'], 2, '.', ','), 0, 0, 'R', $bandera);
        }
        $pdf->Cell(20, 5, $hestado, 0, 0, 'C', $bandera);
        $pdf->Cell(8, 5, $item++, 0, 1, 'C', $bandera);
        $bandera = !$bandera;
    }
    //$pdf->Cell(276, 5, "", 0, 1, 'C', $bandera);
    //$bandera = !$bandera;
}

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(197, 5, '', 0, 0, 'R', $bandera);
$pdf->Cell(25, 5, 'SUMA BASE', 0, 0, 'R', $bandera);
$pdf->Cell(25, 5, 'IGV', 0, 0, 'R', $bandera);
$pdf->Cell(25, 5, 'TOTAL SOLES', 0, 1, 'R', $bandera);
$pdf->Cell(197, 5, '', 0, 0, 'R', $bandera);
$pdf->Cell(25, 5, number_format($suma_total/ 1.18, 2, '.', ','), 0, 0, 'R', $bandera);
$pdf->Cell(25, 5, number_format($suma_total/ 1.18 * 0.18, 2, '.', ','), 0, 0, 'R', $bandera);
$pdf->Cell(25, 5, number_format($suma_total , 2, '.', ','), 0, 1, 'R', $bandera);
$pdf->Output();

ob_end_flush();
