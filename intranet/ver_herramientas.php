<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

require 'class/cl_herramientas.php';
require 'class/cl_varios.php';
$cl_herramientas = new cl_herramientas();
$cl_varios = new cl_varios();
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="es" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
    <!--<![endif]-->

    <head>
        <meta charset="utf-8" />
        <title>Ver Herramientas | SEGEBUCO SAC</title>
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
                    <li class="active">Herramientas</li>
                </ol>
                <!-- end breadcrumb -->
                <!-- begin page-header -->
                <h1 class="page-header">Herramientas y Maquinas <small>matenimiento herramientas</small></h1>
                <!-- end page-header -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-inverse">
                            <div class="panel-heading">
                                <a href="reg_herramienta.php" class="btn btn-info btn-sm" >Registrar Herramienta</a>
                            </div>
                            <div class="panel-body">
                                <table id="tabla_empleados" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Id.</th>
                                            <th>Descripcion</th>
                                            <th>Tipo</th>
                                            <!--<th>Precio</th>-->
                                            <th>Cant.</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $a_herramientas = $cl_herramientas->ver_herramientas();
                                        foreach ($a_herramientas as $value) {
                                            $tipo = $value['tipo'];
                                            if ($tipo == 0) {
                                                $nombre_tipo = "X SERIE";
                                            }
                                            if ($tipo == 1) {
                                                $nombre_tipo = "AGRUPADO";
                                            }

                                            $estado = $value['estado'];
                                            if ($estado == 0) {
                                                $vestado = '<span class="btn btn-warning btn-sm">sin uso</span>';
                                            }
                                            if ($estado == 1) {
                                                $vestado = '<span class="btn btn-success btn-sm">Activo</span>';
                                            }
                                            ?>
                                            <tr class="odd gradeX">
                                                <td class="text-center"><?php echo $cl_varios->zerofill($value['idherramientas'], 5) ?></td>
                                                <td><?php echo $value['descripcion'] ?></td>
                                                <td class="text-center"><?php echo $nombre_tipo ?></td>
                                                <!--<td class="text-right"><?php echo number_format($value['precio'], 2, '.', ',') ?></td>-->
                                                <td class="text-center"><?php echo $value['ctotal'] == 0 ? '-' : $value['ctotal'] ?></td>
                                                <td class="text-center"><?php echo $vestado ?></td>
                                                <td class="text-center">
                                                    <a href="mod_herramientas.php?codigo=<?php echo $value['idherramientas']?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> E</a>
                                                    <a onclick="mostrarUbicacion(<?php echo $value['idherramientas']?>)" href="#modal-ubicar" data-toggle="modal" class="btn btn-warning btn-sm"><i class="fa fa-location-arrow"></i> U</a>
                                                    <a href="ver_kardex_herramientas.php?herramienta=<?php echo $value['idherramientas']?>" class="btn btn-primary btn-sm"><i class="fa fa-bars"></i> K</a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>



                                <div class="modal fade" id="modal-ubicar">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title">Ubicar Herramientas</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div id='contenido_ubicaciones'></div>
                                            </div>
                                            <div class="modal-footer">
                                                <button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button>
                                            </div>
                                        </div>
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
                $('#tabla_empleados').DataTable({
                    responsive: true
                });
                var table = $('#tabla_empleados').DataTable();

                table.order([1, 'asc']).draw();
            });
        </script>
        
        <script>
        function mostrarUbicacion(herramienta) {
                var parametros = {
                    "id_herramienta": herramienta
                };
                $.ajax({
                    data: parametros,
                    url: 'modal_php/m_ubicar_herramienta.php',
                    type: 'post',
                    beforeSend: function () {
                        $("#contenido_ubicaciones").html("Procesando, espere por favor...");
                    },
                    success: function (response) {
                        $("#contenido_ubicaciones").html(response);
                    }
                });
            }
        </script>
    </body>

    <!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:23:54 GMT -->
</html>

