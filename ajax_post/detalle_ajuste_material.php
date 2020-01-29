<?php
$a_materiales = $_SESSION['ajuste_material'];
//echo json_encode($a_ingreso_materiales);
foreach ($a_materiales as $fila) {
    foreach ($fila as $value) {
        $cencontrado = $value['cencontrado'];
        $csistema = $value['csistema'];
        $diferencia = $cencontrado - $csistema;
        $costo = $value['costo'];
        ?>
        <tr class="odd gradeX">
            <td class="text-center"><?php echo $c_varios->zerofill($value['id'], 5) ?></td>
            <td><?php echo $value['descripcion'] . ' - ' . $value['marca'] ?></td>
            <td class="text-right"><?php echo number_format($costo, 2) ?></td>
            <td class="text-right"><?php echo number_format($csistema, 2) ?></td>
            <td class="text-right"><?php echo number_format($cencontrado, 2) ?></td>
            <td class="text-right"><?php echo number_format($diferencia, 2) ?></td>
            
            <td class="text-center">
                <button type="button" class="btn btn-warning btn-sm" onclick="del_material(<?php echo $value['id'] ?>)"><i class="fa fa-close"></i></button>
            </td>
        </tr>  
        <?php
    }
}
?>