<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

require 'class/cl_venta.php';
require 'class/cl_entidad.php';
require 'class/cl_cliente.php';
require 'class/cl_varios.php';
require 'class/cl_numero_letras.php';
$cl_venta = new cl_venta();
$cl_varios = new cl_varios();
$cl_cliente = new cl_cliente();
$cl_entidad = new cl_entidad();
$cl_letras = new cl_numero_letras();
$cl_venta->setCodigo(filter_input(INPUT_GET, 'codigo'));
$cl_venta->setPeriodo(filter_input(INPUT_GET, 'periodo'));
$cl_venta->datos_venta();
$cl_cliente->setCodigo($cl_venta->getCliente());
$a_clientes = $cl_cliente->datos_cliente();
foreach ($a_clientes as $value) {
    $cl_entidad->setRuc($value['ruc']);
    $cl_entidad->setRazon_social($value['razon_social']);
    $cl_entidad->setDireccion($value['direccion']);
}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="es" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
    <!--<![endif]-->

    <head>
        <meta charset="utf-8" />
        <title>Ver Detalle de Venta | SEGEBUCO SAC</title>
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />

        <!-- ================== BEGIN BASE CSS STYLE ================== -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <link href="assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
        <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
        <link href="assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
        <link href="assets/css/animate.min.css" rel="stylesheet" />
        <link href="assets/css/style.min.css" rel="stylesheet" />
        <link href="assets/css/style-responsive.min.css" rel="stylesheet" />
        <link href="assets/css/invoice-print.min.css" rel="stylesheet" />
        <link href="assets/css/theme/default.css" rel="stylesheet" id="theme" />
        <!-- ================== END BASE CSS STYLE ================== -->

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


                <!-- begin invoice -->
                <div class="invoice">
                    <div class="invoice-company">
                        <span class="pull-right hidden-print">
                            <a href="javascript:;" class="btn btn-sm btn-info m-b-10"><i class="fa fa-download m-r-5"></i> Exportar como PDF</a>
                            <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-success m-b-10"><i class="fa fa-print m-r-5"></i>Imprimir</a>
                        </span>
                        Documento: <?php echo $cl_venta->getPeriodo() . ' - ' . $cl_varios->zerofill($cl_venta->getCodigo(), 3)?>
                    </div>
                    <div class="invoice-header">
                        <div class="invoice-from">
                            <small>from</small>
                            <address class="m-t-5 m-b-5">
                                <strong>SEGEBUCO SAC</strong><br />
                                JR. CHANCAY MZA. J LOTE. 16 P.J. FLORIDA ALTA <br />
                                ANCASH - SANTA - CHIMBOTE<br />
                                RUC: 20531757590<br />
                                e: segebuco@gmail.com
                            </address>
                        </div>
                        <div class="invoice-to">
                            <small>to</small>
                            <address class="m-t-5 m-b-5">
                                <strong><?php echo $cl_entidad->getRazon_social()?></strong><br />
                                <?php echo $cl_entidad->getDireccion()?><br />
                                RUC: <?php echo $cl_entidad->getRuc() ?><br />
                                <b>Orden de Servicio:</b> <?php echo $cl_venta->getOrden()?><br />
                                <b>Aceptacion de Servicio:</b> 137409
                            </address>
                        </div>
                        <div class="invoice-date">
                            <small>Factura</small>
                            <div class="date m-t-5"><?php $cl_venta->getFecha_factura()?></div>
                            <div class="invoice-detail">
                                <?php echo $cl_venta->getTido() . ' ¬ ' . $cl_varios->zerofill($cl_venta->getSerie(), 3) . ' - ' . $cl_varios->zerofill($cl_venta->getNumero(), 7); ?><br />
                                Cod. Int.: <?php echo $cl_venta->getPeriodo() . $cl_varios->zerofill($cl_venta->getCodigo(), 3)?> <br />
                                <b>Moneda:</b> <?php echo $cl_venta->getMoneda()?>
                            </div>
                        </div>
                    </div>
                    <div class="invoice-content">
                        <div class="table-responsive">
                            <table class="table table-invoice">
                                <thead>
                                    <tr>
                                        <th>Cant.</th>
                                        <th>Descripcion</th>
                                        <th>P.Unit.</th>
                                        <th>P. Parcial</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center"><?php echo number_format($cl_venta->getPorcentaje() / 100, 2)?></td>
                                        <td>
                                            <?php echo $cl_venta->getGlosa()?>
                                        </td>
                                        <td class="text-right"><?php echo number_format($cl_venta->getTotal() / 1.18 / $cl_venta->getPorcentaje() * 100, 2)?></td>
                                        <td class="text-right"><?php echo number_format($cl_venta->getTotal() / 1.18, 2)?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="invoice-price">
                            <div class="invoice-price-left">
                                <div class="invoice-price-row">
                                    <div class="sub-price">
                                        <small>SUBTOTAL</small>
                                        <?php echo number_format($cl_venta->getTotal() / 1.18, 2)?>
                                    </div>
                                    <div class="sub-price">
                                        <i class="fa fa-plus"></i>
                                    </div>
                                    <div class="sub-price">
                                        <small>I.G.V. (18%)</small>
                                        <?php echo number_format($cl_venta->getTotal() / 1.18 * 0.18, 2)?>
                                    </div>
                                </div>
                            </div>
                            <div class="invoice-price-right">
                                <small>TOTAL</small> <?php echo number_format($cl_venta->getTotal(), 2)?>
                            </div>
                        </div>
                        <div class="invoice-note">
                            <p class="h5">SON: <?php echo $cl_letras->to_word($cl_venta->getTotal(), 'USD')?></h5>
                        </div>
                    </div>
                </div>
                <!-- end invoice -->

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
        <script src="assets/js/apps.min.js"></script>
        <!-- ================== END PAGE LEVEL JS ================== -->
        <script>
                                $(document).ready(function () {
                                    App.init();
                                });

        </script>
    </body>

    <!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:23:54 GMT -->
</html>

