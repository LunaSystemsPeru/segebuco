<?php
include '../../models/Embarcacion.php';

$Embarcacion = new Embarcacion();

$idCliente = filter_input(INPUT_POST, 'id');
$select = filter_input(INPUT_POST, 'select');
echo '<option hidden>Seleccionar Embarcación ...</option>';
foreach ($Embarcacion->verFilas() as $fila) {
    if ($fila['clienteid'] == $idCliente) {
        $sel = ($fila['id'] == $select)?'selected="selected"':'';
        echo '<option value="' . $fila['id'] . '" '. $sel .'>'. $fila['nombre'] . '</option>';
    }
}