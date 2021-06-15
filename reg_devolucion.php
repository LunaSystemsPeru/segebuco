<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

$_SESSION['traslado_botellas'] = null;

require 'class/cl_almacen.php';
require 'class/cl_detalle_tabla_general.php';
require 'class/cl_tipo_documento.php';
$cl_detalle = new cl_detalle_tabla_general();
$cl_tido = new cl_tipo_documento();
$cl_almacen = new cl_almacen();
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="es" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
    <!--<![endif]-->

    <head>
        <meta charset="utf-8" />
        <title>Agregar Documento de Devolucion | SEGEBUCO SAC</title>
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
                    <li class="active">agregar documento de devolucion</li>
                </ol>
                <!-- end breadcrumb -->
                <!-- begin page-header -->
                <h1 class="page-header">Registro de Documento de Devolucion de Botellas <small>matenimiento almacenes</small></h1>
                <!-- end page-header -->
                <?php
                $cl_almacen->setCodigo($_SESSION["almacen"]);
                $cl_almacen->datos_almacen();
                ?>

                <div class="row">

                    <div class="col-md-12">
                        <div class="panel panel-inverse">

                            <div class="panel-heading">
                                <h4 class="panel-title">Devolucion desde: <?php echo $cl_almacen->getNombre() ?></h4>
                            </div>

                            <div class="panel-body">
                                <form class="form-horizontal" id="frm_reg_traslado" method="post" action="procesos/reg_devolucion.php">
                                    <div id="wizard">
                                        <ol>
                                            <li>Datos Generales</li>
                                            <li>Botellas</li>
                                        </ol>
                                        <!-- begin wizard step-1 -->
                                        <div>
                                            <fieldset>
                                                <legend class="pull-left width-full">Datos Generales</legend>
                                                <!-- begin row -->
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Periodo</label>
                                                        <div class="col-md-3">
                                                            <input type="text" class="form-control text-center" maxlength="6" name="input_periodo" id="input_periodo" value="<?php echo date('Y') . date('m') ?>" required="true"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Proveedor:</label>
                                                        <div class="col-md-3">
                                                            <input type="text" class="form-control  text-center" name="input_ruc_proveedor" id="input_ruc_proveedor" maxlength="11"  required />
                                                        </div>
                                                        <div class="col-md-2">
                                                            <a href="reg_entidad.php" class="btn btn-default" target="_blank">Crear Proveedor</a>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="button" class="btn btn-info" value="Validar Documento" disabled="true"/>
                                                        </div>

                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Razon Social:</label>
                                                        <div class="col-md-10">
                                                            <input type="text" class="form-control" name="input_razon_proveedor" id="input_razon_proveedor" required  readonly="true"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Direccion Fiscal:</label>
                                                        <div class="col-md-10">
                                                            <input type="text" class="form-control" name="input_direccion" id="input_direccion" required  readonly="true"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Tipo Documento</label>
                                                        <div class="col-md-3">
                                                            <select class="form-control" name="select_documento" id="select_documento">
                                                                <?php
                                                                $a_documentos = $cl_tido->ver_documentos();
                                                                foreach ($a_documentos as $value) {
                                                                    ?>
                                                                    <option value="<?php echo $value['id'] ?>"><?php echo $value['nombre'] ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <label class="col-md-2 control-label">Fecha</label>
                                                        <div class="col-md-3">
                                                            <input type="text" class="form-control" name="input_fecha" id="input_fecha" value="<?php echo date('d/m/Y') ?>" required />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Serie</label>
                                                        <div class="col-md-3">
                                                            <input type="text" class="form-control text-center" name="input_serie" id="input_serie" maxlength="3" value="1" required />
                                                        </div>
                                                        <label class="col-md-2 control-label">Numero</label>
                                                        <div class="col-md-3">
                                                            <input type="text" class="form-control  text-center" name="input_numero" id="input_numero" maxlength="7"  required />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Almacen Origen:</label>
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

                                        <!-- begin wizard step-4 -->
                                        <div>
                                            <fieldset>
                                                <legend class="pull-left width-full">Agregar Botellas</legend>
                                                <!-- begin row -->
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Buscar Botella</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" name="input_buscar_botellas" id="input_buscar_botellas"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Botella</label>
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control text-center" name="input_id_cilindro" id="input_id_cilindro" readonly="true"/>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <input type="text" class="form-control" name="input_nombre_cilindro" id="input_nombre_cilindro" readonly="true"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-md-3">
                                                            <button type="button" onclick="add_cilindro()" class="btn btn-primary" id="btn_agregar_cilindro" disabled="true">Agregar Botella</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end row -->
                                            </fieldset>
                                            <fieldset>
                                                <legend class="pull-left width-full">Ver Botellas</legend>
                                                <!-- begin row -->
                                                <div class="row">
                                                    <div class="col-xs-12" >
                                                        <div class="table-responsive" >
                                                            <table id="tabla_cilindros" class="table table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Id.</th>
                                                                        <th>Descripcion</th>
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
                                        <!-- end wizard step-4 -->
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
            $(function () {
                $("#input_ruc_proveedor").autocomplete({
                    source: "ajax_post/buscar_proveedores.php",
                    minLength: 2,
                    select: function (event, ui) {
                        event.preventDefault();
                        $('#input_ruc_proveedor').val(ui.item.ruc);
                        $('#input_razon_proveedor').val(ui.item.razon_social);
                        $('#input_direccion').val(ui.item.direccion);
                    }
                });

                $("#input_buscar_botellas").autocomplete({
                    source: "ajax_post/buscar_mis_cilindros.php",
                    minLength: 2,
                    select: function (event, ui) {
                        event.preventDefault();
                        $('#input_id_cilindro').val(ui.item.id);
                        $('#input_nombre_cilindro').val(ui.item.gas + ' - ' + ui.item.capacidad + ' M3');
                        $('#input_buscar_botellas').val("");
                        $('#btn_agregar_cilindro').prop("disabled", false);
                    }
                });

            });
        </script>

        <script>
            function add_cilindro() {
                $.ajax({
                    data: {
                        id_cilindro: $("#input_id_cilindro").val(),
                        descripcion: $("#input_nombre_cilindro").val()
                    },
                    url: 'ajax_post/devolucion_cilindros.php',
                    type: 'POST',
                    //dataType: 'json',
                    beforeSend: function ()
                    {
                        $("#resultado_cilindros").html("Cargando Datos");
                        $("#tabla_cilindros tbody").html("");
                    },
                    success: function (r)
                    {
                        $("#resultado_cilindros").html("");
                        $("#tabla_cilindros tbody").html(r);
                        limpiar_cilindros();
                    },
                    error: function ()
                    {
                        alert('Ocurrio un error en el servidor ..');
                        $("#resultado_cilindros").html("Error al recibir Datos");
                        $("#tabla_cilindros tbody").html("");
                    }
                });
            }

            function limpiar_cilindros() {
                $("#input_id_cilindro").val("");
                $("#input_nombre_cilindro").val("");
                $("#btn_agregar_cilindro").prop("disabled", true);
                $("#input_buscar_botellas").focus();
            }

            function del_cilindro(posicion) {
                $.ajax({
                    data: {posicion: posicion},
                    url: 'ajax_post/eliminar_devolucion_cilindros.php',
                    type: 'POST',
                    //dataType: 'json',
                    beforeSend: function ()
                    {
                        $("#resultado_cilindros").html("Cargando Datos");
                    },
                    success: function (r)
                    {
                        $("#resultado_cilindros").html("");
                        $("#tabla_cilindros tbody").html(r);
                    },
                    error: function ()
                    {
                        alert('Ocurrio un error en el servidor ..');
                        $("#resultado_cilindros").html("Error al recibir Datos");
                    }
                });
            }
        </script>
    </body>

    <!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:23:54 GMT -->
</html>

