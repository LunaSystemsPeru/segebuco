<?php
include '../../models/GuiasRemision.php';
include '../../models/Sedes.php';
include '../../models/VehiculoEmpresa.php';

$Guia = new GuiasRemision();
$Sede = new Sedes();
$Vehiculo = new VehiculoEmpresa();

//obcion temporal
$Sede->obtenerId();
$Sede->insertar();
$Vehiculo->obtenerId();
$Vehiculo->insertar();

$Guia->setFechaemision(filter_input(INPUT_POST,'fecha-emision'));
$Guia->setSerie(filter_input(INPUT_POST,'serie'));
$Guia->setNro(filter_input(INPUT_POST,'nro'));
// $Guia->setIdorigen(filter_input(INPUT_POST,'id-sede'));
$Guia->setIdorigen($Sede->getId());
$Guia->setUbigeodestino(filter_input(INPUT_POST,'ubigeo-destino'));
$Guia->setDirecciondestino(filter_input(INPUT_POST,'direccion-destino'));
// $Guia->setIdvehiculo(filter_input(INPUT_POST,'id-vehiculo'));
$Guia->setIdvehiculo($Vehiculo->getId());

$Guia->obtenerId();
$Guia->insertar();

$respuesta = array(
    'success' => true,
    'mensaje' => 'Registrado exitoso'
);

echo json_encode($respuesta);