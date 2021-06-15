<?php
session_start();
require '../class/cl_conectar.php';
require '../class/cl_varios.php';
$cl_varios = new cl_varios();
mysqli_set_charset($conn, "utf8");
$idmaterial = filter_input(INPUT_POST, 'id_material');
$fecha = filter_input(INPUT_POST, 'fecha');
if ($fecha != "") {
    $fecha = $cl_varios->fecha_web_mysql($fecha);
}

$query = "select k.ingresa, k.sale, k.c_ingreso, k.c_egreso "
        . "from kardex_material as k "
        . "where k.material = '" . $idmaterial . "' and k.almacen = '".$_SESSION['almacen']."' and k.fecha <= '".$fecha."' "
        . "order by k.fecha asc, k.kardex asc";
//echo $query;
$resultado = $conn->query($query);

$saldo = 0;
$stotal = 0;
$costo_promedio = 0;

if ($resultado->num_rows > 0) {
    while ($value = $resultado->fetch_assoc()) {
        $ingreso = $value['ingresa'];
	$cingreso = $value['c_ingreso'];
	$egreso = $value['sale'];
	$cegreso = $value['c_egreso'];
	$saldo = $saldo + $ingreso - $egreso;
	$stotal = $stotal + ($cingreso * $ingreso) - ($cegreso * $egreso);
	$costo_promedio = $stotal / $saldo;
    }
}
//echo json_encode($costo_promedio);
echo number_format($costo_promedio, 5);
flush();
$conn->close();
