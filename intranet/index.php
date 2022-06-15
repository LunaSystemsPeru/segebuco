<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

require 'class/cl_venta.php';
require 'class/cl_compra.php';
require 'class/cl_cliente.php';
require 'class/cl_varios.php';
require 'class/cl_orden_cliente.php';

$cl_cliente = new cl_cliente();
$cl_orden = new cl_orden_cliente();
$cl_venta = new cl_venta();
$cl_compra = new cl_compra();
$cl_varios = new cl_varios();
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="es" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
    <!--<![endif]-->

    <head>
        <meta charset="utf-8" />
        <title>Index | SEGEBUCO SAC</title>
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

        <!-- ================== BEGIN BASE JS ================== -->
        <script src="assets/plugins/pace/pace.min.js"></script>
        <!-- ================== END BASE JS ================== -->

        <!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
        <link href="assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
        <link href="assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
        <!-- ================== END PAGE LEVEL STYLE ================== -->

        <!-- ================== BEGIN PAGE CSS STYLE ================== -->
        <link href="assets/plugins/morris/morris.css" rel="stylesheet" />
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
            <?php require 'includes/header.php'; ?>
            <!-- end #header -->
            <?php
            $a_venta_periodo = $cl_venta->ver_ventas_periodo();
            $a_compra_periodo = $cl_compra->ver_compras_periodo();
            $j_venta_periodo = array();
            $j_compra_periodo = array();
            $fila_periodo = array();

            foreach ($a_venta_periodo as $value) {
                $fila_periodo['periodo'] = $value['periodo'];
                $fila_periodo['datos'] = $value['total'];
                array_push($j_venta_periodo, $fila_periodo);
            }

            foreach ($a_compra_periodo as $value) {
                $fila_periodo['periodo'] = $value['periodo'];
                $fila_periodo['datos'] = $value['total'];
                array_push($j_compra_periodo, $fila_periodo);
            }

            $j_ventas_cliente = array();
            $fila_vcliente = array();
            $a_clientes = $cl_cliente->ver_clientes_ventas();
            foreach ($a_clientes as $value) {
                $fila_vcliente['fila'] = $value['nombre_comercial'];
                $fila_vcliente['datos'] = $value['total_facturado'];
                array_push($j_ventas_cliente, $fila_vcliente);
            }

            $vanual = 0;
            $a_venta_anual = $cl_venta->ver_monto_anual();
            foreach ($a_venta_anual as $value) {
                $vanual = $value['total'];
            }

            $vperiodo = 0;
            $cl_venta->setPeriodo(date('Y') . date('m'));
            $a_venta_eperiodo = $cl_venta->ver_monto_periodo();
            foreach ($a_venta_eperiodo as $value) {
                $vperiodo = $value['total'];
            }
            ?>
            <!-- begin #sidebar -->
            <?php require 'includes/sidebar.php'; ?>
            <!-- end #sidebar -->

            <!-- begin #content -->
            <div id="content" class="content">
                <!-- begin breadcrumb -->
                <ol class="breadcrumb pull-right">
                    <li><a href="javascript:;">Home</a></li>
                    <li><a href="javascript:;">Page Options</a></li>
                    <li class="active">Blank Page</li>
                </ol>
                <!-- end breadcrumb -->
                <!-- begin page-header -->
                <h1 class="page-header">Blank Page <small>header small text goes here...</small></h1>
                <!-- end page-header -->
                <div class="row">
                    <!-- begin col-3 -->
                    <div class="col-md-3 col-sm-6">
                        <div class="widget widget-stats bg-green">
                            <div class="stats-icon"><i class="fa fa-desktop"></i></div>
                            <div class="stats-info">
                                <h4>TOTAL VENTAS</h4>
                                <p>S/ <?php echo number_format($vanual, 2) ?></p>	
                            </div>
                            <div class="stats-link">
                                <a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <!-- end col-3 -->
                    <!-- begin col-3 -->
                    <div class="col-md-3 col-sm-6">
                        <div class="widget widget-stats bg-blue">
                            <div class="stats-icon"><i class="fa fa-chain-broken"></i></div>
                            <div class="stats-info">
                                <h4>VENTAS ESTE MES</h4>
                                <p>S/ <?php echo number_format($vperiodo, 2) ?></p>	
                            </div>
                            <div class="stats-link">
                                <a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <!-- end col-3 -->
                    <!-- begin col-3 -->
                    <div class="col-md-3 col-sm-6">
                        <div class="widget widget-stats bg-purple">
                            <div class="stats-icon"><i class="fa fa-users"></i></div>
                            <div class="stats-info">
                                <h4>UNIQUE VISITORS</h4>
                                <p>1,291,922</p>	
                            </div>
                            <div class="stats-link">
                                <a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <!-- end col-3 -->
                    <!-- begin col-3 -->
                    <div class="col-md-3 col-sm-6">
                        <div class="widget widget-stats bg-red">
                            <div class="stats-icon"><i class="fa fa-clock-o"></i></div>
                            <div class="stats-info">
                                <h4>% APROBACION</h4>
                                <p>63.50%</p>	
                            </div>
                            <div class="stats-link">
                                <a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <!-- end col-3 -->
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-inverse" data-sortable-id="morris-chart-3">
                            <div class="panel-heading">
                                <h4 class="panel-title">Ventas 2019</h4>
                            </div>
                            <div class="panel-body">
                                <h4 class="text-center">Ventas por Periodo</h4>
                                <div id="morris-bar-chart-venta" class="height-sm"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="panel panel-inverse" data-sortable-id="morris-chart-3">
                            <div class="panel-heading">
                                <h4 class="panel-title">Compras 2019</h4>
                            </div>
                            <div class="panel-body">
                                <h4 class="text-center">Compras por Periodo</h4>
                                <div id="morris-bar-chart-compra" class="height-sm"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="panel panel-inverse" data-sortable-id="morris-chart-3">
                            <div class="panel-heading">
                                <h4 class="panel-title">Ventas x Clientes 2019</h4>
                            </div>
                            <div class="panel-body">
                                <h4 class="text-center">Ventas por Clientes </h4>
                                <div id="morris-bar-chart-vcliente" class="height-sm"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="panel panel-inverse">
                            <div class="panel-heading">
                                <h4 class="panel-title">Ordenes Pendientes de Facturar</h4>
                            </div>
                            <div class="panel-body">
                                <table id="tabla_ordenes" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Id.</th>
                                            <th>Descripcion</th>
                                            <th>Cliente.</th>
                                            <th>Emision</th>
                                            <th>Total</th>
                                            <th>Facturado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $a_ordenes = $cl_orden->ver_ordenes_pendientes();
                                        $suma_total = 0;
                                        $facturado = 0;
                                        foreach ($a_ordenes as $value) {
                                            $facturado = $facturado + ($value['facturado'] * $value['total'] / 100);
                                            $suma_total = $suma_total + $value['total'];
                                            if ($value['estado'] == 1) {
                                                $estado = '<span class="btn btn-success btn-sm">' . number_format($value['facturado']) . '%</span>';
                                            } else {
                                                $estado = '<span class="btn btn-danger btn-sm">' . number_format($value['facturado']) . '%</span>';
                                            }
                                            ?>
                                            <tr class="odd gradeX">
                                                <td class="text-center">
                                                    <a href="upload/<?php echo $value['ocliente'] . "/" . $value['osucursal'] ?>/orden_cliente/<?php echo $value['archivo'] ?>" target="_blank">
                                                        <?php echo $value['codigo'] ?>
                                                    </a>
                                                </td>
                                                <td ><?php echo $value['glosa'] ?></td>
                                                <td ><?php echo $value['cliente'] ?></td>                                                
                                                <td class="text-center"><?php echo $value['fecha'] ?></td>
                                                <td class="text-right"><?php echo $value['moneda'] . ' ' . number_format($value['total'], 2, '.', ',') ?></td>
                                                <td class="text-center"><?php echo $estado ?></td>
                                            </tr>
                                            <?php
                                        }
                                        if ($suma_total > 0) {
                                            $porcentaje = $facturado / $suma_total * 100;
                                        } else {
                                            $porcentaje = 0;
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr class="odd gradeX">
                                            <td class="text-center" colspan="4">TOTAL</td>
                                            <td class="text-right"><?php echo number_format($suma_total, 2, '.', ',') ?></td>
                                            <td class="text-center"><?php echo number_format($porcentaje, 2, '.', ',') ?> %</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-inverse">
                            <div class="panel-heading">
                                <h4 class="panel-title">Facturas Pendientes de Cobros</h4>

                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="table-responsive1">
                                        <table id="table_cobranzas" class="table table-striped table-bordered nowrap" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Codigo</th>
                                                    <th>Documento</th>
                                                    <th>Fecha</th>
                                                    <th>Orden</th>
                                                    <th>Razon Social</th>
                                                    <th>Moneda</th>
                                                    <th>Total</th>
                                                    <th>Pagado</th>                                                    
                                                    <th>Por cobrar</th>   
                                                    <th>Total S/</th>                                                    
                                                    <th>Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php {
                                                /*
                                                $a_ventas = $cl_venta->ver_cobranzas();
                                                $suma_ventas_soles = 0;
                                                $suma_ventas_dolares = 0;
                                                $suma_total_soles = 0;
                                                $suma_pagado_soles = 0;
                                                $suma_pagado_dolares = 0;
                                                foreach ($a_ventas as $value) {
                                                    //print_r($value);
                                                    
                                                    $cl_venta->setEstado($value['estado']);
                                                    $cl_venta->setId_venta($cl_varios->zerofill($value['codigo'], 3));
                                                    $cl_venta->setSerie($cl_varios->zerofill($value['serie'], 3));
                                                    echo $value['v.estado'];
                                                    $cl_venta->setNumero($cl_varios->zerofill($value['numero'], 7));
                                                    $cl_venta->setTotal($value['total']);
                                                    $cl_venta->setTc($value['tipo_cambio']);
                                                    $total_soles = $cl_venta->getTotal() * $cl_venta->getTc();
                                                    $deuda = $value['total'] - $value['pagado'];

                                                    
                                                    $id_moneda = $value['id_moneda'];
                                                    if ($id_moneda == 1) {
                                                        $suma_ventas_soles += $cl_venta->getTotal();
                                                        $suma_pagado_soles += $value['pagado'];
                                                    }
                                                    if ($id_moneda == 2) {
                                                        $suma_ventas_dolares += $cl_venta->getTotal();
                                                        $suma_pagado_dolares += $value['pagado'];
                                                    }
                                                    $suma_total_soles = $suma_total_soles + $total_soles;

                                                    if ($cl_venta->getEstado() == 0) {
                                                        $activo = true;
                                                        $cl_venta->setId_cliente($value['cliente'] . ' | ' . $value['sucursal']);
                                                        $cl_venta->setEstado('<span class="btn btn-warning btn-sm">Pendiente</span>');
                                                        $btn_borrar = '<a href="ver_detalle_cliente.php?codigo=10469932091" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                                                    }
                                                    if ($cl_venta->getEstado() == 1) {
                                                        $activo = true;
                                                        $cl_venta->setId_cliente($value['cliente'] . ' | ' . $value['sucursal']);
                                                        $cl_venta->setEstado('<span class="btn btn-success btn-sm">Pagado</span>');
                                                        $btn_borrar = '';
                                                    }
                                                    if ($cl_venta->getEstado() == 2) {
                                                        $activo = false;
                                                        $cl_venta->setId_cliente('****  ANULADO  ****');
                                                        $cl_venta->setEstado('<span class="btn btn-danger btn-sm">Anulado</span>');
                                                        $btn_borrar = '';
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $value['periodo'] . $cl_venta->getId_venta() ?></td>
                                                        <td class="text-center"><?php echo $value['tido'] . '/ ' . $cl_venta->getSerie() . '-' . $cl_venta->getNumero() ?></td>
                                                        <td class="text-center"><?php echo $value['fecha_factura'] ?></td>
                                                        <td class="text-center"><?php echo $value['orden_cliente'] ?></td>
                                                        <td><?php echo $cl_venta->getId_cliente() ?></td>
                                                        <td class="text-right"><?php echo $value['moneda'] ?></td>
                                                        <td class="text-right"><?php echo number_format($cl_venta->getTotal(), 2, '.', ','); ?></td>
                                                        <td class="text-right"><?php echo number_format($value['pagado'], 2, '.', ','); ?></td>
                                                        <td class="text-right"><?php echo number_format($deuda, 2, '.', ','); ?></td>
                                                        <td class="text-right"><?php echo number_format($total_soles, 2, '.', ','); ?></td>
                                                        <td class="text-center"><?php echo $cl_venta->getEstado() ?></td>
                                                    </tr>
                                                    <?php
                                                 * */
                                                }
                                                ?>
                                            <tfoot>
                                                <tr>
                                                    <td class="text-right" colspan="5">TOTAL SOLES </td>
                                                    <td class="text-right"><?php echo number_format($suma_ventas_soles, 2, '.', ',') ?></td>
                                                    <td class="text-right"><?php echo number_format($suma_pagado_soles, 2, '.', ',') ?></td>
                                                    <td class="text-right"><?php echo number_format($suma_ventas_soles - $suma_pagado_soles, 2, '.', ',') ?></td>
                                                    <td class="text-center"></td>
                                                    <td class="text-center"></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right" colspan="5">TOTAL DOLARES </td>
                                                    <td class="text-right"><?php echo number_format($suma_ventas_dolares, 2, '.', ',') ?></td>
                                                    <td class="text-right"><?php echo number_format($suma_pagado_dolares, 2, '.', ',') ?></td>
                                                    <td class="text-right"><?php echo number_format($suma_ventas_dolares - $suma_pagado_dolares, 2, '.', ',') ?></td>
                                                    <td class="text-center"></td>
                                                    <td class="text-center"></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right" colspan="5">SUMA TOTAL SOLES </td>
                                                    <td class="text-right">-</td>
                                                    <td class="text-right">-</td>
                                                    <td class="text-right">-</td>
                                                    <td class="text-center"><?php echo number_format($suma_total_soles, 2, '.', ',') ?></td>
                                                    <td class="text-center"></td>
                                                </tr>
                                            </tfoot>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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

        <script src="assets/plugins/DataTables/media/js/jquery.dataTables.js"></script>
        <script src="assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
        <script src="assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js"></script>

        <!-- ================== BEGIN PAGE LEVEL JS ================== -->
        <script src="assets/plugins/morris/raphael.min.js"></script>
        <script src="assets/plugins/morris/morris.js"></script>
        <script src="assets/js/chart-morris.demo.min.js"></script>
        <script src="assets/js/apps.min.js"></script>
        <!-- ================== END PAGE LEVEL JS ================== -->


        <script>
            $(document).ready(function () {
                App.init();
                MorrisChart.init();

                $('#tabla_ordenes').DataTable({
                    responsive: true
                });

                var table = $('#tabla_ordenes').DataTable();

                $('#table_cobranzas').DataTable({
                    responsive: true
                });

                var table = $('#table_cobranzas').DataTable();
            });



            var MorrisChart = function () {
                "use strict";
                return {
                    init: function () {
                        Barra_Ventas_Periodo();
                        Barra_Compras_Periodo();
                        Barra_Ventas_Cliente();
                    }
                };
            }();

            var blue = "#348fe2",
                    blueLight = "#5da5e8",
                    blueDark = "#1993E4",
                    aqua = "#49b6d6",
                    aquaLight = "#6dc5de",
                    aquaDark = "#3a92ab",
                    green = "#00acac",
                    greenLight = "#33bdbd",
                    greenDark = "#008a8a",
                    orange = "#f59c1a",
                    orangeLight = "#f7b048",
                    orangeDark = "#c47d15",
                    dark = "#2d353c",
                    grey = "#b6c2c9",
                    purple = "#727cb6",
                    purpleLight = "#8e96c5",
                    purpleDark = "#5b6392",
                    red = "#ff5b57";

            var Barra_Ventas_Periodo = function () {
                Morris.Bar({
                    element: "morris-bar-chart-venta",
                    data: <?php print_r(json_encode($j_venta_periodo)) ?>,
                    xkey: "periodo",
                    ykeys: ["datos"],
                    labels: ["Total S/"],
                    barRatio: .4,
                    xLabelAngle: 35,
                    hideHover: "auto",
                    resize: true,
                    barColors: [blueLight]
                })
            };

            var Barra_Compras_Periodo = function () {
                Morris.Bar({
                    element: "morris-bar-chart-compra",
                    data: <?php print_r(json_encode($j_compra_periodo)) ?>,
                    xkey: "periodo",
                    ykeys: ["datos"],
                    labels: ["Total S/"],
                    barRatio: .4,
                    xLabelAngle: 35,
                    hideHover: "auto",
                    resize: true,
                    barColors: [purpleLight]
                })
            };

            var Barra_Ventas_Cliente = function () {
                Morris.Bar({
                    element: "morris-bar-chart-vcliente",
                    data: <?php print_r(json_encode($j_ventas_cliente)) ?>,
                    xkey: "fila",
                    ykeys: ["datos"],
                    labels: ["Total S/"],
                    barRatio: .1,
                    xLabelAngle: 35,
                    hideHover: "auto",
                    resize: true,
                    barColors: [orangeLight]
                })
            };
        </script>
    </body>

    <!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:23:54 GMT -->
</html>

