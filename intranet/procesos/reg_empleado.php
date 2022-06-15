<?php

require '../class/cl_empleado.php';
require '../class/cl_varios.php';

$cl_empleado = new cl_empleado();
$cl_varios = new cl_varios();

if (filter_input(INPUT_POST, 'input_dni') == '') {
    header('Location ../reg_empleado.php');
}

$cl_empleado->setCodigo($cl_empleado->obtener_id());
$cl_empleado->setDni(filter_input(INPUT_POST, 'input_dni'));
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

$registrado = $cl_empleado->i_empleado();

if ($registrado) {
    header('Location: ../ver_empleados.php');
    echo "registrado";
} else {
    echo 'error al registrar';
}
