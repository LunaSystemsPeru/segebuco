<?php

require '../class/cl_entidad.php';
$c_entidad = new cl_entidad();

$ruc = filter_input(INPUT_POST, 'ruc');
$c_entidad->setRuc($ruc);
//$direcion = 'https://www.conmetal.pe/erp/ajax_post/consulta_ruc_nubefact.php?ruc=' . $ruc;
if (strlen($ruc) == 8) {
    $direcion = 'http://lunasystemsperu.com/consultas_json/composer/consultas_dni_JMP.php?dni=' . $ruc;
} else {
    //$direcion = 'http://lunasystemsperu.com/consultas_json/composer/consulta_sunat_JMP.php?ruc=' . $ruc;
    $direcion = "http://lunasystemsperu.com/apis/apiruc.php?ruc=" . $ruc;
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
    $rpt = (object) array(
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

    $rpt = (object) array(
        "success" => "nuevo",
        "result" => json_decode($json_ruc, true)
    );
    echo json_encode($rpt);

    //echo $json_ruc;
}

