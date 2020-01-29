<?php

require '../class/cl_ingresos.php';
require '../class/cl_detalle_ingreso_material.php';
require '../class/cl_devolucion_cilindro.php';
require '../class/cl_devolucion.php';

$cl_ingreso = new cl_ingresos();
$cl_imaterial = new cl_detalle_ingreso_material();

$cl_devolucion = new cl_devolucion();
$cl_cilindros = new cl_devolucion_cilindro();

$periodo = filter_input(INPUT_GET, 'periodo');
$devolucion = filter_input(INPUT_GET, 'id');

$cl_devolucion->setPeriodo($periodo);
$cl_devolucion->setId($devolucion);

$cl_cilindros->setId($devolucion);
$cl_cilindros->setPeriodo($periodo);


if ($cl_cilindros->eliminar()) {
    if ($cl_devolucion->eliminar()) {
        header('Location: ../ver_devoluciones.php?periodo=' . $periodo);
    }
} 