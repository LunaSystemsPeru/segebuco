<?php

require '../class/cl_conectar.php';
require '../class/cl_varios.php';
require '../class/cl_compra.php';

$cl_varios = new cl_varios();
$cl_compra = new cl_compra();

mysqli_set_charset($conn, "utf8");

$a_detalle = $cl_compra->ver_datos_compra(filter_input(INPUT_GET, 'codigo'));

$a_json = array();
$a_json_row = array();

foreach ($a_detalle as $row) {
    $concepto = $row["glosa"];
    $monto = $row["total"];
    $fecha = $cl_varios->fecha_mysql_web($row["fecha_compra"]);
//    $codigo = $row["periodo"] . $row['codigo'];
//    $fecha = $row["fecha_compra"];
    $documento = $row['ndocumento'] . ' / ' . $cl_varios->zerofill(strtoupper($row["serie"]), 4) . ' - ' . $cl_varios->zerofill($row['numero'], 7);
//    $monto = $row['total'];
    //$a_json_row['value'] = $periodo . " | " . $fecha . " | " . $documento . " | " . $monto;
    $a_json_row['concepto'] = $concepto;
    $a_json_row['monto'] = $monto;
    $a_json_row['fecha'] = $fecha;
    $a_json_row['documento'] = $documento;
    $a_json_row['id_centro_costo'] = $row['id_centro_costo'];
    $a_json_row['id_clasificacion'] = $row['id_clasificacion'];
//        $a_json_row['direccion'] = $direccion;
//        $a_json_row['nombre_comercial'] = $nombre_comercial;
    array_push($a_json, $a_json_row);
}

echo json_encode($a_json);
flush();
$conn->close();
?>