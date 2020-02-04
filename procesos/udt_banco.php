<?php
require '../class/cl_banco.php';

$c_banco = new cl_banco();

$c_banco->setCodigo(filter_input(INPUT_POST,'input_codigo'));
$c_banco->setNombre(filter_input(INPUT_POST,'input_nombr'));
$c_banco->setCuenta(filter_input(INPUT_POST,'input_cuent'));
$c_banco->setMoneda(filter_input(INPUT_POST,'select_moned'));
$c_banco->setMonto(filter_input(INPUT_POST,'input_inicia'));


if ($c_banco->actualizar())
{
    header("Location: ../ver_bancos.php");
}

