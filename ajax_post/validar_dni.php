<?php

require '../class/cl_empleado.php';
$cl_empleado = new cl_empleado();

$dni = filter_input(INPUT_POST, 'dni');

$direccion = 'http://lunasystemsperu.com/consultas_json/composer/consultas_dni_JMP.php?dni=' . $dni;
//$direccion = 'http://edunegociosperu.com/reniec-ws/?dni='. $dni;

$encontrado_dni = $cl_empleado->buscar_dni();
if ($encontrado_dni) {
    header('Location ../ver_empleados.php');
} else {
    $json_dni = file_get_contents($direccion, FALSE);

// Check for errors
    if ($json_dni === FALSE) {
        die('Error');
    }
    echo $json_dni;
}