<?php

require '../class/cl_movimiento_caja.php';
require '../class/cl_centro_costo.php';
require '../class/cl_varios.php';

$cl_mcaja = new cl_movimiento_caja();
$cl_ccosto = new cl_centro_costo();
$cl_varios = new cl_varios();

$cl_mcaja->setCaja(filter_input(INPUT_POST, 'hidden_caja'));
$cl_mcaja->setMovimiento($cl_mcaja->obtener_id());
$cl_mcaja->setConcepto(filter_input(INPUT_POST, 'hidden_conceptop'));
$cl_mcaja->setCcosto(filter_input(INPUT_POST, 'select_ccostop'));
$cl_mcaja->setId_tipo_gasto(14);
$cl_mcaja->setCtabla(filter_input(INPUT_POST, 'select_sucursalp'));
$cl_mcaja->setTabla('P');
$cl_mcaja->setEgresa(filter_input(INPUT_POST, 'hidden_montop'));
$cl_mcaja->setIngresa(0);
$cl_mcaja->setFecha($cl_varios->fecha_web_mysql(filter_input(INPUT_POST, 'input_fechap')));

$registrado = $cl_mcaja->insertar();

$cl_ccosto->setCodigo($cl_mcaja->getCcosto());
$cl_ccosto->setGdocumentado(0);
$cl_ccosto->setPlanilla($cl_mcaja->getEgresa());
$cl_ccosto->setGsimple(0);

if ($registrado) {

   if ($cl_ccosto->sumar_gastos()) {
        header("location: ../ver_movimiento_caja.php?caja=" . $cl_mcaja->getCaja());
    }
}