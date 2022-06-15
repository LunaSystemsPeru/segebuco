<?php
session_start();
require '../session_class/cs_devolucion_botellas.php';
require '../class/cl_varios.php';
$cs_botella = new cs_devolucion_botellas();
$c_varios = new cl_varios();

$cs_botella->setId(filter_input(INPUT_POST, 'id_cilindro'));
$cs_botella->setDescripcion(strtoupper(filter_input(INPUT_POST, 'descripcion')));

$cs_botella->i_botella();

$a_cilindros = $_SESSION['devolucion_botellas'];
//echo json_encode($a_ingreso_materiales);

foreach ($a_cilindros as $fila) {
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