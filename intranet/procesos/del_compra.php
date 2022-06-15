<?php

require '../class/cl_compra.php';

$cl_compra = new cl_compra();

$cl_compra->setCodigo(filter_input(INPUT_GET, 'codigo'));
$cl_compra->setPeriodo(filter_input(INPUT_GET, 'periodo'));

if ($cl_compra->eliminar() ) {
    header('Location: ../ver_compras.php?periodo=' . $cl_compra->getPeriodo());
} else {
    //header('Location: ../ver_cotizaciones.php');
}