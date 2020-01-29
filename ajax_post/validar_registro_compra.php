<?php

require '../class/cl_compra.php';
$cl_compra = new cl_compra();

$cl_compra->setProveedor(filter_input(INPUT_POST, 'proveedor'));
$cl_compra->setTido(filter_input(INPUT_POST, 'tipo_documento'));
$cl_compra->setSerie(filter_input(INPUT_POST, 'serie'));
$cl_compra->setNumero(filter_input(INPUT_POST, 'numero'));

$existe = $cl_compra->validar_compra();

$a_json = array();
$a_json_row = array();

$a_json_row['existe'] = $existe;
$a_json_row['codigo'] = $cl_compra->getCodigo();
$a_json_row['periodo'] = $cl_compra->getPeriodo();
array_push($a_json, $a_json_row);
//$data = array("existe" => $existe, "codigo" => $cl_compra->getCodigo(), "periodo" => $cl_compra->getPeriodo());

//print_r(json_encode($data));
print_r (json_encode($a_json));

flush();
