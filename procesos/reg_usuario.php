<?php

require '../class/cl_usuario.php';

$cl_usuario = new cl_usuario();

$cl_usuario->setAlmacen(1);
$cl_usuario->setUsuario(filter_input(INPUT_POST, 'input_usuario'));
$cl_usuario->setEmpleado(filter_input(INPUT_POST, 'input_id_colaborador'));
$cl_usuario->setPass(filter_input(INPUT_POST, 'input_contrasena'));

$registrado = $cl_usuario->insertar();

if ($registrado) {
    header("Location: ../ver_usuarios.php");
}