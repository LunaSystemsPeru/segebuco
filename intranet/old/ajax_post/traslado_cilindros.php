<?php
session_start();
require '../session_class/cs_traslado_botellas.php';
require '../class/cl_varios.php';
$cs_botella = new cs_traslado_botellas();
$c_varios = new cl_varios();

$cs_botella->setId(filter_input(INPUT_POST, 'id_cilindro'));
$cs_botella->setDescripcion(strtoupper(filter_input(INPUT_POST, 'descripcion')));

$cs_botella->i_botella();

$a_traslado_cilindros = $_SESSION['traslado_botellas'];
//echo json_encode($a_ingreso_materiales);

foreach ($a_traslado_cilindros as $fila) {
    foreach ($fila as $value) {
        ?>
        <tr class="odd gradeX">
            <td class="text-center"><?php echo $value['id'] ?></td>
            <td><?php echo $value['descripcion']  ?></td>
            <td class="text-center">
                <button type="button" class="btn btn-warning btn-sm" onclick="del_cilindro(<?php echo $value['id'] ?>)">
                    <i class="fa fa-close"></i>
                </button>
            </td>
        </tr>  
        <?php
    }
}
?>