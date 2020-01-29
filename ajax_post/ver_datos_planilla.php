<?php

require '../class/cl_conectar.php';
require '../class/cl_varios.php';

require '../class/cl_planilla.php';
require '../class/cl_planilla_gastos.php';

$cl_varios = new cl_varios();
$cl_planilla = new cl_planilla();
$cl_gastos = new cl_planilla_gastos();

mysqli_set_charset($conn, "utf8");
$cl_planilla->setCodigo(filter_input(INPUT_GET, 'codigo'));

$a_planillas = $cl_planilla->ver_datos_planilla();
$suma_total = 0;

$a_json = array();
$a_json_row = array();

foreach ($a_planillas as $value) {
    $cl_gastos->setPlanilla($value['codigo']);
    $a_gastos = $cl_gastos->ver_gastos_planilla();
    $suma_gastos = 0.0;
    foreach ($a_gastos as $valor) {
        $suma_gastos = $suma_gastos + $valor['monto'];
    }
    $suma_planilla = $value['planilla'] + $suma_gastos;
    $suma_total = $suma_total + $suma_planilla;
    $a_json_row['monto_total'] = $suma_total;
    $a_json_row['estado'] = $value['estado'];
    array_push($a_json, $a_json_row);
}
echo json_encode($a_json);
flush();
$conn->close();
