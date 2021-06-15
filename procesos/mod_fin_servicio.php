<?php

require '../class/cl_orden_interna.php';
require '../class/cl_varios.php';

$cl_orden = new cl_orden_interna();
$cl_varios = new cl_varios();

$cl_orden->setCodigo(filter_input(INPUT_POST, 'input_codigo'));
$ffin = filter_input(INPUT_POST, 'input_fecha_fin');
$cl_orden->setFfin($ffin);
$cl_orden->setObservaciones(filter_input(INPUT_POST, 'input_observaciones'));


$insertar = $cl_orden->u_orden();

if ($insertar) {
    header('Location: ../ver_servicios.php');
} else {
    //header('Location: ../ver_entidad.php');
}