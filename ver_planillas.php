<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

require 'class/cl_planilla.php';
require 'class/cl_varios.php';
require 'class/cl_planilla_gastos.php';
$cl_varios = new cl_varios();
$cl_planilla = new cl_planilla();
$cl_gastos = new cl_planilla_gastos();
if (filter_input(INPUT_GET, 'semana') != '') {
    $semana = filter_input(INPUT_GET, 'semana');
} else {
    $semana = date("Y") . $cl_varios->zerofill(date("W"), 3);
}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="es" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
    <!--<![endif]-->

    <head>
        <meta charset="utf-8" />
        <title>Planilla | SEGEBUCO SAC</title>
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
                    <li><a href="javascript:;">Planilla</a></li>
                    <li class="active">Planilla</li>
                </ol>
                <!-- end breadcrumb -->
                <!-- begin page-header -->
                <h1 class="page-header">Planilla <?php echo $semana ?> <small>matenimiento planilla</small></h1>
                <!-- end page-header -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-inverse">
                            <div class="panel-heading">
                                <a href="reg_planilla.php" class="btn btn-info btn-sm" >Agregar Planilla</a>
                                <a href="ver_detalle_planilla_colaborador.php?codigo=<?php echo $semana ?>" class="btn btn-info btn-sm" >Ver detalle Planilla</a>
                                <a target="_blank" href="reportes/pdf_detalle_planilla_semana.php?planilla=<?php echo $semana ?>" class="btn btn-warning btn-sm" >Ver PDF Planilla</a>
                                <div class="panel-heading-btn">
                                    <select class="form-control" id="select_semana" name="select_semana">
                                        <option value="-" >Seleccionar Semana</option>
                                        <?php
                                        $a_semanas = $cl_planilla->ver_semanas();
                                        foreach ($a_semanas as $value) {
                                            ?>
                                            <option value="<?php echo $value['semana'] ?>"><?php echo $value['semana'] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="panel-body">
                                <!--<div class="table-responsive">-->
                                <table id="data-table" class="table table-striped table-bordered"  width="100%">
                                    <thead>
                                        <tr>
                                            <th>Id.</th>
                                            <th>Cliente</th>
                                            <th>Sucursal</th>
                                            <th>Usuario</th>
                                            <th>Fec. Inicio</th>
                                            <th>Fec. Fin</th>
                                            <th>Monto</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $suma_total = 0;

                                        $a_planillas = $cl_planilla->ver_planillas($semana);
                                        foreach ($a_planillas as $value) {
                                            $cl_gastos->setPlanilla($value['codigo']);
                                            $a_gastos = $cl_gastos->ver_gastos_planilla();
                                            $suma_gastos = 0.0;
                                            foreach ($a_gastos as $valor) {
                                                $suma_gastos = $suma_gastos + $valor['monto'];
                                            }
                                            $suma_planilla = $value['planilla'] + $suma_gastos;
                                            $suma_total = $suma_total + $suma_planilla;
                                            $estado = $value['estado'];
                                            if ($estado == 0) {
                                                $vestado = '<span class="btn btn-warning btn-sm">Pendiente</span>';
                                            }
                                            if ($estado == 1) {
                                                $vestado = '<span class="btn btn-success btn-sm">Pagado</span>';
                                            }
                                            ?>
                                            <tr class="odd gradeX">
                                                <td class="text-center"><?php echo $value['codigo'] ?></td>
                                                <td><?php echo $value['razon_social'] ?></td>
                                                <td class="text-center"><?php echo $value['sucursal'] ?></td>
                                                <td class="text-center"><?php echo $value['usuario'] ?></td>
                                                <td class="text-center"><?php echo $cl_varios->fecha_mysql_web($value['fecha_inicio']) ?></td>
                                                <td class="text-center"><?php echo $cl_varios->fecha_mysql_web($value['fecha_fin']) ?></td>
                                                <td class="text-right"><?php echo number_format(round($suma_planilla), 2, '.', ',') ?></td>
                                                <td class="text-center"><?php echo $vestado ?></td>
                                                <td class="text-center">
                                                    <a href="ver_detalle_planilla.php?codigo=<?php echo $value['codigo'] ?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                                                    <a href="ver_detalle_planilla_pago.php?codigo=<?php echo $value['codigo'] ?>" class="btn btn-primary btn-sm"><i class="fa fa-desktop"></i></a>
                                                    <a href="ver_detalle_planilla.php?codigo=201701&sucursal=1" class="btn btn-danger btn-sm"><i class="fa fa-close"></i></a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr class="odd gradeX">
                                            <td class="text-right" colspan="6">SUMA TOTAL</td>
                                            <td class="text-right"><?php echo number_format(round($suma_total), 2, '.', ',') ?></td>
                                            <td class="text-center"></td>
                                            <td class="text-center"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <!--</div>-->
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
        <!--<script src="assets/js/table-manage-default.demo.min.js"></script>-->
        <script src="assets/js/table-manage-responsive.demo.min.js"></script>
        <script src="assets/js/apps.min.js"></script>
        <!-- ================== END PAGE LEVEL JS ================== -->
        <script>
            $(document).ready(function () {
                App.init();
                //TableManageDefault.init();
                TableManageResponsive.init();
                var table = $('#data-table').DataTable();

                table.order([0, 'desc']).draw();
            });

            $("#select_semana").change(function () {
                var semana = $("#select_semana").val();
                window.location = "ver_planillas.php?semana=" + semana;
            });
        </script>
    </body>

    <!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:23:54 GMT -->
</html>

