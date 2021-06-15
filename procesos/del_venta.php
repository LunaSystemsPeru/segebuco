<?php

require '../class/cl_venta.php';

$cl_venta = new cl_venta();

$accion = filter_input(INPUT_GET, 'accion');
$idventa = filter_input(INPUT_GET, 'codigo');
$eliminado = false;

if ($accion == "eliminar") {
    $eliminado = $cl_venta->eliminar_venta($idventa);
}

if ($accion == "anular") {
    $eliminado = $cl_venta->anular_venta($idventa);
}

if ($eliminado) {
    header('Location: ../ver_ventas.php');
} else {
    //header('Location: ../ver_ventas.php');
}