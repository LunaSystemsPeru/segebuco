<?php
require '../class/cl_material_compras.php';

$Material = new cl_material_compras();

$Material->setMaterialid(filter_input(INPUT_POST, 'materialid'));
$Material->setFecha(filter_input(INPUT_POST, 'fecha'));
$Material->setCosto(filter_input(INPUT_POST, 'costo'));

$Material->insetar();

//header("Location: ../reg_compra_material.php");
