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
                <form id="frm_reg_compra" method="post" action="procesos/reg_compra.php">
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <h4 class="panel-title">Datos Generales</h4>
                        </div>
                        <div class="panel-body">
                            <div class="col-md-9">
                                <div class="row m-b-10">
                                    <div class="col-md-2">
                                        <label class="form-label" for="input-periodo">Periodo</label>
                                        <input class="form-control" type="text" id="input-periodo" value="<?php echo date('Y') . date('m') ?>" required/>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label" for="input-fecha">Fecha Doc</label>
                                        <input class="form-control" type="date" id="input-fecha" required/>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="exampleInputEmail1">Tipo Documento</label>
                                        <select class="form-control" name="select_documento" id="select_documento" onchange="habilitarAmarre()">
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
                                    <div class="col-md-1">
                                        <label class="form-label" for="exampleInputEmail1">Serie</label>
                                        <input class="form-control" type="text" id="input-serie" placeholder="Ingrese Serie" required/>
                                    </div>
                                    <div class="col-md-1">
                                        <label class="form-label" for="exampleInputEmail1">Numero</label>
                                        <input class="form-control" type="text" id="input-serie" placeholder="Ingrese Numero de Comprobante" required/>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label" for="exampleInputEmail1">Comprobante Afecto</label>
                                        <button type="button" class="form-control ">Agregar Factura</button>
                                    </div>
                                </div>

                                <div class="row m-b-10">
                                    <div class="col-md-3">
                                        <label class="form-label" for="input-ruc-proveedor">RUC Proveedor</label>
                                        <input class="form-control" type="text" id="input-ruc-proveedor" placeholder="Buscar por RUC o Razon Social"/>
                                    </div>
                                    <div class="col-md-7">
                                        <label class="form-label" for="input-razon-proveedor">Razon Social</label>
                                        <input class="form-control" type="text" id="input-razon-proveedor" readonly required/>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label" >Acciones</label>
                                        <button type="button" class="form-control ">Agregar Proveedor</button>
                                    </div>
                                </div>

                                <div class="row m-b-10">
                                    <div class="col-md-6">
                                        <label class="form-label" for="select_ocompra">Orden Compra</label>
                                        <select class="form-control" name="select_ocompra" id="select_ocompra" onchange="ver_datos_orden()">
                                            <option value="-">SELECCIONE PROVEEDOR</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label" for="input-porcentaje-orden">% Pago de Orden</label>
                                        <input class="form-control" type="number" id="input-porcentaje-orden" placeholder="Enter email"/>
                                    </div>
                                </div>

                                <div class="row m-b-10">
                                    <div class="col-md-8">
                                        <label class="form-label" for="select_clasificacion">Tipo de Compra (Asiento Contable)</label>
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
                                <!--
                                <div class="row m-b-10">
                                    <div class="col-md-8">
                                        <label class="form-label" for="input-periodo">Clasificacion Costo (reporte de costos y gastos generales)</label>
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
                                </div>
                                -->


                                <input type="hidden" name="hidden_total" id="hidden_total"/>
                                <input type="hidden" name="hidden_monto_total" id="hidden_monto_total"/>

                            </div>
                            <div class="col-md-3">
                                <div class="row m-b-3">
                                    <div class="col-md-8">
                                        <label class="form-label" for="exampleInputEmail1">Moneda</label>
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
                                    <div class="col-md-3">
                                        <label class="form-label" for="exampleInputEmail1">Tipo Cambio</label>
                                        <input class="form-control" type="email" id="exampleInputEmail1" placeholder="Enter email"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 m-b-3">
                                        <label class="form-label">% IGV</label>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                            <label class="form-check-label" for="flexRadioDefault1">
                                                10%
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                            <label class="form-check-label" for="flexRadioDefault2">
                                                18%
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row m-b-3">
                                    <div class="col-md-12">
                                        <label class="form-label" for="exampleInputEmail1">Sub Total Gravado</label>
                                        <input class="form-control" type="text" id="exampleInputEmail1" placeholder="Enter email"/>
                                    </div>
                                </div>
                                <div class="row m-b-3">
                                    <div class="col-md-12">
                                        <label class="form-label" for="exampleInputEmail1">IGV</label>
                                        <input class="form-control" type="text" id="exampleInputEmail1" placeholder="Enter email"/>
                                    </div>
                                </div>
                                <div class="row m-b-3">
                                    <div class="col-md-12">
                                        <label class="form-label" for="exampleInputEmail1">Inafecto</label>
                                        <input class="form-control" type="text" id="exampleInputEmail1" placeholder="Enter email"/>
                                    </div>
                                </div>
                                <div class="row m-b-3">
                                    <div class="col-md-12">
                                        <label class="form-label" for="exampleInputEmail1">Total</label>
                                        <input class="form-control" type="text" id="exampleInputEmail1" placeholder="Enter email"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer text-right">
                            <button type="submit" class="btn btn-success" id="btn_agregar_compra">Guardar</button>
                        </div>
                    </div>
                </form>
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
        $("#input_igv").val(number_format(igv, 5));
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
        $("#input_subtotal").val(number_format(subtotal, 4));
        $("#input_igv").val(number_format(igv, 5));
        $("#input_total").val(number_format(total, 2));
        $("#hidden_total").val(total);
    }

    function habilitarAmarre() {
        var idtipodocumento = $("#select_documento").val();
        if (idtipodocumento == "14" || idtipodocumento == "15") {
            alert("Tiene que ingresar la fecha, serie y numero del comprobante relacionado");
            $("#input_serie_amarre").prop("required", true);
        } else {
            $("#input_serie_amarre").prop("required", false);
        }
    }

    $(function () {
        //autocomplete
        $("#input-ruc-proveedor").autocomplete({
            source: "ajax_post/buscar_proveedores.php",
            minLength: 2,
            select: function (event, ui) {
                event.preventDefault();
                $('#input-ruc-proveedor').val(ui.item.ruc);
                cargar_ordenes(ui.item.ruc);
                $('#input-razon-proveedor').val(ui.item.razon_social);
                $('#btn_verificar_documento').prop('disabled', false);
            }
        });
    });
</script>
</body>

<!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:23:54 GMT -->
</html>

