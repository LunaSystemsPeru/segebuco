<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

?>
<!DOCTYPE html>
<!--[if IE 8]>
<html lang="es" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
<!--<![endif]-->

<head>
    <meta charset="utf-8"/>
    <title>Agregar Orden de Compra | SEGEBUCO SAC</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>

    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet"/>
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>
    <link href="assets/css/animate.min.css" rel="stylesheet"/>
    <link href="assets/css/style.min.css" rel="stylesheet"/>
    <link href="assets/css/style-responsive.min.css" rel="stylesheet"/>
    <link href="assets/css/theme/default.css" rel="stylesheet" id="theme"/>
    <!-- ================== END BASE CSS STYLE ================== -->

    <!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
    <link href="assets/plugins/bootstrap-validator/bootstrapValidator.min.css" rel="stylesheet"/>
    <!-- ================== END PAGE LEVEL STYLE ================== -->

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="assets/plugins/pace/pace.min.js"></script>
    <!-- ================== END BASE JS ================== -->
</head>
<body>
<!-- begin #page-loader -->
<div id="page-loader" class="fade in">
            <span class="spinner">
            </span>
</div>
<!-- end #page-loader -->

<!-- begin #page-container -->
<div id="page-container" class="page-container fade page-sidebar-fixed page-header-fixed">
    <!-- begin #header -->
    <?php include 'includes/header.php'; ?>
    <!-- end #header -->

    <!-- begin #sidebar -->
    <?php include 'includes/sidebar.php'; ?>
    <!-- end #sidebar -->

    <!-- begin #content -->
    <div id="content" class="content">
        <!-- begin breadcrumb -->
        <ol class="breadcrumb pull-right">
            <li><a href="javascript:;">Inicio</a></li>
            <li><a href="javascript:;">operaciones</a></li>
            <li class="active">agregar orden de compra</li>
        </ol>
        <!-- end breadcrumb -->
        <!-- begin page-header -->
        <h1 class="page-header">Registro de orden de Compra
            <small>matenimiento compras</small>
        </h1>
        <!-- end page-header -->

        <div class="row">

            <div class="col-md-12">
                <div class="panel panel-inverse">

                    <div class="panel-heading">
                        <h4 class="panel-title">Datos Generales</h4>
                    </div>
                    <form class="form-horizontal" id="form_orden_compra" name="form_orden_compra" method="post"
                          action="procesos/reg_orden_compra.php">
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-md-2 control-label">Proveedor:</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="input_buscar_proveedor"
                                           id="input_buscar_proveedor"/>
                                </div>
                                <div class="col-md-1">
                                    <a href="reg_entidad.php" class="btn btn-success" name="btn_crear_entidad"
                                       id="btn_crear_entidad" target="_blank">Nuevo</a>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">RUC</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control  text-center" name="input_ruc_proveedor"
                                           id="input_ruc_proveedor" maxlength="11" required readonly="true"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Razon Social:</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="input_razon_proveedor"
                                           id="input_razon_proveedor" required readonly="true"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Direccion Fiscal:</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="input_direccion_proveedor"
                                           id="input_direccion_proveedor" readonly="true"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Fecha:</label>
                                <div class="col-md-2">
                                    <input type="date" class="form-control" name="input_fecha" id="input_fecha"
                                           required="true"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Moneda:</label>
                                <div class="col-md-3">
                                    <select class="form-control" name="select_moneda">
                                        <option value="1">SOL</option>
                                        <option value="2">DOLAR AMERICANO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Monto total:</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control text-right" name="input_total"
                                           id="input_total" required="true"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Glosa:</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="input_glosa" id="input_glosa"
                                           required/>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer text-right">
                            <button type="submit" class="btn btn-success" id="btn_guardar">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end #content -->

    <!-- begin scroll to top btn -->
    <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i
                class="fa fa-angle-up"></i></a>
    <!-- end scroll to top btn -->
</div>
<!-- end page container -->

<!-- ================== BEGIN BASE JS ================== -->
<script src="assets/plugins/jquery/jquery-1.9.1.min.js"></script>
<script src="assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
<script src="assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<!--[if lt IE 9]>
<script src="assets/crossbrowserjs/html5shiv.js"></script>
<script src="assets/crossbrowserjs/respond.min.js"></script>
<script src="assets/crossbrowserjs/excanvas.min.js"></script>
<![endif]-->
<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="assets/plugins/jquery-cookie/jquery.cookie.js"></script>
<script src="assets/plugins/masked-input/masked-input.min.js"></script>
<script src="assets/plugins/bootstrap-validator/bootstrapValidator.min.js"></script>
<!-- ================== END BASE JS ================== -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="assets/js/table-manage-default.demo.min.js"></script>
<script src="assets/js/apps.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->
<script>
    $(document).ready(function () {
        App.init();
        TableManageDefault.init();
        $("#select_cliente").trigger('change');
    });

    $(function () {
        //autocomplete
        $("#input_buscar_proveedor").autocomplete({
            source: "ajax_post/buscar_proveedores.php",
            minLength: 2,
            select: function (event, ui) {
                event.preventDefault();
                $('#input_ruc_proveedor').val(ui.item.ruc);
                $('#input_razon_proveedor').val(ui.item.razon_social);
                $('#input_direccion_proveedor').val(ui.item.direccion);
                $('#input_buscar_proveedor').val("");
            }
        });
    });
</script>
</body>

<!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:23:54 GMT -->
</html>

