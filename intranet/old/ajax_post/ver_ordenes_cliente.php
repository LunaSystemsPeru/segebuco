<?php

require '../class/cl_sucursal.php';
$cl_sucursal = new cl_sucursal();

$cl_sucursal->setCliente(filter_input(INPUT_GET, 'cliente'));
$cl_sucursal->setCodigo(filter_input(INPUT_GET, 'sucursal'));
$a_ordenes = $cl_sucursal->ver_ordenes_cliente();
$array_ordenes = array();
foreach ($a_ordenes as $value) {
    $fila_orden['id'] = $value['codigo'];
    $fila_orden['nombre'] = $value['codigo'] . ' | ' . $value['moneda'] . ' | ' . number_format($value['total'], 2, '.', ',') . ' | ' . $value['facturado'] . '% FACT.';
    array_push($array_ordenes, $fila_orden);
}
//cargar siempre
$fila_orden['id'] = '-';
$fila_orden['nombre'] = 'SIN ORDEN';
array_push($array_ordenes, $fila_orden);
echo json_encode($array_ordenes);
