<?php

require '../class/cl_conectar.php';
mysqli_set_charset($conn, "utf8");
$searchTerm = mysqli_real_escape_string($conn, (filter_input(INPUT_GET, 'term')));
$query = "select codigo, gas, capacidad "
        . "from cilindros "
        . "where codigo like '%" . $searchTerm . "%' "
        . "order by codigo asc, gas asc";
$resultado = $conn->query($query);
$a_json = array();
$a_json_row = array();

if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $id = $row["codigo"];
        $gas = $row["gas"];
        $capacidad = $row['capacidad'];
        $a_json_row['value'] = $id . " | " .$gas . " | " .$capacidad . " m3 ";
        $a_json_row['id'] = $id;
        $a_json_row['gas'] = $gas;
        $a_json_row['capacidad'] = $capacidad;
        array_push($a_json, $a_json_row);
    }
}
echo json_encode($a_json);
flush();
$conn->close();
?>