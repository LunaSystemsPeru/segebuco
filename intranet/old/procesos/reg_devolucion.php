<?php

session_start();

require '../class/cl_devolucion.php';
require '../class/cl_devolucion_cilindro.php';
require '../class/cl_varios.php';

$cl_devolucion = new cl_devolucion();
$cl_cilindros = new cl_devolucion_cilindro();
$cl_varios = new cl_varios();

$cl_devolucion->setPeriodo(filter_input(INPUT_POST, 'input_periodo'));
$cl_devolucion->obtener_id();
$cl_devolucion->setId_documento(filter_input(INPUT_POST, 'select_documento'));
$cl_devolucion->setSerie(filter_input(INPUT_POST, 'input_serie'));
$cl_devolucion->setNumero(filter_input(INPUT_POST, 'input_numero'));
$cl_devolucion->setFecha($cl_varios->fecha_web_mysql(filter_input(INPUT_POST, 'input_fecha')));
$cl_devolucion->setId_proveedor(filter_input(INPUT_POST, 'input_ruc_proveedor'));
$cl_devolucion->setId_usuario($_SESSION['usuario']);
$cl_devolucion->setId_almacen($_SESSION['almacen']);

$registrado = $cl_devolucion->insertar();

if ($registrado) {
    $cl_cilindros->setPeriodo($cl_devolucion->getPeriodo());
    $cl_cilindros->setId($cl_devolucion->getId());

    $a_cilindros = $_SESSION['devolucion_botellas'];
    foreach ($a_cilindros as $item) {
        foreach ($item as $value) {
            $cl_cilindros->setId_cilindro($value['id']);
            $cl_cilindros->insertar();
        }
    }

    unset($_SESSION['devolucion_botellas']);

    header("Location: ../ver_devoluciones.php");
}
