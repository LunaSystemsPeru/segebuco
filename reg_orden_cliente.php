<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

require 'class/cl_varios.php';
require 'class/cl_orden_cliente.php';
require 'class/cl_cliente.php';

$cl_cliente = new cl_cliente();
$cl_varios = new cl_varios();
$cl_orden = new cl_orden_cliente();
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="es" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
    <!--<![endif]-->

    <head>
        <meta charset="utf-8" />
        <title>Agregar Orden de Cliente | SEGEBUCO SAC</title>
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
                    <li class="active">agregar orden de cliente</li>
                </ol>
                <!-- end breadcrumb -->
                <!-- begin page-header -->
                <h1 class="page-header">Registro de orden de Cliente<small>matenimiento operaciones</small></h1>
                <!-- end page-header -->

                <div class="row">

                    <div class="col-md-12">
                        <div class="panel panel-inverse">

                            <div class="panel-heading">
                                <h4 class="panel-title">Datos Generales</h4>
                            </div>
                            <form class="form-horizontal" id="form_orden_cliente" name="form_orden_cliente" method="post" action="procesos/reg_orden_cliente.php" enctype="multipart/form-data">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Cliente:</label>
                                        <div class="col-md-8">
                                            <select class="form-control" name="select_cliente" id="select_cliente">
                                                <?php
                                                $a_clientes = $cl_cliente->ver_clientes();
                                                foreach ($a_clientes as $value) {
                                                    ?>
                                                    <option value="<?php echo $value['id'] ?>"><?php echo $value['razon_social'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Sucursal</label>
                                        <div class="col-md-4">
                                            <select class="form-control" name="select_sucursal" id="select_sucursal">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Nro Orden:</label>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control" name="input_codigo" required="true"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Fecha:</label>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control" name="input_fecha" id="input_fecha" required="true"/>
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
                                            <input type="text" class="form-control text-right" name="input_total" id="input_total" required="true"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Glosa:</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="input_glosa" id="input_glosa" required/>
                                        </div>
                                    </div>
                                    <div class="form-group">

                                        <label class="col-md-2 control-label">Archivo:</label>
                                        <div class="col-md-8">
                                            <div id="message"></div>
                                            <input class="form-control" type="file" name="file" id="file" required/>
                                        </div>

                                    </div>
                                </div>
                                <div class="panel-footer text-right" >
                                    <button type="submit" class="btn btn-success" id="btn_guardar">Guardar </button>
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
        </script>

        <script language="javascript">
            $(document).ready(function () {
                $('#input_fecha').mask('99/99/9999');

                var faIcon = {
                    valid: 'fa fa-check-circle fa-lg text-success',
                    invalid: 'fa fa-times-circle fa-lg',
                    validating: 'fa fa-refresh'
                };



                // FORM VALIDATION ON TABS
                // =================================================================
                $('#form_orden_cliente').bootstrapValidator({
                    message: 'This value is not valid',
                    excluded: ':disabled',
                    feedbackIcons: faIcon,
                    fields: {
                        input_total: {
                            validators: {
                                numeric: {
                                    message: 'The value can contain only number and point'
                                }
                            }
                        }
                    }
                }).on('status.field.bv', function (e, data) {
                    var $form = $(e.target),
                            validator = data.bv,
                            $tabPane = data.element.parents('.tab-pane'),
                            tabId = $tabPane.attr('id');

                    if (tabId) {
                        var $icon = $('a[href="#' + tabId + '"][data-toggle="tab"]').parent().find('i');

                        // Add custom class to tab containing the field
                        if (data.status == validator.STATUS_INVALID) {
                            $icon.removeClass(faIcon.valid).addClass(faIcon.invalid);
                        } else if (data.status == validator.STATUS_VALID) {
                            var isValidTab = validator.isValidContainer($tabPane);
                            $icon.removeClass(faIcon.valid).addClass(isValidTab ? faIcon.valid : faIcon.invalid);
                        }
                    }
                });

            });

            $(document).ready(function (e) {
                // Function to preview image after validation
                $(function () {
                    $("#file").change(function () {
                        $("#message").empty(); // To remove the previous error message
                        var ext = $("#file").val().split('.').pop().toLowerCase();
                        if ($.inArray(ext, ['pdf']) == -1)
                        {
                            $("#message").html("<p id='error'>Por Favor Seleccione un archivo valido</p>" + "<h4>Nota</h4>" + "<span id='error_message'>Solamente *.pdf, *.doc, *.docx esta permitidos</span>");
                            $("#btn_guardar").prop('disabled', true);
                            return false;
                        }
                        else
                        {
                            $("#btn_guardar").prop('disabled', false);
                            var reader = new FileReader();
                            reader.onload = imageIsLoaded;
                            reader.readAsDataURL(this.files[0]);
                        }
                    });
                });
                function imageIsLoaded(e) {
                    $("#file").css("color", "green");
                    //$('#previewing').attr('height', '300px');
                }
                ;
            });
        </script>

        <script>
            $("#select_cliente").change(function () {
                // Guardamos el select de cursos
                var sucursales = $("#select_sucursal");
                // Guardamos el select de alumnos
                var cliente = $(this);
                if ($(this).val() !== '')
                {
                    $.ajax({
                        data: {id: cliente.val()},
                        url: 'ajax_post/ver_sucursal_cliente.php',
                        type: 'POST',
                        dataType: 'json',
                        beforeSend: function ()
                        {
                            cliente.prop('disabled', true);
                        },
                        success: function (r)
                        {
                            cliente.prop('disabled', false);
                            // Limpiamos el select
                            sucursales.find('option').remove();
                            $(r).each(function (i, v) { // indice, valor
                                sucursales.append('<option value="' + v.id + '">' + v.nombre + '</option>');
                            });
                            sucursales.prop('disabled', false);
                            $("#select_sucursal").trigger('change');
                        },
                        error: function ()
                        {
                            alert('Ocurrio un error en el servidor ..');
                            cliente.prop('disabled', false);
                        }
                    });
                }
                else
                {
                    sucursales.find('option').remove();
                    sucursales.prop('disabled', true);
                }
            });
        </script>
    </body>

    <!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:23:54 GMT -->
</html>

