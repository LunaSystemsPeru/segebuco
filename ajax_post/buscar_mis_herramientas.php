<?php
session_start();
require '../class/cl_conectar.php';
mysqli_set_charset($conn, "utf8");
$searchTerm = mysqli_real_escape_string($conn, (filter_input(INPUT_GET, 'term')));
$query = "select h.idherramientas, concat (h.descripcion, ' ', h.marca, ' ', h.modelo, ' ', h.serie) as dherramienta, h.precio, h.img, h.und_medida, h.tipo, h.caracteristicas, ha.cactual "
        . "from herramienta_almacen as ha "
        . "inner join herramientas as h on h.idherramientas = ha.herramienta "
        . "where concat(descripcion, ' ', marca, ' ', modelo, ' ', serie) like '%" . $searchTerm . "%' and ha.almacen = '" . $_SESSION["almacen"] . "' " //and estado = '0' "
        . "order by h.descripcion asc, h.marca asc, h.modelo asc, h.serie asc";
//echo $query;
$resultado = $conn->query($query);
$a_json = array();
$a_json_row = array();

if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $id = $row["idherramientas"];
        $descripcion = $row["dherramienta"];
        $precio_compra = $row['precio'];
        $cactual = $row['cactual'];
        $imagen = $row['img'];
        $tipo = $row['tipo'];
        $caracteristicas = $row['caracteristicas'];
        $und_medida = $row['und_medida'];
        $a_json_row['value'] = $descripcion . " | Cant. Actual: " . $cactual . "  | Cod:" . $id;
        $a_json_row['id'] = $id;
        $a_json_row['descripcion'] = $descripcion;
        $a_json_row['imagen'] = $imagen;
        $a_json_row['cantidad'] = $cactual;
        $a_json_row['tipo'] = $tipo;
        $a_json_row['precio_compra'] = $precio_compra;
        array_push($a_json, $a_json_row);
    }
}
echo json_encode($a_json);
flush();
$conn->close();
