<?php
session_start();
require '../session_class/cs_retorno_herramientas.php';
require '../class/cl_varios.php';
$cs_herramientas = new cs_retorno_herramientas();
$c_varios = new cl_varios();

$cs_herramientas->setId(filter_input(INPUT_POST, 'id_material'));
$cs_herramientas->setDescripcion(filter_input(INPUT_POST, 'descripcion'));
$cs_herramientas->setTipo(filter_input(INPUT_POST, 'tipo'));
$cs_herramientas->setCodigo(filter_input(INPUT_POST, 'codigo'));
$cs_herramientas->setDocumento(filter_input(INPUT_POST, 'documento'));
$cs_herramientas->setCantidad(filter_input(INPUT_POST, 'cantidad'));

$cs_herramientas->insertar();

$a_traslado_herramientas = $_SESSION['retorno_herramienta'];
//echo json_encode($a_ingreso_materiales);

foreach ($a_traslado_herramientas as $fila) {
    foreach ($fila as $value) {
        $cantidad = $value['cantidad'];
        ?>
        <tr class="odd gradeX">
            <td class="text-center"><?php echo $c_varios->zerofill($value['id'], 5) ?></td>
            <td><?php echo $value['descripcion'] ?></td>
            <td><?php echo $value['documento']; ?></td>
            <td class="text-right"><?php echo number_format($cantidad, 2) ?></td>
            <td class="text-center">Und.</td>
            <td class="text-center">
                <button type="button" class="btn btn-warning btn-sm" onclick="del_herramienta(<?php echo $value['id'] ?>)">
                    <i class="fa fa-close"></i>
                </button>
            </td>
        </tr>  
        <?php
    }
}
?>