<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

require 'class/cl_usuario.php';
require 'class/cl_cliente.php';
$cl_usuario = new cl_usuario();
$cl_cliente = new cl_cliente();
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="es" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
    <!--<![endif]-->

    <head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
        
        <title>Habilitar Obra - Proyecto| SEGEBUCO SAC</title>
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
                    <li><a href="javascript:;">Operaciones</a></li>
                    <li class="active">agregar proyecto</li>
                </ol>
                <!-- end breadcrumb -->
                <!-- begin page-header -->
                <h1 class="page-header">Habilitar Proyecto - obra <small>matenimiento operaciones</small></h1>
                <!-- end page-header -->

                <div class="row">

                    <div class="col-md-12">
                        <div class="panel panel-inverse">
                            <form class="form-horizontal" id="frm_planilla" method="post" action="procesos/reg_obra.php">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Datos Generales</h4>
                                </div>
                                <div class="panel-body">
                                    <div id="resultado"></div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="input_anio">Año</label>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control" id="input_anio" name="input_anio" value="<?php echo date('Y')?>" maxlength="4" readonly="true"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="input_codigo">Codigo</label>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control" id="input_codigo" name="input_codigo" maxlength="3" readonly="true"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="select_cliente">Cliente</label>
                                        <div class="col-md-8">
                                            <select class="form-control" name="select_cliente" id="select_cliente">
                                                <?php
                                                $a_clientes = $cl_cliente->ver_clientes();
                                                foreach ($a_clientes as $value) {
                                                    ?>
                                                    <option value="<?php echo $value['id'] ?>"><?php echo $value['nombre_comercial'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="select_sucursal">Sucursal</label>
                                        <div class="col-md-8">
                                            <select class="form-control" name="select_sucursal" id="select_sucursal">
                                                <option value="--">ESCOJA UN CLIENTE</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="input_inicio">Fecha Inicio </label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" id="input_inicio" name="input_inicio" required="true"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="select_responsable">Responsable</label>
                                        <div class="col-md-8">
                                            <select class="form-control" id="select_responsable" name="select_responsable">
                                                <?php
                                                $a_usuarios = $cl_usuario->ver_usuarios();
                                                foreach ($a_usuarios as $value) {
                                                    ?>
                                                    <option value="<?php echo $value['usuario'] ?>"><?php echo $value['nombres'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer text-right" >
                                    <button type="submit" class="btn btn-success">Agregar </button>
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
            });

            $(document).ready(function () {
                $("#select_cliente").trigger('change');
            });


            // Bloqueamos el SELECT de los cursos
            //$("#select_sucursal").prop('disabled', true);

            // Hacemos la lógica que cuando nuestro SELECT cambia de valor haga algo
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

                            $('#input_inicio').focus();
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
            })

        </script>

        <script language="javascript">
            $(document).ready(function () {
                $('#input_inicio').mask('99/99/9999');
                $('#input_fin').mask('99/99/9999');

                var faIcon = {
                    valid: 'fa fa-check-circle fa-lg text-success',
                    invalid: 'fa fa-times-circle fa-lg',
                    validating: 'fa fa-refresh'
                };



                // FORM VALIDATION ON TABS
                // =================================================================
                $('#frm_planilla').bootstrapValidator({
                    message: 'This value is not valid',
                    excluded: ':disabled',
                    feedbackIcons: faIcon,
                    fields: {
                        input_anio: {
                            validators: {
                                notEmpty: {
                                    message: 'The phone number is required and cannot be empty'
                                },
                                digits: {
                                    message: 'The value can contain only digits'
                                }
                            }
                        },
                        input_semana: {
                            validators: {
                                notEmpty: {
                                    message: 'The phone number is required and cannot be empty'
                                },
                                digits: {
                                    message: 'The value can contain only digits'
                                }
                            }
                        },
                        input_jornal: {
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
        </script>
    </body>

    <!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:23:54 GMT -->
</html>

