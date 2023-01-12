<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();
//ob_start();
include('../class/cl_conectar.php');
//require('../includes/fpdf.php');
require('../class/cl_varios.php');
require('../class/cl_almacen.php');
require('../includes/rotations.php');
define('FPDF_FONTPATH', '../includes/font/');

class PDF extends PDF_Rotate {

    function RotatedText($x, $y, $txt, $angle) {
        //Text rotated around its origin
        $this->Rotate($angle, $x, $y);
        $this->Text($x, $y, $txt);
        $this->Rotate(0);
    }

}

$cl_varios = new cl_varios();
$cl_almacen = new cl_almacen();
$material = filter_input(INPUT_GET, 'codigo');
$almacen = filter_input(INPUT_GET, 'almacen');
$cl_almacen->setCodigo($almacen);
$cl_almacen->datos_almacen();

$q_general = "select m.descripcion "
	. "from material as m "
	. "where m.idmaterial = '".$material."'";
$r_general = $conn->query($q_general);
if ($r_general->num_rows > 0) {
    while ($fila = $r_general->fetch_assoc()) {
        $descripcion = $fila['descripcion'];
    }
}

$pdf = new PDF('L', 'mm', 'A4');
$pdf->SetAutoPageBreak(true, 10);
$pdf->AddPage();

$imagen = "logo_segebuco.png";
$pdf->Image('../upload/' . $imagen, 10, 10, 70, 20);
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 11);
$pdf->SetTextColor(00, 00, 0);
$pdf->Cell(80, 5, "", 0, 0, 'R');
$pdf->MultiCell(198, 5, utf8_decode('FORMATO 13.1: "REGISTRO DE INVENTARIO PERMANENTE VALORIZADO - DETALLE DEL INVENTARIO VALORIZADO'), 0);
$pdf->Cell(278, 5, "Pagina 1 de 1", 0, 1, 'R');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 9);

$pdf->Cell(35, 5, "PERIODO:", 0, 0, 'L');
$pdf->Cell(80, 5, '2019', 0, 1, 'L');
$pdf->Cell(35, 5, "RUC:", 0, 0, 'L');
$pdf->Cell(20, 5, '20532059250', 0, 1, 'L');
$pdf->Cell(35, 5, "RAZON SOCIAL:", 0, 0, 'L');
$pdf->Cell(20, 5, 'SERVICIOS GENERALES BUSINESS CONSULTING SAC', 0, 1, 'L');
$pdf->Cell(35, 5, "SUCURSAL:", 0, 0, 'L');
$pdf->Cell(20, 5, $cl_almacen->getNombre(), 0, 1, 'L');
$pdf->Cell(35, 5, "DESCRIPCION:", 0, 0, 'L');
$pdf->Cell(20, 5, $material . ' | ' . $descripcion . ' | UND', 0, 1, 'L');
$pdf->Cell(45, 5, "METODO DE VALUACION:", 0, 0, 'L');
$pdf->Cell(20, 5, 'COSTO PROMEDIO', 0, 1, 'L');

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(10, 5, "", 1, 0, 'C');
$pdf->Cell(57, 5, "DOCUMENTO", 1, 0, 'C');
$pdf->Cell(45, 5, "", 1, 0, 'C');
$pdf->Cell(55, 5, "ENTRADAS", 1, 0, 'C');
$pdf->Cell(55, 5, "SALIDAS", 1, 0, 'C');
$pdf->Cell(55, 5, "SALDO FINAL", 1, 1, 'C');

$pdf->Cell(10, 5, "Item", 1, 0, 'C');
$pdf->Cell(20, 5, "Fecha", 1, 0, 'C');
$pdf->Cell(15, 5, "Tipo", 1, 0, 'C');
$pdf->Cell(10, 5, "Ser.", 1, 0, 'C');
$pdf->Cell(12, 5, "Nro", 1, 0, 'C');
$pdf->Cell(45, 5, "T. Operacion", 1, 0, 'C');
$pdf->Cell(15, 5, "Cant", 1, 0, 'C');
$pdf->Cell(20, 5, "Cost. Unit.", 1, 0, 'C');
$pdf->Cell(20, 5, "Cost. Tot.", 1, 0, 'C');
$pdf->Cell(15, 5, "Cant.", 1, 0, 'C');
$pdf->Cell(20, 5, "Cost. Unit.", 1, 0, 'C');
$pdf->Cell(20, 5, "Cost. Tot.", 1, 0, 'C');
$pdf->Cell(15, 5, "Cant", 1, 0, 'C');
$pdf->Cell(20, 5, "Cost. Unit.", 1, 0, 'C');
$pdf->Cell(20, 5, "Cost. Tot.", 1, 1, 'C');

$pdf->SetFont('Arial', '', 9);

$pdf->Cell(10, 5, 1, 0, 0, 'C');
$pdf->Cell(20, 5, '', 0, 0, 'C');
$pdf->Cell(15, 5, '', 0, 0, 'C');        
$pdf->Cell(10, 5, '', 0, 0, 'C');  
$pdf->Cell(12, 5, '', 0, 0, 'C');   
$pdf->Cell(45, 5, '0 | SALDO ANTERIOR', 0, 0, 'C'); 
$pdf->Cell(15, 5, '0', 0, 0, 'R');
$pdf->Cell(20, 5, '0.0000', 0, 0, 'R');                
$pdf->Cell(20, 5, '0.00', 0, 0, 'R');
$pdf->Cell(15, 5, '0', 0, 0, 'R');
$pdf->Cell(20, 5, '0.0000', 0, 0, 'R');                
$pdf->Cell(20, 5, '0.00', 0, 0, 'R');
$pdf->Cell(15, 5, '0', 0, 0, 'R');
$pdf->Cell(20, 5, '0.0000', 0, 0, 'R');                
$pdf->Cell(20, 5, '0.00', 0, 1, 'R'); 
$pdf->Line(10,$pdf->getY(),287,$pdf->getY());  

$item = 2;
$q_detalle = "select k.kardex, k.fecha, k.ruc, k.datos, td.abreviado as tido, td.sunat, k.serie, k.numero, k.ingresa, k.sale, k.c_ingreso, k.c_egreso, k.registro, k.tipo_movimiento, dtg.descripcion as movimiento "
                . "from kardex_material as k "
                . "inner join tipo_documento as td on td.id = k.tipo_documento "
                . "inner join detalle_tabla_general as dtg on dtg.general = 8 and dtg.id = k.tipo_movimiento "
                . "where k.material = '" . $material. "' and k.almacen = '" . $almacen . "' "
                . "ORDER BY k.fecha ASC , k.kardex ASC";
$r_detalle = $conn->query($q_detalle);

$saldo = 0;
$stotal = 0;
                                        
if ($r_detalle->num_rows > 0) {
    while ($fila = $r_detalle->fetch_assoc()) {
	$nsaldo=0;
    	$ingreso = $fila['ingresa'];
	$cingreso = $fila['c_ingreso'];
	$egreso = $fila['sale'];
	$cegreso = $fila['c_egreso'];
	$saldo = $saldo + $ingreso - $egreso;
	$stotal = $stotal + ($cingreso * $ingreso) - ($cegreso * $egreso);
        $pdf->Cell(10, 5, $item, 0, 0, 'C');
        $pdf->Cell(20, 5, $fila['fecha'], 0, 0, 'C');
        $pdf->Cell(15, 5, $fila['sunat'] . ' | ' . $fila['tido'], 0, 0, 'C');        
        $pdf->Cell(10, 5, $fila['serie'], 0, 0, 'C');  
        $pdf->Cell(12, 5, $fila['numero'], 0, 0, 'C');    
        $pdf->Cell(45, 5, $fila['tipo_movimiento'] . ' | ' . $fila['movimiento'], 0, 0, 'C');
        $pdf->Cell(15, 5, $fila['ingresa'], 0, 0, 'R');
        $pdf->Cell(20, 5, number_format($fila['c_ingreso'], 4), 0, 0, 'R');                
        $pdf->Cell(20, 5, number_format($fila['c_ingreso'] * $fila['ingresa'], 2), 0, 0, 'R');
        $pdf->Cell(15, 5, $fila['sale'], 0, 0, 'R');
        $pdf->Cell(20, 5, number_format($fila['c_egreso'], 4), 0, 0, 'R');                
        $pdf->Cell(20, 5, number_format($fila['c_egreso'] * $fila['sale'], 2), 0, 0, 'R');
        $pdf->Cell(15, 5, $saldo, 0, 0, 'R');
        if ($saldo < 1) {
		$nsaldo = $stotal ;
        } else {
        	$nsaldo = $stotal / $saldo;
        }
        $pdf->Cell(20, 5, number_format($nsaldo, 4), 0, 0, 'R');                
        $pdf->Cell(20, 5, number_format($nsaldo * $saldo, 2), 0, 1, 'R');   
        $pdf->Line(10,$pdf->getY(),287,$pdf->getY());     
        $item++;
    }
}


$pdf->Output();
//ob_end_flush();
?>
