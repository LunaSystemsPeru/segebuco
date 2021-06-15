<?php

require '../class/cl_proyectos.php';
require '../class/cl_varios.php';
$cl_proyecto = new cl_proyectos();
$cl_varios = new cl_varios();

$cl_proyecto->setAnio(filter_input(INPUT_POST, 'input_anio'));
$cl_proyecto->setCliente(filter_input(INPUT_POST, 'select_cliente'));
$cl_proyecto->setSucursal(filter_input(INPUT_POST, 'select_sucursal'));
$cl_proyecto->setFecha(filter_input(INPUT_POST, 'input_inicio'));
$cl_proyecto->setFecha($cl_varios->fecha_web_mysql($cl_proyecto->getFecha()));
$cl_proyecto->setUsuario(filter_input(INPUT_POST, 'select_responsable'));
$cl_proyecto->setCodigo($cl_proyecto->obtener_id());
$grabado = $cl_proyecto->i_proyecto();

if ($grabado) {
    header("Location: ../ver_obras.php");
}