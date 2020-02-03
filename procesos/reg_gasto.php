<?php
require '../class/cl_gastos.php';
require '../class/cl_movimiento_banco.php';

$c_gasto=new cl_gastos();
$c_movimiento=new cl_movimiento_banco();

$c_movimiento->setFecha(filter_input(INPUT_POST, 'fecha'));
$c_movimiento->setIdClasificacion(filter_input(INPUT_POST, 'id_clasifica'));
$c_movimiento->setBanco(filter_input(INPUT_POST, 'id_banco'));
$c_movimiento->setConcepto(filter_input(INPUT_POST, 'concepto'));
$c_movimiento->setEgreso(filter_input(INPUT_POST, 'monto'));
$c_movimiento->setIngreso(0);
$c_movimiento->setPeriodo(date("Ym",strtotime($c_movimiento->getFecha()) ));

$c_movimiento->setMovimiento($c_movimiento->obtener_id());
$c_gasto->setIdMovimiento($c_movimiento->getMovimiento());
if($c_movimiento->insertar()){
    $c_gasto->insertar();
    header('Location: ../ver_gastos.php');
}
