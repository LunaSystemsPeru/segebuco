<?php

//session_start();
require '../class/cl_cotizacion.php';
require '../class/cl_varios.php';

$cl_varios = new cl_varios();
$cl_cotizacion = new cl_cotizacion();

$cl_cotizacion->setAtencion(strtoupper(filter_input(INPUT_POST, 'input_atencion')));
$cl_cotizacion->setSolicitante(strtoupper(filter_input(INPUT_POST, 'input_solicitante')));
$cl_cotizacion->setCliente(filter_input(INPUT_POST, 'select_cliente'));
$cl_cotizacion->setSucursal(filter_input(INPUT_POST, 'select_sucursal'));
$cl_cotizacion->setFecha($cl_varios->fecha_web_mysql(filter_input(INPUT_POST, 'input_fecha')));
$cl_cotizacion->setDescripcion(strtoupper(filter_input(INPUT_POST, 'input_descripcion')));
$cl_cotizacion->setMoneda(filter_input(INPUT_POST, 'select_moneda'));
$cl_cotizacion->setMonto(filter_input(INPUT_POST, 'input_subtotal'));
$cl_cotizacion->setDias(filter_input(INPUT_POST, 'input_duracion'));
$cl_cotizacion->setTipo_servicio(filter_input(INPUT_POST, 'select_servicio'));
$cl_cotizacion->setForma_pago(filter_input(INPUT_POST, 'select_pago'));
if (filter_input(INPUT_POST, 'incluye_igv') !== null) {
    $cl_cotizacion->setIncluye_igv(filter_input(INPUT_POST, 'incluye_igv'));    
} else {
    $cl_cotizacion->setIncluye_igv(0);
}

$cl_cotizacion->setNumero(filter_input(INPUT_POST, 'input_codigo'));
//$cl_cotizacion->setNumero($cl_cotizacion->obtener_id());
$cl_cotizacion->setVersion(1);
$cl_cotizacion->setCodigo($cl_varios->fecha_cotizacion($cl_cotizacion->getFecha()) . '-P' . $cl_varios->zerofill($cl_cotizacion->getNumero(), 2) . '-V01');

if (isset($_FILES["file"])) {


    $file = $_FILES['file']['name'];
    $file_temporal = $_FILES['file']['tmp_name'];

    $validextensions = array("pdf", "PDF", "doc", "docx", "DOC", "DOCX");
    $temporary = explode(".", $_FILES["file"]["name"]);
    $file_extension = end($temporary);
//$_FILES["file"]["type"] == "application/pdf" &&
    if ( ($_FILES["file"]["size"] < 50000000) && in_array($file_extension, $validextensions)) {
        if ($_FILES["file"]["error"] > 0) {
            echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
        } else {
            $directorio = "../upload/" . $cl_cotizacion->getCliente() . "/" . $cl_cotizacion->getSucursal() . "/cotizacion/";
            echo $directorio;
            if (!mkdir($directorio, 0777, true)) {
                //die('Fallo al crear las carpetas...');
            }

            $cl_cotizacion->setArchivo($cl_cotizacion->getCodigo() . '.' . $file_extension);

            if (move_uploaded_file($file_temporal, $directorio . $cl_cotizacion->getArchivo())) {
                //print "El archivo fue subido con éxito.";
                $registrado = $cl_cotizacion->insertar();

                if ($registrado) {
                    ?>
                    <script>
                        window.location.href = "../ver_cotizaciones.php";
                    </script>
                    <?php
                }
            } else {
                print "Error al intentar subir el archivo.";
            }
        }
    } else {
        echo "el archivo no cumple con las caracteristicas <br/>";
        echo $_FILES["file"]["type"] . "<br/>";
        echo $file_extension;
    }
} else {
    echo "no se ha seleccionado ningun documento";
}