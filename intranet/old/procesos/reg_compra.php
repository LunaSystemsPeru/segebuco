<?php

require '../class/cl_compra.php';
require '../class/cl_varios.php';
require '../class/cl_compra_amarre.php';

$cl_compra = new cl_compra();
$cl_amarre = new cl_compra_amarre();
$cl_varios = new cl_varios();

$cl_compra->setPeriodo(filter_input(INPUT_POST, 'input_periodo'));
$cl_compra->setFecha_compra(filter_input(INPUT_POST, 'input_fecha'));
$cl_compra->setFecha_compra($cl_varios->fecha_web_mysql($cl_compra->getFecha_compra()));
$cl_compra->setGlosa(strtoupper(filter_input(INPUT_POST, 'input_glosa')));
$cl_compra->setMoneda(filter_input(INPUT_POST, 'select_moneda'));
$cl_compra->setTc(filter_input(INPUT_POST, 'input_tc'));
$cl_compra->setProveedor(filter_input(INPUT_POST, 'input_ruc_proveedor'));
$cl_compra->setTido(filter_input(INPUT_POST, 'select_documento'));
$cl_compra->setSerie(strtoupper(filter_input(INPUT_POST, 'input_serie')));
$cl_compra->setNumero(filter_input(INPUT_POST, 'input_numero'));
$cl_compra->setTotal(filter_input(INPUT_POST, 'hidden_total'));
$cl_compra->setIgv(filter_input(INPUT_POST, 'input_igv'));
if ($cl_compra->getTido() == 14) {
    $cl_compra->setTotal(filter_input(INPUT_POST, 'hidden_total'));
    $cl_compra->setTotal($cl_compra->getTotal() *-1);
    $cl_compra->setIgv($cl_compra->getIgv()*-1);
} else {
    $cl_compra->setTotal(filter_input(INPUT_POST, 'hidden_total'));
}  
$cl_compra->setId_orden(filter_input(INPUT_POST, 'select_ocompra'));
$cl_compra->setPorcentaje(filter_input(INPUT_POST, 'input_porcentaje'));
$cl_compra->setId_centro_costo(filter_input(INPUT_POST, 'select_ccosto'));
$cl_compra->setId_clasificacion(filter_input(INPUT_POST, 'select_clasificacion'));
$cl_compra->setCodigo($cl_compra->obtener_id());

$registrado = $cl_compra->i_compra();

if ($cl_compra->getTido() == 14) {
    $cl_amarre->setIdCompra($cl_compra->getCodigo());
    $cl_amarre->setPeriodo($cl_compra->getPeriodo());
    $cl_amarre->setIdTido(filter_input(INPUT_POST, 'select_documento_amarre'));
    $cl_amarre->setFecha(filter_input(INPUT_POST, 'input_fecha_amarre'));
    $cl_amarre->setSerie(filter_input(INPUT_POST, 'input_serie_amarre'));
    $cl_amarre->setNumero(filter_input(INPUT_POST, 'input_numero_amarre'));
    
   

    $cl_amarre->insertar();
}

if ($registrado) {
    header('Location: ../ver_compras.php?periodo=' . $cl_compra->getPeriodo());
}
