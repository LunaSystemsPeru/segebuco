<?php
require '../class/cl_orden_compra.php';
require '../class/cl_varios.php';

$cl_ocompra = new cl_orden_compra();
$cl_varios = new cl_varios();

$cl_ocompra->setIdProveedor(filter_input(INPUT_GET, 'input_proveedor'));

$a_ordenes = $cl_ocompra->ver_ordenes_proveedor();
$array_ordenes = array();
foreach ($a_ordenes as $value) {
    $fila_orden['id'] = $value['anio'] . $value['id'];
    $fila_orden['nombre'] = $value['anio'] . $cl_varios->zerofill($value['id'], 3) . ' | ' 
            . $cl_varios->fecha_mysql_web($value['fecha']) . ' | ' 
            . strtoupper($value['descripcion']) . ' | ' 
            . $value['nmoneda'] . " "
            . number_format($value['monto'], 2, '.', ',') . ' | ' 
            . number_format($value['facturado'], 3, '.', ',') . '% FACT.';
    array_push($array_ordenes, $fila_orden);
}
//cargar siempre
$fila_orden['id'] = '-';
$fila_orden['nombre'] = 'SIN ORDEN DE COMPRA';
array_push($array_ordenes, $fila_orden);
echo json_encode($array_ordenes);
