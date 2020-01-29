<?php

require '../class/cl_materiales.php';
require '../class/cl_varios.php';
$cl_material = new cl_materiales();
$cl_varios = new cl_varios();

$cl_material->setId(filter_input(INPUT_POST, 'input_id'));
$cl_material->setDescripcion(strtoupper(filter_input(INPUT_POST, 'input_descripcion')));
$cl_material->setPrecio(filter_input(INPUT_POST, 'input_precio'));
$cl_material->setUnidad(7);
$cl_material->setImagen(filter_input(INPUT_POST, 'input_imagen_anterior'));

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
            $directorio = "../images/materiales/";
            $cl_material->setImagen($cl_material->getId() . '.' . $file_extension);

            if (!mkdir($directorio, 0777, true)) {
                //die('Fallo al crear las carpetas...');
            }
            
            if (move_uploaded_file($file_temporal, $directorio . $cl_material->getImagen())) {
                print "El archivo fue subido con éxito.";
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

$actualizado = $cl_material->u_material();

if ($actualizado) {
    echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
}