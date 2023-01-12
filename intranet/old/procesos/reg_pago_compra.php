<?php
require '../class/cl_pago_compra.php';
require  '../class/cl_compra.php';
require '../class/cl_movimiento_banco.php';
require '../class/cl_entidad.php';

$movimiento=new cl_movimiento_banco();
$pago=new cl_pago_compra();
$compra=new cl_compra();
$entidad=new cl_entidad();

$idCompra=filter_input(INPUT_POST, 'input_compra');
$compra->setCodigo($idCompra);
$compra->obtener_datos();

$entidad->setRuc($compra->getProveedor());
$entidad->obtener_datos();

$movimiento->setPeriodo(date("Ym",strtotime(filter_input(INPUT_POST, 'input_fecha'))));
$movimiento->setIngreso(0);
$movimiento->setEgreso(filter_input(INPUT_POST, 'input_monto'));
$movimiento->setConcepto("Pago al porveedor ".$entidad->getRazon_social());
$movimiento->setBanco(filter_input(INPUT_POST, 'input_banco'));
$movimiento->setIdClasificacion($compra->getId_clasificacion());
$movimiento->setFecha(filter_input(INPUT_POST, 'input_fecha'));
$movimiento->setMovimiento($movimiento->obtener_id());
$pago->setIdCompra($idCompra);
$pago->setIdMovimiento($movimiento->getMovimiento());

if ($movimiento->insertar()){
    if ($pago->insertar()){
        header("location: ../ver_detalle_compra.php?codigo=".$idCompra );
    }
}