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
        <title>Agregar Cliente | SEGEBUCO SAC</title>
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
                        console.log($("#input_ruc").val().length);
                        var json_ruc = JSON.parse(json);
                        var direccion = "";
                        var comercial = "";
                        var razon = "";
                        var estado = "ACTIVO";
                        var condicion = "HABIDO";
                        if ($("#input_ruc").val().length === 8) {
                            var fuente = json_ruc.source;
                            if (fuente === "essalud") {
                                razon = json_ruc.result.ApellidoPaterno + " " + json_ruc.result.ApellidoMaterno + " " + json_ruc.result.Nombres;
                                direccion = "-";
                                comercial = razon;
                            }
                            if (fuente === "padron_jne") {
                                razon = json_ruc.result.apellidos + " " + json_ruc.result.Nombres;
                                direccion = "-";
                                comercial = razon;
                            }

                        } else {
                            razon = json_ruc.result.razonSocial;
                            estado = json_ruc.result.estado;
                            condicion = json_ruc.result.condicion;
                            direccion = json_ruc.result.direccion;
                            comercial = json_ruc.result.nombreComercial;
                        }
                        $("#input_razon").val(razon);
                        $("#input_estado").val(estado);
                        $("#input_condicion").val(condicion);
                        $("#input_direccion").val(direccion);
                        $("#input_comercial").val(comercial);
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
                    <li><a href="javascript:;">Clientes</a></li>
                    <li class="active">agregar cliente</li>
                </ol>
                <!-- end breadcrumb -->
                <!-- begin page-header -->
                <h1 class="page-header">Registro de Cliente <small>matenimiento clientes</small></h1>
                <!-- end page-header -->

                <div class="row">
                    <form class="form-horizontal" id="frm_detalle" method="post" action="procesos/reg_cliente.php">
                        <div class="col-md-12">
                            <div class="panel panel-inverse">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Datos Generales</h4>
                                </div>
                                <div class="panel-body">
                                    <div id="resultado"></div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="input_ruc">RUC / DNI</label>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control" id="input_ruc" name="input_ruc"/>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" onclick="enviar_ruc()"  class="btn btn-info">Validar DOC</button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="input_razon">Razon Social</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" id="input_razon" name="input_razon" required/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="input_comercial">Nombre Comercial</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" id="input_comercial" name="input_comercial"  />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="input_direcion" >Direccion fiscal</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" id="input_direccion" name="input_direccion"  required/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="input_condicion">Condicion</label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" id="input_condicion" name="input_condicion" readonly="true" placeholder="Habido" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="input_estado">Estado</label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" id="input_estado" name="input_estado" readonly="true" placeholder="Activo" />
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="panel panel-inverse">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Primera Sucursal</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="input_codigo_sucursal">Codigo</label>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control" name="input_codigo_sucursal" id="input_codigo_sucursal" readonly="true"  />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="input_nombre_sucursal" >Nombre</label>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="input_nombre_sucursal" id="input_nombre_sucursal" required="true"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="input_direccion_sucursal">Direccion</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="input_direccion_sucursal" id="input_direccion_sucursal" required/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="input_contacto_sucursal">Contacto</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="input_contacto_sucursal" id="input_contacto_sucursal" required/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="input_email_sucursal">Email Contacto</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="input_email_sucursal" id="input_email_sucursal" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer text-right" >
                                    <button type="submit" class="btn btn-success">Agregar </button>
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

