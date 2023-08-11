<?php
require_once '../fixed/cargarSession.php';
require '../../models/ParametrosOpciones.php';

$ParametroValor = new ParametrosOpciones();

$ParametroValor->setIdparametro(filter_input(INPUT_POST, 'input-parametro-id'));
$ParametroValor->setDescripcion(filter_input(INPUT_POST, 'input-descripcion'));
$ParametroValor->setValor1(filter_input(INPUT_POST, 'input-valor1'));
$ParametroValor->setValor2(filter_input(INPUT_POST, 'input-valor2'));

$ParametroValor->obtenerId();
$ParametroValor->insertar();

header("Location: ../contents/lista-parametros.php?tipo=" . $ParametroValor->getIdparametro());