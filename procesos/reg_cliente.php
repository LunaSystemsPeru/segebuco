<?php

require '../class/cl_entidad.php';
require '../class/cl_cliente.php';
require '../class/cl_sucursal.php';

$cl_entidad = new cl_entidad();
$cl_cliente = new cl_cliente();
$cl_sucursal = new cl_sucursal();

$cl_entidad->setRuc(filter_input(INPUT_POST, 'input_ruc'));
$cl_entidad->setRazon_social(addslashes(filter_input(INPUT_POST, 'input_razon')));
$cl_entidad->setNombre_comercial(filter_input(INPUT_POST, 'input_comercial'));
$cl_entidad->setDireccion(addslashes(filter_input(INPUT_POST, 'input_direccion')));
$cl_entidad->setCondicion(filter_input(INPUT_POST, 'input_condicion'));
$cl_entidad->setEstado(filter_input(INPUT_POST, 'input_estado'));

if (!$cl_entidad->buscar_ruc()) {
    $cl_entidad->i_entidad();
}

$cl_cliente->setRuc($cl_entidad->getRuc());
$cl_cliente->setCodigo($cl_cliente->obtener_id());

$cl_cliente->i_cliente();

$cl_sucursal->setCliente($cl_cliente->getCodigo());
$cl_sucursal->setCodigo($cl_sucursal->obtener_id());
$cl_sucursal->setNombre(strtoupper(filter_input(INPUT_POST, 'input_nombre_sucursal')));
$cl_sucursal->setDireccion(strtoupper(addslashes(filter_input(INPUT_POST, 'input_direccion_sucursal'))));
$cl_sucursal->setContacto(strtoupper(filter_input(INPUT_POST, 'input_contacto_sucursal')));
$cl_sucursal->setEmail(strtolower(filter_input(INPUT_POST, 'input_email_sucursal')));

$grabado_sucursal = $cl_sucursal->i_sucursal();

if ($grabado_sucursal) {
    header('Location: ../ver_clientes.php');
} else {
    header('Location: ../reg_cliente.php');
}


