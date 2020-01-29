<?php

require '../class/cl_tabla_general.php';
$cl_tabla = new cl_tabla_general();

$cl_tabla->setNombre(strtoupper(filter_input(INPUT_POST, 'input_descripcion')));

$grabado = $cl_tabla->i_tabla();

if ($grabado) {
    header("Location: ../ver_tabla_general.php");
}