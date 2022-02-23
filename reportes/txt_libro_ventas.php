<meta http-equiv='cache-control' content='no-cache'>
<meta http-equiv='expires' content='0'>
<meta http-equiv='pragma' content='no-cache'>

<?php

require '../class/cl_venta.php';
require '../class/cl_venta_amarre.php';
require '../class/cl_varios.php';

$cl_venta = new cl_venta();
$cl_varios = new cl_varios();
$cl_amarre = new cl_venta_amarre();

$periodo = filter_input(INPUT_GET, 'input_periodo');

$file_txt = "LE20531757590" . $periodo . "00140100001111.txt";
$archivo = fopen($file_txt, "w");

$cl_venta->setPeriodo($periodo);
$a_ventas = $cl_venta->ver_ventas();
$contar = 1;
foreach ($a_ventas as $value) {
    //print_r($value);
    //echo "<br>";

    $fecha_doc = $value['fecha_factura'];
    $date = new DateTime($fecha_doc);
    $formato_fecha_doc = $date->format('Ymd');
    // echo "<br>" . $formato_fecha_doc;
    $fecha_periodo = $periodo . "00";
    //echo "<br>" . $fecha_periodo;
    if ($formato_fecha_doc < $fecha_periodo) {
        $estado = 8;
    } else {
        $estado = 1;
    }
    // echo "<br>" . $estado;
    $documento_proveedor = $value['ruc_cliente'];
    if (strlen($documento_proveedor) == 11) {
        $tipo_doc_proveedor = 6;
    }
    if (strlen($documento_proveedor) == 8) {
        $tipo_doc_proveedor = 1;
    }
    if (strlen($documento_proveedor) < 8) {
        $tipo_doc_proveedor = 0;
    }
    
    if ($documento_proveedor == "00000000000") {
           $tipo_doc_proveedor = 0;
    }

    $fecha_amarre = "";
    $doc_amarre = "";
    $serie_amarre = "";
    $numero_amarre = "";

    if ($value['tipo_documento'] == 14) {
        $cl_amarre->setIdVenta($value['codigo']);
        $cl_amarre->setPeriodo($value['periodo']);
        $cl_amarre->obtener_datos();
        $fecha_amarre = $cl_varios->fecha_mysql_web($cl_amarre->getFecha());
        if ($cl_amarre->getIdTido() == 3) {
            $doc_amarre = "03";
        }
        if ($cl_amarre->getIdTido() == 4) {
            $doc_amarre = "01";
        }
        $serie_amarre = $cl_amarre->getSerie();
        $numero_amarre = $cl_amarre->getNumero();
    }

    if ($value['id_moneda'] == 1) {
        $moneda = "PEN";
    }

    if ($value['id_moneda'] == 2) {
        $moneda = "USD";
    }

        $date = date_create($value['fecha_factura']);
        $periodo_doc= date_format($date,"Ym");

    $serie_doc = $value['serie'];
    $cod_sunat = $value['sunat'];
    $serie_doc = $cl_varios->zerofill($value['serie'], 4);

    $monto_total_soles = $value['total'] * $value['tipo_cambio'];
    $base = $monto_total_soles / 1.18;
    $igv = $base * 0.18;
    $contenido = $periodo_doc . "00|" .
        $cl_varios->zerofill($value['codigo'], 4) . "|" .
        "M1|" .
        $cl_varios->fecha_mysql_web($value['fecha_factura']) . "|" .
        "|" .
        $cl_varios->zerofill($value['sunat'], 2) . "|" .
        strtoupper($serie_doc) . "|" .
        $value['numero'] . "|" .
        "|" .
        $tipo_doc_proveedor . "|" .
        $documento_proveedor . "|" .
        utf8_decode($value['cliente']) . "|" .
        "|" .
        number_format($base, 2, ".", "") . "|" .
        "0.00|" .
        number_format($igv, 2, ".", "") . "|" .
        "0.00|" .
        "0.00|" .
        "0.00|" .
        "0.00|" .
        "0.00|" .
        "0.00|" .
        "0.00|" .
        "0.00|" .
        number_format($monto_total_soles, 2, ".", "") . "|" .
        $moneda . "|" .
        $value['tipo_cambio'] .
        "|" . $fecha_amarre .
        "|" . $doc_amarre .
        "|" . $serie_amarre .
        "|" . $numero_amarre .
        "|" .
        "|" .
        "|" .
        "|" .
        $estado . "|";
    fwrite($archivo, $contenido . PHP_EOL);
}

fclose($archivo);

echo "archivo generado correctamente, haga clic aqui para <a download href='" . $file_txt . "' >descargar</a>";
