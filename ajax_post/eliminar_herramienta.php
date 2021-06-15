<?php
session_start();
require '../session_class/cs_ingreso_herramientas.php';
require '../class/cl_varios.php';
$cs_herramientas = new cs_ingreso_herramientas();
$c_varios = new cl_varios();

$cs_herramientas->d_herramienta(filter_input(INPUT_POST, 'posicion'));

$a_ingreso_herramientas = $_SESSION['ingreso_herramienta'];
//echo json_encode($a_ingreso_herramientas);
$_SESSION['suma_herramienta'] = 0;

foreach ($a_ingreso_herramientas as $fila) {
    foreach ($fila as $value) {
        $tipo = $value['tipo'];
        if ($tipo == 0) {
            $nombre_tipo = "ELECTRICA";
        }
        if ($tipo == 1) {
            $nombre_tipo = 'MANUAL';
        }
        $cantidad = $value['cantidad'];
        $costo = $value['costo'];
        $parcial = $cantidad * $costo;
        $_SESSION['suma_herramienta'] = $_SESSION['suma_herramienta'] + $parcial;
        ?>
        <tr class="odd gradeX">
            <td class="text-center"><?php echo $c_varios->zerofill($value['id'], 5) ?></td>
            <td><?php echo $value['descripcion'] ?></td>
            <td><?php echo $nombre_tipo; ?></td>
            <td class="text-right"><?php echo number_format($cantidad, 2) ?></td>
            <td class="text-center">Und.</td>
            <td class="text-right"><?php echo number_format($costo, 2) ?></td>
            <td class="text-right"><?php echo number_format($parcial * 1.18, 2) ?></td>
            <td class="text-center">
                <button type="button" class="btn btn-warning btn-sm" onclick="del_herramienta(<?php echo $value['id'] ?>)">
                    <i class="fa fa-close"></i>
                </button>
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
