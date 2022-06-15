<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

require 'class/cl_venta.php';
require 'class/cl_varios.php';
$cl_venta = new cl_venta();
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
        <title>Ventas | SEGEBUCO SAC</title>
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
                    <li><a href="javascript:;">Facturacion</a></li>
                    <li class="active">Ventas</li>
                </ol>
                <!-- end breadcrumb -->
                <!-- begin page-header -->
                <h1 class="page-header">Ventas <?php echo $periodo ?> <small>matenimiento ventas</small></h1>
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
                                        $cl_venta->setPeriodo(date('Y') . date('m'));
                                        $a_periodos = $cl_venta->ver_periodos();
                                        foreach ($a_periodos as $value) {
                                            ?>
                                            <option value="<?php echo $value['periodo'] ?>"><?php echo $value['periodo'] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <a href="reg_venta.php" class="btn btn-info btn-sm" >Agregar Documento</a>
                                <a href="#modal-agregar-anulado" class="btn btn-info btn-sm" data-toggle="modal">Agregar Documento Anulado</a>
                                <a href="reportes/txt_libro_ventas.php?input_periodo=<?php echo $periodo ?>" class="btn btn-info btn-sm" >Generar Libro de Ventas</a>

                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="table-responsive">
                                        <table id="data-table" class="table table-striped table-bordered" width="100%">
                                            <thead>
                                                <tr>
                                                    <!--<th>Codigo</th>-->
                                                    <th>Documento</th>
                                                    <th>Fecha</th>
                                                    <th>Orden</th>
                                                    <th>Razon Social</th>
                                                    <th>Moneda</th>
                                                    <th>Total</th>
                                                    <th>Total S/</th>
                                                    <th>Pagado</th>                                                    
                                                    <th>Estado</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $cl_venta->setPeriodo($periodo);
                                                //$cl_venta->setPeriodo(201703);
                                                $a_ventas = $cl_venta->ver_ventas();
                                                $suma_ventas = 0;
                                                $suma_total = 0;
                                                $suma_pagado = 0;
                                                foreach ($a_ventas as $value) {
                                                    $cl_venta->setEstado($value['estado']);
                                                    $cl_venta->setCodigo($cl_varios->zerofill($value['codigo'], 3));
                                                    $cl_venta->setSerie($cl_varios->zerofill($value['serie'], 3));
                                                    $cl_venta->setNumero($cl_varios->zerofill($value['numero'], 7));
                                                    $cl_venta->setTotal($value['total']);
                                                    $cl_venta->setTc($value['tipo_cambio']);
                                                    if ($value['tipo_documento'] == 14) {
                                                        $cl_venta->setTotal($cl_venta->getTotal() * -1);
                                                    }
                                                    $total_soles = $cl_venta->getTotal() * $cl_venta->getTc();
                                                    $suma_ventas = $suma_ventas + $cl_venta->getTotal();
                                                    $suma_total = $suma_total + $total_soles;
                                                    $suma_pagado = $suma_pagado + $value['pagado'];
                                                    if ($cl_venta->getEstado() == 0) {
                                                        $activo = true;
                                                        $cl_venta->setCliente($value['cliente'] . ' | ' . $value['sucursal']);
                                                        $cl_venta->setEstado('<span class="btn btn-warning btn-sm">Pendiente</span>');
                                                        $btn_borrar = '<button class="btn btn-danger btn-sm" onclick="eliminar_venta('.$value['periodo'] . $value['codigo'].')" title="Eliminar Documento"><i class="fa fa-trash"></i></button>';
                                                    }
                                                    if ($cl_venta->getEstado() == 1) {
                                                        $activo = true;
                                                        $cl_venta->setCliente($value['cliente'] . ' | ' . $value['sucursal']);
                                                        $cl_venta->setEstado('<span class="btn btn-success btn-sm">Pagado</span>');
                                                        $btn_anular = '';
                                                        $btn_borrar = '';
                                                    }
                                                    if ($cl_venta->getEstado() == 2) {
                                                        $activo = false;
                                                        $cl_venta->setCliente('****  ANULADO  ****');
                                                        $cl_venta->setEstado('<span class="btn btn-danger btn-sm">Anulado</span>');
                                                        $btn_anular = '';
                                                        $btn_borrar = '';
                                                    }
                                                    ?>
                                                    <tr class="odd gradeX">
                                                        <!--<td class="text-center"><?php echo $value['periodo'] . $cl_venta->getCodigo() ?></td></td>-->
                                                        <td class="text-center"><?php echo $value['tido'] . '/ ' . $cl_venta->getSerie() . '-' . $cl_venta->getNumero() ?></td>                                                        
                                                        <td class="text-center"><?php echo $value['fecha_factura'] ?></td>
                                                        <td class="text-center"><?php echo $value['orden_cliente'] ?></td>
                                                        <td><?php echo $cl_venta->getCliente() ?></td>
                                                        <td class="text-right"><?php echo $value['moneda'] ?></td>
                                                        <td class="text-right"><?php echo number_format($cl_venta->getTotal(), 2, '.', ','); ?></td>
                                                        <td class="text-right"><?php echo number_format($total_soles, 2, '.', ','); ?></td>
                                                        <td class="text-right"><?php echo number_format($value['pagado'], 2, '.', ','); ?></td>
                                                        <td class="text-center"><?php echo $cl_venta->getEstado() ?></td>
                                                        <td class="text-center">
                                                            <?php if ($activo == true) { ?>
                                                                <a href="ver_detalle_venta.php?periodo=<?php echo $cl_venta->getPeriodo() ?>&codigo=<?php echo $value['codigo']; ?>" class="btn btn-primary btn-sm" title="Ver detalle" alt="ver detalle"><i class="fa fa-navicon"></i></a>
                                                                <a href="ver_pagos_venta.php?periodo=<?php echo $cl_venta->getPeriodo() ?>&codigo=<?php echo $value['codigo']; ?>" class="btn btn-success btn-sm" title="Ver pagos" alt="ver pagos"><i class="fa fa-dollar"></i></a>
                                                            <?php } ?>
                                                            <?php echo $btn_borrar ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            <tfoot>
                                            <td class="text-right" colspan="5">TOTAL</td>
                                            <td class="text-right"><?php echo number_format($suma_ventas, 2, '.', ',') ?></td>
                                            <td class="text-right"><?php echo number_format($suma_total, 2, '.', ',') ?></td>
                                            <td class="text-right"><?php echo number_format($suma_pagado, 2, '.', ',') ?></td>
                                            <td class="text-center"></td>
                                            <td class="text-center"></td>
                                            </tfoot>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modal-agregar-anulado">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title">Agregar Documentos Anulados</h4>
                                </div>
                                <form class="form-horizontal" id="frm_reg_venta_anulada" method="POST" action="procesos/reg_venta.php">
                                    <div class="modal-body">

                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Periodo</label>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control text-center" maxlength="6" name="input_periodo" id="input_periodo" value="<?php echo $periodo //date('Y') . date('m')  ?>" required="true"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Tipo Documento</label>
                                            <div class="col-md-3">
                                                <select class="form-control" name="select_documento" id="select_documento">
                                                    <option value="4">FACTURA</option>
                                                </select>
                                            </div>
                                            <label class="col-md-2 control-label">Fecha</label>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control" name="input_fecha" id="input_fecha" value="<?php echo date('d/m/Y') ?>" required />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Serie</label>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control text-center" name="input_serie" id="input_serie" maxlength="3" value="1" required />
                                            </div>
                                            <label class="col-md-2 control-label">Numero</label>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control  text-center" name="input_numero" id="input_numero" maxlength="7"  required />
                                            </div>
                                        </div>
                                        <input type="hidden" name="hidden_estado" value="2" />
                                        <input type="hidden" name="input_glosa" value="**** ANULADO ****" />
                                        <input type="hidden" name="select_moneda" value="1" />
                                        <input type="hidden" name="input_tc" value="1.00" />
                                        <input type="hidden" name="select_orden" value="-" />
                                        <input type="hidden" name="select_cliente" value="1" />
                                        <input type="hidden" name="select_sucursal" value="1" />
                                        <input type="hidden" name="input_porcentaje" value="0" />
                                        <input type="hidden" name="hidden_total" value="0" />

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
        <script src="assets/js/table-manage-responsive.demo.min.js"></script>
        <script src="assets/js/apps.min.js"></script>
        <!-- ================== END PAGE LEVEL JS ================== -->
        <script>
            $(document).ready(function () {
                App.init();
                TableManageResponsive.init();
                var table = $('#data-table').DataTable();

                table.order([0, 'desc']).draw();
            });

            $("#select_periodo").change(function () {
                var periodo = $("#select_periodo").val();
                console.log(periodo);
                window.location = "ver_ventas.php?periodo=" + periodo;
            });
        </script>
        <script language="JavaScript">
            function eliminar_venta(id) {
                if (!confirm("¿Está seguro de que desea eliminar el documento?")) {
                    return false;
                } else {
                    window.location = "procesos/del_venta.php?accion=eliminar&codigo=" + id;
                    return true;
                }
            }
        </script> 
    </body>

    <!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:23:54 GMT -->
</html>

