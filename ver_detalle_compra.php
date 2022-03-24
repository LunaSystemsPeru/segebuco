<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}
require 'class/cl_compra.php';
require 'class/cl_entidad.php';
require 'class/cl_pago_compra.php';
require 'class/cl_banco.php';
require 'class/cl_planilla.php';
require 'class/cl_detalle_planilla.php';
require 'class/cl_planilla_gastos.php';
require 'class/cl_varios.php';
require 'class/cl_compra_amarre.php';

$cl_planilla = new cl_planilla();
$cl_varios = new cl_varios();
$cl_detalle = new cl_detalle_planilla();
$cl_gastos = new cl_planilla_gastos();
$cl_compra = new cl_compra();
$cl_entidad = new cl_entidad();
$cl_pago_compra = new cl_pago_compra();
$cl_banco = new cl_banco();
$cl_compra_amarre = new cl_compra_amarre();

$cl_compra->setCodigo(filter_input(INPUT_GET,'codigo'));
$cl_compra->setPeriodo(filter_input(INPUT_GET,'periodo'));
$cl_compra->obtener_datos();

$cl_compra_amarre->setPeriodo($cl_compra->getPeriodo());
$cl_compra_amarre->setIdCompra($cl_compra->getCodigo());
$cl_compra_amarre->obtener_datos();

$cl_entidad->setRuc($cl_compra->getProveedor());
$cl_entidad->obtener_datos();
$cl_pago_compra->setIdCompra($cl_compra->getCodigo());
global $conn;


?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="es" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
    <!--<![endif]-->

    <head>
        <meta charset="utf-8" />
        <title>Detalle de Pago de Compra | SEGEBUCO SAC</title>
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
                    <li><a href="ver_planillas.php?semana=<?php echo $cl_planilla->getAnio() . $cl_varios->zerofill($cl_planilla->getSemana(), 3) ?>">Planilla</a></li>
                    <li class="active">Detalle Pago de Compra</li>
                </ol>
                <!-- end breadcrumb -->
                <!-- begin page-header -->
                <h1 class="page-header">Detalle de Pago de Compra <small>matenimiento pago</small></h1>
                <!-- end page-header -->

                <div class="row">
                    <div class="col-md-8">
                        <div class="panel panel-inverse">
                            <div class="panel-heading">
                                <h4 class="panel-title">Datos Generales</h4>
                            </div>
                            <div class="panel-body">
                                <form class="form-horizontal" id="frm_detalle">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">CODIGO</label>
                                        <div class="col-md-8">
                                            <span class="form-control"><?php echo $cl_compra->getCodigo() ?></span>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">PROVEEDOR</label>
                                        <div class="col-md-8">
                                            <span class="form-control" ><?php echo $cl_entidad->getRazon_social() ?></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">FECHA COMPRA</label>
                                        <div class="col-md-8">
                                            <span class="form-control" ><?php echo $cl_compra->getFecha_compra() ?></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">SERIE</label>
                                        <div class="col-md-8">
                                            <span class="form-control" ><?php echo $cl_compra->getSerie() ?></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">NUMERO</label>
                                        <div class="col-md-8">
                                            <span class="form-control" ><?php echo $cl_compra->getNumero() ?></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">TOTAL</label>
                                        <div class="col-md-8">
                                            <span class="form-control" ><?php echo $cl_compra->getTotal() ?></span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-inverse">
                            <div class="panel-heading">
                                <h4 class="panel-title">Factura Relacionada a la Nota</h4>
                            </div>
                            <div class="panel-body">
                                <table id="tabla_factura" class="table table-striped table-bordered"  width="100%">
                                    <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Tipo Doc</th>
                                        <th>Serie</th>
                                        <th>numero</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="odd gradeX">
                                            <td><?php echo $cl_compra_amarre->getFecha() ?></td>
                                            <td class="text-center"><?php echo "FT"?></td>
                                            <td class="text-right"><?php echo $cl_compra_amarre->getSerie() ?></td>
                                            <td class="text-right"><?php echo $cl_compra_amarre->getNumero() ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-inverse">
                            <div class="panel-heading">
                                <div class="panel-heading-btn">
                                    <a href="#modal_gastos" data-toggle="modal" class="btn btn-success btn-xs">Agregar</a>
                                </div>
                                <h4 class="panel-title">Pagos</h4>
                            </div>
                            <div class="panel-body">
                                <table id="tabla_gastos" class="table table-striped table-bordered"  width="100%">
                                    <thead>
                                        <tr>
                                            <th>Banco</th>
                                            <th>fecha</th>
                                            <th>Monto</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        foreach ($cl_pago_compra->ver_pagos() as $value) {
                                            ?>
                                            <tr class="odd gradeX">
                                                <td><?php echo $value['nombre'] ?></td>
                                                <td class="text-center"><?php echo $value['fecha'] ?></td>
                                                <td class="text-right"><?php echo $value['egreso'] ?></td>
                                                <td class="text-center">
                                                    <a href="procesos/del_pago_compra.php?input_compra=<?php echo $cl_compra->getCodigo(). "&input_movimiento=" .  $value ['movimiento'] ?>" class="btn btn-danger btn-sm"><i class="fa fa-close"></i></a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="modal_gastos">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">Agregar Gasto</h4>
                            </div>
                            <form class="form-horizontal" id="frm_registrar" method="post" action="procesos/reg_pago_compra.php">
                                <div class="modal-body">

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">BANCO</label>
                                        <div class="col-md-8">
                                            <select class="form-control" required="true" name="input_banco" id="input_banco">
                                                <?php
                                                $a_banco = $cl_banco->ver_bancos();
                                                foreach ($a_banco as $value) {
                                                    ?>
                                                    <option value="<?php echo $value['codigo'] ?>"><?php echo $value['nombre'] . " - " . "S/.". $value['monto_disponible'] ?></option>
                                                    <?php

                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">FECHA</label>
                                        <div class="col-md-4">
                                            <input type="date" class="form-control" name="input_fecha" id="input_fecha" required/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">MONTO</label>
                                        <div class="col-md-8">
                                            <input type="text" name="input_monto" class="form-control" required="true" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">DEUDA</label>
                                        <div class="col-md-8">
                                            <span disabled=»disabled»  class="form-control" ><?php echo $cl_compra->getTotal() ?></span>
                                        </div>
                                    </div>
                                    <input type="hidden" name="input_compra" value="<?php echo $cl_compra->getCodigo() ?>"/>
                                </div>
                                <div class="modal-footer">
                                    <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Cerrar</a>
                                    <button type="submit" class="btn btn-sm btn-success">Guardar</button>
                                </div>
                            </form>
                        </div>
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
    <script src="assets/js/table-manage-responsive.demo.min.js"></script>
    <script src="assets/js/apps.min.js"></script>
    <!-- ================== END PAGE LEVEL JS ================== -->
    <script>
                                                            $(document).ready(function () {
                                                                App.init();
                                                                TableManageResponsive.init();
                                                            });
    </script>
    <script>
        function cargar_datos_planilla(planilla, empleado) {
            var idplanilla = planilla;
            var idempleado = empleado;
            $.ajax({
                //data: parametros,
                url: 'ajax_post/ver_datos_planilla_colaborador.php?idplanilla=' + idplanilla + '&idempleado=' + idempleado,
                type: 'get',
                beforeSend: function () {
                    $("#resultado").html("Procesando, espere por favor...");
                    $("#input_jornal").val("");
                    $("#input_colaborador_pago").val("");
                    $("#input_diast").val("");
                    $("#input_dominical").val("");
                    $("#input_ext25").val("");
                    $("#input_ext100").val("");
                    $("#input_sext25").val("");
                    $("#input_sext100").val("");
                    $("#input_alimentacion").val("");
                    $("#input_movilidad").val("");
                    $("#input_adelantos").val("");
                    $("#input_otros").val("");
                    $("#input_semana").val("");
                    $("#submit_guardar_empleado").prop('disabled', true);
                },
                success: function (response) {
                    $("#resultado").html("");
                    var json = response;
                    console.log(json);
                    var json_datos = JSON.parse(json);
                    //console.log(json_datos[0].jornal);
                    var jornal = json_datos[0].jornal;
                    var categoria = json_datos[0].categoria;
                    var diast = json_datos[0].diast;
                    var ext25 = json_datos[0].ext25;
                    var ext100 = json_datos[0].ext100;
                    var s_horas25 = jornal / 8 * ext25 * 1.25;
                    var s_horas100 = jornal / 8 * ext100 * 2;
                    var s_alimentacion = Number(json_datos[0].i_alimentacion);
                    var s_gastos = Number(json_datos[0].i_gastos);
                    var s_adelanto = Number(json_datos[0].d_adelanto);
                    var s_otros = Number(json_datos[0].d_otros);
                    var s_diast = jornal * diast;
                    var dominical = 0.0;
                    if (diast === 6) {
                        dominical = parseFloat(jornal);
                    } else {
                        dominical = 0.00;
                    }
                    var sueldo_semana = parseFloat(s_diast + dominical + s_horas25 + s_horas100 + s_alimentacion + s_gastos - s_adelanto - s_otros);
                    console.log(sueldo_semana);
                    //console.log(json_datos[0].idcolaborador);
                    $("#input_id_colaborador_pago").val(json_datos[0].idcolaborador);
                    $("#input_jornal").val(jornal);
                    $("#input_colaborador_pago").val(json_datos[0].empleado);
                    $("#input_diast").val(diast);
                    $("#input_dominical").val(dominical.toFixed(2));
                    $("#input_ext25").val(ext25);
                    $("#input_ext100").val(ext100);
                    $("#input_sext25").val(s_horas25.toFixed(2));
                    $("#input_sext100").val(s_horas100.toFixed(2));
                    $("#input_alimentacion").val(s_alimentacion.toFixed(2));
                    $("#input_movilidad").val(s_gastos.toFixed(2));
                    $("#input_adelantos").val(s_adelanto.toFixed(2));
                    $("#input_otros").val(s_otros.toFixed(2));
                    $("#input_semana").val(Math.round(sueldo_semana).toFixed(2));
                    $("#submit_guardar_empleado").prop('disabled', false);
                }
            });
        }
    </script>
</body>

<!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:23:54 GMT -->
</html>


