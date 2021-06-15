<?php

require '../class/cl_herramientas.php';
require '../class/cl_varios.php';
$cl_herramientas = new cl_herramientas();
$cl_varios = new cl_varios();

$cl_herramientas->setId(filter_input(INPUT_POST, 'input_id'));
$cl_herramientas->setDescripcion(strtoupper(filter_input(INPUT_POST, 'input_descripcion')));
$cl_herramientas->setMarca(strtoupper(filter_input(INPUT_POST, 'input_marca')));
$cl_herramientas->setModelo(strtoupper(filter_input(INPUT_POST, 'input_modelo')));
$cl_herramientas->setSerie(strtoupper(filter_input(INPUT_POST, 'input_serie')));
$cl_herramientas->setPrecio(filter_input(INPUT_POST, 'input_precio'));
$cl_herramientas->setTipo(filter_input(INPUT_POST, 'select_tipo'));
$cl_herramientas->setCaracteristicas(strtoupper(filter_input(INPUT_POST, 'input_caracteristicas')));

$actualizado = $cl_herramientas->actualizar();

if ($actualizado) {
    header ("Location: ../ver_herramientas.php");
}