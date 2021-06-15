<?php
require '../class/cl_detalle_tabla_general.php';
$cl_detalle = new cl_detalle_tabla_general();

$cl_detalle->setId(filter_input(INPUT_POST, 'id'));
$cl_detalle->setTabla(filter_input(INPUT_POST, 'tabla'));
$cl_detalle->datos_detalle();
?>

<div class="form-group">
    <label class="col-md-2 control-label">Codigo</label>
    <div class="col-md-5">
        <input type="text" name="input_id" class="form-control" value="<?php echo $cl_detalle->getId() ?>"  readonly="true"/>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">Descripcion</label>
    <div class="col-md-8">
        <input type="text" class="form-control" name="input_descripcion" value="<?php echo $cl_detalle->getDescripcion() ?>" required/>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">Parametro</label>
    <div class="col-md-8">
        <input type="text" class="form-control" name="input_parametro" value="<?php echo $cl_detalle->getValor() ?>"  required/>
    </div>
</div>
<input type="hidden" name="input_padre" value="<?php echo $cl_detalle->getTabla() ?>" />