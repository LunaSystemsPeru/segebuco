<?php
session_start();
require '../class/cl_conectar.php';
mysqli_set_charset($conn, "utf8");
$searchTerm = mysqli_real_escape_string($conn, (filter_input(INPUT_GET, 'term')));
$query = "select oi.id_orden, ct.codigo, ct.descripcion, ct.tipo_servicio, oi.fecha_inicio, oi.fecha_termino, oi.estado, oi.dias, " 
        . "date_add(oi.fecha_inicio, interval oi.dias day) as aprox_termino "
        . "from orden_interna as oi  "
        . "inner join cotizaciones as ct on ct.codigo = oi.id_cotizacion "
        . "inner join almacen as al on al.cliente = ct.cliente and al.sucursal = ct.sucursal "
        . "where oi.id_almacen = '".$_SESSION['almacen']."' and ct.descripcion like '%" . $searchTerm . "%'";
        //echo $query;
$resultado = $conn->query($query);
$a_json = array();
$a_json_row = array();

if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $descripcion = $row["descripcion"];
        $id = $row["id_orden"];
        $finicio = $row['fecha_inicio'];
        $ftermino = $row['fecha_termino'];        
        $a_json_row['value'] = $descripcion . " | COD.: " . $id ;
        $a_json_row['codigo'] = $id;
        $a_json_row['descripcion'] = $descripcion ;
        $a_json_row['finicio'] = $finicio ;
        if ($ftermino == '1000-01-01') {
            $a_json_row['ftermino'] = $row['aprox_termino'] ;
        } else {
            $a_json_row['ftermino'] = $ftermino ;   
        }
        array_push($a_json, $a_json_row);
    }
}
echo json_encode($a_json);
flush();
$conn->close();

?>