<?php
include '../../models/TareaDiaria.php';
include '../../models/Colaboradores.php';
include '../../models/Embarcacion.php';

$Tarea = new TareaDiaria();
$Maestro = new Colaboradores();
$Embarcacion = new Embarcacion();

$Tarea->setId(filter_input(INPUT_POST, 'id-tarea'));
$Tarea->obtenerDatos();

$Maestro->setId($Tarea->getIdmaestro());
$Maestro->obtenerDatos();

$Embarcacion->setId($Tarea->getIdembarcacion());
$Embarcacion->obtenerDatos();

echo json_encode(array ('id_tarea'=>$Tarea->getId(),'descripcion' => $Tarea->getDescripcion(),'maestro' => $Maestro->getDatos(), 'id_embarcacion'=>$Tarea->getIdembarcacion(), 'id_cliente'=>$Embarcacion->getIdcliente()));