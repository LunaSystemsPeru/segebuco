<?php

require '../class/cl_planilla_gastos.php';

$cl_gasto = new cl_planilla_gastos();

$cl_gasto->setCodigo(filter_input(INPUT_GET, 'codigo'));
$cl_gasto->setPlanilla(filter_input(INPUT_GET, 'planilla'));

if($cl_gasto->eliminar_gasto()){
        header("Location: ../ver_detalle_planilla_pago.php?codigo=".$cl_gasto->getCodigo());
}