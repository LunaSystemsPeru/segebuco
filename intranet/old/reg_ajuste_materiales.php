<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

$_SESSION['ajuste_material'] = "";

require 'class/cl_almacen.php';
$cl_almacen = new cl_almacen();
?>
<!DOCTYPE html>
<!--[if IE 8]>
<html lang="es" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
<!--<![endif]-->

<head>
    <meta charset="utf-8"/>
    <title>Realizar Ajuste de Materiales | SEGEBUCO SAC</title>
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
    <link href="assets/plugins/bootstrap-wizard/css/bwizard.min.css" rel="stylesheet"/>
    <link href="assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet"/>
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
            <li><a href="javascript:;">Almacenes</a></li>
            <li class="active">Ajuste de Materiales</li>
        </ol>
        <!-- end breadcrumb -->
        <!-- begin page-header -->
        <h1 class="page-header">Realizar Ajuste de Materiales
            <small>matenimiento almacenes</small>
        </h1>
        <!-- end page-header -->
        <?php
        $cl_almacen->setCodigo($_SESSION["almacen"]);
        $cl_almacen->datos_almacen();
        ?>

        <div class="row">

            <div class="col-md-12">
                <div class="panel panel-inverse">
                    <form class="form-horizontal" id="frm_reg_ingreso" method="post" action="procesos/reg_ajuste.php">
                        <div class="panel-heading">
                            <h4 class="panel-title">Datos Generales</h4>
                        </div>

                        <div class="panel-body">
                            <!-- begin wizard step-2 -->
                            <div>
                                <fieldset>
                                    <legend class="pull-left width-full">Agregar Materiales</legend>
                                    <!-- begin row -->
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Buscar Materiales</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="input_buscar_material" id="input_buscar_material"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Material</label>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control text-center" name="input_id_material" id="input_id_material" readonly="true"/>
                                            </div>
                                            <div class="col-md-7">
                                                <input type="text" class="form-control" name="input_nombre_material" id="input_nombre_material" readonly="true"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">C. Sistema</label>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control text-right" name="input_csistema" id="input_csistema" readonly="true"/>
                                            </div>
                                            <label class="col-md-1 control-label">Costo con IGV</label>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control text-right" name="input_cigv_material" id="input_cigv_material" onkeyup="calcular_precio()" readonly="true"/>
                                            </div>
                                            <label class="col-md-1 control-label">Costo Sin IGV</label>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control text-right" name="input_costo_material" id="input_costo_material" readonly="true"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">C. Encontrado</label>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control text-right" name="input_cencontrado" id="input_cencontrado" onkeyup="calcular_diferencia()" readonly="true"/>
                                            </div>
                                            <label class="col-md-1 control-label">Diferencia</label>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control text-right" name="input_diferencia" id="input_diferencia" readonly="true"/>
                                            </div>
                                            <div class="col-md-2 col-md-offset-3">
                                                <button type="button" class="btn btn-primary" onclick="add_material()" id="btn_agregar_material"><i class="fa fa-plus"></i> Item</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end row -->
                                </fieldset>
                                <fieldset>
                                    <legend class="pull-left width-full">Ver Materiales</legend>
                                    <!-- begin row -->
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div id="resultado_materiales">
                                            </div>
                                            <div class="table-responsive">
                                                <table id="tabla_materiales" class="table table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>Id.</th>
                                                        <th>Descripcion</th>
                                                        <th>Costo</th>
                                                        <th>C. Sistema</th>
                                                        <th>C. Encontrado</th>
                                                        <th>Diferencia</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end row -->
                                </fieldset>
                            </div>
                            <!-- end wizard step-2 -->

                        </div>

                        <div class="panel-footer text-right">
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end #content -->

    <!-- begin scroll to top btn -->
    <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
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
<!-- ================== END BASE JS ================== -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="assets/plugins/bootstrap-wizard/js/bwizard.js"></script>
<script src="assets/plugins/masked-input/masked-input.min.js"></script>
<script src="assets/plugins/bootstrap-validator/bootstrapValidator.min.js"></script>
<script src="assets/js/apps.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->
<script type="text/javascript">
    $(document).ready(function () {
        App.init();
    });
</script>
<script type="text/javascript">
    function number_format(amount, decimals) {

        amount += ''; // por si pasan un numero en vez de un string
        amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

        decimals = decimals || 0; // por si la variable no fue pasada

        // si no es un numero o es igual a cero retorno el mismo cero
        if (isNaN(amount) || amount === 0)
            return parseFloat(0).toFixed(decimals);
        // si es mayor o menor que cero retorno el valor formateado como numero
        amount = '' + amount.toFixed(decimals);
        var amount_parts = amount.split('.'),
            regexp = /(\d+)(\d{3})/;
        while (regexp.test(amount_parts[0]))
            amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');
        return amount_parts.join('.');
    }

    function calcular_precio() {
        var cigv = $("#input_cigv_material").val();
        var sigv = cigv / 1.18;
        $("#input_costo_material").val(number_format(sigv, 5));
    }

    function calcular_diferencia() {
        var cencontrado = $("#input_cencontrado").val();
        var csistema = $("#input_csistema").val();
        var diferencia = cencontrado - csistema;
        $("#input_diferencia").val(diferencia);
    }

    $(function () {
        //autocomplete
        $("#input_buscar_material").autocomplete({
            source: "ajax_post/buscar_mis_materiales.php",
            minLength: 2,
            select: function (event, ui) {
                event.preventDefault();
                var costo_sigv = ui.item.precio_compra * 1.18;
                $('#input_id_material').val(ui.item.id);
                $('#input_nombre_material').val(ui.item.descripcion);
                $('#input_csistema').val(ui.item.cantidad);
                $('#input_costo_material').val(ui.item.precio_compra);
                $('#input_cigv_material').val(costo_sigv.toFixed(5));
                $('#input_buscar_material').val("");
                $('#btn_agregar_material').prop("disabled", false);
                $('#input_cencontrado').prop("readonly", false);
                $('#input_cencontrado').focus();
            }
        });
    });
</script>

<script>
    function add_material() {
        $.ajax({
            data: {
                id_material: $("#input_id_material").val(),
                descripcion: $("#input_nombre_material").val(),
                marca: '',
                cencontrado: $("#input_cencontrado").val(),
                csistema: $("#input_csistema").val(),
                costo: $("#input_costo_material").val()
            },
            url: 'ajax_post/add_material_ajuste.php',
            type: 'POST',
            //dataType: 'json',
            beforeSend: function () {
                $("#resultado_materiales").html("Cargando Datos");
                $("#tabla_materiales tbody").html("");
            },
            success: function (r) {
                $("#resultado_materiales").html("");
                $("#tabla_materiales tbody").html(r);
                limpiar_material();
            },
            error: function () {
                alert('Ocurrio un error en el servidor ..');
                $("#resultado_materiales").html("Error al recibir Datos");
                $("#tabla_materiales tbody").html("");
            }
        });
    }

    function limpiar_material() {
        $("#input_id_material").val("");
        $("#input_nombre_material").val("");
        $("#input_cencontrado").val("");
        $("#input_csistema").val("");
        $("#input_diferencia").val("");
        $("#input_costo_material").val("");
        $("#input_cigv_material").val("");
        $("#btn_agregar_material").prop("disabled", true);
        $("#input_cigv_material").prop("readonly", true);
        $("#input_costo_material").prop("readonly", true);
        $("#input_cencontrado").prop("readonly", true);
        $("#input_buscar_material").focus();
    }

    function del_material(posicion) {
        $.ajax({
            data: {posicion: posicion},
            url: 'ajax_post/del_ajuste_material.php',
            type: 'POST',
            //dataType: 'json',
            beforeSend: function () {
                $("#resultado_materiales").html("Cargando Datos");
            },
            success: function (r) {
                $("#resultado_materiales").html("");
                $("#tabla_materiales tbody").html(r);
            },
            error: function () {
                alert('Ocurrio un error en el servidor ..');
                $("#resultado_materiales").html("Error al recibir Datos");
            }
        });
    }
</script>
</body>

<!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:23:54 GMT -->
</html>

