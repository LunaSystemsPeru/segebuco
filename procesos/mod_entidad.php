<?php

require '../class/cl_entidad.php';

$cl_entidad = new cl_entidad();

$cl_entidad->setRuc(filter_input(INPUT_POST, 'input_ruc'));
$cl_entidad->setRazon_social(filter_input(INPUT_POST, 'input_razon'));
$cl_entidad->setNombre_comercial(filter_input(INPUT_POST, 'input_comercial'));
$cl_entidad->setCondicion(filter_input(INPUT_POST, 'input_condicion'));
$cl_entidad->setEstado(filter_input(INPUT_POST, 'input_estado'));

    $modificado = $cl_entidad->m_entidad();

if ($modificado) {
    header('Location: ../ver_entidad.php');
} else {
    header('Location: ../ver_entidad.php');
}


