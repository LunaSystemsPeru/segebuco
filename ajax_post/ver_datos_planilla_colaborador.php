<?php
require '../class/cl_detalle_planilla.php';
global $conn;
mysqli_set_charset($conn,"utf8");

$cl_detalle = new cl_detalle_planilla();

$cl_detalle->setPlanilla(filter_input(INPUT_GET, 'idplanilla'));
$cl_detalle->setColaborador(filter_input(INPUT_GET, 'idempleado'));

$a_detalle = $cl_detalle->v_detalle_pago();
$json_pago = array();
$fila_pago = array();
foreach ($a_detalle as $value) {
    $fila_pago['idcolaborador'] = $cl_detalle->getColaborador();
    $fila_pago['idplanilla'] = $cl_detalle->getPlanilla();
    $fila_pago['jornal'] = $value['jornal_dia'];
    $fila_pago['empleado'] = $value['nombres'];
    $fila_pago['horas_normal'] = $value['horas_normal'];
    $fila_pago['ext25'] = $value['horas_25'];
    $fila_pago['ext100'] = $value['horas_100'];
    $fila_pago['categoria'] = $value['categoria'];
    $fila_pago['i_alimentacion'] = $value['i_alimentacion'];
    $fila_pago['i_gastos'] = $value['i_gastos'];
    $fila_pago['d_adelanto'] = $value['d_adelanto'];
    $fila_pago['d_otros'] = $value['d_otros'];
    $fila_pago['diast'] =  $value['horas_normal'] / 8;
    array_push($json_pago, $fila_pago);
}
echo json_encode($json_pago, JSON_UNESCAPED_UNICODE);


//2791.94
