<?php
require_once '../class/cl_herramientas.php';

$cl_herramientas = new cl_herramientas();

$cl_herramientas->setId($_POST['id_herramienta']);
$cl_herramientas->obtener_datos();
$a_ubicaciones = $cl_herramientas->ver_ubicaciones();
?>

<FORM>
    <div class="form-group">
        <label class="col-md-2 control-label">Descripcion</label>
        <label class="col-md-10 text-muted"><?php echo $cl_herramientas->getId() . ' | ' . $cl_herramientas->getDescripcion() . ' | ' . $cl_herramientas->getMarca() . ' | ' . $cl_herramientas->getModelo() . ' | ' . $cl_herramientas->getSerie() ?></label>
    </div>
</FORM>
<table id="tabla_ubicaciones" class="table table-striped">
    <thead>
        <tr>
            <th>Almacen</th>
            <th>Cantidad</th>
            <th>Fecha Ingreso</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($a_ubicaciones as $value) {
            ?>
            <tr class="odd gradeX">
                <td class="text-left"><?php echo $value['nombre']?></td>
                <td class="text-center"><?php echo $value['cactual']?></td>
                <td class="text-center"><?php echo $value['fingreso']?></td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>
