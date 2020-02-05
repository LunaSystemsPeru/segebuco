<?php

require '../class/cl_pago_compra.php';
require '../class/cl_movimiento_banco.php';

$idCompra=filter_input(INPUT_GET, 'input_compra');

$movimiento=new cl_movimiento_banco();
$pago=new cl_pago_compra();
$pago->setIdMovimiento(filter_input(INPUT_GET, 'input_movimiento'));
$pago->setIdCompra($idCompra);

$movimiento->setMovimiento($pago->getIdMovimiento());

if ($pago->eliinar()){
    if ($movimiento->eliminar()){
        header("location: ../ver_detalle_compra.php?codigo=".$idCompra );
    }
}