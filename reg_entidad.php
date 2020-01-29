<?php 
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="es" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
    <!--<![endif]-->

    <head>
        <meta charset="utf-8" />
        <title>Agregar Entidad | SEGEBUCO SAC</title>
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
        <link href="assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
        <link href="assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
        <!-- ================== END PAGE LEVEL STYLE ================== -->

        <!-- ================== BEGIN BASE JS ================== -->
        <script src="assets/plugins/pace/pace.min.js"></script>
        <!-- ================== END BASE JS ================== -->
        <script>
            function enviar_ruc() {
                var parametros = {
                    "ruc": $("#input_ruc").val()
                };
                $.ajax({
                    data: parametros,
                    url: 'ajax_post/validar_ruc.php',
                    type: 'post',
                    beforeSend: function () {
                        $("#resultado").html("Procesando, espere por favor...");
                    },
                    success: function (response) {
                        $("#resultado").html("");
                        var json = response;
                        //console.log(json);

                        var json_ruc = JSON.parse(json);
                        //console.log(json_ruc.estado_del_contribuyente);
                        $("#input_razon").val(json_ruc.result.RazonSocial);
                        $("#input_estado").val(json_ruc.result.Estado);
                        $("#input_condicion").val(json_ruc.result.Condicion);
                        $("#input_direccion").val(json_ruc.result.Direccion);
                        $("#input_comercial").val(json_ruc.result.NombreComercial);
                        $("#input_comercial").prop('readonly', false);
                        $("#input_comercial").focus();
                    }
                });
            }

        </script>
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
                    <li><a href="javascript:;">Entidad</a></li>
                    <li class="active">agregar entidad</li>
                </ol>
                <!-- end breadcrumb -->
                <!-- begin page-header -->
                <h1 class="page-header">Registro de entidad <small>matenimiento entidad</small></h1>
                <!-- end page-header -->

                <div class="row">
                    <form class="form-horizontal" id="frm_detalle" method="post" action="procesos/reg_entidad.php">
                        <div class="col-md-12">
                            <div class="panel panel-inverse">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Datos Generales</h4>
                                </div>
                                <div class="panel-body">
                                    <div id="resultado"></div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="input_ruc">RUC</label>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control text-center" id="input_ruc" name="input_ruc"/>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" onclick="enviar_ruc()"  class="btn btn-info">Validar RUC</button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="input_razon">Razon Social</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" id="input_razon" name="input_razon" readonly="true" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="input_comercial">Nombre Comercial</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" id="input_comercial" name="input_comercial" readonly="true" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="input_direcion" >Direccion fiscal</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" id="input_direccion" name="input_direccion" readonly="true" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="input_condicion">Condicion</label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" id="input_condicion" name="input_condicion" readonly="true" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="input_estado">Estado</label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" id="input_estado" name="input_estado" readonly="true" />
                                        </div>
                                    </div>

                                </div>
                                <div class="panel-footer text-right" >
                                    <button type="submit" class="btn btn-success">Guardar </button>
                                </div>
                            </div>
                        </div>
                    </form>
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
        <script src="assets/plugins/DataTables/media/js/jquery.dataTables.js"></script>
        <script src="assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
        <script src="assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
        <script src="assets/js/table-manage-default.demo.min.js"></script>
        <script src="assets/js/apps.min.js"></script>
        <!-- ================== END PAGE LEVEL JS ================== -->
        <script>
                                                $(document).ready(function () {
                                                    App.init();
                                                    TableManageDefault.init();
                                                });
        </script>
    </body>

    <!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:23:54 GMT -->
</html>

