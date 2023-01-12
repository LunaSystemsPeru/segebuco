<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

require 'class/cl_planilla.php';
require 'class/cl_detalle_planilla.php';
require 'class/cl_varios.php';
$cl_planilla = new cl_planilla();
$cl_varios = new cl_varios();
$cl_detalle = new cl_detalle_planilla();

if (filter_input(INPUT_GET, 'codigo') != '') {
    $cl_planilla->setCodigo(filter_input(INPUT_GET, 'codigo'));
    $a_datos = $cl_planilla->ver_datos_planilla();
    foreach ($a_datos as $value) {
        $cl_planilla->setSemana($value['semana']);
        $cl_planilla->setAnio($value['anio']);
        $cl_planilla->setCliente($value['nombre_comercial']);
        $cl_planilla->setSucursal($value['sucursal']);
        $cl_planilla->setInicio($value['fecha_inicio']);
        $cl_planilla->setFinal($value['fecha_fin']);
        $cl_planilla->setUsuario($value['nombres']);
    }
} else {
    header('Location: ver_planillas.php');
}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="es" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
    <!--<![endif]-->

    <head>
        <meta charset="utf-8" />
        <title>Detalle Planilla | SEGEBUCO SAC</title>
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
                    <li><a href="ver_planillas.php">Planilla</a></li>
                    <li class="active">Detalle Planilla</li>
                </ol>
                <!-- end breadcrumb -->
                <!-- begin page-header -->
                <h1 class="page-header">Detalle de Planilla <small>matenimiento planilla</small></h1>
                <!-- end page-header -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-inverse">
                            <div class="panel-heading">
                                <h4 class="panel-title">Datos Generales</h4>
                            </div>
                            <div class="panel-body">
                                <form class="form-horizontal" id="frm_detalle">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">CODIGO</label>
                                        <div class="col-md-8">
                                            <span class="form-control"><?php echo $cl_planilla->getCodigo() ?></span>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">CLIENTE</label>
                                        <div class="col-md-8">
                                            <span class="form-control" ><?php echo $cl_planilla->getCliente() ?></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">SUCURSAL</label>
                                        <div class="col-md-8">
                                            <span class="form-control" ><?php echo $cl_planilla->getSucursal() ?></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">FECHA INICIO</label>
                                        <div class="col-md-8">
                                            <span class="form-control" ><?php echo $cl_varios->fecha_mysql_web($cl_planilla->getInicio()) ?></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">FECHA FIN</label>
                                        <div class="col-md-8">
                                            <span class="form-control" ><?php echo $cl_varios->fecha_mysql_web($cl_planilla->getFinal()) ?></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">USUARIO</label>
                                        <div class="col-md-8">
                                            <span class="form-control" ><?php echo $cl_planilla->getUsuario() ?></span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-inverse">
                            <div class="panel-heading">
                                <a href="reg_empleado_planilla.php?planilla=<?php echo $cl_planilla->getCodigo() ?>" class="btn btn-info btn-sm" >Agregar Empleado</a>
                                <a href="ver_detalle_planilla_pago.php?codigo=<?php echo $cl_planilla->getCodigo() ?>" class="btn btn-success btn-sm" >Ver Pagos</a>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table id="tabla_colaboradores" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Id.</th>
                                                <th>DNI</th>
                                                <th>Apellidos y Nombres</th>
                                                <th>Cargo</th>
                                                <th>D.Tra.</th>
                                                <th>H. Ex. 25%</th>
                                                <th>H. Ex. 100%</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $cl_detalle->setPlanilla($cl_planilla->getCodigo());
                                            $a_colaborador = $cl_detalle->v_colaboradores();
                                            $contador = 1;
                                            foreach ($a_colaborador as $value) {
                                                ?>
                                                <tr class="odd gradeX">
                                                    <td class="text-center"><?php echo $contador; ?></td>
                                                    <td class="text-center"><?php echo $value['dni']; ?></td>
                                                    <td><?php echo $value['nombres']; ?></td>
                                                    <td class="text-center"><?php echo $value['cargo']; ?></td>
                                                    <td class="text-center"><?php echo $value['horas_normal'] / 8; ?></td>
                                                    <td class="text-center"><?php echo $value['horas_25']; ?></td>
                                                    <td class="text-center"><?php echo $value['horas_100']; ?></td>
                                                    <td class="text-center"><span class="btn btn-warning btn-sm">Pendiente</span></td>
                                                    <td class="text-center">
                                                        <a href="reg_empleado_planilla_real.php?codigo=201701&empleado=1" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                                        <a href="procesos/del_planilla_colaborador.php?planilla=<?php echo $cl_planilla->getCodigo() ?>&colaborador=<?php echo $value['colaborador']; ?>" class="btn btn-danger btn-sm"><i class="fa fa-close"></i></a>
                                                    </td>

                                                </tr>
                                                <?php
                                                $contador++;
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
                TableManageDefault.init();
            });
        </script>
    </body>

    <!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:23:54 GMT -->
</html>

