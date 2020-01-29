<?php

require '../class/cl_orden_interna.php';

$cl_orden = new cl_orden_interna();

$cl_orden->setCodigo(filter_input(INPUT_GET, 'codigo'));

$eliminado = $cl_orden->e_orden();

if ($eliminado) {
    header('Location: ../ver_cotizaciones.php');
} else {
    header('Location: ../ver_servicios.php');
}