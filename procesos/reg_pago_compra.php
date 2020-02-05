<?php
require '../class/cl_pago_compra.php';
require  '../class/cl_compra.php';
require '../class/cl_movimiento_banco.php';

$movimiento=new cl_movimiento_banco();
$pago=new cl_pago_compra();
$compra=new cl_compra();

$idCompra=filter_input(INPUT_POST, '');
$compra->setCodigo($idCompra);
$compra->

$movimiento->setPeriodo(filter_input(INPUT_POST, ''));
$movimiento->setIngreso(filter_input(INPUT_POST, ''));
$movimiento->setEgreso(filter_input(INPUT_POST, ''));
$movimiento->setConcepto(filter_input(INPUT_POST, ''));
$movimiento->setBanco(filter_input(INPUT_POST, ''));
$movimiento->setIdClasificacion(filter_input(INPUT_POST, ''));
$movimiento->setFecha(filter_input(INPUT_POST, ''));
$movimiento->setMovimiento($movimiento->obtener_id());
$pago->setIdCompra($idCompra);
$pago->setIdMovimiento($movimiento->getMovimiento());

if ($movimiento->insertar()){
    if ($pago->insertar()){
        header("location: ../?codigo=".$idCompra );
    }
}