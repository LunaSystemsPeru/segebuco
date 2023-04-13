<?php
include '../../models/TareaDiaria.php';
$Tarea = new TareaDiaria();

$maestro = filter_input(INPUT_POST, 'maestro');
$embarcacion = filter_input(INPUT_POST, 'embarcacion');
$f_inicio = filter_input(INPUT_POST, 'f-inicio') ?? "";
$f_fin = filter_input(INPUT_POST, 'f-fin');
$operador = ($maestro == $embarcacion) ? "OR" : "AND";

foreach ($Tarea->verTareas($maestro, $embarcacion, $f_inicio, $f_fin, $operador) as $clave => $fila) {
    switch ($fila['estado']) {
        case 0:
            $estado = '<span class="badge badge-warning">En Proceso</span>';
            $opcion = '';
            break;
        case 1:
            $estado = '<span class="badge badge-blue">Pendiente</span>';
            $opcion = '<a onclick="idcotizacion(' . $fila['id'] . ')" class="btn btn-info btn-sm" data-toggle="modal" data-target="#cotizacion"><i class="fa fa-money-check"></i></a>';
            break;
        case 2:
            $estado = '<span class="badge badge-success">Cotizado</span>';
            $opcion = '';
            break;
    }
    $fecha = str_split($fila['fecha_registro'], 10);
?>
    <tr>
        <th scope="row"><?php echo $clave + 1 ?></th>
        <td class="text-center"><?php echo $fecha[0] ?></td>
        <td><?php echo $fila['nombre_corto'] ?></td>
        <td><?php echo $fila['datos'] ?></td>
        <td><?php echo $fila['ncliente'] ?></td>
        <td><?php echo $fila['nep'] ?></td>
        <td><?php echo $fila['tiposervicio'] ?></td>
        <td><?php echo $estado ?></td>
        <td class="text-center"><?php echo $opcion ?></td>
    </tr>
<?php } ?>