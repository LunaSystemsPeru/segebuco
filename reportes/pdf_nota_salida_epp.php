<?php

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
$entrega = $_GET['entrega'];
$empleado = $_GET['empleado'];

$q_general = "select e.codigo, dtg.descripcion as epp, c.dni, c.nombres, c.ape_pat, c.ape_mat, e.entrega, e.devolucion, e.estado, date_add(e.entrega, interval dtg.atributo day) as retorno, car.descripcion as cargo "
        . "from entrega_epp as e "
        . "inner join detalle_tabla_general as dtg on dtg.general = 7 and dtg.id = e.epp "
        . "inner join colaborador as c on c.id = e.colaborador "
        . "inner join detalle_tabla_general as car on car.general = '1' and car.id = c.cargo "
        . "where e.colaborador = '" . $empleado . "' and e.codigo = '".$entrega."'";
$r_general = $conn->query($q_general);
if ($r_general->num_rows > 0) {
    while ($fila = $r_general->fetch_assoc()) {
        $codigo = $fila['codigo'];
        $fecha_entrega = $cl_varios->fecha_mysql_web($fila['entrega']);
        $dni = $fila['dni'];
        $trabajador = $fila['ape_pat'] . ' ' . $fila['ape_mat'] . ', ' . $fila['nombres'];
        $cargo = $fila['cargo'];
    }
}

$pdf = new PDF('P', 'mm', 'A4');
$pdf->SetAutoPageBreak(true, 10);
$pdf->AddPage();

$imagen = "logo_segebuco.png";
$pdf->Image('../upload/' . $imagen, 10, 10, 70, 20);
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 11);
$pdf->SetTextColor(00, 00, 0);
$pdf->Cell(195, 5, "NOTA DE SALIDA - ENTREGA DE EPP", 0, 1, 'R');
$pdf->Cell(195, 5, "Pagina 1 de 1", 0, 1, 'R');

$pdf->Ln(13);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 9);

$pdf->Cell(40, 5, "NRO DNI:", 0, 0, 'L');
$pdf->Cell(80, 5, $dni, 0, 0, 'L');
$pdf->Cell(40, 5, "FECHA:", 0, 0, 'R');
$pdf->Cell(20, 5, $fecha_entrega, 0, 1, 'L');

$pdf->Cell(40, 5, "NOMBRES Y APELLIDOS:", 0, 0, 'L');
$pdf->Cell(80, 5, $trabajador, 0, 0, 'L');
$pdf->Cell(40, 5, "CODIGO ENTREGA:", 0, 0, 'R');
$pdf->Cell(20, 5, $codigo, 0, 1, 'L');

$pdf->Cell(40, 5, "CARGO:", 0, 0, 'L');
$pdf->Cell(80, 5, $cargo, 0, 1, 'L');

$pdf->Ln(5);
$pdf->Cell(40, 5, "Detalle de Entrega:", 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(30, 5, "Id EPP", 0, 0, 'C');
$pdf->Cell(100, 5, "Descripcion", 0, 0, 'C');
$pdf->Cell(30, 5, "F. Cambio", 0, 0, 'C');
$pdf->Cell(30, 5, "F. Devolucion", 0, 1, 'C');
$pdf->SetFont('Arial', '', 9);

$item = 1;
$q_detalle = "select e.codigo, e.epp, dtg.descripcion as depp, c.dni, c.nombres, c.ape_pat, c.ape_mat, e.entrega, e.devolucion, e.estado, date_add(e.entrega, interval dtg.atributo day) as retorno "
        . "from entrega_epp as e "
        . "inner join detalle_tabla_general as dtg on dtg.general = 7 and dtg.id = e.epp "
        . "inner join colaborador as c on c.id = e.colaborador "
        . "where e.colaborador = '" . $empleado . "' and e.codigo = '".$entrega."' "
        . "order by depp asc";
$r_detalle = $conn->query($q_detalle);
if ($r_detalle->num_rows > 0) {
    while ($fila = $r_detalle->fetch_assoc()) {
        $codigo_epp = $fila['epp'];
        $nombre_epp = $fila['depp'];
        $devolucion = $fila['retorno'];
        $pdf->Cell(30, 5, $item, 0, 0, 'C');
        $pdf->Cell(100, 5, $nombre_epp, 0, 0, 'L');
        $pdf->Cell(30, 5, $cl_varios->fecha_mysql_web($devolucion), 0, 0, 'C');
        $pdf->Cell(30, 5, "   /      /      ", 0, 1, 'C');
        $item++;
    }
}
$pdf->SetFont('Arial', '', 8);
$pdf->RotatedText(10, 140, "CYS-REG-OPE-004     Vr. 02      Fec. Aprob.: 06-01-2018", 90);
$pdf->SetFont('Arial', '', 9);
$pdf->SetY(-170);
$pdf->Cell(190, 5, "______________", 0, 1, 'C');
$pdf->Cell(190, 5, "Firma", 0, 1, 'C');
$pdf->Cell(190, 5, "DNI: " . $dni, 0, 1, 'C');
$pdf->Output();
//ob_end_flush();
?>
