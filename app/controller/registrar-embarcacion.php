<?php
include '../../models/Embarcacion.php';

$Embarcacion = new Embarcacion();

$Embarcacion->setNombre(filter_input(INPUT_POST,'input-nombre'));
$Embarcacion->setIdcliente(filter_input(INPUT_POST,'select-cliente'));
$Embarcacion->obtenerId();

$Embarcacion->insertar();

$resultado = array('success' => true, 'id' => $Embarcacion->getId(), 'nombre'=>$Embarcacion->getNombre());
echo json_encode($resultado);