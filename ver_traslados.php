<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

require 'class/cl_traslado.php';
require 'class/cl_varios.php';
$cl_traslado = new cl_traslado();
$cl_varios = new cl_varios();

if (filter_input(INPUT_GET, 'periodo') != '') {
    $cl_traslado->setPeriodo(filter_input(INPUT_GET, 'periodo'));
} else {
    $cl_traslado->setPeriodo(date('Y') . date('m'));
}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="es" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
    <!--<![endif]-->

    <head>
        <meta charset="utf-8" />
        <title>Ver Traslados | SEGEBUCO SAC</title>
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
                    <li><a href="javascript:;">Almacenes</a></li>
                    <li class="active">Traslados</li>
                </ol>
                <!-- end breadcrumb -->
                <!-- begin page-header -->
                <h1 class="page-header">Traslados <small>matenimiento almacenes</small></h1>
                <!-- end page-header -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-inverse">
                            <div class="panel-heading">
                                <div class="panel-heading-btn">
                                    <select class="form-control" id="select_periodo" name="select_periodo">
                                        <option value="-" >Seleccionar Periodo</option>
                                        <?php
                                        $a_periodos = $cl_traslado->ver_periodo();
                                        foreach ($a_periodos as $value) {
                                            ?>
                                            <option value="<?php echo $value['periodo'] ?>"><?php echo $value['periodo'] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <a href="reg_traslado.php" class="btn btn-info btn-sm" >Nuevo Traslado</a>
                            </div>
                            <div class="panel-body">
                                <table id="tabla_traslado" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Id.</th>
                                            <th>Fec. Traslado</th>
                                            <th>Origen</th>
                                            <th>Destino</th>
                                            <th>Documento</th>
                                            <th>Usuario</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $a_traslados = $cl_traslado->ver_traslados();
                                        foreach ($a_traslados as $value) {
                                            ?>
                                            <tr class="odd gradeX">
                                                <td class="text-center"><?php echo $value['periodo'] . $cl_varios->zerofill($value['codigo'], 3) ?></td>
                                                <td class="text-center"><?php echo $value['fecha'] ?></td>
                                                <td><?php echo $value['origen'] ?></td>
                                                <td><?php echo $value['destino'] ?></td>
                                                <td class="text-center"><?php echo $value['abreviado'] . ' / ' . $cl_varios->zerofill($value['serie'], 3) . ' - ' . $cl_varios->zerofill($value['numero'], 7) ?></td>
                                                <td class="text-center"><?php echo $value['usuario'] ?></td>
                                                <td class="text-center"><a target="_blank" href="reportes/pdf_ver_documento_traslado.php?codigo=<?php echo $value['periodo'] . $value['codigo'] ?>" class="btn btn-info btn-sm"><i class="fa fa-print"></i></a></td>
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
        <script src="assets/js/apps.min.js"></script>
        <!-- ================== END PAGE LEVEL JS ================== -->
        <script>
            $(document).ready(function () {
                App.init();
                TableManageDefault.init();

                var table = $('#tabla_traslado').DataTable();

                table.order([0, 'asc']).draw();
            });
            
             $("#select_periodo").change(function () {
                var periodo = $("#select_periodo").val();
                console.log(periodo);
                window.location = "ver_traslados.php?periodo=" + periodo;
            });
        </script>
    </body>

    <!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:23:54 GMT -->
</html>

