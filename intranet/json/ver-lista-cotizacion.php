<?php
include '../../models/Cotizacion.php';
$Cotizacion = new Cotizacion();

$datos = filter_input(INPUT_POST, 'datos');
$f_inicio = filter_input(INPUT_POST, 'f-inicio') ?? "";
$f_fin = filter_input(INPUT_POST, 'f-fin');

foreach ($Cotizacion->verFilas($datos,$f_inicio,$f_fin) as $clave => $fila) {
    switch ($fila['estado']) {
        case 0:
            $estado = '<span class="badge badge-warning">Pendiente</span>';
            break;
        case 1:
            $estado = '<span class="badge badge-primary">En Proceso</span>';
            break;
        case 2:
            $estado = '<span class="badge badge-success">Aceptado</span>';
            break;
    }
?>
    <tr>
        <th scope="row"><?php echo $clave + 1 ?></th>
        <td class="text-center"><?php echo $fila['fecha'] ?></td>
        <td class="text-center"><?php echo $fila['nro'] ?></td>
        <td><?php echo $fila['cliente'] ?></td>
        <td><?php echo $fila['descripcion'] ?></td>
        <td><?php echo $fila['moneda'] ?></td>
        <td class="text-right"><?php echo $fila['monto'] ?></td>
        <td><?php echo $estado ?></td>
        <td class="text-center">
            <a href="#" class="btn btn-info btn-sm"><i class="ti ti-eye"></i></a>
        </td>
    </tr>
<?php }
