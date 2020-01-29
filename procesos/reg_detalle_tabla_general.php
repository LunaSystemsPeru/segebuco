<?php

require '../class/cl_detalle_tabla_general.php';
$cl_detalle = new cl_detalle_tabla_general();

$cl_detalle->setDescripcion(strtoupper(filter_input(INPUT_POST, 'input_descripcion')));
$cl_detalle->setValor(strtoupper(filter_input(INPUT_POST, 'input_parametro')));
$cl_detalle->setTabla(filter_input(INPUT_POST, 'input_padre'));
$cl_detalle->setId($cl_detalle->obtener_id());

$grabado = $cl_detalle->i_detalle();

if ($grabado) {
    header("Location: ../ver_detalle_tabla_general.php?codigo=" . $cl_detalle->getTabla());
}