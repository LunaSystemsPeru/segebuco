<?php

require '../class/cl_detalle_planilla.php';
require '../class/cl_planilla_colaborador.php';

$cl_detalle = new cl_detalle_planilla();
$cl_detalle_colaborador = new cl_planilla_colaborador();

$cl_detalle->setColaborador(filter_input(INPUT_GET, 'colaborador'));
$cl_detalle->setPlanilla(filter_input(INPUT_GET, 'planilla'));

$cl_detalle->d_colaborador();

$cl_detalle_colaborador->setColaborador(filter_input(INPUT_GET, 'colaborador'));
$cl_detalle_colaborador->setPlanilla(filter_input(INPUT_GET, 'planilla'));

$cl_detalle_colaborador->d_empleado();

header("Location: ../ver_detalle_planilla.php?codigo=" . $cl_detalle->getPlanilla());
