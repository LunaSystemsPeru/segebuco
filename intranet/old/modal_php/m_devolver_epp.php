<?php
require '../class/cl_entrega_epp.php';

$cl_dentrega = new cl_entrega_epp();

$cl_dentrega->setCodigo($_POST['id_entrega']);
$cl_dentrega->setEpp($_POST['id_epp']);
$cl_dentrega->setColaborador($_POST['id_empleado']);

$a_entrega = $cl_dentrega->datos_entrega();

foreach ($a_entrega as $value) {
    $nepp = $value['epp'];
    $cepp = $value['cepp'];
    $fentrega = $value['entrega'];
    $fdevolucion =  $value['retorno'];
}
?>
<div class="modal-header">
    <button data-dismiss="modal" class="close" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">Devolucion de EPPs</h4>
</div>
<form class="form-horizontal" id="frm_epp" action="procesos/mod_entrega_epp.php" method="post">
    <div class="modal-body">
        <div class="form-group">
            <label class="col-lg-3 control-label">Id</label>
            <div class="col-lg-7">
                <input type="text" name="id_epp" id="id_epp" class="form-control" value="<?php echo $cepp?>" readonly="true">
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Nombre</label>
            <div class="col-lg-7">
                <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo $nepp?>" readonly="true">
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Fecha Entrega</label>
            <div class="col-lg-7">
                <input type="text" class="form-control" name="fecha_entrega" value="<?php echo $fentrega?>" readonly="true">
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Fecha Devolucion Aprox.</label>
            <div class="col-lg-7">
                <input type="text" class="form-control" name="fecha_devolucion_aprox" value="<?php echo $fdevolucion?>" readonly="true">
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Fecha Devolucion</label>
            <div class="col-lg-7">
                <input type="date"class="form-control" name="fecha_devolucion" id="fecha_devolucion" placeholder="dd/mm/aaaa" required >
            </div>
        </div>
        <input type="hidden" name="id_entrega" value="<?php echo $cl_dentrega->getCodigo() ?>">
        <input type="hidden" name="id_epp" value="<?php echo $cl_dentrega->getEpp() ?>">
        <input type="hidden" name="id_empleado" value="<?php echo $cl_dentrega->getColaborador() ?>">
    </div>
    <div class="modal-footer">
        <button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button>
        <input type="submit" class="btn btn-primary" name="devolver_epp">
    </div>
</form>