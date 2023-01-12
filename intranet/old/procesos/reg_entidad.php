<?php

require '../class/cl_entidad.php';

$cl_entidad = new cl_entidad();

$cl_entidad->setRuc(filter_input(INPUT_POST, 'input_ruc'));
$cl_entidad->setRazon_social(htmlentities(filter_input(INPUT_POST, 'input_razon')));
$cl_entidad->setNombre_comercial(strtoupper(filter_input(INPUT_POST, 'input_comercial')));
$cl_entidad->setDireccion(htmlentities(filter_input(INPUT_POST, 'input_direccion')));
$cl_entidad->setCondicion(filter_input(INPUT_POST, 'input_condicion'));
$cl_entidad->setEstado(filter_input(INPUT_POST, 'input_estado'));

if (!$cl_entidad->buscar_ruc()) {
    $grabado = $cl_entidad->i_entidad();
}

if ($grabado) {
    header('Location: ../ver_entidad.php');
} else {
    header('Location: ../reg_entidad.php');
}


