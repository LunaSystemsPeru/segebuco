<?php
session_start();
require '../session_class/cs_ingreso_botellas.php';
require '../class/cl_varios.php';
$cs_botella = new cs_ingreso_botellas();
$c_varios = new cl_varios();

$cs_botella->setId(filter_input(INPUT_POST, 'id_cilindro'));
$cs_botella->setDescripcion(strtoupper(filter_input(INPUT_POST, 'descripcion')));

$cs_botella->i_botella();

$a_ingreso_cilindros = $_SESSION['ingreso_botellas'];
//echo json_encode($a_ingreso_materiales);

foreach ($a_ingreso_cilindros as $fila) {
    foreach ($fila as $value) {
        $parcial = 0.00;
        $_SESSION['suma_ingreso'] = $_SESSION['suma_ingreso'] + $parcial;
        ?>
        <tr class="odd gradeX">
            <td class="text-center"><?php echo $value['id'] ?></td>
            <td><?php echo $value['descripcion']  ?></td>
            <td class="text-center">
                <button type="button" class="btn btn-warning btn-sm" onclick="del_botella(<?php echo $value['id'] ?>)"><i class="fa fa-close"></i></button>
            </td>
        </tr>  
        <?php
    }
}
?>
<script>
    $("#input_subtotal").val("<?php echo number_format($_SESSION['suma_ingreso'], 2, '.', ',') ?>");
    $("#input_igv").val("<?php echo number_format(($_SESSION['suma_ingreso'] * 0.18), 2, '.', ',') ?>");
    $("#input_total").val("<?php echo number_format(($_SESSION['suma_ingreso'] * 1.18), 2, '.', ',') ?>");
</script>