<?php

require '../class/cl_orden_cliente.php';
require '../class/cl_varios.php';

$cl_orden = new cl_orden_cliente();
$cl_varios = new cl_varios();

$cl_orden->setCodigo(filter_input(INPUT_POST, 'input_codigo'));
$cl_orden->setCliente(filter_input(INPUT_POST, 'select_cliente'));
$cl_orden->setSucursal(filter_input(INPUT_POST, 'select_sucursal'));
$cl_orden->setFecha(filter_input(INPUT_POST, 'input_fecha'));
$cl_orden->setFecha($cl_varios->fecha_web_mysql($cl_orden->getFecha()));
$cl_orden->setGlosa(strtoupper(addslashes(filter_input(INPUT_POST, 'input_glosa'))));
$cl_orden->setMoneda(filter_input(INPUT_POST, 'select_moneda'));
$cl_orden->setMonto(filter_input(INPUT_POST, 'input_total'));

if (isset($_FILES["file"])) {


    $file = $_FILES['file']['name'];
    $file_temporal = $_FILES['file']['tmp_name'];

    $validextensions = array("pdf", "PDF");
    $temporary = explode(".", $_FILES["file"]["name"]);
    $file_extension = end($temporary);

    if ($_FILES["file"]["type"] == "application/pdf" && ($_FILES["file"]["size"] < 50000000) && in_array($file_extension, $validextensions)) {
        if ($_FILES["file"]["error"] > 0) {
            echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
        } else {
            $directorio = "../upload/" . $cl_orden->getCliente() . "/" . $cl_orden->getSucursal() . "/orden_cliente/";
            if (!mkdir($directorio, 0777, true)) {
                //die('Fallo al crear las carpetas...');
            }
            $cl_orden->setArchivo($cl_orden->getCodigo() . '.' . $file_extension);

            if (move_uploaded_file($file_temporal, $directorio . $cl_orden->getArchivo())) {
                print "El archivo fue subido con éxito.";
                global $conn;

                $grabado = $cl_orden->i_orden();

                if ($grabado) {
                ?>
                    <script>
                    window.location.href = "../ver_ordenes.php";
                    </script>
                    <?php
                }
            } else {
                print "Error al intentar subir el archivo.";
            }
        }
    } else {
        echo "el archivo no cumple con las caracteristicas";
        echo $_FILES["file"]["type"];
        echo $file_extension;
    }
} else {
    echo "no se ha seleccionado ningun documento";
}
ob_end_flush();
