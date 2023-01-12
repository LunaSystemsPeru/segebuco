<?php

require '../class/cl_cotizacion.php';

$cl_cotizacion = new cl_cotizacion();

$cl_cotizacion->setCodigo(filter_input(INPUT_POST, 'input_codigo'));
$cl_cotizacion->setNotas(filter_input(INPUT_POST, 'input_orden'));

$modificado = $cl_cotizacion->aprobar();

if ($modificado) {
    header('Location: ../ver_cotizaciones.php');
} else {
    //header('Location: ../ver_entidad.php');
}