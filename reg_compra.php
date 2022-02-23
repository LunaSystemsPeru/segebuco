<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

require 'class/cl_cliente.php';
require 'class/cl_detalle_tabla_general.php';
require 'class/cl_centro_costo.php';
require 'class/cl_tipo_documento.php';

$cl_detalle = new cl_detalle_tabla_general();
$cl_cliente = new cl_cliente();
$cl_centro = new cl_centro_costo();
$cl_tido = new cl_tipo_documento();
?>
<!DOCTYPE html>
<!--[if IE 8]>
<html lang="es" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
<!--<![endif]-->

<head>
    <meta charset="utf-8"/>
    <title>Agregar Documento Compra | SEGEBUCO SAC</title>
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
    <link href="assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet"/>
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
            <li><a href="javascript:;">Pagos</a></li>
            <li class="active">agregar documento Compra</li>
        </ol>
        <!-- end breadcrumb -->
        <!-- begin page-header -->
        <h1 class="page-header">Registro de Documento de Compra
            <small>matenimiento compras</small>
        </h1>
        <!-- end page-header -->

        <div class="row">

            <div class="col-md-12">
                <div class="panel panel-inverse">

                    <div class="panel-heading">
                        <h4 class="panel-title">Datos Generales</h4>
                    </div>
                    <form class="form-horizontal" id="frm_reg_compra" method="post" action="procesos/reg_compra.php">
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-md-2 control-label">Periodo</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control text-center" maxlength="6"
                                           name="input_periodo" id="input_periodo"
                                           value="<?php echo date('Y') . date('m') ?>" required="true"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Tipo Documento</label>
                                <div class="col-md-3">
                                    <select class="form-control" name="select_documento" id="select_documento">
                                        <?php
                                        $a_tidos = $cl_tido->ver_documentos();
                                        foreach ($a_tidos as $value) {
                                            ?>
                                            <option value="<?php echo $value['id'] ?>"><?php echo $value['nombre'] ?></option>
                                            <?php
                                            echo PHP_EOL;
                                        }
                                        ?>
                                    </select>
                                </div>
                                <label class="col-md-2 control-label">Fecha</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="input_fecha" id="input_fecha"
                                           required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Serie</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control text-center" name="input_serie"
                                           id="input_serie" maxlength="12" required/>
                                </div>
                                <label class="col-md-2 control-label">Numero</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control  text-center" name="input_numero"
                                           id="input_numero" maxlength="15" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Proveedor:</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="input_buscar_proveedor"
                                           id="input_buscar_proveedor"/>
                                </div>
                                <div class="col-md-1">
                                    <a href="reg_entidad.php" class="btn btn-success" name="btn_crear_entidad"
                                       id="btn_crear_entidad" target="_blank">Nuevo</a>
                                </div>
                                <label class="col-md-1 control-label">RUC</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control  text-center" name="input_ruc_proveedor"
                                           id="input_ruc_proveedor" maxlength="11" required readonly="true"/>
                                </div>
                                <div class="col-md-1">
                                    <input type="button" class="btn btn-warning" name="btn_verificar_documento"
                                           id="btn_verificar_documento" disabled="true" onclick="validar_compra()"
                                           value="Validar">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Nombre Comercial:</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="input_nombre_proveedor"
                                           id="input_nombre_proveedor" readonly="true"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Razon Social:</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="input_razon_proveedor"
                                           id="input_razon_proveedor" required readonly="true"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Direccion Fiscal:</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="input_direccion_proveedor"
                                           id="input_direccion_proveedor" readonly="true"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Documento Amarre</label>
                                <div class="col-md-3">
                                    <select class="form-control" name="select_documento_amarre"
                                            id="select_documento_amarre">
                                        <option value="4">FACTURA</option>
                                        <option value="3">BOLETA</option>
                                    </select>
                                </div>
                                <label class="col-md-2 control-label">Fecha Doc. Amarre</label>
                                <div class="col-md-3">
                                    <input type="date" class="form-control text-center"
                                           name="input_fecha_amarre" id="input_fecha_amarre"
                                    />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Serie - Numero Amarre</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control text-center" maxlength="6"
                                           placeholder="Serie"
                                           name="input_serie_amarre" id="input_serie_amarre"
                                    />
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control text-center" maxlength="6"
                                           placeholder="Numero"
                                           name="input_numero_amarre" id="input_numero_amarre"
                                    />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Orden de Compra</label>
                                <div class="col-md-9">
                                    <select class="form-control" name="select_ocompra" id="select_ocompra" onchange="ver_datos_orden()">
                                        <option value="-">SELECCIONE PROVEEDOR</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Moneda</label>
                                <div class="col-md-3">
                                    <select class="form-control" name="select_moneda" id="select_moneda"
                                            onchange="validar_moneda()">
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
                                <label class="col-md-1 control-label">TC sunat</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control text-right" name="input_tc" id="input_tc"
                                           maxlength="5" required/>
                                </div>
                                <label class="col-md-1 control-label">% Factura</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control text-right" name="input_porcentaje"
                                           id="input_porcentaje" value="100" onkeyup="facturado()" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Sub Total</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control text-right" placeholder="0.00"
                                           name="input_subtotal" id="input_subtotal" onkeyup="calcularIGV()"/>
                                </div>
                                <label class="col-md-1 control-label">IGV</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control text-right" placeholder="0.00"
                                           name="input_igv" id="input_igv" onkeyup="calcular_total()"/>
                                </div>
                                <label class="col-md-1 control-label">Total</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control text-right" placeholder="0.00"
                                           name="input_total" id="input_total" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Centro de Costo</label>
                                <div class="col-md-3">
                                    <select class="form-control" name="select_ccosto" id="select_ccosto">
                                        <?php
                                        $a_centros = $cl_centro->ver_centros();
                                        foreach ($a_centros as $filas) {
                                            ?>
                                            <option value="<?php echo $filas['anio'] . $filas['codigo'] ?>"><?php echo $filas['anio'] . ' | ' . $filas['descripcion'] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <label class="col-md-1 control-label">Tipo Compra</label>
                                <div class="col-md-3">
                                    <select class="form-control" name="select_clasificacion" id="select_clasificacion">
                                        <?php
                                        $cl_detalle->setTabla(10);
                                        $a_clasificacion = $cl_detalle->v_detalle();
                                        foreach ($a_clasificacion as $value) {
                                            ?>
                                            <option value="<?php echo $value['id'] ?>"><?php echo $value['descripcion'] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Glosa:</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="input_glosa" id="input_glosa"
                                           required/>
                                </div>
                            </div>
                            <input type="hidden" name="hidden_total" id="hidden_total"/>
                            <input type="hidden" name="hidden_monto_total" id="hidden_monto_total"/>

                        </div>
                        <div class="panel-footer text-right">
                            <button type="submit" class="btn btn-success" id="btn_agregar_compra">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end #content -->

    <!-- begin scroll to top btn -->
    <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i
                class="fa fa-angle-up"></i></a>
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
<script src="assets/plugins/masked-input/masked-input.min.js"></script>
<script src="assets/plugins/bootstrap-validator/bootstrapValidator.min.js"></script>
<script src="assets/js/table-manage-default.demo.min.js"></script>
<script src="assets/plugins/gritter/js/jquery.gritter.js"></script>
<script src="assets/js/apps.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->
<script>
    $(document).ready(function () {
        App.init();
        TableManageDefault.init();
        $('#input_fecha').mask('99/99/9999');
        $('#input_periodo').mask('999999');
        //                                                    $('#input_serie').mask('999');
        //                                                    $('#input_numero').mask('9999999');


        var faIcon = {
            valid: 'fa fa-check-circle fa-lg text-success',
            invalid: 'fa fa-times-circle fa-lg',
            validating: 'fa fa-refresh'
        };
        // FORM VALIDATION ON TABS
        // =================================================================
        $('#frm_reg_compra').bootstrapValidator({
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
                        //                                                                    digits: {
                        //                                                                        message: 'The value can contain only digits'
                        //                                                                    }
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
    });</script>
<script>

    function validar_moneda() {
        var moneda = $("#select_moneda").val();
        if (moneda !== 1) {
            $("#input_tc").val('');
            $("#input_tc").focus();
        }
        if (moneda == 1) {
            $("#input_tc").val('1.000');
            $("#input_porcentaje").focus();
        }
    }

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

    function calcularIGV() {
        var subtotal = parseFloat($("#input_subtotal").val());
        var igv = subtotal * 0.18
        var total = subtotal * 1.18;
        $("#input_igv").val(number_format(igv, 2));
        $("#input_total").val(number_format(total, 2));
        $("#hidden_total").val(total);
    }

    function calcular_total() {
        var subtotal = parseFloat($("#input_subtotal").val());
        var igv = parseFloat($("#input_igv").val());
        var total = subtotal + igv;
        $("#input_total").val(number_format(total, 2));
        $("#hidden_total").val(total);
    }

    function validar_compra() {
        $.ajax({
            data: {
                proveedor: $("#input_ruc_proveedor").val(),
                tipo_documento: $("#select_documento").val(),
                serie: $("#input_serie").val(),
                numero: $("#input_numero").val()
            },
            url: 'ajax_post/validar_registro_compra.php',
            type: 'POST',
            dataType: 'json',
            beforeSend: function () {
                //cliente.prop('disabled', true);
            },
            success: function (r) {
                var content = JSON.parse(JSON.stringify(r));
                console.log(content);
                var existe = content[0].existe;
                if (existe === true) {
                    $('#btn_agregar_compra').prop('disabled', true);
                    $.gritter.add({
                        title: "Documento existente!",
                        text: "Este Documento ya se encuentra registrado Codigo: " + content[0].periodo + " - " + content[0].codigo,
                        image: "assets/img/user-12.jpg",
                        sticky: false,
                        time: ""
                    });
                    return false;
                }
            },
            error: function () {
                alert('Ocurrio un error en el servidor ..');
                $('#btn_agregar_compra').prop('disabled', true);
            }
        });
    }

    function cargar_ordenes(id_proveedor) {
        var ordenes = $("#select_ocompra");
        $.ajax({
            data: {input_proveedor: id_proveedor},
            url: 'ajax_post/ver_ordenes_proveedor.php',
            type: 'GET',
            dataType: 'json',
            beforeSend: function () {
                //
            },
            success: function (r) {
                // Limpiamos el select
                ordenes.find('option').remove();
                $(r).each(function (i, v) { // indice, valor
                    ordenes.append('<option value="' + v.id + '">' + v.nombre + '</option>');
                });
                ordenes.prop('disabled', false);
                ver_datos_orden();
            },
            error: function () {
                alert('Ocurrio un error en el servidor ..');
            }
        });
    }

    function ver_datos_orden() {
        var orden = $("#select_ocompra").val();
        if (orden !== '-') {
            $.ajax({
                data: {id_orden: orden},
                url: 'ajax_post/ver_datos_ocompra.php',
                type: 'GET',
                dataType: 'json',
                beforeSend: function () {
                    $("#input_subtotal").val('0.00');
                },
                success: function (response) {
                    var json = response;
                    console.log(json);
                    var monto = json.total;
                    var facturado = json.porcentaje;
                    var total = (100 - facturado) / 100 * monto;
                    var subtotal = total / 1.18;
                    var igv = subtotal * 0.18;
                    var glosa = json.glosa;
                    var id_moneda = json.id_moneda;
                    $("#input_porcentaje").val(100 - facturado);
                    $("#input_glosa").val(glosa);
                    $("#select_moneda").val(id_moneda).change();
                    $("#input_subtotal").val(number_format(subtotal, 2));
                    $("#input_igv").val(number_format(igv, 2));
                    $("#input_total").val(number_format(total, 2));
                    $("#hidden_total").val(total);
                    $("#hidden_monto_total").val(monto);
                    $("#input_tc").focus();
                },
                error: function () {
                    alert('Ocurrio un error en el servidor ..');
                    $("#input_subtotal").val('ERROR AL CARGAR DATOS');
                }
            });
        } else {
            $("#input_porcentaje").val(100);
            $("#input_glosa").val('');
            $("#select_moneda").val(1).change();
            $("#input_subtotal").val('');
            $("#input_igv").val('');
            $("#input_total").val('');
            $("#hidden_total").val(0);
            $("#hidden_monto_total").val(0);
            $("#input_tc").focus();
        }
    }

    function facturado() {
        var total = $("#hidden_monto_total").val();
        var facturado = $("#input_porcentaje").val();
        var subtotal = (total * facturado / 100) / 1.18;
        var igv = subtotal * 0.18;
        var total = total * facturado / 100;
        $("#input_subtotal").val(number_format(subtotal, 2));
        $("#input_igv").val(number_format(igv, 2));
        $("#input_total").val(number_format(total, 2));
        $("#hidden_total").val(total);
    }

    $(function () {
        //autocomplete
        $("#input_buscar_proveedor").autocomplete({
            source: "ajax_post/buscar_proveedores.php",
            minLength: 2,
            select: function (event, ui) {
                event.preventDefault();
                $('#input_ruc_proveedor').val(ui.item.ruc);
                cargar_ordenes(ui.item.ruc);
                $('#input_razon_proveedor').val(ui.item.razon_social);
                $('#input_nombre_proveedor').val(ui.item.nombre_comercial);
                $('#input_direccion_proveedor').val(ui.item.direccion);
                $('#btn_verificar_documento').prop('disabled', false);
                $('#input_buscar_proveedor').val("");
            }
        });
    });
</script>
</body>

<!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:23:54 GMT -->
</html>

