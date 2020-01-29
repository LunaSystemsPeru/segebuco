<?php
session_start();
ini_set('session.cache_expire', 200000);
ini_set('session.cache_limiter', 'none');
ini_set('session.cookie_lifetime', 2000000);
ini_set('session.gc_maxlifetime', 200000); //el mas importante 

require '../class/cl_usuario.php';

$cl_usuario = new cl_usuario();

$cl_usuario->setUsuario(filter_input(INPUT_POST, 'input_usuario'));
$cl_usuario->setPass(filter_input(INPUT_POST, 'input_contrasena'));

$grabado = $cl_usuario->validar_usuario();


if ($grabado) {
    $_SESSION["usuario"] = $cl_usuario->getUsuario();
    $_SESSION["almacen"] = $cl_usuario->getAlmacen();
    $_SESSION["empleado"] = $cl_usuario->getEmpleado();
    header('Location: ../index.php');
} else {
    header('Location: ../login.php?error=true');
}


