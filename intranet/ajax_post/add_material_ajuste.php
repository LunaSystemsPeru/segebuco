<?php

session_start();
require '../session_class/cs_ajuste_materiales.php';
$cs_ajuste = new cs_ajuste_materiales();
require '../class/cl_varios.php';
$c_varios = new cl_varios();

$cs_ajuste->setId(filter_input(INPUT_POST, 'id_material'));
$cs_ajuste->setDescripcion(filter_input(INPUT_POST, 'descripcion'));
$cs_ajuste->setCosto(filter_input(INPUT_POST, 'costo'));
$cs_ajuste->setCsistema(filter_input(INPUT_POST, 'csistema'));
$cs_ajuste->setCencontrado(filter_input(INPUT_POST, 'cencontrado'));
$cs_ajuste->setMarca("");

$cs_ajuste->i_material();

include 'detalle_ajuste_material.php';
