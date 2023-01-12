<?php
session_start();
require '../session_class/cs_ingreso_materiales.php';
require '../class/cl_varios.php';
$cs_materiales = new cs_ingreso_materiales();
$c_varios = new cl_varios();

$cs_materiales->d_material(filter_input(INPUT_POST, 'posicion'));

$a_ingreso_materiales = $_SESSION['ingreso_material'];
//echo json_encode($a_ingreso_materiales);
$_SESSION['suma_material'] = 0;

foreach ($a_ingreso_materiales as $fila) {
    foreach ($fila as $value) {
        $cantidad = $value['cantidad'];
        $costo = $value['costo'];
        $parcial = $cantidad * $costo;
        $_SESSION['suma_material'] = $_SESSION['suma_material'] + $parcial;
        ?>
        <tr class="odd gradeX">
            <td class="text-center"><?php echo $c_varios->zerofill($value['id'], 5) ?></td>
            <td><?php echo $value['descripcion'] ?></td>
            <td class="text-right"><?php echo number_format($cantidad, 2) ?></td>
            <td class="text-center">Und.</td>
            <td class="text-right"><?php echo number_format($costo, 2) ?></td>
            <td class="text-right"><?php echo number_format($parcial * 1.18, 2) ?></td>
            <td class="text-center">
                <button type="button" class="btn btn-warning btn-sm" onclick="del_material(<?php echo $value['id'] ?>)"><i class="fa fa-close"></i></button>
            </td>
        </tr>  
        <?php
    }
} 
$suma_total = $_SESSION['suma_herramienta'] + $_SESSION['suma_material'];
?>
<script>
    $("#input_subtotal").val("<?php echo number_format($suma_total, 2, '.', ',') ?>");
    $("#input_igv").val("<?php echo number_format(($suma_total * 0.18), 2, '.', ',') ?>");
    $("#input_total").val("<?php echo number_format(($suma_total * 1.18), 2, '.', ',') ?>");
</script>