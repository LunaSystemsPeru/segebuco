<?php
include '../../models/TareaDiaria.php';

$Tarea = new TareaDiaria();

$idEmbarcacion = filter_input(INPUT_POST, 'id-embarcacion');
$select = filter_input(INPUT_POST,'select');

echo '<option hidden>Seleccionar Tarea ...</option>';

foreach ($Tarea->verTareas() as $fila) {
    if ($fila['embarcacionid'] == $idEmbarcacion && $fila['estado'] == 1) {
        $sel = ($fila['id'] == $select)?'selected="selected"':'';?>
        <option value="<?php echo $fila['id'] ?>" <?php echo $sel ?> ><?php echo $fila['nombre_corto'] ?></option>
<?php }
} ?>