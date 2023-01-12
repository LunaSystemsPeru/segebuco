<?php
session_start();
require '../class/cl_usuario.php';

$cl_usuario = new cl_usuario();

$cl_usuario->setUsuario(filter_input(INPUT_POST, 'input_usuario'));
$cl_usuario->setAlmacen(filter_input(INPUT_POST, 'select_almacen'));
$cl_usuario->setPass(filter_input(INPUT_POST, 'input_contra'));


$modificado = $cl_usuario->modificar();

if ($modificado) {
    $_SESSION['almacen'] = $cl_usuario->getAlmacen();
    header('Location: ../ver_perfil.php');
} else {
    header('Location: ../mod_perfil.php?usuario=' . $cl_usuario->getUsuario());
}


