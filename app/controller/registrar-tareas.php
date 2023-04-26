<?php
include '../../models/TareaDiaria.php';
include '../../models/TareaColaboradores.php';
include '../../models/Colaboradores.php';

$Tarea = new TareaDiaria();
$Trabajadores = new TareaColaboradores();
$Colaboradores = new Colaboradores();
$arraytrabajadores = json_decode(filter_input(INPUT_POST, 'input-trabajadores'));

$Tarea->setId(filter_input(INPUT_POST, 'hidden-id-tarea'));

// $Tarea->setFecharegistro(filter_input(INPUT_POST, 'input-registro'));
$Tarea->setFechainicio(filter_input(INPUT_POST, 'input-inicio'));
$Tarea->setFechatermino(filter_input(INPUT_POST, 'input-fin'));
$Tarea->setIdmaestro(filter_input(INPUT_POST, 'select-maestro'));
$Tarea->setEstado(filter_input(INPUT_POST, 'select-estado'));
$Tarea->setIdembarcacion(filter_input(INPUT_POST, 'select-embarcacion'));
$Tarea->setMotorista(filter_input(INPUT_POST, 'input-motorista'));
$Tarea->setDescripcion(filter_input(INPUT_POST, 'input-descripcion'));
// $Tarea->setGuia();
$Tarea->setGuia(filter_input(INPUT_POST, 'input-guia'));
$Tarea->setIdcotizacion(filter_input(INPUT_POST, 'input-cotizacion'));
$Tarea->setIdcotizacion(0);
// $Tarea->setIdcotizacion(1);
//$Tarea->setIdtiposervicio(filter_input(INPUT_POST, 'select-servicio'));
$Tarea->setIdtiposervicio(4);
$Tarea->setNombre(filter_input(INPUT_POST, 'input-nombre'));
$Tarea->setPorcentaje(filter_input(INPUT_POST, 'input-porcentaje'));


// Encaso que un maestro sola puede estar en una tarea
// $Colaboradores->setId($Tarea->getIdmaestro());
// $Colaboradores->setEstado(0);
// $Colaboradores->modificarEstado();
if($Tarea->getId()){
    $Tarea->modificar();
    $Trabajadores->setIdtarea($Tarea->getId());
    $Trabajadores->eliminar();
}else{
    $Tarea->obtenerId();
    $Tarea->insertar();
}


foreach ($arraytrabajadores as $lista) {
    $Trabajadores->setIdtarea($Tarea->getId());
    $Trabajadores->setIdcolaborador($lista->id);
    $Trabajadores->obtenerId();
    // $Colaboradores->setId($lista->id);
    // $Colaboradores->setEstado(0);
    //$Colaboradores->modificarEstado();
    $Trabajadores->insertar();
}

$respuesta = array(
    'success' => true,
    'mensagess' => 'Tarea Registrado'
);

echo json_encode($respuesta);
