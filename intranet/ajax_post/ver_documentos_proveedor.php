<?php

require '../class/cl_conectar.php';
require '../class/cl_varios.php';

$cl_varios = new cl_varios();

mysqli_set_charset($conn, "utf8");
$ruc = filter_input(INPUT_GET, 'ruc_proveedor');

$query = "select c.codigo, c.periodo, c.fecha_compra, td.abreviado, c.serie, c.numero, dtgm.descripcion as nmoneda, dtgm.atributo as moneda, c.total "
        . "from compras as c "
        . "inner join tipo_documento as td on td.id = c.tipo_documento "
        . "inner join detalle_tabla_general as dtgm on dtgm.general = 5 and dtgm.id = c.moneda "
        . "where c.estado = '0' and c.ruc_proveedor = '" . $ruc . "' "
        . "order by c.fecha_compra asc";
$resultado = $conn->query($query);
$a_json = array();
$a_json_row = array();

if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $periodo = $row["periodo"];
        $codigo = $row["periodo"] . $row['codigo'];
        $fecha = $row["fecha_compra"];
        $amoneda = $row["moneda"];
        $documento = $row['abreviado'] . ' / '. $cl_varios->zerofill(strtoupper($row["serie"]),4) . ' - ' . $cl_varios->zerofill($row['numero'], 7);
        $monto = $row['total'];
        $a_json_row['value'] = $periodo . " | " . $fecha . " | " . $documento . " | " . $amoneda . ' ' . $monto;
        $a_json_row['codigo'] = $codigo;
//        $a_json_row['razon_social'] = $razon_social;
//        $a_json_row['direccion'] = $direccion;
//        $a_json_row['nombre_comercial'] = $nombre_comercial;
        array_push($a_json, $a_json_row);
    }
}
echo json_encode($a_json);
flush();
$conn->close();
?>