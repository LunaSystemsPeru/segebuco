<?php

require '../class/cl_cliente.php';
$cl_cliente = new cl_cliente();

$cl_cliente->setCodigo(filter_input(INPUT_GET, 'id'));

$datos_cliente = $cl_cliente->datos_cliente();
$array_cliente = array();
foreach ($datos_cliente as $value) {
    $fila_cliente['id'] = $value['id'];
    $fila_cliente['ruc'] = $value['ruc'];
    $fila_cliente['razon_social'] = $value['razon_social'];
    $fila_cliente['direccion'] = $value['direccion'];
    $fila_cliente['nombre_comercial'] = $value['nombre_comercial'];
}

array_push($array_cliente, $fila_cliente);

echo json_encode($array_cliente);
