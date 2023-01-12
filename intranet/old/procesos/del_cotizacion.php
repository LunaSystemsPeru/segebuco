<?php

require '../class/cl_cotizacion.php';

$cl_cotizacion = new cl_cotizacion();

$cl_cotizacion->setCodigo(filter_input(INPUT_GET, 'codigo'));

$eliminado = $cl_cotizacion->eliminar();

if ($eliminado) {
    header('Location: ../ver_cotizaciones.php');
} else {
    header('Location: ../ver_cotizaciones.php');
}