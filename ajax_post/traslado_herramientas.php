<?php
session_start();
require '../session_class/cs_traslado_herramientas.php';
require '../class/cl_varios.php';
$cs_herramientas = new cs_traslado_herramientas();
$c_varios = new cl_varios();

$cs_herramientas->setId(filter_input(INPUT_POST, 'id_material'));
$cs_herramientas->setDescripcion(filter_input(INPUT_POST, 'descripcion'));
$cs_herramientas->setTipo(filter_input(INPUT_POST, 'tipo'));
$cs_herramientas->setCantidad(filter_input(INPUT_POST, 'cantidad'));

$cs_herramientas->insertar();

$a_traslado_herramientas = $_SESSION['traslado_herramienta'];
//echo json_encode($a_ingreso_materiales);

foreach ($a_traslado_herramientas as $fila) {
    foreach ($fila as $value) {
        $tipo = $value['tipo'];
        if ($tipo == 0) {
            $nombre_tipo = "ELECTRICA";
        }
        if ($tipo == 1) {
            $nombre_tipo = 'MANUAL';
        }
        $cantidad = $value['cantidad'];
        ?>
        <tr class="odd gradeX">
            <td class="text-center"><?php echo $c_varios->zerofill($value['id'], 5) ?></td>
            <td><?php echo $value['descripcion'] ?></td>
            <td><?php echo $nombre_tipo; ?></td>
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