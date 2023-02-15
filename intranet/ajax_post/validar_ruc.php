<?php

require '../class/cl_entidad.php';
$c_entidad = new cl_entidad();

$ruc = filter_input(INPUT_POST, 'ruc');
$c_entidad->setRuc($ruc);
if (strlen($ruc) == 8) {
    $direcion = 'https://goempresarial.com/apis/peru-consult-api/public/api/v1/dni/' . $ruc . '?token=abcxyz';
} else {
    $direcion = 'https://goempresarial.com/apis/peru-consult-api/public/api/v1/ruc/' . $ruc . '?token=abcxyz';
}

$encontrado_entidad = false;
//$encontrado_entidad = $c_entidad->buscar_ruc();
$fila_ruc = array();
if ($encontrado_entidad) {
    $array_ruc = array();
    $a_ruc = $c_entidad->datos_ruc();
    if ($a_ruc) {
        $fila_ruc['razonSocial'] = $c_entidad->getRazon_social();
        $fila_ruc['nombreComercial'] = $c_entidad->getNombre_comercial();
        $fila_ruc['direccion'] = $c_entidad->getDireccion();
        $fila_ruc['condicion'] = 'HABIDO';
        $fila_ruc['estado'] = 'ACTIVO';
    }
    array_push($array_ruc, $fila_ruc);
    $rpt = (object)array(
        "success" => "existe",
        "result" => $fila_ruc
    );
    echo json_encode($rpt);
    //echo json_encode($fila_ruc);
} else {
    $json_ruc = file_get_contents($direcion, FALSE);
    // Check for errors
    if ($json_ruc === FALSE) {
        die('Error');
    }

    $rpt = (object)array(
        "success" => "nuevo",
        "result" => json_decode($json_ruc, true)
    );
    echo json_encode($rpt);

    //echo $json_ruc;
}

