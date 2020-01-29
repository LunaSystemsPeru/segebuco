<?php

require '../class/cl_conectar.php';
require '../class/cl_varios.php';

require '../class/cl_planilla.php';

$cl_varios = new cl_varios();
$cl_planilla = new cl_planilla();

mysqli_set_charset($conn, "utf8");
$codigop = filter_input(INPUT_GET, 'semana');
$cl_planilla->setCliente(filter_input(INPUT_GET, 'cliente'));

$a_clientes = $cl_planilla->ver_sucursal_semana($codigop);
$a_json = array();
$a_json_row = array();

foreach ($a_clientes as $row) {
    $estado = $row['estado'];
    if ($estado == 1) {
        $a_json_row['value'] = $row['nsucursal'] . ' | PLANILLA PAGADA';
    }
    if ($estado == 0) {
        $a_json_row['value'] = $row['nsucursal'];
    }
    $a_json_row['codigo'] = $row['codigo'];
    array_push($a_json, $a_json_row);
}
echo json_encode($a_json);
flush();
$conn->close();
?>