<?php
require '../../models/ParametroDetalle.php';
$Detalle = new ParametroDetalle();

$Detalle->setId(2);
$Detalle->obtenerDatos();
$interes = $Detalle->getDescripcion();

$valorinteres = 0;
$constante = 0;

$idformapago = filter_input(INPUT_POST, 'idforma');
$Detalle->setId($idformapago);
$Detalle->obtenerDatos();
$constante = $Detalle->getValor();

//$valorinteres = pow((1 + $interes),$constante) - 1;

echo $constante;
