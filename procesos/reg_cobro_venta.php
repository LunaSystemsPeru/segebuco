<?php

require '../class/cl_cobro_venta.php';
require '../class/cl_varios.php';

$cl_cobro = new cl_cobro_venta();
$cl_varios = new cl_varios();

$cl_cobro->setPeriodo(filter_input(INPUT_POST, 'hidden_periodo'));
$cl_cobro->setVenta(filter_input(INPUT_POST, 'hidden_venta'));
$cl_cobro->setCodigo($cl_cobro->obtener_id());
$cl_cobro->setBanco(filter_input(INPUT_POST, 'select_banco'));
$cl_cobro->setMoneda(filter_input(INPUT_POST, 'select_moneda'));
$cl_cobro->setFecha($cl_varios->fecha_web_mysql(filter_input(INPUT_POST, 'input_fecha')));
$cl_cobro->setTc(filter_input(INPUT_POST, 'input_tc'));
$cl_cobro->setMonto(filter_input(INPUT_POST, 'input_mcobro'));

$grabado = $cl_cobro->insertar();

if ($grabado) {
    header('Location: ../ver_pagos_venta.php?periodo='.$cl_cobro->getPeriodo().'&codigo='.$cl_cobro->getVenta());
} else {
    // header('Location: ../ver_ventas.php');
}


