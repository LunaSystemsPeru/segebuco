<?php
//recorrer las empreas
require '../../models/Empresa.php';

$Empresa = new Empresa();

$url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$rutabase = dirname($url) . DIRECTORY_SEPARATOR;

//echo $rutabase;

//$fecha = date("Y-m-d");
//$fecha = date("Y-m-d",strtotime($fecha."- 1 days"));

$fecha = filter_input(INPUT_GET, 'fecha');
//echo $rutabase;

$aempresas = $Empresa->verFilas();
foreach ($aempresas as $fila) {
    if ($fila['ubigeo']) {
        //por cada empresa enviar
        // reusmen boletsas
        //  resumen anulados
        // comunicacion de baja

        echo $fila['id_empresa'] . " nombre " . $fila['razon'] . "<br>" . PHP_EOL;
        $id_empresa = $fila['id_empresa'];


        $post = [
            'empresaid' => $id_empresa,
            'fecha' => $fecha
        ];

        // $tiempo_inicial = microtime(true);
        // echo $tiempo_inicial . "<br>";

        //enviar RESUMEN ACTIVOS XML
        $ruta = $rutabase . "resumen-activos.php?empresaid=" . $id_empresa . "&fecha=" . $fecha;
        $ch_bolactivas = curl_init();
        curl_setopt($ch_bolactivas, CURLOPT_URL, $ruta);
        //curl_setopt($ch_factura, CURLOPT_POST, 0);
        //curl_setopt($ch_factura, CURLOPT_SSL_VERIFYPEER, false);
        //curl_setopt($ch_factura, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch_bolactivas, CURLOPT_RETURNTRANSFER, true);
        $respuesta_bolactivas = curl_exec($ch_bolactivas);
        curl_close($ch_bolactivas);

        echo PHP_EOL . " respuesta boletas activas " . "<br>" . PHP_EOL;
        print_r($respuesta_bolactivas);
        echo PHP_EOL. "<br>";

        //  $tiempoenvioanulados = microtime(true);
        //  echo $tiempoenvioanulados. "<br>";
        //enviar RESUMEN ANULADOS XML
        $ruta = $rutabase . "resumen-anulados.php?empresaid=" . $id_empresa . "&fecha=" . $fecha;
        $ch_bolanuladas = curl_init();
        curl_setopt($ch_bolanuladas, CURLOPT_URL, $ruta);
        // curl_setopt($ch_factura, CURLOPT_POST, 0);
        //curl_setopt($ch_factura, CURLOPT_SSL_VERIFYPEER, false);
        //curl_setopt($ch_factura, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch_bolanuladas, CURLOPT_RETURNTRANSFER, true);
        $respuesta_bolanuladas = curl_exec($ch_bolanuladas);
        curl_close($ch_bolanuladas);

        echo PHP_EOL . " respuesta boletas anuladas " . "<br>" . PHP_EOL;
        print_r($respuesta_bolanuladas);
        echo PHP_EOL. "<br>";

        //  $tiempoenviofacturasanuladas  = microtime(true);
        //  echo $tiempoenviofacturasanuladas. "<br>";

        //enviar FACTURAS ANULADAS XML
        $ruta = $rutabase . "comunicacion-baja.php?empresaid=" . $id_empresa . "&fecha=" . $fecha;
        $ch_baja = curl_init();
        curl_setopt($ch_baja, CURLOPT_URL, $ruta);
        //curl_setopt($ch_factura, CURLOPT_POST, 0);
        //curl_setopt($ch_factura, CURLOPT_SSL_VERIFYPEER, false);
        //curl_setopt($ch_factura, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch_baja, CURLOPT_RETURNTRANSFER, true);
        $respuesta_bajas = curl_exec($ch_baja);
        curl_close($ch_baja);

        echo PHP_EOL . " respuesta comunicacion baja " . "<br>" . PHP_EOL;
        print_r($respuesta_bajas);
        echo PHP_EOL. "<br>";

    }
}
