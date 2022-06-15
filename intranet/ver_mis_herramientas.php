<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

require 'class/cl_herramientas_almacen.php';
require 'class/cl_almacen.php';
require 'class/cl_varios.php';

$cl_mi_herramienta = new cl_herramientas_almacen();
$cl_mialmacen = new cl_almacen();
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

            <?php
            if (filter_input(INPUT_GET, 'almacen') != '') {
                $cl_mi_herramienta->setAlmacen(filter_input(INPUT_GET, 'almacen'));
            } else {
                $cl_mi_herramienta->setAlmacen($_SESSION['almacen']);
            }

            $cl_mialmacen->setCodigo($cl_mi_herramienta->getAlmacen());
            $cl_mialmacen->datos_almacen();
            ?>
            <!-- begin #sidebar -->
            <?php include 'includes/sidebar.php'; ?>
            <!-- end #sidebar -->

            <!-- begin #content -->
            <div id="content" class="content">
                <!-- begin breadcrumb -->
                <ol class="breadcrumb pull-right">
                    <li><a href="javascript:;">Inicio</a></li>
                    <li><a href="javascript:;">Almacenes</a></li>
                    <li class="active">Mis Herramientas</li>
                </ol>
                <!-- end breadcrumb -->
                <!-- begin page-header -->
                <h1 class="page-header">Mis Herramientas en <?php echo $cl_mialmacen->getNombre() ?><small> matenimiento almacenes</small></h1>
                <!-- end page-header -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-inverse">
                            <div class="panel-heading">
                                <div class="panel-heading-btn">
                                    <select class="form-control" id="select_almacen" name="select_almacen">
                                        <option>Seleccionar Almacen</option>
                                        <?php
                                        $a_almacen = $cl_mialmacen->ver_almacenes();
                                        foreach ($a_almacen as $value) {
                                            ?>
                                            <option value="<?php echo $value['codigo'] ?>"><?php echo $value['nombre'] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <a href="reg_ingreso.php" class="btn btn-info btn-sm" >Nuevo Ingreso</a>
                            </div>
                            <div class="panel-body">
                                <table id="data-table" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Id.</th>
                                            <th width = "40%">Descripcion</th>
                                            <th>Tipo</th>
                                            <th>C. Total</th>
                                            <th>C. Actual</th>
                                            <th>Und. Med.</th>
                                            <!--<th>Estado</th>-->
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $a_mis_materiales = $cl_mi_herramienta->ver_herramientas();
                                        foreach ($a_mis_materiales as $value) {
                                            $tipo = $value['tipo'];
                                            if ($tipo == 0) {
                                                $nombre_tipo = "ELECTRICA";
                                            }
                                            if ($tipo == 1) {
                                                $nombre_tipo = "MANUAL";
                                            }
                                            $url_kardex = 'ver_kardex_mis_herramientas.php?herramienta=' . $value['herramienta'] . '&almacen=' . $cl_mialmacen->getCodigo();
                                            ?>
                                            <tr class="odd gradeX">
                                                <td class="text-center"><?php echo $cl_varios->zerofill($value['herramienta'], 5); ?></td>
                                                <td><?php echo $value['descripcion'] ?></td>
                                                <td class="text-center"><?php echo $nombre_tipo ?></td>
                                                <td class="text-right"><?php echo number_format($value['ctotal'], 2) ?></td>
                                                <td class="text-right"><?php echo number_format($value['cactual'], 2) ?></td>
                                                <td class="text-center">Und.</td>
                                                <!--<td class="text-center"><span class="btn btn-success btn-sm">Activo</span></td>-->
                                                <td class="text-center">
                                                    <a href="<?php echo $url_kardex ?>" class="btn btn-success btn-sm"><i class="fa fa-exchange"></i> K</a>
                                                    <button type="button" class="btn btn-warning btn-sm" onclick="cargar_herramienta('<?php echo $value['herramienta'] ?>')" title="Retirar Herramienta"><i class="fa fa-download"></i> M</button>
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

                    <!--Default Bootstrap Modal-->
                    <!--===================================================-->
                    <div class="modal modal fade" id="m_merma" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content" id="contenido_merma">

                            </div>
                        </div>
                    </div>
                    <!--===================================================-->
                    <!--End Default Bootstrap Modal-->
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

                                                            var table = $('#data-table').DataTable();

                                                            table.order([1, 'asc']).draw();
                                                        });

                                                        $("#select_almacen").change(function () {
                                                            var almacen = $("#select_almacen").val();
                                                            //console.log(periodo);
                                                            window.location = "ver_mis_herramientas.php?almacen=" + almacen;
                                                        });
        </script>
        <script>
            function cargar_herramienta(id_herramienta) {
                var parametros = {
                    "id_herramienta": id_herramienta,
                    "id_almacen" : <?php echo $cl_mialmacen->getCodigo()?>
                };
                $.ajax({
                    data: parametros,
                    url: 'modal_php/m_merma.php',
                    type: 'post',
                    beforeSend: function () {
                        $("#contenido_merma").html("Procesando, espere por favor...");
                    },
                    success: function (response) {
                        $('#m_merma').modal('toggle');
                        $("#contenido_merma").html(response);
                    }
                });
            }
        </script>
    </body>

    <!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:23:54 GMT -->
</html>

