<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
//ob_start();
include('../class/cl_conectar.php');
//require('../includes/fpdf.php');
require('../class/cl_varios.php');
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
$codigo = filter_input(INPUT_GET, 'codigo');

$q_general = "select d.fecha, d.anio, d.id_despacho, ct.descripcion, d.id_orden_interna, cl.nombres, cl.dni, cl.ape_pat, cl.ape_mat, car.descripcion as cargo, e.nombre_comercial, e.razon_social, sc.nombre as sucursal "
                . "from despacho_material as d "
                . "inner join orden_interna as oi on oi.id_orden = d.id_orden_interna "
                . "inner join cotizaciones as ct on ct.codigo = oi.id_cotizacion "
                . "inner join clientes as c on c.id = ct.cliente "
                . "inner join entidad as e on e.ruc = c.ruc "
                . "inner join sucursal_cliente as sc on sc.cliente = ct.cliente and sc.id = ct.sucursal "
                . "inner join colaborador as cl on cl.id = d.id_colaborador "
                . "inner join detalle_tabla_general as car on car.general = '1' and car.id = cl.cargo "
                . "where concat(d.anio, d.id_despacho) = '".$codigo."' ";
$r_general = $conn->query($q_general);
if ($r_general->num_rows > 0) {
    while ($fila = $r_general->fetch_assoc()) {
        $id= $fila['id_despacho'];
        $anio = $fila['anio'];
        $fecha_entrega = $cl_varios->fecha_mysql_web($fila['fecha']);
        $dni = $fila['dni'];
        $trabajador = $fila['ape_pat'] . ' ' . $fila['ape_mat'] . ', ' . $fila['nombres'];
        $cargo = $fila['cargo'];
        $cliente = $fila['razon_social'];
        $sucursal = $fila['sucursal'];
        $servicio = $fila['descripcion'];
        $id_servicio = $fila['id_orden_interna'];
    }
}

$pdf = new PDF('P', 'mm', 'A4');
$pdf->SetAutoPageBreak(true, 10);
$pdf->AddPage();

$imagen = "logo_segebuco.png";
$pdf->Image('../upload/' . $imagen, 10, 10, 30, 20);
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 11);
$pdf->SetTextColor(00, 00, 0);
$pdf->Cell(195, 5, "NOTA DE DESPACHO - ENTREGA DE INSUMOS MATERIALES", 0, 1, 'R');
//$pdf->Cell(195, 5, "Pagina 1 de 1", 0, 1, 'R');

$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 9);

$pdf->Cell(40, 5, "NRO DNI:", 0, 0, 'L');
$pdf->Cell(80, 5, $dni, 0, 0, 'L');
$pdf->Cell(40, 5, "FECHA:", 0, 0, 'R');
$pdf->Cell(20, 5, $fecha_entrega, 0, 1, 'L');

$pdf->Cell(40, 5, "NOMBRES Y APELLIDOS:", 0, 0, 'L');
$pdf->Cell(80, 5, $trabajador, 0, 0, 'L');
$pdf->Cell(40, 5, "CODIGO ENTREGA:", 0, 0, 'R');
$pdf->Cell(20, 5, $anio . ' | ' . $id, 0, 1, 'L');

$pdf->Cell(40, 5, "CARGO:", 0, 0, 'L');
$pdf->Cell(80, 5, $cargo, 0, 1, 'L');

$pdf->Cell(20, 5, "CLIENTE:", 0, 0, 'L');
$pdf->Cell(90, 5, $cliente . ' | ' . $sucursal, 0, 1, 'L');
$pdf->Cell(20, 5, "SERVICIO:", 0, 0, 'L');
$pdf->MultiCell(170, 5, utf8_decode($servicio . ' | Cod.: ' . $id_servicio), 0);

$pdf->Ln(5);
//$pdf->Cell(40, 5, "Detalle de Entrega:", 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(20, 5, "Item", 0, 0, 'C');
$pdf->Cell(135, 5, "Descripcion", 0, 0, 'C');
$pdf->Cell(15, 5, "Cant.", 0, 0, 'C');
$pdf->Cell(15, 5, "Parcial.", 0, 1, 'C');
$pdf->SetFont('Arial', '', 9);

$item = 1;
$q_detalle = "select ddi.cantidad, ddi.id_material, m.descripcion, m.precio_compra " 
	. "from detalle_despacho_material as ddi "
	. "inner join material as m on m.idmaterial = ddi.id_material "
	. "where concat(ddi.anio, ddi.id_despacho) = '".$codigo."' "
	. "order by m.descripcion asc";
$r_detalle = $conn->query($q_detalle);
if ($r_detalle->num_rows > 0) {
    while ($fila = $r_detalle->fetch_assoc()) {
        $id_insumo = $fila['id_material'];
        $n_material= $fila['descripcion'];
        $c_material= $fila['cantidad'];
        $parcial = $fila['cantidad'] * $fila['precio_compra'];
        $pdf->Cell(20, 5, $item, 0, 0, 'C');
        $pdf->Cell(135, 5, $id_insumo . ' | ' . utf8_decode($n_material), 0, 0, 'L');
        $pdf->Cell(15, 5, number_format($c_material, 2), 0, 0, 'R');
        $pdf->Cell(15, 5, number_format($parcial, 2), 0, 1, 'R');
        $item++;
    }
}

$pdf->SetFont('Arial', '', 8);
//$pdf->RotatedText(10, 140, "IPC-REG-OPE-004     Vr. 02      Fec. Aprob.: 06-01-2017", 90);
$pdf->SetFont('Arial', '', 9);
$pdf->SetY(-170);
$pdf->Cell(190, 5, "______________", 0, 1, 'C');
$pdf->Cell(190, 5, "Firma", 0, 1, 'C');
$pdf->Cell(190, 5, "DNI: " . $dni, 0, 1, 'C');
$pdf->Output();
//ob_end_flush();
?>
