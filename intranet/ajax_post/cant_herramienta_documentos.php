<?php
session_start();
require '../class/cl_conectar.php';
require '../class/cl_varios.php';

$cl_varios = new cl_varios();

$codigo = filter_input(INPUT_POST, 'codigo');

$tipo = substr($codigo, 0);
$codigo = substr($codigo, 2);

$array_documentos = array();
    
if ($tipo == 1) {
    $query = " select td.abreviado, i.serie, i.numero, dih.cantidad "
            . "from detalle_ingreso_herramienta as dih "
            . "inner join ingresos as i on dih.ingreso = i.id and dih.periodo = i.periodo "
            . "inner join tipo_documento as td on td.id = i.tipo_documento "
            . "where concat(i.periodo, i.id, dih.herramienta) = '".$codigo."' and i.almacen = '".$_SESSION['almacen']."' ";
    $resultado = $conn->query($query);
    
    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $fila_documentos['cantidad'] = $row['cantidad'];
            $fila_documentos['documento'] = $row['abreviado'] . ' - ' . $cl_varios->zerofill($row['serie'], 2) . '-'. $cl_varios->zerofill($row['numero'], 4);
            array_push($array_documentos, $fila_documentos);
        }
    }
}

if ($tipo == 2) {
    $query = " select td.abreviado, t.serie, t.numero, dth.cantidad "
            . "from detalle_traslado_herramienta as dth "
            . "inner join traslado as t on dth.traslado = t.codigo and dth.periodo = t.periodo "
            . "inner join tipo_documento as td on td.id = t.documento "
            . "where concat(t.periodo, t.codigo, dth.herramienta) = '".$codigo."' and t.destino = '".$_SESSION['almacen']."' ";
    $resultado = $conn->query($query);
    
    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $fila_documentos['cantidad'] = $row['cantidad'];
            $fila_documentos['documento'] = $row['abreviado'] . ' - ' . $cl_varios->zerofill($row['serie'], 2) . '-'. $cl_varios->zerofill($row['numero'], 4);
            array_push($array_documentos, $fila_documentos);
        }
    }
}

echo json_encode($array_documentos);