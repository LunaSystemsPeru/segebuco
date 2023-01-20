<?php
include '../../models/TareaDiaria.php';

$Tarea = new TareaDiaria();
// $trabajadores = filter_input(INPUT_POST,'input-trabajadores');

$Tarea->setFecharegistro(filter_input(INPUT_POST,'input-registro'));
$Tarea->setFechainicio(filter_input(INPUT_POST,'input-inicio'));
$Tarea->setFechatermino(filter_input(INPUT_POST,'input-fin'));
$Tarea->setIdsupervisor(1);
// $Tarea->setIdsupervisor(filter_input(INPUT_POST,'input-supervisor'));
$Tarea->setIdmaestro(1);
$Tarea->setEstado(1);
$Tarea->setIdembarcacion(1);
// $Tarea->setIdembarcacion(filter_input(INPUT_POST,'input-embarcacion'));
$Tarea->setDescripcion(filter_input(INPUT_POST,'input-tareas'));
$Tarea->setDireccion(filter_input(INPUT_POST,'input-direccion'));
$Tarea->obtenerId();

$Tarea->insertar();
// foreach($trabajadores as $lista){

// }

$respuesta = array(
    'success' => true,
    'mensagess' => 'Tarea Registrado'
);

echo json_encode($respuesta);