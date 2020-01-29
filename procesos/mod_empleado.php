<?php

require '../class/cl_empleado.php';
require '../class/cl_varios.php';

$cl_empleado = new cl_empleado();
$cl_varios = new cl_varios();

if (filter_input(INPUT_POST, 'input_codigo') == '') {
    header('Location ../ver_empleados.php');
}

$cl_empleado->setCodigo(filter_input(INPUT_POST, 'input_codigo'));
$cl_empleado->setNombres(filter_input(INPUT_POST, 'input_nombres'));
$cl_empleado->setPaterno(filter_input(INPUT_POST, 'input_paterno'));
$cl_empleado->setMaterno(filter_input(INPUT_POST, 'input_materno'));
$cl_empleado->setDireccion(strtoupper(filter_input(INPUT_POST, 'input_direccion')));
$cl_empleado->setEmail(strtolower(filter_input(INPUT_POST, 'input_email')));
$nacimiento = filter_input(INPUT_POST, 'input_nacimiento');
$cl_empleado->setFecha_nacimiento($cl_varios->fecha_web_mysql($nacimiento));
$cl_empleado->setGrado(filter_input(INPUT_POST, 'select_grado'));
$cl_empleado->setProfesion(strtoupper(filter_input(INPUT_POST, 'input_profesion')));
$cl_empleado->setCelular(filter_input(INPUT_POST, 'input_celular'));
$cl_empleado->setTelefono(filter_input(INPUT_POST, 'input_telefono'));
$cl_empleado->setCargo(filter_input(INPUT_POST, 'select_cargo'));
$cl_empleado->setCategoria(filter_input(INPUT_POST, 'select_categoria'));
$cl_empleado->setJornal(filter_input(INPUT_POST, 'input_jornal'));
$cl_empleado->setEstado_civil(filter_input(INPUT_POST, 'select_civil'));
$cl_empleado->setImagen(filter_input(INPUT_POST, 'input_imagen'));

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
            $directorio = "../upload/colaboradores/";
            $cl_empleado->setImagen($cl_empleado->getCodigo() . '.' . $file_extension);

            if (!mkdir($directorio, 0777, true)) {
                //die('Fallo al crear las carpetas...');
            }
            
            if (move_uploaded_file($file_temporal, $directorio . $cl_empleado->getImagen())) {
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

$registrado = $cl_empleado->modificar();

if ($registrado) {
    ?>
    <script>
        window.location.href = "../ver_empleados.php";
    </script>
    <?php
    echo "registrado";
} else {
    echo 'error al registrar';
}
