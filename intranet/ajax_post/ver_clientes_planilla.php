<?php

require '../class/cl_conectar.php';
require '../class/cl_varios.php';

require '../class/cl_planilla.php';

$cl_varios = new cl_varios();
$cl_planilla = new cl_planilla();

mysqli_set_charset($conn, "utf8");
$codigop = filter_input(INPUT_GET, 'semana');

$a_clientes = $cl_planilla->ver_clientes_semana($codigop);
$a_json = array();
$a_json_row = array();

foreach ($a_clientes as $row) {
    $cliente = $row["cliente"];
    $razon_social = $row["razon_social"];
    $a_json_row['value'] = $razon_social;
    $a_json_row['codigo'] = $cliente;
    array_push($a_json, $a_json_row);
}
echo json_encode($a_json);
flush();
$conn->close();
?>