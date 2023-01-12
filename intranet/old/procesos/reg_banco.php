<?php
require '../class/cl_banco.php';

$cl_banco = new cl_banco();

$cl_banco->setCuenta(filter_input(INPUT_POST, 'input_cuenta'));
$cl_banco->setMoneda(filter_input(INPUT_POST, 'select_moneda'));
$cl_banco->setNombre(filter_input(INPUT_POST, 'input_nombre'));
$cl_banco->setMonto(filter_input(INPUT_POST, 'input_inicial'));
$cl_banco->setEstado(1);

$cl_banco->obtener_id();
$registrado = $cl_banco->insertar();

if ($registrado) {
    header("Location: ../ver_bancos.php");
}