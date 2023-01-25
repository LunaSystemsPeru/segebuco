<?php
include '../../models/TareaDiaria.php';
include '../../models/TareaColaboradores.php';

$Tarea = new TareaDiaria();
$Colaboradores = new TareaColaboradores();
$trabajadores = json_decode(filter_input(INPUT_POST,'input-trabajadores'));

$Tarea->setFecharegistro(filter_input(INPUT_POST,'input-registro'));
$Tarea->setFechainicio(filter_input(INPUT_POST,'input-inicio'));
$Tarea->setFechatermino(filter_input(INPUT_POST,'input-fin'));
$Tarea->setIdmaestro(filter_input(INPUT_POST,'select-maestro'));
$Tarea->setEstado(0);
$Tarea->setIdembarcacion(filter_input(INPUT_POST,'select-embarcacion'));
$Tarea->setMotorista(filter_input(INPUT_POST,'input-motorista'));
$Tarea->setDescripcion(filter_input(INPUT_POST,'input-descripcion'));
$Tarea->setGuia(1);
// $Tarea->setGuia(filter_input(INPUT_POST,'input-guia'));
$Tarea->setIdcotizacion(filter_input(INPUT_POST,'input-cotizacion'));
$Tarea->setIdcotizacion(1); 
$Tarea->setIdtiposervicio(filter_input(INPUT_POST,'select-servicio'));
$Tarea->setNombre(filter_input(INPUT_POST,'input-nombre'));
$Tarea->obtenerId();

$Tarea->insertar();

foreach($trabajadores as $lista){
    $Colaboradores->setIdtarea($Tarea->getId());
    $Colaboradores->setIdcolaborador($lista->id);
    $Colaboradores->obtenerId();

    $Colaboradores->insertar();
}

$respuesta = array(
    'success' => true,
    'mensagess' => 'Tarea Registrado'
);

echo json_encode($respuesta);