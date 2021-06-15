<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

require 'class/cl_varios.php';
require 'class/cl_orden_cliente.php';
require 'class/cl_proyectos.php';
require 'class/cl_centro_costo.php';
require 'class/cl_venta.php';

$cl_varios = new cl_varios();
$cl_orden = new cl_orden_cliente();
$cl_proyecto = new cl_proyectos();
$cl_venta = new cl_venta();
$cl_ccosto = new cl_centro_costo();

$s_gastos = 0;
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="es" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
    <!--<![endif]-->

    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        
        <title>Ver Ordenes x Obras | SEGEBUCO SAC</title>
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
                    <li><a href="javascript:;">Obras</a></li>
                    <li class="active">Ordenes</li>
                </ol>
                <!-- end breadcrumb -->
                <!-- begin page-header -->
                <h1 class="page-header">Ordenes <small>matenimiento obras</small></h1>
                <!-- end page-header -->

                <div class="row">

                    <div class="col-md-12">
                        <div class="panel panel-inverse">
                            <div class="panel-heading">
                                <div class="panel-heading-btn">
                                    <select class="form-control" id="select_estado" name="select_estado">
                                        <option value="-" >Seleccionar Estado</option>
                                        <option value="0">PENDIENTE</option>
                                        <option value="2">TODOS</option>
                                    </select>
                                </div>
                                <div class="panel-heading-btn">
                                    <select class="form-control" id="select_anio" name="select_anio">
                                        <option value="-" >Seleccionar Año</option>
                                        <option value="<?php echo date('Y') ?>"><?php echo date('Y') ?></option>
                                        <?php
                                        $cl_orden->setAnio(date('Y'));
                                        $a_anio = $cl_orden->ver_anios_ordenes();
                                        foreach ($a_anio as $value) {
                                            ?>
                                            <option value="<?php echo $value['anio'] ?>"><?php echo $value['anio'] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <a href="reg_orden_cliente.php" class="btn btn-info btn-sm" >Agregar Orden</a>
                            </div>
                            <div class="panel-body">
                                <table id="tabla_ordenes" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Id.</th>
                                            <th>Descripcion</th>
                                            <th>Cliente.</th>
                                            <th>Emision</th>
                                            <th>Total</th>
                                            <th>Facturado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (filter_input(INPUT_GET, 'estado') == '') {
                                            $cl_orden->setEstado(0);
                                            //$cl_entrega->setEstado(filter_input(INPUT_GET, 'estado'));
                                        } 
                                        if (filter_input(INPUT_GET, 'estado') == '2') {
                                            $cl_orden->setEstado("");
                                        }
                                        if (filter_input(INPUT_GET, 'estado') == '1') {
                                            $cl_orden->setEstado(1);
                                        }
                                        if (filter_input(INPUT_GET, 'estado') == '0') {
                                            $cl_orden->setEstado(0);
                                        }
                                        
                                        $cl_orden->setAnio(date('Y'));
                                        $a_ordenes = $cl_orden->ver_total_ordenes();
                                        $suma_total = 0;
                                        $facturado = 0;
                                        foreach ($a_ordenes as $value) {
                                            $idorden = $value['ocliente'] . $value['osucursal'] . $value['codigo'];
                                            $facturado = $facturado + ($value['facturado'] * $value['total'] / 100);
                                            $suma_total = $suma_total + $value['total'];
                                            if ($value['estado'] == 1) {
                                                $estado = '<span class="btn btn-success btn-sm">' . number_format($value['facturado']) . '%</span>';
                                            } else {
                                                $estado = '<span class="btn btn-danger btn-sm">' . number_format($value['facturado']) . '%</span>';
                                            }
                                            ?>
                                            <tr class="odd gradeX">
                                                <td class="text-center">
                                                    <a href="upload/<?php echo $value['ocliente'] . "/" . $value['osucursal'] ?>/orden_cliente/<?php echo $value['archivo'] ?>" target="_blank">
                                                        <?php echo $value['codigo'] ?>
                                                    </a>
                                                </td>
                                                <td ><?php echo $value['glosa'] ?></td>
                                                <td ><?php echo $value['cliente'] ?></td>                                                
                                                <td class="text-center"><?php echo $value['fecha'] ?></td>
                                                <td class="text-right"><?php echo $value['moneda'] . ' ' . number_format($value['total'], 2, '.', ',') ?></td>
                                                <td class="text-center"><?php echo $estado ?></td>
                                                <td class="text-center">
                                                    <button class="btn btn-info btn-sm" onclick="ver_facturas('<?php echo $value['ocliente'] ?>', '<?php echo $value['osucursal'] ?>', '<?php echo $value['codigo'] ?>')" data-toggle="modal" data-target="#modal_facturas" title="Ver Facturas" alt="Ver Facturas"><i class="fa fa-dollar"></i></button>
                                                    <?php if ($value['facturado'] == 0) { ?>
                                                    <button class="btn btn-danger btn-sm" onclick="eliminar_orden('<?php echo $idorden?>')" title="Eliminar Documento">
                                                        <i class="fa fa-trash"> </i>
                                                    </button>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        if ($suma_total > 0) {
                                            $porcentaje = $facturado / $suma_total * 100;
                                        } else {
                                            $porcentaje = 0;
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr class="odd gradeX">
                                            <td class="text-center" colspan="4">TOTAL</td>
                                            <td class="text-right"><?php echo number_format($suma_total, 2, '.', ',') ?></td>
                                            <td class="text-center"><?php echo number_format($porcentaje, 2, '.', ',') ?> %</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- end #content -->
            
            <div class="modal fade" id="modal_facturas">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title">Ver Facturas</h4>
                        </div>
                        <div class="modal-body">
                            <div id='contenido_facturas'></div>
                        </div>
                        <div class="modal-footer">
                            <button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

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

                $('#tabla_ordenes').DataTable({
                    responsive: true
                });

                var table = $('#tabla_ordenes').DataTable();

                table.order([3, 'desc']).draw();
            });
            
            $("#select_estado").change(function () {
                var estado = $("#select_estado").val();
                console.log(estado);
                window.location = "ver_ordenes.php?estado=" + estado;
            });
            
        </script>
        
        <script>
        function ver_facturas(cliente, sucursal, orden) {
                var parametros = {
                    "cliente": cliente,
                    "sucursal": sucursal,
                    "orden": orden
                };
                $.ajax({
                    data: parametros,
                    url: 'modal_php/m_facturas_ordenes.php',
                    type: 'post',
                    beforeSend: function () {
                        $("#contenido_facturas").html("Procesando, espere por favor...");
                    },
                    success: function (response) {
                        $("#contenido_facturas").html(response);
                    }
                });
            }
        </script>
        <script language="JavaScript">
            function eliminar_orden(id) {
                if (!confirm("¿Está seguro de que desea eliminar el documento?")) {
                    return false;
                } else {
                    window.location = "procesos/del_orden.php?codigo=" + id;
                    return true;
                }
            }
        </script> 
    </body>

    <!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:23:54 GMT -->
</html>

