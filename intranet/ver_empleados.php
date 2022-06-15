<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

require 'class/cl_empleado.php';
require 'class/cl_varios.php';
$cl_empleado = new cl_empleado();
$cl_varios = new cl_varios();
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="es" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
    <!--<![endif]-->

    <head>
        <meta charset="utf-8" />
        <title>Empleados | SEGEBUCO SAC</title>
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
                    <li><a href="javascript:;">Empleados</a></li>
                    <li class="active">Empleados</li>
                </ol>
                <!-- end breadcrumb -->
                <!-- begin page-header -->
                <h1 class="page-header">Empleados <small>matenimiento empleados</small></h1>
                <!-- end page-header -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-inverse">
                            <div class="panel-heading">
                                <a href="reg_empleado.php" class="btn btn-info btn-sm" >Agregar Empleado</a>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive123">
                                    <table id="tabla_empleados" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>DNI</th>
                                                <th>Apellidos y Nombres</th>
                                                <!--<th>Categoria</th>-->
                                                <th>Cargo</th>
                                                <th>Diario</th>
                                                <th>Fecha Nac.</th>
                                                <!--<th>Est. Civil</th>-->
                                                <!--<th>Estado</th>-->
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $a_empleados = $cl_empleado->v_tabla_empleados();
                                            foreach ($a_empleados as $value) {
                                                ?>
                                                <tr class="odd gradeX">
                                                    <td class="text-center"><?php echo $value['dni'] ?></td>
                                                    <td><?php echo $value['nombres'] ?></td>
                                                    <!--<td class="text-center"><?php echo $value['categoria'] ?></td>-->
                                                    <td class="text-center"><?php echo $value['cargo'] ?></td>
                                                    <td class="text-right"><?php echo $value['jornal_dia'] ?></td>
                                                    <td class="text-center"><?php echo $cl_varios->fecha_mysql_web($value['fecha_nacimiento']) ?></td>
                                                    <!--<td class="text-center"><?php echo $value['estado_civil'] ?></td>-->
                                                    <!--<td class="text-center"><span class="btn btn-success btn-sm">Activo</span></td>-->
                                                    <td class="text-center">
                                                        <a href="mod_empleado.php?codigo=<?php echo $value['id'] ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                                        <!--<a href="ver_entrega_epp.php?codigo=<?php echo $value['id'] ?>" alt="Entregar EPPs" class="btn btn-warning btn-sm"><i class="fa fa-shield"></i></a>-->
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
                //TableManageDefault.init();

                $('#tabla_empleados').DataTable({
                    responsive: true,
                    "order": [[ 1, "asc" ]],
                    "bProcessing": true,
                   // "bServerSide": true
                });

              /*  var table = $('#tabla_empleados').DataTable();
               / table.order([1, 'asc']).draw();*/
            });
        </script>
    </body>

    <!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:23:54 GMT -->
</html>

