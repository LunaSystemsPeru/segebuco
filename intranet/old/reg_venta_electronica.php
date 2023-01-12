<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

require 'class/cl_cliente.php';
require 'class/cl_detalle_tabla_general.php';
$cl_detalle = new cl_detalle_tabla_general();
$cl_cliente = new cl_cliente();
?>
<!DOCTYPE html>
<!--[if IE 8]>
<html lang="es" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
<!--<![endif]-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=gb18030">

    <title>Facturacion Electronica | SEGEBUCO SAC</title>
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
            <li><a href="javascript:;">Facturacion</a></li>
            <li class="active">crear comprobante de venta</li>
        </ol>
        <!-- end breadcrumb -->
        <!-- begin page-header -->
        <h1 class="page-header">Comprobante de Venta Electronica <small>matenimiento ventas</small></h1>
        <!-- end page-header -->

        <div class="row">

            <div class="col-md-5">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <h4 class="panel-title">Datos del Comprobate</h4>
                    </div>
                    <div class="panel-body">
                    <form class="form-horizontal" id="frm_reg_venta">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Comprobante</label>
                            <div class="col-md-9">
                                <select class="form-control" name="select_documento" id="select_documento">
                                    <option value="4">FACTURA</option>
                                    <option value="3">BOLETA</option>
                                    <option value="14">NOTA DE CREDITO</option>
                                    <option value="15">NOTA DE DEBITO</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Serie</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control text-center" name="input_serie"
                                       id="input_serie" maxlength="4" value="E001" required/>
                                       </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control  text-center" name="input_numero"
                                       id="input_numero" maxlength="7" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Fecha</label>
                            <div class="col-md-9">
                                <input type="date" class="form-control" name="input_fecha" id="input_fecha"
                                       value="<?php echo date('Y-m-d') ?>" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Moneda</label>
                            <div class="col-md-6">
                                <select class="form-control" name="select_documento" id="select_documento">
                                    <option value="4">SOLES</option>
                                    <option value="3">DOLAR AMERICANO</option>
                                </select>
                                
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control  text-right" name="input_tc"
                                       id="input_tc" maxlength="5" required/>
                            </div>

                        </div>
                        
                         <div class="form-group">
                            <label class="col-md-3 control-label">Detraccion</label>
                            <div class="col-md-6">
                                <select class="form-control" name="select_documento" id="select_documento">
                                    <option value="4">020 MANTENIMIENTO</option>
                                    <option value="3">022 OTROS SERVICIOS</option>
                                </select>
                                
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control  text-center" name="input_tc"
                                       id="input_tc" maxlength="5" value="12" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Retencion</label>
                            <div class="col-md-6">
                                <select class="form-control" name="select_documento" id="select_documento">
                                        <option value="4">SI</option>
                                    <option value="3">NO</option>
                                </select>
                                
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control  text-center" name="input_tc"
                                       id="input_tc" maxlength="5" value="0" required/>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <h4 class="panel-title">Datos de la Venta</h4>
                    </div>
                    <div class=panel-body>
                        <form class="form-horizontal" id="frm_reg_venta" >
                            <div class="form-group">
                                <label class="col-md-3 control-label">RUC Cliente</label>
                                <div class="col-md-4">
                                    <input class="form-control text-center" value="" id="input_ruc_cliente" name="input_ruc_cliente" maxlength="11" required>
                                    <input type="hidden" id="hidden_id_cliente" name="hidden_id_cliente">
                                    <input type="hidden" id="hidden_ubigeo_cliente" name="hidden_ubigeo_cliente" value="">
                                </div>
                                <div class="col-md-2">
                                    <a class="btn btn-info btn-sm" href="reg_cliente.php" target="_blank"><i class="fa fa-plus"></i> Reg. Cliente</a>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" id="btn_editar_cliente" class="btn btn-success btn-sm" onclick="cargar_web()" disabled=true><i class="fa fa-edit"></i> Edit. Cliente</button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Razon Cliente</label>
                                <div class="col-md-9">
                                    <input class="form-control" id="input_razon_social" name="input_razon_social" readonly="true" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Direccion Cliente</label>
                                <div class="col-md-7">
                                    <select class="form-control">
                                        <option id="">DIRECCION 1</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-success btn-sm" ><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Hoja de Entrada</label>
                                <div class="col-md-5">
                                    <input type="text" class="form-control text-center" name="input_serie"
                                       id="input_serie" maxlength="4" value="" required/>
                               </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Orden de Compra</label>
                                <div class="col-md-5">
                                    <input type="text" class="form-control text-center" name="input_serie"
                                           id="input_serie" maxlength="4" value="" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Guias de Remision</label>
                                <div class="col-md-5">
                                    <input type="text" class="form-control text-center" name="input_serie"
                                           id="input_serie" maxlength="4" value="-" required/>
                                </div>
                                <div class="col-md-4">
                                            <button type="button" class="btn btn-success btn-sm" ><i class="fa fa-plus"></i> Agregar Guias</button>
                                </div>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
           
           <div class="col-md-12">
                <!-- begin panel -->
                <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
                    <div class="panel-heading">
                        <h4 class="panel-title">Agregar Items</h4>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label class="col-md-1 control-label">Descripcion</label>
                                <div class="col-md-11">
                                    <textarea class="form-control" rows="3" id="input_descripcion_producto"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-1 control-label">Cantidad</label>
                                <div class="col-md-2">
                                    <input class="form-control text-right" value="1" id="input_cantidad_producto" name="input_cantidad_producto">
                                </div>
                                <label class="col-md-1 col-md-offset-1 control-label">Precio c/ IGV</label>
                                <div class="col-md-2">
                                    <input class="form-control text-right" value="0.00" id="input_precio_producto" name="input_precio_producto" onkeyup="calcular_item_sigv()">
                                </div>
                                <label class="col-md-1 control-label">Precio sin IGV</label>
                                <div class="col-md-2">
                                    <input class="form-control text-right" value="0.00" id="input_sigv_precio_producto" name="input_sigv_precio_producto">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-warning btn-sm" onclick="add_item()"><i class="fa fa-plus"></i> Agregar Item</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- end panel -->
            </div>
            
            <!-- inicio panel detalle venta-->
            <div class="col-md-12">
                <!-- begin panel -->
                <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
                    <div class="panel-heading">
                        <h4 class="panel-title">Detalle Venta</h4>
                    </div>
                    <div class="panel-body">
                        <table id="tabla_detalle" class="table table-striped">
                            <thead>
                            <tr>
                                <th>Id.</th>
                                <th>Descripcion</th>
                                <th>Cantidad</th>
                                <th>Und. Med.</th>
                                <th>Precio</th>
                                <th>Parcial</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- end panel -->
            </div>
            <!-- end col-12 -->
            
            <!-- inicio panel add item-->
            <div class="col-md-12">
                <!-- begin panel -->
                <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
                    <div class="panel-heading">
                        <h4 class="panel-title">Finalizar Venta</h4>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal">
                            <div class="panel-body col-md-8">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Forma de Pago</label>
                                    <div class="col-md-3">
                                        <select class="form-control" id="select_forma_pago" name="select_forma_pago" onchange="validarFormaPago()">
                                                                                            <option value="1">CONTADO</option>
                                                                                                <option value="2">CREDITO</option>
                                                                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Fecha Vcto</label>
                                    <div class="col-md-3">
                                        <input type="date" class="form-control text-center" name="input_fecha_vcto_cuota" id="input_fecha_vcto_cuota" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Monto Cuota</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control text-right" name="input_monto_cuota" id="input_monto_cuota" value="0.00" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" id="btn_add_cuota" class="btn btn-success btn-sm" onclick="add_item_cuota()" disabled><i class="fa fa-plus"></i> Añadir Cuota</button>
                                    </div>
                                </div>
                                <div class="form-group col-md-8">
                                    <table id="tabla_cuotas" class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>Nro Cuota</th>
                                            <th>Fec. Vcto</th>
                                            <th>Monto</th>
                                            <th>Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="panel-body col-md-4">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Sub Total</label>
                                    <div class="col-md-6">
                                        <input class="form-control text-right" value="0.00" id="input_subtotal" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">IGV</label>
                                    <div class="col-md-6">
                                        <input class="form-control text-right" value="0.00" id="input_igv" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Total</label>
                                    <div class="col-md-6">
                                        <input class="form-control text-right" value="0.00" id="input_total" readonly required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Detraccion</label>
                                    <div class="col-md-6">
                                        <input class="form-control text-right" value="0.00" id="input_monto_detraccion" readonly required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Total Neto</label>
                                    <div class="col-md-6">
                                        <input class="form-control text-right" value="0.00" id="input_neto" readonly required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-md-offset-1">
                                        <button type="button" class="btn btn-info btn" onclick="enviar_formulario()"><i class="fa fa-save"></i> Finalizar Venta</button>
                                    </div>
                                </div>
                            </div>


                        </form>
                    </div>
                </div>
                <!-- end panel -->
            </div>
            <!-- end col-12 -->
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
<script src="assets/js/apps.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->
<script>
    $(document).ready(function () {
        App.init();
        TableManageDefault.init();
        
//                                                    $('#input_serie').mask('999');
//                                                    $('#input_numero').mask('9999999');
        $("#select_cliente").trigger('change');


        var faIcon = {
            valid: 'fa fa-check-circle fa-lg text-success',
            invalid: 'fa fa-times-circle fa-lg',
            validating: 'fa fa-refresh'
        };


       
    });
</script>

<script>

    // Bloqueamos el SELECT de los cursos
    //$("#select_sucursal").prop('disabled', true);

    // Hacemos la lógica que cuando nuestro SELECT cambia de valor haga algo
    $("#select_cliente").change(function () {
        // Guardamos el select de cursos
        var sucursales = $("#select_sucursal");
        // Guardamos el select de alumnos
        var cliente = $(this);
        if ($(this).val() !== '') {
            //ver_datos_cliente(cliente.val());
            $.ajax({
                data: {id: cliente.val()},
                url: 'ajax_post/ver_sucursal_cliente.php',
                type: 'POST',
                dataType: 'json',
                beforeSend: function () {
                    cliente.prop('disabled', true);
                },
                success: function (r) {
                    cliente.prop('disabled', false);
                    // Limpiamos el select
                    sucursales.find('option').remove();
                    $(r).each(function (i, v) { // indice, valor
                        sucursales.append('<option value="' + v.id + '">' + v.nombre + '</option>');
                    });
                    sucursales.prop('disabled', false);
                    $("#select_sucursal").trigger('change');
                },
                error: function () {
                    alert('Ocurrio un error en el servidor ..');
                    cliente.prop('disabled', false);
                }
            });
        } else {
            sucursales.find('option').remove();
            sucursales.prop('disabled', true);
        }
    });

    $("#select_sucursal").change(function () {
        // Guardamos el select de cursos
        var ordenes = $("#select_orden");
        var cliente = $("#select_cliente");
        // Guardamos el select de alumnos
        var sucursal = $(this);
        if ($(this).val() !== '') {
            $.ajax({
                //data: {sucursal: sucursal.val(), cliente:cliente.val()},
                url: 'ajax_post/ver_ordenes_cliente.php?cliente=' + cliente.val() + '&sucursal=' + sucursal.val(),
                type: 'GET',
                dataType: 'json',
                beforeSend: function () {
                    sucursal.prop('disabled', true);
                },
                success: function (r) {
                    sucursal.prop('disabled', false);
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
                    sucursal.prop('disabled', false);
                }
            });
        } else {
            ordenes.find('option').remove();
            ordenes.prop('disabled', true);
        }
    });

    function ver_datos_cliente(id_cliente) {
        var cliente = id_cliente;
        if (cliente !== '') {
            $.ajax({
                //data: {id: cliente},
                url: 'ajax_post/ver_datos_cliente.php?id=' + cliente,
                type: 'GET',
                dataType: 'json',
                beforeSend: function () {
                    $("#input_direccion").val('CARGANDO DATOS');
                },
                success: function (response) {
                    var json = response;
                    console.log(json);

//                            var json_cliente = JSON.parse(json);
                    //console.log(JSON.parse(json));
                    $("#input_direccion").val(json[0].direccion);
                },
                error: function () {
                    alert('Ocurrio un error en el servidor ..');
                    $("#input_direccion").val('ERROR AL CARGAR DATOS');
                }
            });
        } else {
            $("#input_direccion").val('NO HAY CLIENTES');
        }
    }

    function ver_datos_orden() {
        var orden = $("#select_orden").val();
        if (orden !== '-') {
            $.ajax({
                //data: {id: cliente},
                url: 'ajax_post/ver_datos_orden.php?id=' + orden,
                type: 'GET',
                dataType: 'json',
                beforeSend: function () {
                    $("#input_subtotal").val('0.00');
                },
                success: function (response) {
                    var json = response;
                    console.log(json);
                    var monto = json[0].monto;
                    var facturado = json[0].facturado;
                    var total = (100 - facturado) / 100 * monto;
                    var subtotal = total / 1.18;
                    var igv = subtotal * 0.18;
                    var glosa = json[0].glosa;
                    var id_moneda = json[0].moneda;
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
            $("#input_tc").focus();
        }
    }

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
</body>

<!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:23:54 GMT -->
</html>
