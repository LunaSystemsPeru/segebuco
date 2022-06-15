<?php
session_start();
require '../class/cl_conectar.php';
require '../class/cl_varios.php';

$cl_varios = new cl_varios();

$herramienta = filter_input(INPUT_POST, 'id');

//cargar documentos de ingreso
$query = " select i.id, i.periodo, i.fecha, td.abreviado, i.serie, i.numero "
        . "from detalle_ingreso_herramienta as dih "
        . "inner join ingresos as i on dih.ingreso = i.id and dih.periodo = i.periodo "
        . "inner join tipo_documento as td on td.id = i.tipo_documento "
        . "where dih.herramienta = '".$herramienta."' and i.almacen = '".$_SESSION['almacen']."' "
        . "order by i.fecha asc ";
$resultado = $conn->query($query);

$array_documentos = array();
if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $fila_documentos['value'] = '1-' . $row['periodo'] . $row['id'] . $herramienta;
        $fila_documentos['texto'] = $row['abreviado'] . ' - ' . $cl_varios->zerofill($row['serie'], 2) . '-'. $cl_varios->zerofill($row['numero'], 4) . ' | ' . $row['fecha'] . ' | INGRESO';
        array_push($array_documentos, $fila_documentos);
    }
}

//cargar documentos de traslado
$query = " select t.codigo, t.periodo, t.fecha, td.abreviado, t.serie, t.numero "
        . "from detalle_traslado_herramienta as dth "
        . "inner join traslado as t on dth.traslado = t.codigo and dth.periodo = t.periodo "
        . "inner join tipo_documento as td on td.id = t.documento "
        . "where dth.herramienta = '".$herramienta."' and t.destino = '".$_SESSION['almacen']."' "
        . "order by t.fecha asc";
$resultado = $conn->query($query);

if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $fila_documentos['value'] = '2-' . $row['periodo'] . $row['codigo'] . $herramienta;
        $fila_documentos['texto'] = $row['abreviado'] . ' - ' . $cl_varios->zerofill($row['serie'], 2) . '-'. $cl_varios->zerofill($row['numero'], 4) . ' | ' . $row['fecha'] . ' | TRASLADO';
        array_push($array_documentos, $fila_documentos);
    }
}

echo json_encode($array_documentos);