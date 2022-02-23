<meta http-equiv='cache-control' content='no-cache'>
<meta http-equiv='expires' content='0'>
<meta http-equiv='pragma' content='no-cache'>

<?php

require '../class/cl_compra.php';
require '../class/cl_varios.php';
require '../class/cl_compra_amarre.php';

$cl_compra = new cl_compra();
$cl_varios = new cl_varios();
$cl_amarre = new cl_compra_amarre();

$periodo = filter_input(INPUT_GET, 'input_periodo');

$file_txt = "LE20531757590" . $periodo . "00080100001111.txt";
$archivo = fopen($file_txt, "w");

$cl_compra->setPeriodo($periodo);
$a_compras = $cl_compra->ver_compras();
$contar = 1;
foreach ($a_compras as $value) {
    //print_r($value);
    //echo "<br>";

    $fecha_doc = $value['fecha_compra'];
    $date = new DateTime($fecha_doc);
    $formato_fecha_doc = $date->format('Ymd');
    // echo "<br>" . $formato_fecha_doc;
    $fecha_periodo = $periodo . "00";
    //echo "<br>" . $fecha_periodo;
    if ($formato_fecha_doc < $fecha_periodo) {
        $estado = 6;
    } else {
        $estado = 1;
    }
    // echo "<br>" . $estado;
    $documento_proveedor = $value['ruc_proveedor'];
    if (strlen($documento_proveedor) == 11) {
        $tipo_doc_proveedor = 6;
    }
    if (strlen($documento_proveedor) == 8) {
        $tipo_doc_proveedor = 1;
    }
    if (strlen($documento_proveedor) < 8) {
        $tipo_doc_proveedor = 0;
    }

    $fecha_amarre = "";
    $doc_amarre = "";
    $serie_amarre = "";
    $numero_amarre = "";

    if ($value['tipo_documento'] == 14) {
        $cl_amarre->setIdCompra($value['codigo']);
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

    $serie_doc = $value['serie'];
    $cod_sunat = $value['sunat'];
    if ($cod_sunat == 1) {
        $serie_doc = $cl_varios->zerofill($value['serie'], 4);
    }
    if ($cod_sunat == 2) {
        $serie_doc = $cl_varios->zerofill($value['serie'], 4);
    }
    if ($cod_sunat == 3) {
        $serie_doc = $cl_varios->zerofill($value['serie'], 4);
    }
    if ($cod_sunat == 4) {
        $serie_doc = $cl_varios->zerofill($value['serie'], 4);
    }
    if ($cod_sunat == 6) {
        $serie_doc = $cl_varios->zerofill($value['serie'], 4);
    }
    if ($cod_sunat == 7) {
        $serie_doc = $cl_varios->zerofill($value['serie'], 4);
    }
    if ($cod_sunat == 8) {
        $serie_doc = $cl_varios->zerofill($value['serie'], 4);
    }

    if ($value['id_moneda'] == 1) {
        $moneda = "PEN";
    }

    if ($value['id_moneda'] == 2) {
        $moneda = "USD";
    }

    $monto_total_soles = $value['total'] * $value['tipo_cambio'];
    $igv = $value['igv'] * $value['tipo_cambio'];
    $base = $monto_total_soles - $igv;
    $contenido = $cl_compra->getPeriodo() . "00|" .
        $cl_varios->zerofill($value['codigo'], 4) . "|" .
        "M3|" .
        $cl_varios->fecha_mysql_web($value['fecha_compra']) . "|" .
        $cl_varios->fecha_mysql_web($value['fecha_compra']) . "|" .
        $cl_varios->zerofill($value['sunat'], 2) . "|" .
        strtoupper($serie_doc) . "|" .
        "|" .
        $value['numero'] . "|" .
        "|" .
        $tipo_doc_proveedor . "|" .
        $documento_proveedor . "|" .
        utf8_decode($value['proveedor']) . "|" .
        number_format($base, 2, ".", "") . "|" .
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
        $value['tipo_cambio'] . "|" .
        $fecha_amarre . "|" .
        $doc_amarre . "|" .
        $serie_amarre . "|" .
        "|" .
        $numero_amarre . "|" .
        "|" .
        "|" .
        "|" .
        "|" .
        "|" .
        "|" .
        "|" .
        "|" .
        "|" .
        "|" .
        $estado . "|";
    fwrite($archivo, $contenido . PHP_EOL);
}

fclose($archivo);

$file_compra_txt = "LE20531757590" . $periodo . "00080200001011.txt";
$archivo_no = fopen($file_compra_txt, "w");
fwrite($archivo_no, "");
fclose($archivo_no);
?>

<h2>Archivos Generados</h2>
<p>Libro de Compras - clic aqui <a download href="<?php echo $file_txt ?>">Descargar</a></p>
<p>Libro de Compras no Domiciliado - clic aqui <a download href="<?php echo $file_compra_txt ?>">Descargar</a></p>
