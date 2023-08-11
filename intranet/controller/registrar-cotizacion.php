<?php
require_once '../fixed/cargarSession.php';
include '../../models/Cotizacion.php';
include '../../models/TareaDiaria.php';

$Cotizacion = new Cotizacion();
$Tarea = new TareaDiaria();

$Cotizacion->setNro(filter_input(INPUT_POST,'nro'));
$Cotizacion->setFeccotizacion(filter_input(INPUT_POST,'fecha-cotizacion'));
$Cotizacion->setIdusuario($_SESSION['usuario_id']);
$Cotizacion->setEstado(0);
$Cotizacion->setFecregistro(date("Y-m-d"));
$Cotizacion->setIdmoneda(filter_input(INPUT_POST,'id-moneda'));
$Cotizacion->setMoncotizacion(filter_input(INPUT_POST,'monto'));
$Cotizacion->setMonaprobado(0);
$Cotizacion->setNrosolped(filter_input(INPUT_POST,'nro-solped'));
$Cotizacion->setIdcliente(filter_input(INPUT_POST,'id-cliente'));
$Cotizacion->setDescripcion(filter_input(INPUT_POST,'descripcion'));
$Cotizacion->setIdembarcacion(filter_input(INPUT_POST,'id-embarcacion'));
// $Cotizacino->setIdorden(filter_input(INPUT_POST,'id-orden'));
$Cotizacion->obtenerId();

$Cotizacion->insertar();
/*
$Tarea->setId(filter_input(INPUT_POST,'tarea-diaria'));
$Tarea->setEstado("2");
$Tarea->setIdcotizacion($Cotizacion->getId());
$Tarea->modificarEstado();
*/

$resultado = array('success' => true);

echo json_encode(array('success' => true));