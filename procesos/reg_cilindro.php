<?php

require '../class/cl_cilindro.php';

$cl_cilindro = new cl_cilindro();

$cl_cilindro->setCodigo(strtoupper(filter_input(INPUT_POST, 'input_codigo')));
$cl_cilindro->setGas(filter_input(INPUT_POST, 'select_gas'));
$cl_cilindro->setCapacidad(filter_input(INPUT_POST, 'input_capacidad'));
$cl_cilindro->setEstado(0);

$grabado= $cl_cilindro->insertar();


if ($grabado) {
    header('Location: ../ver_cilindros.php');
} else {
    header('Location: ../reg_cilindro.php');
}


