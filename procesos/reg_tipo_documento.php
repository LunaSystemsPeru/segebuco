<?php

require '../class/cl_tipo_documento.php';
$cl_tido = new cl_tipo_documento();

$cl_tido->setNombre(strtoupper(filter_input(INPUT_POST, 'input_descripcion')));
$cl_tido->setCorto(strtoupper(filter_input(INPUT_POST, 'input_abreviatura')));
$cl_tido->setSunat(filter_input(INPUT_POST, 'input_sunat'));
$cl_tido->setSerie(filter_input(INPUT_POST, 'input_serie'));
$cl_tido->setNumero(filter_input(INPUT_POST, 'input_numero'));
$cl_tido->setCodigo($cl_tido->obtener_codigo());

$registrado = $cl_tido->i_documento();

if ($registrado) {
    header ('Location: ../ver_tipo_documentos.php');
}
