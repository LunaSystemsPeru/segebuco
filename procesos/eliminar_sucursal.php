<?php

require '../class/cl_sucursal.php';

$cl_sucursal = new cl_sucursal();

$cl_sucursal->setCliente(filter_input(INPUT_POST, 'cliente'));
$cl_sucursal->setCodigo(filter_input(INPUT_POST, 'sucursal'));

if ($cl_sucursal->eliminar()) {
    header("Location: ../ver_detalle_cliente.php?codigo=" . $cl_sucursal->getCliente());
}