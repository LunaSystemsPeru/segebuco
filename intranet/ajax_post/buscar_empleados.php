<?php

require '../class/cl_conectar.php';
mysqli_set_charset($conn, "utf8");
$searchTerm = mysqli_real_escape_string($conn, (filter_input(INPUT_GET, 'term')));

function limpia_espacios($cadena){
	$cadena = str_replace(' ', '', $cadena);
	return $cadena;
}

$query = "select c.id, c.dni, c.jornal_dia, c.ape_pat, c.ape_mat, c.nombres, dtgc.descripcion as cargo "
        . "from colaborador as c "
        . "inner join detalle_tabla_general as dtgc on dtgc.general = 1 and dtgc.id = c.cargo "
        . "where concat (c.ape_pat, ' ',c.ape_mat,' ', c.nombres) like '%" . $searchTerm . "%' and c.estado = 1 "
        . " order by c.ape_pat, c.ape_mat, c.nombres asc ";
$resultado = $conn->query($query);
$a_json = array();
$a_json_row = array();

if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $nombres = $row["ape_pat"] . " " . $row["ape_mat"] . " " . $row["nombres"];
        $dni = $row["dni"];
        $id = $row["id"];
        $cargo = $row['cargo'];
        $jornal = $row['jornal_dia'];
        $apellido_limpio = limpia_espacios($row["ape_pat"]);
        $usuario = strtolower($row['nombres'][0]. $apellido_limpio . $row["ape_mat"][0]);
        $a_json_row['value'] = $dni . " | " . $nombres;
        $a_json_row['codigo'] = $id;
        $a_json_row['nombres'] = $nombres;
        $a_json_row['dni'] = $dni;
        $a_json_row['cargo'] = $cargo;
        $a_json_row['jornal'] = $jornal;
        $a_json_row['usuario'] = $usuario;        
        array_push($a_json, $a_json_row);
    }
}
echo json_encode($a_json);
flush();
$conn->close();

?>