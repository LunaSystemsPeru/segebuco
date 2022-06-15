<?php

require '../class/cl_conectar.php';
mysqli_set_charset($conn, "utf8");
$searchTerm = mysqli_real_escape_string($conn, (filter_input(INPUT_GET, 'term')));
$query = "select idmaterial, descripcion as dmaterial, precio_compra, imagen, und_medida "
        . "from material "
        . "where descripcion like '%" . $searchTerm . "%' "
        . "order by descripcion asc";
$resultado = $conn->query($query);
$a_json = array();
$a_json_row = array();

if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $id = $row["idmaterial"];
        $descripcion = $row["dmaterial"];
        $precio_compra = $row['precio_compra'];
        $imagen = $row['imagen'];
        $und_medida = $row['und_medida'];
        $a_json_row['value'] = $descripcion . " | S/ " . $precio_compra . " --- | Cod:" . $id;
        $a_json_row['id'] = $id;
        $a_json_row['descripcion'] = $descripcion;
        $a_json_row['imagen'] = $imagen;
        $a_json_row['precio_compra'] = $precio_compra;
        array_push($a_json, $a_json_row);
    }
}
echo json_encode($a_json);
flush();
$conn->close();