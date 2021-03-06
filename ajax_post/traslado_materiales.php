<?php
session_start();
require '../session_class/cs_traslado_materiales.php';
require '../class/cl_varios.php';
$cs_materiales = new cs_traslado_materiales();
$c_varios = new cl_varios();

$cs_materiales->setId(filter_input(INPUT_POST, 'id_material'));
$cs_materiales->setDescripcion(filter_input(INPUT_POST, 'descripcion'));
$cs_materiales->setCosto(filter_input(INPUT_POST, 'costo'));
$cs_materiales->setCantidad(filter_input(INPUT_POST, 'cantidad'));

$cs_materiales->insertar();

$a_traslado_materiales = $_SESSION['traslado_material'];
//echo json_encode($a_ingreso_materiales);

foreach ($a_traslado_materiales as $fila) {
    foreach ($fila as $value) {
        $cantidad = $value['cantidad'];
        ?>
        <tr class="odd gradeX">
            <td class="text-center"><?php echo $c_varios->zerofill($value['id'], 5) ?></td>
            <td><?php echo $value['descripcion'] ?></td>
            <td class="text-right"><?php echo number_format($cantidad, 2) ?></td>
            <td class="text-center">Und.</td>
            <td class="text-center">
                <button type="button" class="btn btn-warning btn-sm" onclick="del_material(<?php echo $value['id'] ?>)">
                    <i class="fa fa-close"></i>
                </button>
            </td>
        </tr>  
        <?php
    }
}
?>