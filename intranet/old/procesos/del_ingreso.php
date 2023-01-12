<?php

require '../class/cl_ingresos.php';
require '../class/cl_detalle_ingreso_material.php';

$cl_ingreso= new cl_ingresos();
$cl_imaterial= new cl_detalle_ingreso_material();

$cl_ingreso->setCodigo(filter_input(INPUT_GET, 'codigo'));
$cl_imaterial->setIngreso(filter_input(INPUT_GET, 'codigo'));

$eli_imaterial = $cl_imaterial->eliminar();
$eli_ingreso = $cl_ingreso->eliminar();

if ($eli_ingreso ) {
    header('Location: ../ver_ingresos.php');
} else {
    //header('Location: ../ver_cotizaciones.php');
}