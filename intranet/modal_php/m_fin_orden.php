<?php
require '../class/cl_cotizacion.php';
require '../class/cl_orden_interna.php';

$cl_cotizacion = new cl_cotizacion();
$cl_orden = new cl_orden_interna();

$cl_cotizacion->setCodigo($_POST['id_cotizacion']);
$cl_orden->setCodigo($_POST['id_orden']);

$a_datos = $cl_orden->datos_orden_mix();

foreach ($a_datos as $value) {
    $codigo = $value['id_orden'];
    $fecha = $value['fecha_inicio'];
    $cliente = $value['razon_social'];
    $sucursal =  $value['sucursal'];
    $descripcion =  $value['descripcion'];
    $dias =  $value['dias_ejecucion'];
}
?>
<div class="modal-header">
    <button data-dismiss="modal" class="close" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">Finalizar Orden Interna</h4></h4>
</div>
<form class="form-horizontal" id="frm_epp" action="procesos/mod_fin_servicio.php" method="post">
    <div class="modal-body">
        <div class="form-group">
            <label class="col-lg-3 control-label">Id</label>
            <div class="col-lg-4">
                <input type="text" name="input_codigo" id="input_codigo" class="form-control" value="<?php echo $codigo?>" readonly="true">
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Fecha</label>
            <div class="col-lg-4">
                <input type="text" name="input_fecha" id="input_fecha" class="form-control" value="<?php echo $fecha?>" readonly="true">
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Cliente</label>
            <div class="col-lg-9">
                <input type="text" name="input_cliente" id="input_cliente" class="form-control" value="<?php echo $cliente . ' | ' . $sucursal?>" readonly="true">
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Descripcion</label>
            <div class="col-lg-9">
                <textarea class="form-control" readonly ><?php echo $descripcion?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Duracion (dias).</label>
            <div class="col-lg-2">
                <input type="text" class="form-control" name="input_dias" value="<?php echo $dias?>" readonly="true">
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Fecha Fin</label>
            <div class="col-lg-4">
                <input type="date" class="form-control" name="input_fecha_fin" required/>
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