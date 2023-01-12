<?php
require '../class/cl_orden_compra.php';
require '../class/cl_varios.php';

$c_orden = new cl_orden_compra();
$c_varios = new cl_varios();

$c_orden->setFecha(filter_input(INPUT_POST, 'input_fecha'));
$c_orden->setAnio($c_varios->anio_de_fecha($c_orden->getFecha()));
$c_orden->setGlosa(strtoupper(filter_input(INPUT_POST, 'input_glosa')));
$c_orden->setMonto(filter_input(INPUT_POST, 'input_total'));
$c_orden->setIdProveedor(filter_input(INPUT_POST, 'input_ruc_proveedor'));
$c_orden->setIdMoneda(filter_input(INPUT_POST, 'select_moneda'));
$c_orden->obtener_id();

if ($c_orden->insertar()) {
    header("Location: ../ver_orden_compra.php");
}