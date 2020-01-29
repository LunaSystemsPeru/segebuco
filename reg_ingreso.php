<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

$_SESSION['ingreso_material'] = "";
$_SESSION['ingreso_herramienta'] = "";
$_SESSION['ingreso_botellas'] = "";
$_SESSION['suma_material'] = 0;
$_SESSION['suma_herramienta'] = 0;

require 'class/cl_detalle_tabla_general.php';
require 'class/cl_tipo_documento.php';
require_once 'class/cl_almacen.php';
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
        <title>Agregar Documento Ingreso | SEGEBUCO SAC</title>
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
                    <li class="active">agregar documento ingreso</li>
                </ol>
                <!-- end breadcrumb -->
                <!-- begin page-header -->
                <h1 class="page-header">Registro de Documento de Ingreso <small>matenimiento almacenes</small></h1>
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
                                <form class="form-horizontal" id="frm_reg_ingreso" method="post" action="procesos/reg_ingreso.php">
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
                                                        <label class="col-md-2 control-label">Almacen Origen:</label>
                                                        <input type="hidden" name="select_almacen" value="<?php echo $_SESSION['almacen'] ?>" />
                                                        <div class="col-md-10">
                                                            <input type="text" class="form-control" name="input_origen" value="<?php echo $cl_almacen->getNombre() ?>" readonly="true"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Moneda</label>
                                                        <div class="col-md-3">
                                                            <select class="form-control" name="select_moneda" id="select_moneda" onchange="validar_moneda()">
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
                                                        <label class="col-md-2 control-label">TC sunat</label>
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control text-right" name="input_tc" id="input_tc" maxlength="6" required />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Sub Total</label>
                                                        <div class="col-md-3">
                                                            <input type="text" class="form-control text-right" value="0.00" name="input_subtotal" id="input_subtotal" required readonly="true"/>
                                                        </div>
                                                        <label class="col-md-1 control-label">IGV</label>
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control text-right" value="0.00"  name="input_igv" id="input_igv" required readonly="true"/>
                                                        </div>
                                                        <label class="col-md-1 control-label">Total</label>
                                                        <div class="col-md-3">
                                                            <input type="text" class="form-control text-right" value="0.00" name="input_total" id="input_total" required readonly="true"/>
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
                                                        <div class="col-md-7">
                                                            <input type="text" class="form-control" name="input_buscar_material" id="input_buscar_material"/>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <a href="reg_material.php" class="btn btn-success" name="btn_crear_material" id="btn_crear_material" target="_blank">Nuevo Material</a>
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
                                                            <input type="text" class="form-control text-right" name="input_cantidad_material" id="input_cantidad_material" disabled="true"/>
                                                        </div>
                                                        <label class="col-md-1 control-label">Costo con IGV</label>
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control text-right"  name="input_cigv_material" id="input_cigv_material" onkeyup="calcular_precio()" disabled="true"/>
                                                        </div>
                                                        <label class="col-md-1 control-label">Costo Sin IGV</label>
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control text-right"  name="input_costo_material" id="input_costo_material" disabled="true"/>
                                                        </div>
                                                        <div class="col-md-2">
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


                                        <!-- begin wizard step-3 -->
                                        <div>
                                            <fieldset>
                                                <legend class="pull-left width-full">Agregar Herramientas</legend>
                                                <!-- begin row -->
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Buscar Herramientas</label>
                                                        <div class="col-md-7">
                                                            <input type="text" class="form-control" name="input_buscar_herramientas" id="input_buscar_herramientas"/>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <a href="reg_herramienta.php" class="btn btn-success" name="btn_crear_herramienta" id="btn_crear_herramienta" target="_blank">Nueva Herramienta</a>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Herramienta</label>
                                                        <div class="col-md-1">
                                                            <input type="text" class="form-control text-center" name="input_id_herramienta" id="input_id_herramienta" readonly="true"/>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" name="input_nombre_herramienta" id="input_nombre_herramienta" readonly="true"/>
                                                        </div>
                                                        <label class="col-md-1 control-label">Tipo</label>
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control text-center" name="input_tipo_herramienta" id="input_tipo_herramienta" readonly="true"/>
                                                            <input type="hidden" name="select_tipo_herramienta" id="select_tipo_herramienta" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Cantidad</label>
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control text-right" name="input_cantidad_herramienta" id="input_cantidad_herramienta" readonly="true"/>
                                                        </div>
                                                        <label class="col-md-1 control-label">Costo con IGV</label>
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control text-right"  name="input_cigv_herramienta" id="input_cigv_herramienta" onkeyup="herramienta_sigv()" disabled="true"/>
                                                        </div>
                                                        <label class="col-md-1 control-label">Costo Sin IGV</label>
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control text-right"  name="input_costo_herramienta" id="input_costo_herramienta" disabled="true"/>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <button type="button" class="btn btn-primary" id="btn_agregar_herramienta" onclick="add_herramienta()">Agregar Herramientas</button>
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
                                                                        <th>Tipo</th>
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
                                        <!-- end wizard step-3 -->


                                        <!-- begin wizard step-4 -->
                                        <div>
                                            <fieldset>
                                                <legend class="pull-left width-full">Agregar Botellas</legend>
                                                <!-- begin row -->
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Buscar Botella</label>
                                                        <div class="col-md-3">
                                                            <input type="text" class="form-control" name="input_buscar_botellas" id="input_buscar_botellas"/>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <a href="reg_cilindro.php" class="btn btn-success" name="btn_crear_cilindro" id="btn_crear_cilindro" target="_blank">Nuevo Cilindro</a>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Botella</label>
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control text-center" name="input_id_cilindro" id="input_id_cilindro" readonly="true"/>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <input type="text" class="form-control" name="input_nombre_cilindro" id="input_nombre_cilindro" readonly="true"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-md-7">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <button type="button" class="btn btn-primary" onclick="add_cilindro()" id="btn_agregar_cilindro">Agregar Botella</button>
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
                                                        <div id="resultado_cilindros" >
                                                        </div>
                                                        <div class="table-responsive" >
                                                            <table id="tabla_cilindros" class="table table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-center">Id.</th>
                                                                        <th class="text-center">Descripcion</th>
                                                                        <th class="text-center">Acciones</th>
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
                                                                    $('#input_periodo').mask('999999');
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
                        if (data.status === validator.STATUS_INVALID) {
                            $icon.removeClass(faIcon.valid).addClass(faIcon.invalid);
                        } else if (data.status === validator.STATUS_VALID) {
                            var isValidTab = validator.isValidContainer($tabPane);
                            $icon.removeClass(faIcon.valid).addClass(isValidTab ? faIcon.valid : faIcon.invalid);
                        }
                    }
                });
            }

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
                    amount_parts[0] = amount_parts[0].replace(regexp, '$1' + '' + '$2');
                return amount_parts.join('.');
            }

            function calcular_precio() {
                var cigv = $("#input_cigv_material").val();
                var sigv = cigv / 1.18;
                $("#input_costo_material").val(sigv.toFixed(5));
            }

            function herramienta_sigv() {
                var cigv = $("#input_cigv_herramienta").val();
                var sigv = cigv / 1.18;
                $("#input_costo_herramienta").val(sigv.toFixed(5));
            }

            function validar_moneda() {
                var moneda = $("#select_moneda").val();
                if (moneda === "1") {
                    $("#input_tc").val("1.000");
                } else {
                    $("#input_tc").val('');
                    $("#input_tc").focus();
                }
                //console.log("moneda seleccionada " + $("#select_moneda").val());
            }


            $(function () {
                //autocomplete
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

                $("#input_buscar_material").autocomplete({
                    source: "ajax_post/buscar_materiales.php",
                    minLength: 2,
                    select: function (event, ui) {
                        event.preventDefault();
                        $('#input_id_material').val(ui.item.id);
                        $('#input_nombre_material').val(ui.item.descripcion);
                        $('#input_cantidad_material').val(1);
                        $('#input_costo_material').val(ui.item.precio_compra);
                        $('#input_buscar_material').val("");
                        $('#btn_agregar_material').prop("disabled", false);
                        $('#input_cantidad_material').prop("disabled", false);
                        $('#input_costo_material').prop("disabled", false);
                        $('#input_cigv_material').prop("disabled", false);
                        $('#input_cantidad_material').focus();
                    }
                });

                $("#input_buscar_herramientas").autocomplete({
                    source: "ajax_post/buscar_herramientas.php",
                    minLength: 2,
                    select: function (event, ui) {
                        event.preventDefault();
                        var tipo = ui.item.tipo;
                        if (tipo === '1') {
                            $('#input_id_herramienta').val(ui.item.id);
                            $('#input_nombre_herramienta').val(ui.item.descripcion);
                            $('#input_cantidad_herramienta').val(1);
                            $('#input_cantidad_herramienta').prop("readonly", true);
                            $('#input_costo_herramienta').prop("disabled", false);
                            $('#input_cigv_herramienta').prop("disabled", false);
                            $('#input_costo_herramienta').val(ui.item.precio_compra);
                            $('#input_buscar_herramientas').val("");
                            $('#select_tipo_herramienta').val(0);
                            $('#input_tipo_herramienta').val("X SERIE");
                            $('#input_costo_herramienta').focus();
                        }
                        if (tipo === '2') {
                            $('#input_id_herramienta').val(ui.item.id);
                            $('#input_nombre_herramienta').val(ui.item.descripcion);
                            $('#input_cantidad_herramienta').val(1);
                            $('#input_cantidad_herramienta').prop("readonly", false);
                            $('#input_costo_herramienta').prop("disabled", false);
                            $('#input_cigv_herramienta').prop("disabled", false);
                            $('#input_costo_herramienta').val(ui.item.precio_compra);
                            $('#input_buscar_herramientas').val("");
                            $('#select_tipo_herramienta').val(1);
                            $('#input_tipo_herramienta').val("AGRUPADA");
                            $('#input_cantidad_herramienta').focus();
                        }
                        $('#btn_agregar_herramienta').prop("disabled", false);
                    }
                });

                $("#input_buscar_botellas").autocomplete({
                    source: "ajax_post/buscar_cilindros.php",
                    minLength: 2,
                    select: function (event, ui) {
                        event.preventDefault();
                        $('#input_id_cilindro').val(ui.item.id);
                        $('#input_nombre_cilindro').val(ui.item.gas + ' - ' + ui.item.capacidad + ' M3');
                        $('#input_buscar_botellas').val("");
                        $("#btn_agregar_cilindro").prop("disabled", false);
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
                $("#input_costo_material").val("");
                $("#input_cigv_material").val("");
                $("#btn_agregar_material").prop("disabled", true);
                $("#input_cigv_material").prop("disabled", true);
                $("#input_costo_material").prop("disabled", true);
                $("#input_cantidad_material").prop("disabled", true);
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
                        cantidad: $("#input_cantidad_herramienta").val(),
                        costo: $("#input_costo_herramienta").val()
                    },
                    url: 'ajax_post/ingreso_herramientas.php',
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
                $("#input_cantidad_herramienta").val("");
                $("#input_costo_herramienta").val("");
                $("#input_tipo_herramienta").val("");
                $("#btn_agregar_herramienta").prop("disabled", true);
                $("#input_cantidad_herramienta").prop("readonly", true);
                $("#input_costo_herramienta").prop("readonly", true);
                $("#input_buscar_herramientas").focus();
            }

            function del_herramienta(posicion) {
                $.ajax({
                    data: {posicion: posicion},
                    url: 'ajax_post/eliminar_herramienta.php',
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
                    url: 'ajax_post/ingreso_cilindros.php',
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
                    url: 'ajax_post/eliminar_cilindro.php',
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

