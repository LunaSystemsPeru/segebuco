<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

require 'class/cl_detalle_tabla_general.php';
require 'class/cl_tipo_documento.php';
require_once 'class/cl_almacen.php';
$cl_detalle = new cl_detalle_tabla_general();
$cl_tido = new cl_tipo_documento();
$cl_almacen = new cl_almacen();

$_SESSION['despacho_material'] = "";

?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="es" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
    <!--<![endif]-->

    <head>
        <meta charset="utf-8" />
        <title>Agregar Documento de Despacho| SEGEBUCO SAC</title>
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />

        <!-- ================== BEGIN BASE CSS STYLE ================== -->
        <link href="assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
        <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
        <link href="assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
        <link href="assets/css/animate.min.css" rel="stylesheet" />
        <link href="assets/css/style.min.css" rel="stylesheet" />
        <link href="assets/css/style-responsive.min.css" rel="stylesheet" />
        <link href="assets/css/theme/default.css" rel="stylesheet" id="theme" />
        <!-- ================== END BASE CSS STYLE ================== -->

        <!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
        <link href="assets/plugins/bootstrap-validator/bootstrapValidator.min.css" rel="stylesheet" />
        <link href="assets/plugins/bootstrap-wizard/css/bwizard.min.css" rel="stylesheet" />
        <link href="assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
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
                    <li class="active">agregar documento despacho</li>
                </ol>
                <!-- end breadcrumb -->
                <!-- begin page-header -->
                <h1 class="page-header">Registro de Documento de Despacho <small>matenimiento almacenes</small></h1>
                <!-- end page-header -->
                <?php
                $cl_almacen->setCodigo($_SESSION["almacen"]);
                $cl_almacen->datos_almacen();
                ?>

                <div class="row">

                    <div class="col-md-12">
                        <div class="panel panel-inverse">

                            <div class="panel-heading">
                                <h4 class="panel-title">Datos Generales</h4>
                            </div>

                            <div class="panel-body">
                                <form class="form-horizontal" id="frm_reg_despacho" method="post" action="procesos/reg_despacho_materiales.php">
                                    <div id="wizard">
                                        <ol>
                                            <li>Datos Generales</li>
                                            <li>Materiales / Insumos</li>
                                        </ol>
                                        <!-- begin wizard step-1 -->
                                        <div>
                                            <fieldset>
                                                <legend class="pull-left width-full">Datos Generales</legend>
                                                <!-- begin row -->
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Colaborador:</label>
                                                        <div class="col-md-1">
                                                            <input type="text" class="form-control  text-center" name="input_id_colaborador" id="input_id_colaborador" readonly="true" required />
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" name="input_colaborador" id="input_colaborador" required/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Servicio:</label>
                                                        <div class="col-md-1">
                                                            <input type="text" class="form-control  text-center" name="input_id_servicio" id="input_id_servicio" readonly="true" required />
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" name="input_servicio" id="input_servicio" required/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label"></label>
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control text-center" name="input_finicio" id="input_finicio" readonly="true"/>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control text-center" name="input_ffin" id="input_ffin" readonly="true"/>
                                                        </div>
                                                    </div>
                                                     <div class="form-group">
                                                        <label class="col-md-2 control-label">Fecha</label>
                                                        <div class="col-md-3">
                                                            <input type="text" class="form-control text-center" name="input_fecha" id="input_fecha" value="<?php //echo date('d/m/Y') ?>" required />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Almacen:</label>
                                                        <div class="col-md-10">
                                                            <input type="text" class="form-control" name="input_origen" value="<?php echo $cl_almacen->getNombre() ?>" readonly="true"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-md-3">
                                                            <button type="submit" class="btn btn-success">Guardar </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end row -->
                                            </fieldset>
                                        </div>
                                        <!-- end wizard step-1 -->


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
                                                    <label class="col-md-2 control-label">C. Actual</label>
                                                        <div class="col-md-1">
                                                            <input type="text" class="form-control text-right" name="input_cactual_material" id="input_cactual_material" readonly="true"/>
                                                        </div>
                                                        <label class="col-md-2 control-label">Cantidad</label>
                                                        <div class="col-md-1">
                                                            <input type="text" class="form-control text-right" name="input_cantidad_material" id="input_cantidad_material"/>
                                                        </div>
                                                        <label class="col-md-1 control-label">Costo Promedio </label>
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control text-right"  name="input_costo_material" id="input_costo_material" readonly="true"/>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <button type="button" class="btn btn-primary" onclick="add_material()" id="btn_agregar_material" disabled="true">Agregar Materiales</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end row -->
                                            </fieldset>
                                            <fieldset>
                                                <legend class="pull-left width-full">Ver Materiales</legend>
                                                <!-- begin row -->
                                                <div class="row">
                                                    <div class="col-xs-12" >
                                                        <div id="resultado_materiales" >
                                                        </div>
                                                        <div class="table-responsive" >
                                                            <table id="tabla_materiales" class="table table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Id.</th>
                                                                        <th>Descripcion</th>
                                                                        <th>Cantidad</th>
                                                                        <th>Und. Med.</th>
                                                                        <th>Costo</th>
                                                                        <th>Parcial</th>
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
                                </form>
                            </div>
                            <!--                            <div class="panel-footer text-right" >
                                                            <button type="submit" class="btn btn-success">Guardar </button>
                                                        </div>-->
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
                                                                    // FormWizard.init();
                                                                    $("#wizard").bwizard()
                                                                    $('#input_fecha').mask('99/99/9999');
                                                                });
        </script>
        <script type="text/javascript">
            function number_format(amount, decimals) {

                amount += ''; // por si pasan un numero en vez de un string
                amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

                decimals = decimals || 0; // por si la variable no fue fue pasada

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

            function calcular_subtotal() {
                var cigv = $("#input_cigv_material").val();
                var sigv = cigv / 1.18;
                $("#input_costo_material").val(number_format(sigv, 5));
            }
            
            function costo_promedio(idmaterial, fecha) {
            var costo_promedio = 0;
            	$.ajax({
                    data: {
                        id_material: idmaterial, 
                        fecha: fecha
                    },
                    url: 'ajax_post/calcular_costopromedio_material.php',
                    type: 'POST',
                    //dataType: 'json',
                    beforeSend: function ()
                    {
                        costo_promedio = 0;
                    },
                    success: function (r)
                    {
                        costo_promedio = r;
                        $('#input_costo_material').val(r);
                        console.log(r);
                        console.log(fecha);
                    },
                    error: function ()
                    {
                        alert('Ocurrio un error en el servidor ..');
                        costo_promedio = 0;
                    }
                });
                return costo_promedio;
            }

            $(function () {
                //autocomplete
                $("#input_colaborador").autocomplete({
                    source: "ajax_post/buscar_empleados.php",
                    minLength: 3,
                    select: function (event, ui) {
                        event.preventDefault();
                        $('#input_id_colaborador').val(ui.item.codigo);
                        $('#input_colaborador').val(ui.item.dni + " | " + ui.item.nombres);
                       // $('#input_id_servicio').val("");
                    }
                });
                
                $("#input_servicio").autocomplete({
                    source: "ajax_post/buscar_servicios_almacen.php",
                    minLength: 3,
                    select: function (event, ui) {
                        event.preventDefault();
                        $('#input_id_servicio').val(ui.item.codigo);
                        $('#input_servicio').val(ui.item.descripcion);
                        $('#input_finicio').val(ui.item.finicio);
                        $('#input_ffin').val(ui.item.ftermino);
                       // $('#input_id_servicio').val("");
                    }
                });

                $("#input_buscar_material").autocomplete({
                    source: "ajax_post/buscar_mis_materiales.php",
                    minLength: 2,
                    select: function (event, ui) {
                        event.preventDefault();
                        $('#input_id_material').val(ui.item.id);
                        $('#input_nombre_material').val(ui.item.descripcion);
                        $("#input_cactual_material").val(ui.item.cantidad);
                        $('#input_cantidad_material').val(1);
                        var fecha = $('#input_fecha').val();
                        var costo = costo_promedio(ui.item.id, fecha);
                        $('#input_costo_material').val(costo);
                        $('#btn_agregar_material').prop("disabled", false);
                        $("#input_buscar_material").val("");
                        $('#input_cantidad_material').focus();
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
                        cantidad: $("#input_cantidad_material").val(),
                        costo: $("#input_costo_material").val()
                    },
                    url: 'ajax_post/despacho_materiales.php',
                    type: 'POST',
                    //dataType: 'json',
                    beforeSend: function ()
                    {
                        $("#resultado_materiales").html("Cargando Datos");
                        $("#tabla_materiales tbody").html("");
                    },
                    success: function (r)
                    {
                        $("#resultado_materiales").html("");
                        $("#tabla_materiales tbody").html(r);
                        limpiar_material();
                    },
                    error: function ()
                    {
                        alert('Ocurrio un error en el servidor ..');
                        $("#resultado_materiales").html("Error al recibir Datos");
                        $("#tabla_materiales tbody").html("");
                    }
                });
            }

            function limpiar_material() {
                $("#input_id_material").val("");
                $("#input_nombre_material").val("");
                $("#input_cantidad_material").val("");
                $("#input_cactual_material").val("");                
                $("#input_costo_material").val("");
                $("#input_cigv_material").val("");
                $("#input_buscar_material").val("");
                $("#btn_agregar_material").prop("disabled", true);
                $("#input_buscar_material").focus();
            }

            function del_material(posicion) {
                $.ajax({
                    data: {posicion: posicion},
                    url: 'ajax_post/eliminar_despacho_materiales.php',
                    type: 'POST',
                    //dataType: 'json',
                    beforeSend: function ()
                    {
                        $("#resultado_materiales").html("Cargando Datos");
                    },
                    success: function (r)
                    {
                        $("#resultado_materiales").html("");
                        $("#tabla_materiales tbody").html(r);
                    },
                    error: function ()
                    {
                        alert('Ocurrio un error en el servidor ..');
                        $("#resultado_materiales").html("Error al recibir Datos");
                    }
                });
            }
        </script>
    </body>

    <!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:23:54 GMT -->
</html>

