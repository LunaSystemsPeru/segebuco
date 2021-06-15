<?php
session_start();

require '../class/cl_almacen.php';
require '../class/cl_herramientas.php';
require '../class/cl_herramientas_almacen.php';

$cl_almacen = new cl_almacen();
$cl_almacen->setCodigo(filter_input(INPUT_POST, 'id_almacen'));
$cl_almacen->datos_almacen();

$cl_herramientas = new cl_herramientas();
$cl_herramientas->setId(filter_input(INPUT_POST, 'id_herramienta'));
$cl_herramientas->obtener_datos();

$cl_mi_herramienta = new cl_herramientas_almacen();
$cl_mi_herramienta->setAlmacen($cl_almacen->getCodigo());
$cl_mi_herramienta->setCodigo($cl_herramientas->getId());
$cl_mi_herramienta->obtener_datos();
?>

<div class="modal-header">
    <button data-dismiss="modal" class="close" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">Retirar Herramienta</h4>
</div>
<form class="form-horizontal" id="frm_merma" action="procesos/reg_herramienta_merma.php" method="post">
    <div class="modal-body">
        <div class="form-group">
            <label class="col-lg-3 control-label">Almacen de Trabajo</label>
            <div class="col-lg-9">
                <input type="text" class="form-control" value="<?php echo $cl_almacen->getNombre() ?>" readonly>
                <input type="hidden" name="input_id_almacen" value="<?php echo $cl_almacen->getCodigo() ?>"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Id</label>
            <div class="col-lg-4">
                <input type="text" name="input_id_herramienta" id="input_codigo" class="form-control" value="<?php echo $cl_herramientas->getId() ?>" readonly="true">
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Herramienta</label>
            <div class="col-lg-9">
                <input type="text" name="input_descripcion" id="input_fecha" class="form-control" value="<?php echo $cl_herramientas->getDescripcion() ?>" readonly="true">
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Fecha</label>
            <div class="col-lg-4">
                <input type="text" class="form-control" value="<?php echo date("Y-m-d") ?>" name="input_fecha" readonly=""/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Cant. Actual</label>
            <div class="col-lg-3">
                <input type="text" class="form-control text-right" name="input_cactual" value="<?php echo $cl_mi_herramienta->getCactual() ?>" readonly="true">
                <input type="hidden" name="input_tipo" value="<?php echo $cl_herramientas->getTipo()?>">
            </div>
            <label class="col-lg-3 control-label">Cant. Retiro</label>
            <div class="col-lg-3">
                <input type="number" value="1" class="form-control text-right" name="input_cmerma" required>
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
