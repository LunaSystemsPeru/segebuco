<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

//$_SESSION['traslado_material'] = array();
//$_SESSION['traslado_herramienta'] = array();
//$_SESSION['traslado_botellas'] = array();

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
        <title>Registrar Retorno a Almacen | SEGEBUCO SAC</title>
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
                    <li class="active">agregar retorno</li>
                </ol>
                <!-- end breadcrumb -->
                <!-- begin page-header -->
                <h1 class="page-header">Registro de Retorno a Almacen <small>matenimiento almacenes</small></h1>
                <!-- end page-header -->
                <?php
                $cl_almacen->setCodigo($_SESSION["almacen"]);
                $cl_almacen->datos_almacen();
                ?>

                <div class="row">

                    <div class="col-md-12">
                        <div class="panel panel-inverse">

                            <div class="panel-heading">
                                <h4 class="panel-title">TRASLADO: <?php echo $cl_almacen->getNombre() ?> -=> seleccionar almacen</h4>
                            </div>

                            <div class="panel-body">
                                <form class="form-horizontal" id="frm_reg_retorno" method="post" action="procesos/reg_retorno.php">
                                    <div id="wizard">
                                        <ol>
                                            <li>Datos Generales</li>
                                            <li>Insumos</li>
                                            <li>Herramientas</li>
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
                                                        <label class="col-md-2 control-label">Fecha</label>
                                                        <div class="col-md-3">
                                                            <input type="text" class="form-control text-center" name="input_fecha" id="input_fecha" value="<?php echo date('d/m/Y') ?>" required />
                                                        </div>
                                                        <label class="col-md-2 control-label">Usuario</label>
                                                        <div class="col-md-3">
                                                            <input type="text" class="form-control text-center" name="input_usuario" id="input_usuario" value="<?php echo $_SESSION['usuario'] ?>" readonly="true" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Almacen Origen:</label>
                                                        <input type="hidden" name="input_origen" value="1" />
                                                        <div class="col-md-10">
                                                            <input type="text" class="form-control" name="input_origen" value="<?php echo $cl_almacen->getNombre() ?>" readonly="true"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Almacen Destino:</label>
                                                        <div class="col-md-10">
                                                            <select name="select_destino" id="select_destino" class="form-control">
                                                                <?php
                                                                $a_almacen_destino = $cl_almacen->ver_almacenes();
                                                                foreach ($a_almacen_destino as $value) {
                                                                    ?>
                                                                    <option value="<?php echo $value['codigo'] ?>"><?php echo $value['nombre'] ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
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
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" name="input_buscar_material" id="input_buscar_material"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Material</label>
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control text-center" name="input_id_material" id="input_id_material" readonly="true"/>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" name="input_nombre_material" id="input_nombre_material" readonly="true"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Cantidad</label>
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control text-right" name="input_cantidad_material" id="input_cantidad_material"/>
                                                        </div>
                                                        <div class="col-md-4">

                                                        </div>
                                                        <div class="col-md-3">
                                                            <button type="button" class="btn btn-primary" onclick="add_material()" id="btn_agregar_material">Agregar Materiales</button>
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


                                        <!-- begin wizard step-3 -->
                                        <div>
                                            <fieldset>
                                                <legend class="pull-left width-full">Agregar Herramientas</legend>
                                                <!-- begin row -->
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Buscar Herramientas</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" name="input_buscar_herramientas" id="input_buscar_herramientas"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Herramienta</label>
                                                        <div class="col-md-1">
                                                            <input type="text" class="form-control text-center" name="input_id_herramienta" id="input_id_herramienta" readonly="true"/>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" name="input_nombre_herramienta" id="input_nombre_herramienta" readonly="true"/>
                                                        </div>

                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Tipo</label>
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control text-center" name="input_tipo_herramienta" id="input_tipo_herramienta" readonly="true"/>
                                                            <input type="hidden" name="select_tipo_herramienta" id="select_tipo_herramienta" />
                                                        </div>
                                                        <label class="col-md-1 control-label">Cant. Actual</label>
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control text-right" name="input_cactual_herramienta" id="input_cactual_herramienta" readonly="true"/>
                                                        </div>
                                                        <label class="col-md-1 control-label">Cant. Doc.</label>
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control text-right" name="input_cdoc_herramienta" id="input_cdoc_herramienta" readonly="true"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Documento:</label>
                                                        <div class="col-md-5">
                                                            <select name="select_documento_herramienta" id="select_documento_herramienta" class="form-control" onchange="datos_documento_herramienta()" disabled>
                                                            </select>
                                                        </div>
                                                        <label class="col-md-1 control-label">Cant. Retorno</label>
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control text-right" name="input_cretorno_herramienta" id="input_cretorno_herramienta" readonly="true"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-md-2">
                                                            <input type="hidden" name="h_documento" id="hidden_documento" />
                                                            <button type="button" class="btn btn-primary" id="btn_agregar_herramienta" onclick="add_herramienta()" disabled="true">Agregar Herramientas</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end row -->
                                            </fieldset>
                                            <fieldset>
                                                <legend class="pull-left width-full">Ver Herramientas</legend>
                                                <!-- begin row -->
                                                <div class="row">
                                                    <div class="col-xs-12" >
                                                        <div id="resultado_herramientas" >
                                                        </div>
                                                        <div class="table-responsive" >
                                                            <table id="tabla_herramientas" class="table table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Id.</th>
                                                                        <th>Descripcion</th>
                                                                        <th>Documento</th>
                                                                        <th>Cantidad</th>
                                                                        <th>Und. Med.</th>
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
                                        <!-- end wizard step-3 -->


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
                                                                    validar_formulario();
                                                                });
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
                $('#frm_reg_traslado').bootstrapValidator({
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

    </script>
    <script>
        function datos_documento_herramienta() {
            var codigo = $("#select_documento_herramienta").val();
            $.ajax({
                data: {codigo: codigo},
                url: 'ajax_post/cant_herramienta_documentos.php',
                type: 'POST',
                dataType: 'json',
                beforeSend: function ()
                {
                    $("#input_cdoc_herramienta").val("");
                },
                success: function (r)
                {
                    var json = r;
                    console.log(json);
                    var cantidad = json[0].cantidad;
                    $("#input_cdoc_herramienta").val(cantidad);
                    if (cantidad > 1) {
                        $("#input_cretorno_herramienta").focus();
                    } else {
                        $('#input_cretorno_herramienta').prop("readonly", true);
                    }
                    $("#hidden_documento").val(json[0].documento);
                },
                error: function ()
                {
                    alert('Ocurrio un error en el servidor ..');
                    $("#input_cdoc_herramienta").val("");
                }
            });
        }
        
        function doc_herramientas(id_herramienta) {
            var select_documento = $("#select_documento_herramienta");
            if (id_herramienta !== '')
            {
                $.ajax({
                    data: {id: id_herramienta},
                    url: 'ajax_post/ver_documentos_herramientas.php',
                    type: 'POST',
                    dataType: 'json',
                    beforeSend: function ()
                    {
                        select_documento.prop('disabled', true);
                    },
                    success: function (r)
                    {
                        // Limpiamos el select
                        select_documento.find('option').remove();
                        $(r).each(function (i, v) { // indice, valor
                            select_documento.append('<option value="' + v.value + '">' + v.texto + '</option>');
                        });
                        select_documento.prop('disabled', false);
                        datos_documento_herramienta();
                    },
                    error: function ()
                    {
                        alert('Ocurrio un error en el servidor ..');
                        select_documento.prop('disabled', false);
                    }
                });
            }
            else
            {
                select_documento.find('option').remove();
                select_documento.prop('disabled', true);
            }
        };
    </script>
    <script>
            $(function () {
                $("#input_buscar_material").autocomplete({
                    source: "ajax_post/buscar_mis_materiales.php",
                    minLength: 2,
                    select: function (event, ui) {
                        event.preventDefault();
                        $('#input_id_material').val(ui.item.id);
                        $('#input_nombre_material').val(ui.item.descripcion);
                        $('#input_cantidad_material').val(1);
                        $('#input_buscar_material').val("");
                        $('#btn_agregar_material').prop("disabled", false);
                        $('#input_cantidad_material').focus();
                    }
                });

                $("#input_buscar_herramientas").autocomplete({
                    source: "ajax_post/buscar_mis_herramientas.php",
                    minLength: 2,
                    select: function (event, ui) {
                        event.preventDefault();
                        var tipo = ui.item.tipo;
                        $('#input_id_herramienta').val(ui.item.id);
                        $('#input_nombre_herramienta').val(ui.item.descripcion);
                        $('#input_cactual_herramienta').val(ui.item.cantidad);
                        $('#input_cretorno_herramienta').val(1);
                        $('#input_buscar_herramientas').val("");
                        if (tipo === '1') {
                            $('#input_cretorno_herramienta').prop("readonly", true);
                            $('#select_tipo_herramienta').val(0);
                            $('#input_tipo_herramienta').val("X SERIE");
                        }
                        if (tipo === '2') {
                            $('#input_cretorno_herramienta').prop("readonly", false);
                            $('#select_tipo_herramienta').val(1);
                            $('#input_tipo_herramienta').val("AGRUPADA");
                        }
                        $('#input_cantidad_herramienta').focus();
                        doc_herramientas(ui.item.id);
                        $('#btn_agregar_herramienta').prop("disabled", false);
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
            function add_material() {
                $.ajax({
                    data: {
                        id_material: $("#input_id_material").val(),
                        descripcion: $("#input_nombre_material").val(),
                        marca: '',
                        cantidad: $("#input_cantidad_material").val()
                    },
                    url: 'ajax_post/ingreso_materiales.php',
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
                $("#btn_agregar_material").prop("disabled", true);
                $("#input_buscar_material").focus();
            }

            function del_material(posicion) {
                $.ajax({
                    data: {posicion: posicion},
                    url: 'ajax_post/eliminar_material.php',
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

        <script>
            function add_herramienta() {
                $.ajax({
                    data: {
                        id_material: $("#input_id_herramienta").val(),
                        descripcion: $("#input_nombre_herramienta").val(),
                        tipo: $("#select_tipo_herramienta").val(),
                        codigo: $("#select_documento_herramienta").val(),
                        documento: $("#hidden_documento").val(),
                        cantidad: $("#input_cretorno_herramienta").val()
                    },
                    url: 'ajax_post/retorno_herramientas.php',
                    type: 'POST',
                    //dataType: 'json',
                    beforeSend: function ()
                    {
                        $("#resultado_herramientas").html("Cargando Datos");
                        $("#tabla_herramientas tbody").html("");
                    },
                    success: function (r)
                    {
                        $("#resultado_herramientas").html("");
                        $("#tabla_herramientas tbody").html(r);
                        limpiar_herramienta();
                    },
                    error: function ()
                    {
                        alert('Ocurrio un error en el servidor ..');
                        $("#resultado_herramientas").html("Error al recibir Datos");
                        $("#tabla_herramientas tbody").html("");
                    }
                });
            }
            
            function limpiar_herramienta() {
                $("#input_id_herramienta").val("");
                $("#input_nombre_herramienta").val("");
                $("#input_cactual_herramienta").val("");
                $("#input_cretorno_herramienta").val("");
                $("#input_cdoc_herramienta").val("");
                $("#input_costo_herramienta").val("");
                $("#input_tipo_herramienta").val("");
                $("#btn_agregar_herramienta").prop("disabled", true);
                $("#select_documento_herramienta").find('option').remove();
                $("#input_cretorno_herramienta").prop("readonly", true);
                $("#input_buscar_herramientas").focus();
            }

            function del_herramienta(posicion) {
                $.ajax({
                    data: {posicion: posicion},
                    url: 'ajax_post/eliminar_retorno_herramientas.php',
                    type: 'POST',
                    //dataType: 'json',
                    beforeSend: function ()
                    {
                        $("#resultado_herramientas").html("Cargando Datos");
                    },
                    success: function (r)
                    {
                        $("#resultado_herramientas").html("");
                        $("#tabla_herramientas tbody").html(r);
                    },
                    error: function ()
                    {
                        alert('Ocurrio un error en el servidor ..');
                        $("#resultado_herramientas").html("Error al recibir Datos");
                    }
                });
            }
        </script>

        <script>
            function add_cilindro() {
                $.ajax({
                    data: {
                        id_cilindro: $("#input_id_cilindro").val(),
                        descripcion: $("#input_nombre_cilindro").val()
                    },
                    url: 'ajax_post/traslado_cilindros.php',
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
                    url: 'ajax_post/eliminar_mis_cilindros.php',
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

