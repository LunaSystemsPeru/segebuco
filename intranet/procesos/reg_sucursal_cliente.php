<?php

require '../class/cl_sucursal.php';
$cl_sucursal = new cl_sucursal();

$cl_sucursal->setCliente(filter_input(INPUT_POST, 'input_cliente'));
$cl_sucursal->setNombre(strtoupper(filter_input(INPUT_POST, 'input_nombre')));
$cl_sucursal->setDireccion(strtoupper(filter_input(INPUT_POST, 'input_direccion')));
$cl_sucursal->setContacto(strtoupper(filter_input(INPUT_POST, 'input_contacto')));
$cl_sucursal->setEmail(strtolower(filter_input(INPUT_POST, 'input_email')));
$cl_sucursal->setCodigo($cl_sucursal->obtener_id());

$cl_sucursal->setDireccion(trim($cl_sucursal->getDireccion()));

$grabado = $cl_sucursal->i_sucursal();

if ($grabado) {
    header('Location: ../ver_detalle_cliente.php?codigo=' . $cl_sucursal->getCliente());
}