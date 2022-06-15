<?php

require '../class/cl_orden_interna.php';
require '../class/cl_varios.php';

$cl_orden = new cl_orden_interna();
$cl_varios = new cl_varios();

$cl_orden->setCodigo($cl_orden->obtener_id());
$cl_orden->setCotizacion(filter_input(INPUT_POST, 'input_cotizacion'));
$cl_orden->setDias(filter_input(INPUT_POST, 'input_dias'));
$finicio = filter_input(INPUT_POST, 'input_fecha_inicio');
$cl_orden->setFinicio($finicio);
$cl_orden->setPaprobado(filter_input(INPUT_POST, 'input_aprobado'));
$cl_orden->setId_almacen(filter_input(INPUT_POST, 'select_almacen'));
$cl_orden->setObservaciones(filter_input(INPUT_POST, 'input_observaciones'));


$insertar = $cl_orden->i_orden();

if ($insertar) {
    header('Location: ../ver_servicios.php');
} else {
    //header('Location: ../ver_entidad.php');
}