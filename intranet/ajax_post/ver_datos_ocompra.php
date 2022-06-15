<?php

require '../class/cl_orden_compra.php';

$cl_orden = new cl_orden_compra();

$codigo = filter_input(INPUT_GET, 'id_orden');
$datos_orden = $cl_orden->cargar_datos($codigo);

$datos = array("id_moneda" => $cl_orden->getIdMoneda(),
    "porcentaje" => $cl_orden->getPorcentaje(),
    "total" => $cl_orden->getMonto(),
    "glosa" => $cl_orden->getGlosa());

echo json_encode($datos);