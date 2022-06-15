<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

require 'class/cl_cliente.php';
require 'class/cl_proyectos.php';
require 'class/cl_detalle_tabla_general.php';
require 'class/cl_tipo_documento.php';
$cl_detalle = new cl_detalle_tabla_general();
$cl_cliente = new cl_cliente();
$cl_proyecto = new cl_proyectos();
$cl_tido = new cl_tipo_documento();
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="es" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
    <!--<![endif]-->

    <head>
        <meta charset="utf-8" />
        <title>Agregar Cotizacion | SEGEBUCO SAC</title>
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
        <link href="assets/plugins/bootstrap-wysihtml5/src/bootstrap-wysihtml5.css" rel="stylesheet" />
        <!-- ================== END PAGE LEVEL STYLE ================== -->

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
                    <li><a href="javascript:;">Operaciones</a></li>
                    <li class="active">agregar cotizacion</li>
                </ol>
                <!-- end breadcrumb -->
                <!-- begin page-header -->
                <h1 class="page-header">Registro de Cotizacion<small>matenimiento proyectos</small></h1>
                <!-- end page-header -->

                <div class="row">

                    <div class="col-md-12">
                        <div class="panel panel-inverse">

                            <div class="panel-heading">
                                <h4 class="panel-title">Datos Generales</h4>
                            </div>

                            <form class="form-horizontal" id="frm_reg_ingreso" method="post" action="procesos/reg_cotizacion.php" enctype="multipart/form-data">
                                <div class="panel-body">
                                    <div>
                                        <fieldset>
                                            <!-- begin row -->
                                            <div class="row">
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Fecha</label>
                                                    <div class="col-md-3">
                                                        <input type="text" class="form-control text-center" name="input_fecha" id="input_fecha" value="<?php echo date('d/m/Y') ?>" required />
                                                    </div>
                                                    <label class="col-md-1 control-label">Codigo</label>
                                                    <div class="col-md-2">
                                                        <input type="text" class="form-control text-center" name="input_codigo" id="input_codigo" required />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Clientes</label>
                                                    <div class="col-md-7">
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
                                                    <div class="col-md-7">
                                                        <select class="form-control" name="select_sucursal" id="select_sucursal" disabled="true">
                                                            <option>Seleccionar Cliente</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Solicitante</label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" name="input_solicitante" id="input_solicitante" required />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Atencion</label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" name="input_atencion" id="input_atencion" required />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Proyecto</label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" name="input_descripcion" id="input_descripcion" required />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Moneda</label>
                                                    <div class="col-md-3">
                                                        <select class="form-control" name="select_moneda" id="select_moneda">
                                                            <?php
                                                            $cl_detalle->setTabla(5);
                                                            $a_moneda = $cl_detalle->v_detalle();
                                                            foreach ($a_moneda as $value) {
                                                                ?>
                                                                <option value="<?php echo $value['id'] ?>"><?php echo $value['descripcion'] ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
<!--                                                    <label class="col-md-2 control-label">Incluye IGV</label>
                                                    <div class="col-md-2">
                                                        <input type="checkbox" name="incluye_igv" id="incluye_igv" value="1"/>
                                                    </div>-->
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Sub Total</label>
                                                    <div class="col-md-2">
                                                        <input type="text" class="form-control text-right" value="0.00" name="input_subtotal" id="input_subtotal" onkeyup="calcular_total()"  required />
                                                    </div>
                                                    <label class="col-md-1 control-label">IGV</label>
                                                    <div class="col-md-2">
                                                        <input type="text" class="form-control text-right" value="0.00"  name="input_igv" id="input_igv" required readonly="true"/>
                                                    </div>
                                                    <label class="col-md-1 control-label">Total</label>
                                                    <div class="col-md-2">
                                                        <input type="text" class="form-control text-right" value="0.00" name="input_total" id="input_total" required readonly="true"/>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Duracion (dias)</label>
                                                    <div class="col-md-2">
                                                        <input type="text" class="form-control" name="input_duracion" id="input_duracion" required />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Tipo de Servicio</label>
                                                    <div class="col-md-7">
                                                        <select class="form-control" name="select_servicio" id="select_servicio">
                                                            <option value="1">A TODO COSTO</option>
                                                            <option value="2">POR ALQUILER TRANSPORTE</option>
                                                            <option value="3">POR COMPRA CHATARRA</option>
                                                            <option value="4">POR MANO DE OBRA</option>
                                                            <option value="5">POR MANO DE OBRA + CONSUMIBLES</option>
                                                            <option value="6">POR TRASLADO DE MERCADERIA</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Forma de Pago</label>
                                                    <div class="col-md-7">
                                                        <select class="form-control" name="select_pago" id="select_pago">
                                                            <option value="1">A CONVENIR</option>
                                                            <option value="2">30% ADELANTO</option>
                                                            <option value="3">50% ADELANTO</option>
                                                            <option value="4">CONTRAENTREGA</option>
                                                            <option value="5">POR VALORIZACION SEMANAL</option>
                                                            <option value="6">45 DIAS DESPUES DE LA FACTURA</option>
                                                        </select>
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
                                            <!-- end row -->
                                        </fieldset>
                                    </div>
                                    <!-- end wizard step-1 -->

                                </div>
                                <div class="panel-footer text-right" >
                                    <button type="submit" class="btn btn-success">Guardar </button>
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
                                                                $('#input_fecha').mask('99/99/9999');
                                                                $('#input_periodo').mask('999999');
                                                                validar_formulario();
                                                                $("#select_cliente").trigger('change');
                                                            })
        </script>
        <script type="text/javascript">
            function validar_formulario() {
                var faIcon = {
                    valid: 'fa fa-check-circle fa-lg text-success',
                    invalid: 'fa fa-times-circle fa-lg',
                    validating: 'fa fa-refresh'
                };
                // FORM VALIDATION ON TABS
                // =================================================================
                $('#frm_reg_ingreso').bootstrapValidator({
                    message: 'This value is not valid',
                    excluded: ':disabled',
                    feedbackIcons: faIcon,
                    fields: {
                        input_periodo: {
                            validators: {
                                notEmpty: {
                                    message: 'The phone number is required and cannot be empty'
                                },
                                digits: {
                                    message: 'The value can contain only digits'
                                }
                            }
                        },
                        input_serie: {
                            validators: {
                                notEmpty: {
                                    message: 'The phone number is required and cannot be empty'
                                },
                                digits: {
                                    message: 'The value can contain only digits'
                                }
                            }
                        },
                        input_numero: {
                            validators: {
                                notEmpty: {
                                    message: 'The phone number is required and cannot be empty'
                                },
                                digits: {
                                    message: 'The value can contain only digits'
                                }
                            }
                        },
                        input_tc: {
                            validators: {
                                notEmpty: {
                                    message: 'The phone number is required and cannot be empty'
                                },
                                numeric: {
                                    message: 'The value can contain only number and point'
                                }
                            }
                        },
                        input_subtotal: {
                            validators: {
                                notEmpty: {
                                    message: 'The phone number is required and cannot be empty'
                                }
                            }
                        },
                        input_igv: {
                            validators: {
                                notEmpty: {
                                    message: 'The phone number is required and cannot be empty'
                                }
                            }
                        }
                    }
                }).on('status.field.bv', function (e, data) {
                    var $form = $(e.target),
                            validator = data.bv,
                            $tabPane = data.element.parents('.tab-pane'), tabId = $tabPane.attr('id');
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
            }

            $(document).ready(function (e) {
                // Function to preview image after validation
                $(function () {
                    $("#file").change(function () {
                        $("#message").empty(); // To remove the previous error message
                        var ext = $("#file").val().split('.').pop().toLowerCase();
                        if ($.inArray(ext, ['pdf', 'doc', 'docx']) == -1)
                        {
                            $("#message").html("<p id='error'>Por Favor Seleccione un archivo valido</p>" + "<h4>Nota</h4>" + "<span id='error_message'>Solamente *.pdf, *.doc, *.docx esta permitidos</span>");
                            $("#btn_guardar").prop('disabled', true);
                            return false;
                        } else
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

            function calcular_total() {
                var subtotal = $("#input_subtotal").val();
                var igv = subtotal * 0.18;
                var total = subtotal * 1.18;

                $("#input_igv").val(number_format(igv, 2));
                $("#input_total").val(number_format(total, 2));
                $("#hidden_total").val(total);
            }
        </script>
        <script>
            $("#select_cliente").change(function () {
                // Guardamos el select de cursos
                var sucursales = $("#select_sucursal");
                // Guardamos el select de alumnos
                var cliente = $(this);
                if ($(this).val() !== '')
                {
                    //ver_datos_cliente(cliente.val());
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
                            cliente.prop('disabled', true);
                        }
                    });
                } else
                {
                    sucursales.find('option').remove();
                    sucursales.prop('disabled', true);
                }
            });

            function incluir_igv() {
                var incluido = $("#incluir_igv").val();
                alert(incluido);
            }
        </script>

    </body>

    <!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:23:54 GMT -->
</html>

