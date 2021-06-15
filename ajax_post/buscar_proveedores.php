<?php

require '../class/cl_conectar.php';
mysqli_set_charset($conn, "utf8");
$searchTerm = mysqli_real_escape_string($conn, (filter_input(INPUT_GET, 'term')));
$query = "select ruc, razon_social, nombre_comercial, direccion "
    . "from entidad "
    . "where ruc like '%" . $searchTerm . "%' or razon_social like '%" . $searchTerm . "%' "
    . "order by razon_social";
$resultado = $conn->query($query);
$a_json = array();
$a_json_row = array();

if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $razon_social = $row["razon_social"];
        $ruc = $row["ruc"];
        $nombre_comercial = $row["nombre_comercial"];
        $direccion = $row['direccion'];
        $a_json_row['value'] = $ruc . " | " . $razon_social;
        $a_json_row['ruc'] = $ruc;
        $a_json_row['razon_social'] = $razon_social;
        $a_json_row['direccion'] = $direccion;
        $a_json_row['nombre_comercial'] = $nombre_comercial;
        array_push($a_json, $a_json_row);
    }
}
echo json_encode($a_json);
flush();
$conn->close();
?>