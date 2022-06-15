<?php

require '../class/cl_movimiento_caja.php';
require '../class/cl_varios.php';
require '../class/cl_centro_costo.php';

$cl_mcaja = new cl_movimiento_caja();
$cl_ccosto = new cl_centro_costo();
$cl_varios = new cl_varios();

$cl_mcaja->setCaja(filter_input(INPUT_POST, 'hidden_caja'));
$cl_mcaja->setMovimiento($cl_mcaja->obtener_id());
$cl_mcaja->setConcepto(filter_input(INPUT_POST, 'input_ruc_proveedor') . ' | ' . filter_input(INPUT_POST, 'hidden_documentogd') . ' | ' . strtoupper(filter_input(INPUT_POST, 'input_conceptogd')));
$cl_mcaja->setCcosto(filter_input(INPUT_POST, 'select_ccostogd'));
$cl_mcaja->setCtabla(filter_input(INPUT_POST, 'select_documentos'));
$cl_mcaja->setTabla('C');
$cl_mcaja->setEgresa(filter_input(INPUT_POST, 'input_montogd'));
$cl_mcaja->setIngresa(0);
$cl_mcaja->setId_tipo_gasto(filter_input(INPUT_POST, 'select_clasificaciongd'));
$cl_mcaja->setFecha($cl_varios->fecha_web_mysql(filter_input(INPUT_POST, 'input_fechagd')));

$registrado = $cl_mcaja->insertar();

$cl_ccosto->setCodigo($cl_mcaja->getCcosto());
$cl_ccosto->setGdocumentado($cl_mcaja->getEgresa());
$cl_ccosto->setPlanilla(0);
$cl_ccosto->setGsimple(0);

if ($registrado) {

    if ($cl_ccosto->sumar_gastos($cl_mcaja->getCcosto())) {
        header("location: ../ver_movimiento_caja.php?caja=" . $cl_mcaja->getCaja());
    }
}