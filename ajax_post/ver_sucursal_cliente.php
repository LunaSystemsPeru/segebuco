<?php

require '../class/cl_sucursal.php';
$cl_sucursal = new cl_sucursal();

$cl_sucursal->setCliente(filter_input(INPUT_POST, 'id'));
$a_sucursales = $cl_sucursal->ver_sucursales();
$array_sucursales = array();
foreach ($a_sucursales as $value) {
    $fila_sucursal['id'] = $value['id'];
    $fila_sucursal['nombre'] = $value['nombre'] . " | " . $value['direccion'];
    array_push($array_sucursales, $fila_sucursal);
}

echo json_encode($array_sucursales);