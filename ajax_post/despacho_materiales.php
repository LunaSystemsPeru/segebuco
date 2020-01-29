<?php
session_start();
require '../session_class/cs_despacho_materiales.php';
require '../class/cl_varios.php';
$cs_materiales = new cs_despacho_materiales();
$c_varios = new cl_varios();

$cs_materiales->setId(filter_input(INPUT_POST, 'id_material'));
$cs_materiales->setDescripcion(filter_input(INPUT_POST, 'descripcion'));
$cs_materiales->setMarca(strtoupper(filter_input(INPUT_POST, 'marca')));
$cs_materiales->setCantidad(filter_input(INPUT_POST, 'cantidad'));
$cs_materiales->setCosto(filter_input(INPUT_POST, 'costo'));

$cs_materiales->i_material();

$a_despacho_materiales = $_SESSION['despacho_material'];

foreach ($a_despacho_materiales as $fila) {
    foreach ($fila as $value) {
        $cantidad = $value['cantidad'];
        $costo = $value['costo'];
        $parcial = $cantidad * $costo;
        ?>
        <tr class="odd gradeX">
            <td class="text-center"><?php echo $c_varios->zerofill($value['id'], 5) ?></td>
            <td><?php echo $value['descripcion'] . ' - ' . $value['marca'] ?></td>
            <td class="text-right"><?php echo number_format($cantidad, 2) ?></td>
            <td class="text-center">Und.</td>
            <td class="text-right"><?php echo number_format($costo, 2) ?></td>
            <td class="text-right"><?php echo number_format($parcial, 2) ?></td>
            <td class="text-center">
                <button type="button" class="btn btn-warning btn-sm" onclick="del_material(<?php echo $value['id'] ?>)"><i class="fa fa-close"></i></button>
            </td>
        </tr>  
        <?php
    }
}
?>