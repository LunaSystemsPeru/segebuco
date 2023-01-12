<?php
require '../../models/PrestamoCuota.php';
$Cuota = new PrestamoCuota();

$idcliente = filter_input(INPUT_GET, 'idcliente');
$Cuota->verCuotaMinimaCliente($idcliente);

echo json_encode(array("monto_cuota" => $Cuota->getMonto() - $Cuota->getMontopago()));

