<?php

require '../class/cl_planilla_gastos.php';

$cl_gastos = new cl_planilla_gastos();

$cl_gastos->setPlanilla(filter_input(INPUT_POST, 'input_planilla'));
$cl_gastos->setCodigo($cl_gastos->obtener_id());
$cl_gastos->setGlosa(filter_input(INPUT_POST, 'input_glosa'));
$cl_gastos->setMonto(filter_input(INPUT_POST, 'input_monto'));

$ingresado = $cl_gastos->i_gastos();

if ($ingresado) {
    header("Location: ../ver_detalle_planilla_pago.php?codigo=" . $cl_gastos->getPlanilla());
}