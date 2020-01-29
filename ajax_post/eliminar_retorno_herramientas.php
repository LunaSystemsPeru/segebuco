<?php
session_start();
require '../session_class/cs_retorno_herramientas.php';
require '../class/cl_varios.php';
$cs_herramientas = new cs_retorno_herramientas();
$c_varios = new cl_varios();

$cs_herramientas->d_herramienta(filter_input(INPUT_POST, 'posicion'));

$a_traslado_herramientas = $_SESSION['retorno_herramienta'];

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
