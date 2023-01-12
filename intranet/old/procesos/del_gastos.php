<?php

require '../class/cl_gastos.php';
require '../class/cl_movimiento_banco.php';

$gastos =new cl_gastos();
$movimiento=new cl_movimiento_banco();

$movimiento->setMovimiento(filter_input(INPUT_GET, 'idM'));
$gastos->setIdMovimiento(filter_input(INPUT_GET, 'idM'));

if($gastos->eliminar()){
    if ($movimiento->eliminar())
        header("Location: ../ver_gastos.php");
}