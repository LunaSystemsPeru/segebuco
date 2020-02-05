<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

require 'class/cl_varios.php';
require 'class/cl_compra.php';
$cl_compra = new cl_compra();
$cl_varios = new cl_varios();

if (filter_input(INPUT_GET, 'periodo') != '') {
    $periodo = filter_input(INPUT_GET, 'periodo');
} else {
    $periodo = date('Y') . date('m');
}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="es" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
    <!--<![endif]-->

    <head>
        <meta charset="utf-8" />
        <title>Compras | SEGEBUCO SAC</title>
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
                    <li><a href="javascript:;">Pagos</a></li>
                    <li class="active">Compras</li>
                </ol>
                <!-- end breadcrumb -->
                <!-- begin page-header -->
                <h1 class="page-header">Compras <?php echo $periodo ?> <small>matenimiento facturacion</small></h1>
                <!-- end page-header -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-inverse">
                            <div class="panel-heading">
                                <div class="panel-heading-btn">
                                    <select class="form-control" id="select_periodo" name="select_periodo">
                                        <option value="-" >Seleccionar Periodo</option>
                                        <option value="<?php echo date('Y') . date('m') ?>"><?php echo date('Y') . date('m') ?></option>
                                        <?php
                                        $cl_compra->setPeriodo(date('Y') . date('m'));
                                        $a_periodos = $cl_compra->ver_periodos();
                                        foreach ($a_periodos as $value) {
                                            ?>
                                            <option value="<?php echo $value['periodo'] ?>"><?php echo $value['periodo'] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <a href="reg_compra.php" class="btn btn-info btn-sm" >Agregar Documento</a>
                                <a href="ver_compras_semana.php" class="btn btn-info btn-sm" >Ver Compras x Semana</a>
                                <a href="reportes/txt_libro_compras.php?input_periodo=<?php echo $periodo ?>" class="btn btn-info btn-sm" >Generar Libro de Compras</a>

                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="table-responsive">
                                        <table id="data-table" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Codigo.</th>
                                                    <th>Fecha</th>
                                                    <th>Documento</th>
                                                    <th>Razon Social</th>
                                                    <th>Moneda</th>
                                                    <th>Total</th>
                                                    <th>Total S/</th>
                                                    <th>Estado</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $cl_compra->setPeriodo($periodo);
                                                //$cl_venta->setPeriodo(201703);
                                                $a_compras = $cl_compra->ver_compras();
                                                $suma_total = 0;
                                                foreach ($a_compras as $value) {

                                                    $cl_compra->setCodigo($cl_varios->zerofill($value['codigo'], 3));
                                                    $cl_compra->setSerie($cl_varios->zerofill($value['serie'], 3));
                                                    $cl_compra->setNumero($cl_varios->zerofill($value['numero'], 7));
                                                    $cl_compra->setTotal($value['total']);
                                                    $cl_compra->setTc($value['tipo_cambio']);
                                                    $cl_compra->setProveedor($value['ruc_proveedor'] . ' - ' . $value['proveedor']);
                                                    $cl_compra->setEstado($value['estado']);
                                                    $total_soles = $cl_compra->getTotal() * $cl_compra->getTc();
                                                    $suma_total = $suma_total + $total_soles;
                                                    //$cl_varios->fecha_mysql_web($value['fecha_compra'])
                                                    if ($cl_compra->getEstado() == 0) {
                                                        $cl_compra->setEstado('<span class="btn btn-warning btn-sm">Pendiente</span>');
                                                    }
                                                    if ($cl_compra->getEstado() == 1) {
                                                        $cl_compra->setEstado('<span class="btn btn-success btn-sm">Pagado</span>');
                                                    }
                                                    ?>
                                                    <tr class="odd gradeX">
                                                        <td class="text-center"><?php echo $value['periodo'] . $cl_compra->getCodigo() ?></td>
                                                        <td class="text-center"><?php echo $value['fecha_compra'] ?></td>
                                                        <td class="text-center"><?php echo $value['tido'] . '/ ' . strtoupper($cl_compra->getSerie()) . '-' . $cl_compra->getNumero() ?></td>
                                                        <td><?php echo $cl_compra->getProveedor() ?></td>
                                                        <td class="text-right"><?php echo $value['moneda'] ?></td>
                                                        <td class="text-right"><?php echo number_format($cl_compra->getTotal(), 2, '.', ','); ?></td>
                                                        <td class="text-right"><?php echo number_format($total_soles, 2, '.', ','); ?></td>
                                                        <td class="text-center"><?php echo $cl_compra->getEstado() ?></td>
                                                        <td class="text-center">
                                                            <a href="ver_detalle_compra.php?codigo=<?php echo $value['codigo']?>" class="btn btn-primary btn-sm"><i class="fa fa-navicon"></i></a>
                                                            <button type=button onclick="eliminar('<?php echo $value['periodo'] ?>', '<?php echo $value['codigo'] ?>')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            <tfoot>
                                            <td class="text-right" colspan="6">TOTAL</td>
                                            <td class="text-right"><?php echo number_format($suma_total, 2, '.', ',') ?></td>
                                            <td class="text-center"></td>
                                            </tfoot>
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

                $('#data-table').DataTable({
                    responsive: true,
                    "order": [[ 1, "asc" ]],
                    "bProcessing": true,
                    // "bServerSide": true
                });

            });

            $("#select_periodo").change(function () {
                var periodo = $("#select_periodo").val();
                console.log(periodo);
                window.location = "ver_compras.php?periodo=" + periodo;
            });
            
            function eliminar(periodo, codigo) {
                if (!confirm("¿Está seguro de que desea eliminar el Documento Seleccionado?")) {
                    return false;
                }
                else {
                    document.location = "procesos/del_compra.php?periodo=" + periodo + "&codigo=" + codigo;
                    return true;
                }
            }
        </script>
    </body>

    <!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:23:54 GMT -->
</html>

