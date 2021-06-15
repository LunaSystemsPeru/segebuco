<?php
require '../class/cl_cotizacion.php';
require '../class/cl_almacen.php';

$cl_cotizacion = new cl_cotizacion();
$cl_almacen = new cl_almacen();

$cl_cotizacion->setCodigo($_POST['id_cotizacion']);

$a_datos = $cl_cotizacion->datos_cotizacion_mix();

foreach ($a_datos as $value) {
    $codigo = $value['codigo'];
    $fecha = $value['fecha'];
    $cliente = $value['razon_social'];
    $sucursal = $value['sucursal'];
    $descripcion = $value['descripcion'];
    $dias = $value['dias_ejecucion'];
    $monto = $value['monto'];
}
?>
<div class="modal-header">
    <button data-dismiss="modal" class="close" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">Pre - Aprobar Cotizacion</h4>
</div>
<form class="form-horizontal" id="frm_epp" action="procesos/mod_preaprueba_cotizacion.php" method="post">
    <div class="modal-body">
        <div class="form-group">
            <label class="col-lg-3 control-label">Id</label>
            <div class="col-lg-4">
                <input type="text" name="input_cotizacion" id="input_codigo" class="form-control" value="<?php echo $codigo ?>" readonly="true">
            </div>
            <label class="col-lg-2 control-label">Fecha</label>
            <div class="col-lg-3">
                <input type="text" name="input_fecha" id="input_fecha" class="form-control" value="<?php echo $fecha ?>" readonly="true">
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Cliente</label>
            <div class="col-lg-9">
                <input type="text" name="input_cliente" id="input_cliente" class="form-control" value="<?php echo $cliente . ' | ' . $sucursal ?>" readonly="true">
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Descripcion</label>
            <div class="col-lg-9">
                <textarea class="form-control" readonly ><?php echo $descripcion ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Duracion (dias).</label>
            <div class="col-lg-2">
                <input type="text" class="form-control" name="input_dias" value="<?php echo $dias ?>" readonly="true">
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Fecha de Inicio</label>
            <div class="col-lg-4">
                <input type="date" class="form-control" name="input_fecha_inicio" required/>
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-3 control-label">Precio Cotizado.</label>
            <div class="col-lg-3">
                <input type="text" class="form-control text-right" name="input_cotizado" value="<?php echo $monto ?>" readonly="true">
            </div>
            <label class="col-lg-3 control-label">Precio Aprobado.</label>
            <div class="col-lg-3">
                <input type="text" class="form-control text-right" name="input_aprobado" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Almacen de Trabajo</label>
            <div class="col-lg-9">
                <select class="form-control" name="select_almacen"> 
                    <?php
                    $a_almacen = $cl_almacen->ver_almacenes();
                    foreach ($a_almacen as $value) {
                        ?>
                        <option value="<?php echo $value['codigo'] ?>"><?php echo $value['nombre'] ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Observaciones</label>
            <div class="col-lg-9">
                <textarea class="form-control" name="input_observaciones" ></textarea>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button>
        <input type="submit" class="btn btn-primary" name="btn_grabar">
    </div>
</form>