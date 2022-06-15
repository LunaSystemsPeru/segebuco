<?php
session_start();
require '../class/cl_conectar.php';
mysqli_set_charset($conn, "utf8");
$searchTerm = mysqli_real_escape_string($conn, (filter_input(INPUT_GET, 'term')));
$query = "select m.idmaterial, m.descripcion as dmaterial, m.precio_compra, ma.cantidad, m.und_medida "
	. "from material_almacen as ma "
        . "inner join material as m on m.idmaterial = ma.material "
        . "where (m.descripcion like '%" . $searchTerm . "%' or m.idmaterial = '" . $searchTerm . "') and ma.almacen = '".$_SESSION['almacen']."' "
        . "order by m.descripcion asc";
$resultado = $conn->query($query);
$a_json = array();
$a_json_row = array();

if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $id = $row["idmaterial"];
        $descripcion = $row["dmaterial"];
        $precio_compra = $row['precio_compra'];
        $und_medida = $row['und_medida'];
        $cantidad = $row['cantidad'];        
        $a_json_row['value'] = $descripcion . " | Cant.: " . $cantidad . " --- | Cod:" . $id;
        $a_json_row['id'] = $id;
        $a_json_row['descripcion'] = $descripcion;
        $a_json_row['precio_compra'] = $precio_compra;
        $a_json_row['cantidad'] = $cantidad;        
        array_push($a_json, $a_json_row);
    }
}
echo json_encode($a_json);
flush();
$conn->close();