<?php

require '../class/cl_entrega_epp.php';
require '../class/cl_varios.php';

$cl_entrega = new cl_entrega_epp();
$cl_varios = new cl_varios();

$cl_entrega->setColaborador(filter_input(INPUT_POST, 'input_id_colaborador'));
$cl_entrega->setCodigo($cl_entrega->obtener_id());
$cl_entrega->setEntrega($cl_varios->fecha_web_mysql(filter_input(INPUT_POST, 'fecha_entrega')));

$id_epp = (filter_input(INPUT_POST, 'array_idepp'));
$items_epp = json_decode($id_epp, true);

$elementCount = count($items_epp);

for ($x = 0; $x < $elementCount; $x++) {
    $cl_entrega->setEpp($items_epp [$x]);
    
    $cl_entrega->setDevolucion($cl_entrega->getEntrega());
    $cl_entrega->devolver_mismo_epp();
    
    $cl_entrega->insertar();
    
}

echo'<script type="text/javascript">'
 . 'window.location="../ver_entrega_epp.php?codigo=' . $cl_entrega->getColaborador() . '";'
 . '</script>';
