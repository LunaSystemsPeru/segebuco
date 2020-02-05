<?php

require '../class/cl_pago_compra.php';
require '../class/cl_movimiento_banco.php';

$idCompra=filter_input(INPUT_GET, '');

$movimiento=new cl_movimiento_banco();
$pago=new cl_pago_compra();
$pago->setIdMovimiento(filter_input(INPUT_GET, ''));
$pago->setIdCompra($idCompra);

$movimiento->setMovimiento($pago->getIdMovimiento());

if ($pago->eliinar()){
    if ($movimiento->eliminar()){
        header("location: ../?codigo=".$idCompra );
    }
}