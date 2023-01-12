<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

require 'class/cl_varios.php';
require 'class/cl_orden_compra.php';
$cl_ocompra = new cl_orden_compra();
$cl_varios = new cl_varios();

if (filter_input(INPUT_GET, 'periodo') != '') {
    $periodo = filter_input(INPUT_GET, 'periodo');
} else {
    $periodo = date('Y') . date('m');
}
?>
<!DOCTYPE html>
<!--[if IE 8]>
<html lang="es" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
<!--<![endif]-->

<head>
    <meta charset="utf-8"/>
    <title>Orden de Compra | SEGEBUCO SAC</title>
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

    <!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
    <link href="assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet"/>
    <link href="assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet"/>
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
            <li><a href="javascript:;">Pagos</a></li>
            <li class="active">Compras</li>
        </ol>
        <!-- end breadcrumb -->
        <!-- begin page-header -->
        <h1 class="page-header">Ordenes de Compras <?php echo $periodo ?>
            <small>matenimiento facturacion</small>
        </h1>
        <!-- end page-header -->

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <select class="form-control" id="select_periodo" name="select_periodo">
                                <option value="-">Seleccionar Año</option>
                                <?php
                                $a_periodos = $cl_ocompra->ver_periodos();
                                foreach ($a_periodos as $value) {
                                    ?>
                                    <option value="<?php echo $value['anio'] ?>"><?php echo $value['anio'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <a href="reg_orden_compra.php" class="btn btn-info btn-sm">Agregar Documento</a>

                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table id="data-table" class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Codigo.</th>
                                        <th>Fecha</th>
                                        <th>Razon Social</th>
                                        <th>Moneda</th>
                                        <th>Total</th>
                                        <th>Facturado %</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $a_ordenes = $cl_ocompra->ver_ordenes();
                                    foreach ($a_ordenes as $fila) {
                                        $codigo_completo = $fila['anio'] . $cl_varios->zerofill($fila['id'], 3);
                                        $facturado = $fila['facturado'];
                                        if ($facturado == 0) {
                                            $l_facturado = '<span class="btn btn-danger btn-xs">0 %</span>';
                                        }
                                        ?>
                                        <tr class="odd gradeX">
                                            <td class="text-center"><?php echo $codigo_completo?></td>
                                            <td class="text-center"><?php echo $fila['fecha']?></td>
                                            <td><?php echo $fila['proveedor'] . ' | ' . $fila['razon_social']?></td>
                                            <td class="text-right"><?php echo $fila['nmoneda']?></td>
                                            <td class="text-right"><?php echo number_format($fila['monto'], 2, '.', ',')?></td>
                                            <td class="text-center"><?php echo $l_facturado?></td>
                                            <td class="text-center">
                                                <a href="ver_detalle_compra.php?codigo=10469932091"
                                                   class="btn btn-primary btn-sm"><i class="fa fa-navicon"></i></a>
                                                <?php if ($facturado > 0) { ?>
                                                    <a href="ver_detalle_compra.php?codigo=10469932091" class="btn btn-success btn-sm"><i class="fa fa-dollar"></i></a>
                                                <?php } ?>
                                                <?php if ($facturado == 0) { ?>
                                                <a href="ver_detalle_compra.php?codigo=10469932091"
                                                   class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                                <?php } ?>
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


    </div>
    <!-- end #content -->

    <!-- begin scroll to top btn -->
    <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i
                class="fa fa-angle-up"></i></a>
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

        table.order([1, 'desc']).draw();
    });

    $("#select_periodo").change(function () {
        var periodo = $("#select_periodo").val();
        console.log(periodo);
        window.location = "ver_compras.php?periodo=" + periodo;
    });
</script>
</body>

<!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:23:54 GMT -->
</html>

