<?php

require '../class/cl_planilla.php';
require '../class/cl_varios.php';
$cl_planilla = new cl_planilla();
$cl_varios = new cl_varios();

$cl_planilla->setAnio(filter_input(INPUT_POST, 'input_anio'));
$cl_planilla->setSemana(filter_input(INPUT_POST, 'input_semana'));
$cl_planilla->setCliente(filter_input(INPUT_POST, 'select_cliente'));
$cl_planilla->setSucursal(filter_input(INPUT_POST, 'select_sucursal'));
$cl_planilla->setInicio(filter_input(INPUT_POST, 'input_inicio'));
$cl_planilla->setInicio($cl_varios->fecha_web_mysql($cl_planilla->getInicio()));
$cl_planilla->setFinal(filter_input(INPUT_POST, 'input_fin'));
$cl_planilla->setFinal($cl_varios->fecha_web_mysql($cl_planilla->getFinal()));
$cl_planilla->setUsuario(filter_input(INPUT_POST, 'select_responsable'));
$cl_planilla->setAlimentacion(filter_input(INPUT_POST, 'input_alimentacion'));
$cl_planilla->setLocal(filter_input(INPUT_POST, 'cbx_local'));
if ($cl_planilla->getLocal() == 0) {
    $cl_planilla->setLocal(2);
}
$codigo = $cl_planilla->getAnio() . $cl_varios->zerofill($cl_planilla->getSemana(), 2) . $cl_varios->zerofill($cl_planilla->getCliente(), 3) . $cl_varios->zerofill($cl_planilla->getSucursal(), 3);
$cl_planilla->setCodigo($codigo);
$grabado = $cl_planilla->i_planilla();

if ($grabado) {
    header("Location: ../ver_planillas.php");
}