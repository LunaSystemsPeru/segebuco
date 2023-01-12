<?php

require '../class/cl_detalle_planilla.php';

$cl_detalle = new cl_detalle_planilla();

$cl_detalle->setPlanilla(filter_input(INPUT_POST, 'input_planilla_pago'));
$cl_detalle->setColaborador(filter_input(INPUT_POST, 'input_id_colaborador_pago'));
$cl_detalle->setI_alimentacion(filter_input(INPUT_POST, 'input_alimentacion'));
$cl_detalle->setI_gastos(filter_input(INPUT_POST, 'input_movilidad'));
$cl_detalle->setD_adelanto(filter_input(INPUT_POST, 'input_adelantos'));
$cl_detalle->setD_otros(filter_input(INPUT_POST, 'input_otros'));

$modificado = $cl_detalle->u_pago_colaborador();

if ($modificado) {
    header("Location: ../ver_detalle_planilla_pago.php?codigo=" . $cl_detalle->getPlanilla());
}