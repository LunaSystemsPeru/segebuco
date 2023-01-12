<?php

ob_start();

include('../class/cl_conectar.php');
require('../includes/rotations.php');
require('../class/cl_varios.php');
require '../class/cl_planilla_gastos.php';
$varios = new cl_varios();

define('FPDF_FONTPATH', '../includes/font/');
$codigo = filter_input(INPUT_GET, 'planilla');
$cl_gastos = new cl_planilla_gastos();

global $conn;
//mysqli_set_charset($conn, "utf8");
$query = "select e.nombre_comercial, sc.nombre as sucursal, pl.cliente as id_cliente, pl.sucursal as id_sucursal, p.colaborador, c.dni, concat (c.ape_pat, ' ',c.ape_mat,' ', c.nombres) as nombres, c.categoria, p.jornal as jornal_dia, p.i_alimentacion, p.i_gastos, p.d_adelanto, p.d_otros, p.horas_normal, p.horas_25, p.horas_100, dtgc.descripcion as cargo "
        . "from detalle_planilla as p "
        . "inner join planilla as pl on pl.codigo = p.planilla "
        . "inner join clientes as cl on cl.id = pl.cliente "
        . "inner join entidad as e on e.ruc = cl.ruc "
        . "inner join sucursal_cliente as sc on sc.cliente = pl.cliente and sc.id = pl.sucursal "
        . "inner join colaborador as c on c.id = p.colaborador "
        . "inner join detalle_tabla_general as dtgc on dtgc.general = 1 and dtgc.id = c.cargo "
        . "where concat (pl.anio, lpad(pl.semana, 3, 0)) = '" . $codigo . "' "
        . "order by sc.nombre asc , e.nombre_comercial asc, sc.nombre asc, c.ape_pat asc, c.ape_mat asc";
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
$pdf->Cell(50, 5, "PLANILLA SEMANA: " . $codigo, 0, 1, 'C');

$pdf->SetFillColor(129, 129, 129); //Gris tenue de cada fila
$pdf->SetTextColor(255, 255, 255); //Color del texto: Negro

$pdf->Cell(8, 5, "Id.", 1, 0, 'C', 1);
$pdf->Cell(65, 5, "Apellidos y Nombres", 1, 0, 'C', 1);
$pdf->Cell(35, 5, "Zona", 1, 0, 'C', 1);
$pdf->Cell(45, 5, "Cargo.", 1, 0, 'C', 1);
$pdf->Cell(15, 5, "Jornal.", 1, 0, 'C', 1);
$pdf->Cell(10, 5, "D. T.", 1, 0, 'C', 1);
$pdf->Cell(15, 5, "HEx 25%", 1, 0, 'C', 1);
$pdf->Cell(15, 5, "HEx 100%", 1, 0, 'C', 1);
$pdf->Cell(20, 5, "Ingresos", 1, 0, 'C', 1);
$pdf->Cell(20, 5, "Descuentos", 1, 0, 'C', 1);
$pdf->Cell(20, 5, "Sueldo", 1, 0, 'C', 1);
$pdf->Cell(8, 5, "Id.", 1, 1, 'C', 1);

$pdf->SetFont('Arial', '', 8);
$pdf->SetFillColor(229, 229, 229); //Gris tenue de cada fila
$pdf->SetTextColor(3, 3, 3); //Color del texto: Negro
$item = 1;
$suma_sueldos = 0;
$bandera = false;
if ($resultado->num_rows > 0) {
    $zona = "";
    $zona_nueva = "";
    while ($value = $resultado->fetch_assoc()) {
        $categoria = $value['categoria'];
        $jornal = $value['jornal_dia'];
        $diast = $value['horas_normal'] / 8;
        $s_horas25 = $jornal / 8 * $value['horas_25'] * 1.25;
        $s_horas100 = $jornal / 8 * $value['horas_100'] * 2;
        $s_alimentacion = $value['i_alimentacion'];
        $s_gastos = $value['i_gastos'];
        $s_adelanto = $value['d_adelanto'];
        $s_otros = $value['d_otros'];
        $s_diast = $jornal * $diast;
        if ($diast == 6) {
            $dominical = $jornal;
        } else {
            $dominical = $jornal / 6 * $diast;
        }
        // $dominical = $jornal / 6 * $diast;
        $sueldo_semana = round($s_diast + $dominical + $s_horas25 + $s_horas100 + $s_alimentacion + $s_gastos - $s_adelanto - $s_otros);
        $suma_sueldos = $suma_sueldos + $sueldo_semana;
        $suma_ingresos = $s_alimentacion + $s_gastos;
        $suma_descuento = $s_adelanto + $s_otros;
        if ($suma_descuento == 0) {
            $suma_descuento = '-';
        } else {
            $suma_descuento = number_format($suma_descuento, 2);
        }
        if ($suma_ingresos == 0) {
            $suma_ingresos = '-';
        } else {
            $suma_ingresos = number_format($suma_ingresos, 2);
        }
        $zona = substr($value['nombre_comercial'], -2) . " | " . $value['sucursal'];
        if ($zona != $zona_nueva) {
            $zona_nueva = $zona;
            $pdf->Cell(276, 5, "", 0, 1, 'C', $bandera);
            $bandera = !$bandera;
        }

        if ($value['horas_25'] == 0) {
            $monto_ex25 = '-';
        } else {
            $monto_ex25 = number_format($value['horas_25'], 0);
        }
        
        if ($value['horas_100'] == 0) {
            $monto_ex100 = '-';
        } else {
            $monto_ex100 = number_format($value['horas_100'], 0);
        }

        $pdf->Cell(8, 5, $item, 0, 0, 'C', $bandera);
        $pdf->Cell(65, 5, utf8_decode($value['nombres']), 0, 0, 'L', $bandera);
        $pdf->Cell(35, 5, substr($value['nombre_comercial'], -2) . " | " . $value['sucursal'], 0, 0, 'C', $bandera);
        $pdf->Cell(45, 5, $value['cargo'], 0, 0, 'C', $bandera);
        $pdf->Cell(15, 5, number_format($value['jornal_dia'], 2, '.', ','), 0, 0, 'R', $bandera);
        $pdf->Cell(10, 5, $diast, 0, 0, 'C', $bandera);
        $pdf->Cell(15, 5, $monto_ex25, 0, 0, 'C', $bandera);
        $pdf->Cell(15, 5, $monto_ex100, 0, 0, 'C', $bandera);
        $pdf->Cell(20, 5, $suma_ingresos, 0, 0, 'R', $bandera);
        $pdf->Cell(20, 5, $suma_descuento, 0, 0, 'R', $bandera);
        $pdf->Cell(20, 5, number_format($sueldo_semana, 2, '.', ','), 0, 0, 'R', $bandera);
        $pdf->Cell(8, 5, $item++, 0, 1, 'C', $bandera);
        $bandera = !$bandera;
    }
    $pdf->Cell(276, 5, "", 0, 1, 'C', $bandera);
    $bandera = !$bandera;
}

//recorrer planillas 
$q_idplanilla = "select distinct codigo "
        . "from planilla "
        . "where concat (anio, lpad(semana, 3, 0)) = '" . $codigo . "' ";
$r_idplanilla = $conn->query($q_idplanilla);
if ($r_idplanilla->num_rows > 0) {
    while ($fila = $r_idplanilla->fetch_assoc()) {
        $cl_gastos->setPlanilla($fila['codigo']);
        $a_gastos_planilla = $cl_gastos->ver_gastos_planilla();
        foreach ($a_gastos_planilla as $row) {
            $suma_sueldos = $suma_sueldos + $row['monto'];
//            $pdf->Cell(248, 5, $cl_gastos->getPlanilla() . ' - ' . $row['glosa'], 0, 0, 'R', $bandera);
//            $pdf->Cell(20, 5, number_format($row['monto'], 2, '.', ','), 0, 0, 'R', $bandera);
//            $pdf->Cell(8, 5, $item++, 0, 1, 'C', $bandera);
            //  $bandera = !$bandera;

            $pdf->Cell(8, 5, $item, 0, 0, 'C', $bandera);
            $pdf->Cell(65, 5, $cl_gastos->getPlanilla() . ' - ' . $row['glosa'], 0, 0, 'L', $bandera);
            $pdf->Cell(35, 5, '-', 0, 0, 'C', $bandera);
            $pdf->Cell(45, 5, '-', 0, 0, 'C', $bandera);
            $pdf->Cell(15, 5, '-', 0, 0, 'C', $bandera);
            $pdf->Cell(15, 5, '-', 0, 0, 'C', $bandera);
            $pdf->Cell(10, 5, '-', 0, 0, 'C', $bandera);
            $pdf->Cell(15, 5, '-', 0, 0, 'C', $bandera);
            $pdf->Cell(20, 5, '-', 0, 0, 'C', $bandera);
            $pdf->Cell(20, 5, '-', 0, 0, 'C', $bandera);
            $pdf->Cell(20, 5, number_format(number_format($row['monto']), 2, '.', ','), 0, 0, 'R', $bandera);
            $pdf->Cell(8, 5, $item++, 0, 1, 'C', $bandera);
            $bandera = !$bandera;
        }
    }
}

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(248, 5, 'SUMA TOTAL', 0, 0, 'R');
$pdf->Cell(20, 5, number_format($suma_sueldos, 2, '.', ','), 0, 1, 'R');
$pdf->Output();

ob_end_flush();
