<?php

require '../class/cl_movimiento_caja.php';
require '../class/cl_centro_costo.php';
require '../class/cl_varios.php';

$cl_mcaja = new cl_movimiento_caja();
$cl_ccosto = new cl_centro_costo();
$cl_varios = new cl_varios();

$cl_mcaja->setCaja(filter_input(INPUT_POST, 'hidden_caja'));
$cl_mcaja->setMovimiento($cl_mcaja->obtener_id());
$cl_mcaja->setConcepto(strtoupper(filter_input(INPUT_POST, 'input_conceptogs')));
$cl_mcaja->setCcosto(filter_input(INPUT_POST, 'select_ccostogs'));
$cl_mcaja->setCtabla();
$cl_mcaja->setTabla();
$cl_mcaja->setEgresa(filter_input(INPUT_POST, 'input_montogs'));
$cl_mcaja->setIngresa(0);
$cl_mcaja->setId_tipo_gasto(filter_input(INPUT_POST, 'select_clasificaciongs'));
//$cl_mcaja->setFecha($cl_varios->fecha_web_mysql(filter_input(INPUT_POST, 'input_fechags')));
$cl_mcaja->setFecha(filter_input(INPUT_POST, 'input_fechags'));

$registrado = $cl_mcaja->insertar();

$cl_ccosto->setCodigo($cl_mcaja->getCcosto());
$cl_ccosto->setGdocumentado(0);
$cl_ccosto->setPlanilla(0);
$cl_ccosto->setGsimple($cl_mcaja->getEgresa());

if ($registrado) {
    if ($cl_ccosto->sumar_gastos($cl_mcaja->getCcosto())) {
        header("location: ../ver_movimiento_caja.php?caja=" . $cl_mcaja->getCaja());
    }
}