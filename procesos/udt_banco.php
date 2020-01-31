<?php
require '../class/cl_banco.php';

$c_banco = new cl_banco();

$c_banco->setCodigo(filter_input(INPUT_POST,'input_codigo'));
$c_banco->setNombre(filter_input(INPUT_POST,'input_nombre'));
$c_banco->setCuenta(filter_input(INPUT_POST,'input_cuenta'));
$c_banco->setMoneda(filter_input(INPUT_POST,'select_moneda'));
$c_banco->setMonto(filter_input(INPUT_POST,'input_inicial'));


if ($c_banco->actualizar())
{
    header("Location: ../ver_bancos.php");
}

