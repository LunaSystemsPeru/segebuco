<?php

require '../class/cl_conectar.php';
mysqli_set_charset($conn, "utf8");
$searchTerm = mysqli_real_escape_string($conn, (filter_input(INPUT_GET, 'term')));
$query = "select idherramientas, concat (descripcion, ' ', marca, ' ', modelo, ' ', serie) as dherramienta, precio, img, und_medida, tipo, caracteristicas "
        . "from herramientas "
        . "where concat(descripcion, ' ', marca, ' ', modelo, ' ', serie) like '%" . $searchTerm . "%' " //and estado = '0' "
        . "order by descripcion asc, marca asc, modelo asc, serie asc";
$resultado = $conn->query($query);
$a_json = array();
$a_json_row = array();

if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $id = $row["idherramientas"];
        $descripcion = $row["dherramienta"];
        $precio_compra = $row['precio'];
        $imagen= $row['img'];
        $tipo = $row['tipo'];
        $caracteristicas = $row['caracteristicas'];
        $und_medida = $row['und_medida'];
        $a_json_row['value'] = $descripcion . " | S/ " . $precio_compra . " -- | Cod:" . $id;
        $a_json_row['id'] = $id;
        $a_json_row['descripcion'] = $descripcion;
        $a_json_row['imagen'] = $imagen;
        $a_json_row['tipo'] = $tipo;
        $a_json_row['precio_compra'] = $precio_compra;        
        array_push($a_json, $a_json_row);
    }
}
echo json_encode($a_json);
flush();
$conn->close();