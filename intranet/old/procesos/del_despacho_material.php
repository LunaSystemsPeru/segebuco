<?php

require '../class/cl_despacho_material.php';
require '../class/cl_detalle_despacho_material.php';

$cl_despacho = new cl_despacho_material();
$cl_dmaterial = new cl_detalle_despacho_material();

$cl_despacho->setIddespacho(filter_input(INPUT_GET, 'codigo'));
$cl_dmaterial->setIddespacho(filter_input(INPUT_GET, 'codigo'));

$eli_imaterial = $cl_dmaterial->eliminar();
$eli_ingreso = $cl_despacho->eliminar();

if ($eli_ingreso ) {
    header('Location: ../ver_despacho_materiales.php');
} else {
    //header('Location: ../ver_cotizaciones.php');
}