<?php

require '../class/cl_orden_cliente.php';

$cl_orden = new cl_orden_cliente();

$codigo = filter_input(INPUT_GET, 'codigo');

$eliminado = $cl_orden->eliminar_orden($codigo);

if ($eliminado) {
    header('Location: ../ver_ordenes.php');
} else {
    //header('Location: ../ver_ordenes.php');
}