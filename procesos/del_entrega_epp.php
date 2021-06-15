<?php

require '../class/cl_entrega_epp.php';

$cl_entrega = new cl_entrega_epp();

$cl_entrega->setColaborador(filter_input(INPUT_GET, 'empleado'));
$cl_entrega->setEpp(filter_input(INPUT_GET, 'epp'));
$cl_entrega->setCodigo(filter_input(INPUT_GET, 'codigo'));

$eliminado = $cl_entrega->eliminar();

if ($eliminado) {
    header('Location: ../ver_entrega_epp.php?codigo=' . $cl_entrega->getColaborador());
} else {
    header('Location: ../ver_entrega_epp.php?codigo=' . $cl_entrega->getColaborador());
}