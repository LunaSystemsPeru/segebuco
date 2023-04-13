<?php
include '../../models/OrdenServicioCliente.php';
$Servicio = new OrdenServicioCliente();

$datos = filter_input(INPUT_POST, 'datos');
$f_inicio = filter_input(INPUT_POST, 'f-inicio') ?? "";
$f_fin = filter_input(INPUT_POST, 'f-fin');

foreach ($Servicio->verFilas($datos,$f_inicio,$f_fin) as $clave => $fila) {
    switch ($fila['estado']) {
        case 0:
            $estado = '<label class="badge badge-warning">Pendiente</label>';
            break;
        case 1:
            $estado = '<label class="badge badge-info">Recepcionado</label>';
            break;
        case 2:
            $estado = '<label class="badge badge-success">Aprovado</label>';
            break;
        case 3:
            $estado = '<label class="badge badge-danger">Anulado</label>';
            break;
    }
?>
    <tr>
        <th scope="row"><?php echo $clave + 1 ?></th>
        <td class="text-center"><?php echo $fila['fecha'] ?></td>
        <td class="text-center"><?php echo $fila['nro'] ?></td>
        <td><?php echo $fila['cliente'] ?></td>
        <td><?php echo "JESUS AVILA" ?></td>
        <td class="text-right"><?php echo $fila['valor1'] . ' ' . $fila['monto'] ?></td>
        <td class="text-center"><?php echo $fila['valor2'] ?></td>
        <td><?php echo $fila['nombre'] ?></td>
        <td class="text-center"><label class="badge badge-dark">-</label></td>
        <td class="text-center"><?php echo "-----" ?></td>
        <td class="text-center"><?php echo $estado ?></td>
        <td class="text-center">
            <a href="detalle-contrato.php?id=1" class="btn btn-info btn-sm"><i class="ti ti-eye"></i></a>
        </td>
    </tr>
<?php }
