<?php

require '../class/cl_entrega_epp.php';
require '../class/cl_varios.php';

$cl_varios = new cl_varios();
$cl_entrega = new cl_entrega_epp();

$cl_entrega->setColaborador(filter_input(INPUT_POST, 'id_empleado'));
$cl_entrega->setEpp(filter_input(INPUT_POST, 'id_epp'));
$cl_entrega->setCodigo(filter_input(INPUT_POST, 'id_entrega'));
$devolucion = filter_input(INPUT_POST, 'fecha_devolucion');
$cl_entrega->setDevolucion($devolucion);

$actualizar = $cl_entrega->devolver();

if ($actualizar) {
    header('Location: ../ver_entrega_epp.php?codigo=' . $cl_entrega->getColaborador());
} else {
//    header('Location: ../ver_entrega_epp.php?codigo=' . $cl_entrega->getColaborador());
}