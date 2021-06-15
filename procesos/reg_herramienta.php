<?php

require '../class/cl_herramientas.php';
require '../class/cl_varios.php';
$cl_herramientas = new cl_herramientas();
$cl_varios = new cl_varios();

$cl_herramientas->setId($cl_herramientas->obtener_id());
$cl_herramientas->setDescripcion(strtoupper(trim(filter_input(INPUT_POST, 'input_descripcion'))));
$cl_herramientas->setMarca(strtoupper(trim(filter_input(INPUT_POST, 'input_marca'))));
$cl_herramientas->setModelo(strtoupper(trim(filter_input(INPUT_POST, 'input_modelo'))));
$cl_herramientas->setSerie(strtoupper(trim(filter_input(INPUT_POST, 'input_serie'))));
$cl_herramientas->setPrecio(filter_input(INPUT_POST, 'input_precio'));
$cl_herramientas->setUnd_medida(7);
$cl_herramientas->setTipo(filter_input(INPUT_POST, 'select_tipo'));
$cl_herramientas->setImagen(filter_input(INPUT_POST, 'input_imagen'));
$cl_herramientas->setCaracteristicas(strtoupper(trim(filter_input(INPUT_POST, 'input_caracteristicas'))));

if (isset($_FILES["file"])) {
    $file = $_FILES['file']['name'];
    $file_temporal = $_FILES['file']['tmp_name'];

    $validextensions = array("jpeg", "jpg", "png", "JPG", "JPEG", "PNG");
    $temporary = explode(".", $_FILES["file"]["name"]);
    $file_extension = end($temporary);

    if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")) && ($_FILES["file"]["size"] < 1000000) && in_array($file_extension, $validextensions)) {
        if ($_FILES["file"]["error"] > 0) {
            echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
        } else {
            $directorio = "../images/herramientas/";
            $cl_herramientas->setImagen($cl_herramientas->getId() . '.' . $file_extension);

            if (!mkdir($directorio, 0777, true)) {
                //die('Fallo al crear las carpetas...');
            }
            
            if (move_uploaded_file($file_temporal, $directorio . $cl_herramientas->getImagen())) {
                print "El archivo fue subido con éxito.";
                header("Location: ../ver_herramientas.php");
            } else {
                print "error al subir le archivo";
            }
        }
    } else {
        echo "imagen no cumple con las caracteristicas";
        echo $_FILES["file"]["type"];
        echo $file_extension;
    }
} else {
    echo "no se ha seleccionado ninguna imagen";
}

$registrado = $cl_herramientas->insertar();

if ($registrado) {
    echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
}