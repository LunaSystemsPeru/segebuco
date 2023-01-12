<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

require 'class/cl_centro_costo.php';
$cl_ccosto = new cl_centro_costo();
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="es" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
    <!--<![endif]-->

    <head>
        <meta charset="utf-8" />
        <title>Ver Centro de Costos | SEGEBUCO SAC</title>
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
                    <li><a href="javascript:;">Operaciones</a></li>
                    <li class="active">Centro de Costos</li>
                </ol>
                <!-- end breadcrumb -->
                <!-- begin page-header -->
                <h1 class="page-header">Centro de Costos <small>matenimiento operaciones</small></h1>
                <!-- end page-header -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-inverse">
<!--                            <div class="panel-heading">
                                <a href="reg_entidad.php" class="btn btn-info btn-sm" >Agregar Proveedor</a>
                            </div>-->
                            <div class="panel-body">
                                <table id="data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Codigo</th>
                                            <th>Descripcion</th>
                                            <th>S/ Presupuesto</th>
                                            <th>S/ en Caja</th>
                                            <th>S/ Gastos y Costos</th>
                                            <th>S/ Planilla</th>
                                            <th width="15%">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $a_centros = $cl_ccosto->ver_centros();
                                        $suma_planilla = 0;
                                        $suma_presupuesto = 0;
                                        $suma_gastos = 0;
                                        $suma_caja = 0;
                                        foreach ($a_centros as $value) {
                                            $gastos = $value['gastos_documentados'] + $value['gastos_simples'];
                                            $planilla = $value['planilla'];
                                            $presupuesto = $value['presupuesto'];
                                            $caja = $value['caja'];
                                            $suma_planilla = $suma_planilla + $value['planilla'];
                                            $suma_presupuesto = $suma_presupuesto + $value['presupuesto'];
                                            $suma_caja= $suma_caja + $value['caja'];
                                            $suma_gastos = $suma_gastos + $gastos;
                                            ?>
                                            <tr class="odd gradeX">
                                                <td class="text-center"><?php echo $value['codigo'] ?></td>
                                                <td><?php echo $value['descripcion'] ?></td>
                                                <td class="text-right"><?php echo number_format($presupuesto, 2) ?></td>
                                                <td class="text-right"><?php echo number_format($caja, 2) ?></td>
                                                <td class="text-right"><?php echo number_format($gastos, 2) ?></td>
                                                <td class="text-right"><?php echo number_format($planilla, 2) ?></td>
                                                <td class="text-center">
                                                    <!--<a href="#modal-modificar-centro" class="btn btn-info btn-sm" data-toggle="modal" onclick=""><i class="fa fa-edit"></i></a>-->
                                                    <a href="ver_detalle_centro.php?caja=<?php echo $value['codigo'] ?>" class="btn btn-danger btn-sm" ><i class="fa fa-desktop"></i></a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr class="odd gradeX">
                                            <td class="text-center" colspan="2"><b>SUMA TOTALES</b></td>
                                            <td class="text-right"><b><?php echo number_format($suma_presupuesto, 2) ?></b></td>
                                            <td class="text-right"><b><?php echo number_format($suma_caja, 2) ?></b></td>
                                            <td class="text-right"><b><?php echo number_format($suma_gastos, 2) ?></b></td>
                                            <td class="text-right"><b><?php echo number_format($suma_planilla, 2) ?></b></td>
                                            <td class="text-center">
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal modal-message fade" id="modal-modificar-entidad">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">Modificar Entidad - Proveedor</h4>
                            </div>
                            <form class="form-horizontal" id="frm_mod_entidad" method="POST" action="procesos/mod_entidad.php">
                                <div class="modal-body">
                                    <div id="resultado"></div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="input_ruc">RUC</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control text-center" id="input_ruc" name="input_ruc" readonly="true"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="input_razon">Razon Social</label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" id="input_razon" name="input_razon" required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="input_comercial">Nombre Comercial</label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" id="input_comercial" name="input_comercial" required/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="input_direcion" >Direccion fiscal</label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" id="input_direccion" name="input_direccion" readonly="true" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="input_condicion">Condicion</label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" id="input_condicion" name="input_condicion" readonly="true" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="input_estado">Estado</label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" id="input_estado" name="input_estado" readonly="true" />
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Cerrar</a>
                                    <input type="submit" class="btn btn-sm btn-success" name="button_submit" value="Guardar "/>
                                </div>
                            </form>
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
                var table = $('#data-table').DataTable();

                table.order([1, 'asc']).draw();
            });
        </script>
    </body>

    <!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:23:54 GMT -->
</html>

