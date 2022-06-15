<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

require 'class/cl_varios.php';
require 'class/cl_centro_costo.php';
require 'class/cl_cliente.php';
require 'class/cl_entidad.php';
require 'class/cl_sucursal.php';
require 'class/cl_movimiento_caja.php';

$cl_varios = new cl_varios();
$cl_costo = new cl_centro_costo();

if (filter_input(INPUT_GET, 'caja') != '') {
    $cl_costo->setCodigo(filter_input(INPUT_GET, 'caja'));
    $cl_costo->setAnio(date("Y"));
    $cl_costo->obtener_datos();
} else {
    header("Location: ver_centro_costo.php");
}

$cl_cliente = new cl_cliente();
$cl_cliente->setCodigo($cl_costo->getCliente());
$cl_cliente->obtener_datos();

$cl_entidad = new cl_entidad();
$cl_entidad->setRuc($cl_cliente->getRuc());
$cl_entidad->obtener_datos();

$cl_sucursal = new cl_sucursal();
$cl_sucursal->setCodigo($cl_costo->getSucursal());
$cl_sucursal->setCliente($cl_costo->getCliente());
$cl_sucursal->cargar_datos();
$a_ingreso = $cl_sucursal->ver_cobros_sucursal();

$cl_movimiento = new cl_movimiento_caja();
$cl_movimiento->setCcosto($cl_costo->getAnio() . $cl_costo->getCodigo());
$a_movimientos = $cl_movimiento->ver_movimiento_ccosto();
?>
<!DOCTYPE html>
<!--[if IE 8]>
<html lang="es" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
<!--<![endif]-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=euc-jp">

    <title>Ver detalle de Centro de Costo | SEGEBUCO SAC</title>
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

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="assets/plugins/pace/pace.min.js"></script>
    <!-- ================== END BASE JS ================== -->

    <!-- ================== BEGIN PAGE CSS STYLE ================== -->
    <link href="assets/plugins/morris/morris.css" rel="stylesheet"/>
    <!-- ================== END PAGE CSS STYLE ================== -->
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
            <li><a href="javascript:;">Centro de Costo</a></li>
            <li class="active">Detalle del Centro</li>
        </ol>
        <!-- end breadcrumb -->
        <!-- begin page-header -->
        <h1 class="page-header">Ver Detalle Centro de Costo</h1>
        <!-- end page-header -->

        <div class="col-lg-7">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Datos Generales</h4>
                </div>
                <div class="panel-body">
                    <!-- begin table -->
                    <div class="table-responsive">
                        <table class="table table-profile">
                            <thead>
                            <tr>

                                <th colspan="2">
                                    <h4><?php echo $cl_entidad->getNombre_comercial() . " - " . $cl_sucursal->getNombre() ?></h4>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="field">
                                <td class="field">cliente</td>
                                <td><?php echo $cl_entidad->getRuc() . " - " . $cl_entidad->getRazon_social() ?></td>
                            </tr>
                            <tr class="field">
                                <td class="field">Sucursal</td>
                                <td><?php echo $cl_sucursal->getDireccion() ?></td>
                            </tr>
                            <tr class="divider highlight">
                                <td colspan="2"></td>
                            </tr>
                            <tr class="field">
                                <td class="field">Año</td>
                                <td>2019</td>
                            </tr>
                            <tr class="divider highlight">
                                <td colspan="2"></td>
                            </tr>
                            <tr class="field">
                                <td class="field">Estado</td>
                                <td>ACTIVO</td>
                            </tr>
                            <tr class="field">
                                <td class="field">Observaciones</td>
                                <td>---</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- end table -->
                </div>
                <!-- end profile-info -->
            </div>
            <!-- end profile-section -->
        </div>

        <div class="col-lg-5">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <!--<a href="#modal_archivo" data-toggle="modal" class="btn btn-success btn-xs">Agregar</a>-->
                    </div>
                    <h4 class="panel-title">TOTAL INGRESOS</h4>
                </div>
                <div class="panel-body">
                    <table id="tabla_documentos" class="table table-striped table-bordered" width="100%">
                        <thead>
                        <tr>
                            <th>Banco</th>
                            <th>Monto USD</th>
                            <th>Monto S/</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $total_ingreso = 0;
                        foreach ($a_ingreso as $fila) {
                            $total_ingreso += $fila['total_cobros'];
                            ?>
                            <tr>
                                <td><?php echo $fila['nombre'] ?></td>
                                <td></td>
                                <td class="text-right"><?php echo number_format($fila['total_cobros'], 2) ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td class="text-right">TOTAL</td>
                            <td></td>
                            <td class="text-right"><?php echo number_format($total_ingreso, 2) ?></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="panel panel-inverse">
                <div class="panel-heading">

                    <h4 class="panel-title">Detalle de Egresos</h4>
                </div>
                <div class="panel-body">
                    <table id="data-table" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>Item</th>
                            <th>Tipo Gasto</th>
                            <th>Monto S/</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $total_gastos = 0;
                        foreach ($a_movimientos as $fila) {
                            $total_gastos = $total_gastos + $fila['total_gastos'];
                            ?>
                            <tr>
                                <td><?php echo $fila['id_tipo_gasto'] ?></td>
                                <td><?php echo $fila['descripcion'] ?></td>
                                <td class="text-right"><?php echo number_format($fila['total_gastos'], 2) ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td></td>
                            <td class="text-right">SUMA GASTOS</td>
                            <td class="text-right"><?php echo number_format($total_gastos, 2) ?></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <?php
        $_grafica = array();
        foreach ($a_movimientos as $fila) {
            $porcentaje = $fila['total_gastos'] / $total_gastos * 100;
            $_grafica[] = array ("label" => $fila['descripcion'], "value"=> number_format($porcentaje, 2));
        }
        $utilidad = 0;
        if ($total_ingreso > $total_gastos) {
            $total_ingreso - $total_gastos;
        }
        if ($utilidad > 0) {
            $_grafica[] = array("label" => "UTILIDAD", "value" => number_format($utilidad, 2));
        }
        $json_grafica = json_encode($_grafica);
        ?>

        <div class="col-sm-6">
            <div class="panel panel-inverse">
                <div class="panel-heading">

                    <h4 class="panel-title">Grafica de Utilidades</h4>
                </div>
                <div class="panel-body">
                    <div id="morris-donut-chart" class="height-sm"></div>
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
<script src="assets/js/table-manage-default.demo.min.js"></script>
<script src="assets/js/apps.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="assets/plugins/morris/raphael.min.js"></script>
<script src="assets/plugins/morris/morris.js"></script>
<script src="assets/js/chart-morris.demo.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->
<script>
    var handleMorrisDonusChart = function () {
        Morris.Donut({
            element: "morris-donut-chart",
            data: <?php echo $json_grafica?>,
            formatter: function (e) {
                return e + "%"
            },
            resize: true,
            colors: [dark, orange, red, grey, green]
        })
    };

    $(document).ready(function () {
        App.init();
        //TableManageDefault.init();
        handleMorrisDonusChart();
    });
</script>

<script language="javascript">
    function exportTableToExcel(tableID, filename = '') {
        var downloadLink;
        var dataType = 'application/vnd.ms-excel';
        var tableSelect = document.getElementById(tableID);
        var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

        // Specify file name
        filename = filename ? filename + '.xls' : 'excel_data.xls';

        // Create download link element
        downloadLink = document.createElement("a");

        document.body.appendChild(downloadLink);

        if (navigator.msSaveOrOpenBlob) {
            var blob = new Blob(['ufeff', tableHTML], {
                type: dataType
            });
            navigator.msSaveOrOpenBlob(blob, filename);
        } else {
            // Create a link to the file
            downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

            // Setting the file name
            downloadLink.download = filename;

            //triggering the function
            downloadLink.click();
        }
    }
</script>
</body>

<!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:23:54 GMT -->
</html>

