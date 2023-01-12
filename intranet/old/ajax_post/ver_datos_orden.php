<?php

require '../class/cl_orden_cliente.php';
$cl_orden = new cl_orden_cliente();

$cl_orden->setCodigo(filter_input(INPUT_GET, 'id'));

$datos_orden = $cl_orden->datos_orden();
$array_orden = array();
foreach ($datos_orden as $value) {
    $fila_orden['codigo'] = $value['codigo'];
    $fila_orden['monto'] = $value['total'];
    $fila_orden['moneda'] = $value['id_moneda'];
    $fila_orden['facturado'] = $value['facturado'];
    $fila_orden['glosa'] = strtoupper($value['glosa']);
    array_push($array_orden, $fila_orden);
}
echo json_encode($array_orden);
