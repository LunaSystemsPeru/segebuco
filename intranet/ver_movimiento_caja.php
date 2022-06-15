<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

require 'class/cl_centro_costo.php';
require 'class/cl_detalle_tabla_general.php';
require 'class/cl_compra.php';
require 'class/cl_caja_chica.php';
require 'class/cl_movimiento_caja.php';
require 'class/cl_planilla.php';
require 'class/cl_varios.php';

$cl_varios = new cl_varios();
$cl_ccosto = new cl_centro_costo();
$cl_compra = new cl_compra();
$cl_caja = new cl_caja_chica();
$cl_planilla = new cl_planilla();
$cl_mcaja = new cl_movimiento_caja();
$cl_detalle = new cl_detalle_tabla_general();

if (isset($_GET)) {
    $cl_caja->setCodigo(filter_input(INPUT_GET, 'caja'));
    $cl_mcaja->setCaja($cl_caja->getCodigo());
}

$a_costos = $cl_ccosto->ver_centros();
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="es" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
    <!--<![endif]-->

    <head>
        <meta charset="utf-8" />
        <title>Ver Movimiento de Caja Chica | SEGEBUCO SAC</title>
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
                    <li><a href="javascript:;">Cajas y Bancos</a></li>
                    <li class="active">ver Cajas chica</li>
                </ol>
                <!-- end breadcrumb -->
                <!-- begin page-header -->
                <h1 class="page-header">Cajas y Bancos <small>matenimiento cajas</small></h1>
                <!-- end page-header -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-inverse">
                            <div class="panel-heading">
                                <a href="#modal-gasto-documentado" class="btn btn-info btn-sm" data-toggle="modal"><i class="fa fa-plus"></i> Gasto Documentado</a>
                                <a href="#modal-gasto-simple" class="btn btn-success btn-sm" data-toggle="modal"><i class="fa fa-plus"></i> Gasto Simple</a>
                                <a href="#modal-planilla" class="btn btn-primary btn-sm" data-toggle="modal"><i class="fa fa-plus"></i> Pago Planilla</a>
                            </div>
                            <div class="panel-body">
                                <table id="data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Codigo</th>
                                            <th>Fecha</th>
                                            <th>Concepto</th>
                                            <th>c. Costo</th>
                                            <th>Ingreso</th>
                                            <th>Egreso</th>
                                            <th>Saldo</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $a_movimiento = $cl_mcaja->ver_movimientos();
                                        $saldo = 0;
                                        $singresos = 0;
                                        $segresos = 0;
                                        foreach ($a_movimiento as $value) {
                                            $ingreso = $value['ingreso'];
                                            $egreso = $value['egreso'];
                                            $saldo = $saldo + $ingreso - $egreso;
                                            if ($ingreso == 0) {
                                                $vingreso = '-';
                                            } else {
                                                $vingreso = number_format($ingreso, 2);
                                            }
                                            if ($egreso == 0) {
                                                $vegreso = '-';
                                            } else {
                                                $vegreso = number_format($egreso, 2);
                                            }
                                            ?>
                                            <tr class="odd gradeX">
                                                <td class="text-center"><?php echo $cl_mcaja->getCaja() . '-' . $cl_varios->zerofill($value['movimiento'], 3) ?></td>
                                                <td class="text-center"><?php echo $value['fecha'] ?></td>
                                                <td><?php echo $value['concepto'] ?></td>
                                                <td class="text-center"><?php echo $value['ccosto'] ?></td>
                                                <td class="text-right"><?php echo $vingreso ?></td>
                                                <td class="text-right"><?php echo $vegreso ?></td>
                                                <td class="text-right"><?php echo number_format($saldo, 2) ?></td>
                                                <td class="text-center">
                                                    <a href="" class="btn btn-danger btn-xs" ><i class="fa fa-close"></i></a>
                                                </td>
                                            </tr>
                                            <?php
                                            $singresos = $singresos + $ingreso;
                                            $segresos = $segresos + $egreso;
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr class="odd gradeX">
                                            <td class="text-center" colspan="4">Saldos</td>
                                            <td class="text-right"><?php echo number_format($singresos, 2) ?></td>
                                            <td class="text-right"><?php echo number_format($segresos, 2) ?></td>
                                            <td class="text-right"><?php echo number_format($saldo, 2) ?></td>
                                            <td class="text-center">
                                                <a href="" class="btn btn-danger btn-xs" ><i class="fa fa-close"></i></a>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal modal-message fade" id="modal-gasto-simple">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">Registro de Gasto Simple</h4>
                            </div>
                            <form class="form-horizontal" id="frm_gasto_simple" method="POST" action="procesos/reg_gasto_simple.php">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="input_fechags">Fecha</label>
                                        <div class="col-md-3">
                                            <input type="date" class="form-control text-center" id="input_fechags" name="input_fechags" required/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="input_conceptogs">Concepto</label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" id="input_conceptogs" name="input_conceptogs" required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="input_montogs">Monto</label>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control text-right" id="input_montogs" name="input_montogs" required/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Centro de Costo</label>
                                        <div class="col-md-5">
                                            <select class="form-control" name="select_ccostogs" id="select_ccostogs">
                                                <?php
                                                $a_centros = $cl_ccosto->ver_centros();
                                                foreach ($a_centros as $filas) {
                                                    ?>
                                                    <option value="<?php echo $filas['anio'] . $filas['codigo'] ?>"><?php echo $filas['anio'] . ' | ' . $filas['descripcion'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <label class="col-md-2 control-label">Tipo Compra</label>
                                        <div class="col-md-3">
                                            <select class="form-control" name="select_clasificaciongs" id="select_clasificaciongs">
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
                                    <input type="hidden" name="hidden_caja" value="<?php echo $cl_caja->getCodigo() ?>"/>
                                </div>
                                <div class="modal-footer">
                                    <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Cerrar</a>
                                    <input type="submit" class="btn btn-sm btn-success" name="button_submit" value="Guardar "/>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal modal-message fade" id="modal-gasto-documentado" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">Registro de Gasto Documentado</h4>
                            </div>
                            <form class="form-horizontal" id="frm_gasto_simple" method="POST" action="procesos/reg_gasto_documentado.php">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Proveedor:</label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="input_buscar_proveedor" id="input_buscar_proveedor"/>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="reg_compra.php" class="btn btn-success" name="btn_agregar_compra" id="btn_agregar_compra" target="_blank">Nueva Factura</a>
                                        </div>
                                        <label class="col-md-1 control-label">RUC</label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control  text-center" name="input_ruc_proveedor" id="input_ruc_proveedor" maxlength="11" required readonly="true"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Nombre Comercial:</label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="input_nombre_proveedor" id="input_nombre_proveedor" required  readonly="true"/>
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
                                            <input type="text" class="form-control" name="input_direccion_proveedor" id="input_direccion_proveedor" required  readonly="true"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="select_documentos">Documento</label>
                                        <div class="col-md-7">
                                            <select class="form-control" name="select_documentos" id="select_documentos" disabled="true" onchange="ver_datos_factura()">

                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="input_conceptogd">Concepto</label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" id="input_conceptogd" name="input_conceptogd" readonly="true" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="input_fechadoc">Fecha Doc</label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control text-center" id="input_fechadoc" name="input_fechadoc" readonly="true"/>
                                        </div>
                                        <label class="col-md-2 control-label" for="input_fechagd">Fecha Pago</label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control text-center" id="input_fechagd" name="input_fechagd" value="<?php echo date('d/m/Y') ?>" required/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="input_montodoc">Monto</label>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control text-right" id="input_montodoc" name="input_montodoc" readonly="true"/>
                                        </div>
                                        <label class="col-md-2 control-label" for="input_montogd">Monto a Pagar</label>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control text-right" id="input_montogd" name="input_montogd" required/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Centro de Costo</label>
                                        <div class="col-md-5">
                                            <select class="form-control" name="select_ccostogd" id="select_ccostogd">
                                                <?php
                                                $a_centros = $cl_ccosto->ver_centros();
                                                foreach ($a_centros as $filas) {
                                                    ?>
                                                    <option value="<?php echo $filas['anio'] . $filas['codigo'] ?>"><?php echo $filas['anio'] . ' | ' . $filas['descripcion'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <label class="col-md-2 control-label">Tipo Compra</label>
                                        <div class="col-md-3">
                                            <select class="form-control" name="select_clasificaciongd" id="select_clasificaciongd">
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
                                    <input type="hidden" name="hidden_caja" value="<?php echo $cl_caja->getCodigo() ?>"/>
                                    <input type="hidden" name="hidden_documentogd" id="hidden_documentogd" >
                                </div>
                                <div class="modal-footer">
                                    <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Cerrar</a>
                                    <input type="submit" class="btn btn-sm btn-success" name="button_submit" value="Guardar "/>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal modal-message fade" id="modal-planilla">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">Pago de Planilla</h4>
                            </div>
                            <form class="form-horizontal" id="frm_gasto_simple" method="POST" action="procesos/reg_pago_planilla.php">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="select_semanap">Seleccionar Semana</label>
                                        <div class="col-md-7">
                                            <select class="form-control" name="select_semanap" id="select_semanap">
                                                <option value="0">SELECCIONAR SEMANA</option>
                                                <?php
                                                $a_semanas = $cl_planilla->ver_semanas_planilla();
                                                foreach ($a_semanas as $value) {
                                                    ?>
                                                    <option value="<?php echo $value['semana'] ?>"><?php echo $value['semana'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="select_clientep">Seleccionar Cliente</label>
                                        <div class="col-md-7">
                                            <select class="form-control" name="select_clientesp" id="select_clientesp" onchange="ver_sucursal_cliente_planilla()">
                                                <option value="0">SELECCIONAR SEMANA</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="select_sucursalp">Seleccionar Sucursal</label>
                                        <div class="col-md-7">
                                            <select class="form-control" name="select_sucursalp" id="select_sucursalp" onchange="ver_datos_planilla()">
                                                <option value="0">SELECCIONAR CLIENTE</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="input_fechap">Fecha</label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control text-center" id="input_fechap" name="input_fechap" value="<?php echo date('d/m/Y') ?>" required/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="input_montop">Monto</label>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control text-right" id="input_montop" name="input_montop" readonly="true"/>
                                        </div>
                                    </div>
                                    <input type="hidden" name="hidden_montop" id="hidden_montop"/>
                                    <input type="hidden" name="hidden_conceptop" id="hidden_conceptop"/>
                                    <input type="hidden" name="hidden_caja" value="<?php echo $cl_caja->getCodigo() ?>"/>
                                </div>
                                <div class="modal-footer">
                                    <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Cerrar</a>
                                    <input type="submit" class="btn btn-sm btn-success" name="button_submitp" id="button_submitp" value="Guardar "/>
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
        <script src="assets/plugins/DataTables/media/js/jquery.dataTables.js"></script>
        <script src="assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
        <script src="assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
        <script src="assets/js/table-manage-default.demo.min.js"></script>
        <script src="assets/plugins/masked-input/masked-input.min.js"></script>
        <script src="assets/js/apps.min.js"></script>
        <!-- ================== END PAGE LEVEL JS ================== -->
        <script>
                                                $(document).ready(function () {
                                                    App.init();
                                                    TableManageDefault.init();
                                                    var table = $('#data-table').DataTable();

                                                    table.order([1, 'asc']).draw();
                                                    //$('#input_fechags').mask('99/99/9999');
                                                    $('#input_fechagd').mask('99/99/9999');

                                                    $("#select_semanap").change(function () {
                                                        var semana = $("#select_semanap").val();
                                                        ver_cliente_planilla(semana);
                                                    });
                                                });
        </script>

        <script >
            $(function () {
                //autocomplete
                $("#input_buscar_proveedor").autocomplete({
                    appendTo: "#modal-gasto-documentado",
                    source: "ajax_post/buscar_proveedores_compras.php",
                    minLength: 2,
                    select: function (event, ui) {
                        event.preventDefault();
                        $('#input_ruc_proveedor').val(ui.item.ruc);
                        $('#input_razon_proveedor').val(ui.item.razon_social);
                        $('#input_nombre_proveedor').val(ui.item.nombre_comercial);
                        $('#input_direccion_proveedor').val(ui.item.direccion);
                        $('#btn_verificar_documento').prop('disabled', false);
                        ver_documentos_proveedor(ui.item.ruc);
                        $('#input_buscar_proveedor').val("");
                    }
                });

            });

            function ver_documentos_proveedor(ruc_proveedor) {
                var ruc_proveedor = ruc_proveedor;
                var documentos_proveedor = $("#select_documentos");
                if (ruc_proveedor !== '')
                {
                    $.ajax({
                        //data: {sucursal: sucursal.val(), cliente:cliente.val()},
                        url: 'ajax_post/ver_documentos_proveedor.php?ruc_proveedor=' + ruc_proveedor,
                        type: 'GET',
                        dataType: 'json',
                        beforeSend: function ()
                        {
                            documentos_proveedor.prop('disabled', true);
                        },
                        success: function (r)
                        {
                            documentos_proveedor.prop('disabled', false);
                            // Limpiamos el select
                            documentos_proveedor.find('option').remove();
                            $(r).each(function (i, v) { // indice, valor
                                documentos_proveedor.append('<option value="' + v.codigo + '">' + v.value + '</option>');
                            });
                            //ordenes.prop('disabled', false);
                            ver_datos_factura();
                        },
                        error: function ()
                        {
                            alert('Ocurrio un error en el servidor ..');
                            documentos_proveedor.prop('disabled', true);
                        }
                    });
                } else
                {
                    documentos_proveedor.find('option').remove();
                    documentos_proveedor.prop('disabled', true);
                }
            }

            function ver_datos_factura() {
                var factura = $("#select_documentos").val();
                if (factura !== '-')
                {
                    $.ajax({
                        //data: {id: cliente},
                        url: 'ajax_post/ver_datos_compra.php?codigo=' + factura,
                        type: 'GET',
                        dataType: 'json',
                        beforeSend: function ()
                        {
                            $("#input_conceptogd").val('');
                            $("#input_fechadoc").val('');
                            $("#input_montodoc").val('');
                            $("#input_fechagd").val('');
                            $("#input_montogd").val('');
                            $("#hidden_documentogd").val('');
                        },
                        success: function (response)
                        {
                            var json = response;
                            console.log(json[0].id_centro_costo);
                            var monto = json[0].monto;
                            var concepto = json[0].concepto;
                            var fecha = json[0].fecha;
                            var id_centro_costo = json[0].id_centro_costo;
                            var id_clasificacion = json[0].id_clasificacion;
                            $("#input_conceptogd").val(concepto);
                            $("#input_fechadoc").val(fecha);
                            $("#input_fechagd").val(fecha);
                            $("#input_montodoc").val(monto);
                            $("#input_montogd").val(monto);
                            $("#select_ccostogd").val(id_centro_costo).change();
                            $("#select_clasificaciongd").val(id_clasificacion).change();
                            $("#hidden_documentogd").val(json[0].documento);
                            $("#input_montogd").focus();
                        },
                        error: function ()
                        {
                            alert('Ocurrio un error en el servidor ..');
                            $("#input_conceptogd").val('ERROR AL CARGAR DATOS');
                        }
                    });
                } else
                {
                    $("#input_conceptogd").val('');
                    $("#input_fechadoc").val('');
                    $("#input_montodoc").val('');
                    $("#input_fechagd").val('');
                    $("#input_montogd").val('');
                    $("#hidden_documentogd").val('');
                }
            }
        </script>
        <script>
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

            function ver_cliente_planilla() {
                var semana = $("#select_semanap").val();
                var clientes_planilla = $("#select_clientesp");
                if (semana !== '')
                {
                    $.ajax({
                        //data: {sucursal: sucursal.val(), cliente:cliente.val()},
                        url: 'ajax_post/ver_clientes_planilla.php?semana=' + semana,
                        type: 'GET',
                        dataType: 'json',
                        beforeSend: function ()
                        {
                            clientes_planilla.prop('disabled', true);
                        },
                        success: function (r)
                        {
                            clientes_planilla.prop('disabled', false);
                            // Limpiamos el select
                            clientes_planilla.find('option').remove();
                            $(r).each(function (i, v) { // indice, valor
                                clientes_planilla.append('<option value="' + v.codigo + '">' + v.value + '</option>');
                            });
                            //ordenes.prop('disabled', false);
                            ver_sucursal_cliente_planilla();
                        },
                        error: function ()
                        {
                            alert('Ocurrio un error en el servidor ..');
                            clientes_planilla.prop('disabled', true);
                        }
                    });
                } else
                {
                    clientes_planilla.find('option').remove();
                    clientes_planilla.prop('disabled', true);
                }
            }

            function ver_sucursal_cliente_planilla() {
                var semana = $("#select_semanap").val();
                var cliente = $("#select_clientesp").val();
                var sucursal_planilla = $("#select_sucursalp");
                if (semana !== '' && cliente !== '')
                {
                    $.ajax({
                        //data: {sucursal: sucursal.val(), cliente:cliente.val()},
                        url: 'ajax_post/ver_sucursal_planilla.php?cliente=' + cliente + '&semana=' + semana,
                        type: 'GET',
                        dataType: 'json',
                        beforeSend: function ()
                        {
                            sucursal_planilla.prop('disabled', true);
                        },
                        success: function (r)
                        {
                            sucursal_planilla.prop('disabled', false);
                            // Limpiamos el select
                            sucursal_planilla.find('option').remove();
                            $(r).each(function (i, v) { // indice, valor
                                sucursal_planilla.append('<option value="' + v.codigo + '">' + v.value + '</option>');
                            });
                            //ordenes.prop('disabled', false);
                            ver_datos_planilla();
                        },
                        error: function ()
                        {
                            alert('Ocurrio un error en el servidor ..');
                            sucursal_planilla.prop('disabled', true);
                        }
                    });
                } else
                {
                    sucursal_planilla.find('option').remove();
                    sucursal_planilla.prop('disabled', true);
                }
            }

            function ver_datos_planilla() {
                var codigo = $("#select_sucursalp").val();
                if (codigo !== '-')
                {
                    $.ajax({
                        //data: {id: cliente},
                        url: 'ajax_post/ver_datos_planilla.php?codigo=' + codigo,
                        type: 'GET',
                        dataType: 'json',
                        beforeSend: function ()
                        {
                            $("#input_montop").val('');
                            $("#hidden_montop").val('');
                        },
                        success: function (response)
                        {
                            var json = response;
                            //console.log(json);
                            var monto = Math.round(json[0].monto_total).toFixed(2);
                            var estado = json[0].estado;
                            if (estado === '0') {
                                $("#input_montop").val(number_format(monto, 2));
                                $("#hidden_montop").val(monto);
                                $("#button_submitp").prop('disabled', false);
                                $("#input_fechap").prop('readonly', false);
                            }
                            if (estado === '1') {
                                $("#input_montop").val(0.00);
                                $("#hidden_montop").val(0);
                                $("#button_submitp").prop('disabled', true);
                                $("#input_fechap").prop('readonly', true);
                            }
                            $("#hidden_conceptop").val("PAGO DE PLANILLA - " + $("#select_clientesp option:selected").text() + " - " + $("#select_sucursalp option:selected").text());
                            $("#input_fechap").focus();
                        },
                        error: function ()
                        {
                            alert('Ocurrio un error en el servidor ..');
                            $("#input_montop").val('ERROR AL CARGAR DATOS');
                        }
                    });
                } else
                {
                    $("#input_montop").val('');
                    $("#hidden_montop").val('');
                }
            }
        </script>
    </body>

    <!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:23:54 GMT -->
</html>

