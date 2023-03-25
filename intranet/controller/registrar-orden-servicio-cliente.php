<?php
include '../../models/OrdenServicioCliente.php';

$Servicio = new OrdenServicioCliente();

$Servicio->setNroorden(filter_input(INPUT_POST,'nro-orden'));
$Servicio->setFechaorden(filter_input(INPUT_POST,'fecha-orden'));
$Servicio->setIdcliente(filter_input(INPUT_POST,'id-cliente'));
$Servicio->setIdmoneda(filter_input(INPUT_POST,'id-moneda'));
$Servicio->setMontoorden(filter_input(INPUT_POST,'monto'));
// $Servicio->setEstado(filter_input(INPUT_POST,'estado'));
$Servicio->setEstado("0");
$Servicio->setNombre(filter_input(INPUT_POST,'nombre-corto'));
$Servicio->setIdusuario("0");
$Servicio->setPorcentaje("0");

$Servicio->obtenerId();
$Servicio->insertar();

$resultado = array('success'=>true);
echo json_encode($resultado);