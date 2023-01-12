<?php

require '../class/cl_entidad.php';
$cl_entidad = new cl_entidad();

$cl_entidad->setRuc(filter_input(INPUT_GET, 'ruc'));

$datos_entidad = $cl_entidad->datos_ruc();
$array_entidad = array();
foreach ($datos_entidad as $value) {
    $fila_entidad['ruc'] = $value['ruc'];
    $fila_entidad['razon_social'] = $value['razon_social'];
    $fila_entidad['direccion'] = $value['direccion'];
    $fila_entidad['nombre_comercial'] = $value['nombre_comercial'];
    $fila_entidad['condicion'] = $value['condicion'];
    $fila_entidad['estado'] = $value['estado'];
}

array_push($array_entidad, $fila_entidad);

echo json_encode($array_entidad);
