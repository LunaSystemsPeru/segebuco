<?php
require '../class/cl_herramienta_merma.php';

$cl_merma = new cl_herramienta_merma();

$cl_merma->setId_herramienta(filter_input(INPUT_POST, 'input_id_herramienta'));
$cl_merma->setId_almacen(filter_input(INPUT_POST, 'input_id_almacen'));
$cl_merma->setCactual(filter_input(INPUT_POST, 'input_cactual'));
$cl_merma->setCmerma(filter_input(INPUT_POST, 'input_cmerma'));
$cl_merma->setFecha(filter_input(INPUT_POST, 'input_fecha'));
$cl_merma->setTipo(filter_input(INPUT_POST, 'input_tipo'));
$cl_merma->setObservacion(filter_input(INPUT_POST, 'input_observaciones'));

if ($cl_merma->insertar()) {
    header("Location: ../ver_mis_herramientas.php");
}