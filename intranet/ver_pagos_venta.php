<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

require 'class/cl_venta.php';
require 'class/cl_entidad.php';
require 'class/cl_cliente.php';
require 'class/cl_varios.php';
require 'class/cl_banco.php';
require 'class/cl_detalle_tabla_general.php';
require 'class/cl_cobro_venta.php';
$cl_detalle = new cl_detalle_tabla_general();
$cl_venta = new cl_venta();
$cl_varios = new cl_varios();
$cl_cliente = new cl_cliente();
$cl_entidad = new cl_entidad();
$cl_banco = new cl_banco();
$cl_cobro = new cl_cobro_venta();

if (filter_input(INPUT_GET, 'codigo') != '') {
    $cl_venta->setCodigo(filter_input(INPUT_GET, 'codigo'));
    $cl_venta->setPeriodo(filter_input(INPUT_GET, 'periodo'));
    $cl_cobro->setVenta($cl_venta->getCodigo());
    $cl_cobro->setPeriodo($cl_venta->getPeriodo());
    $cl_venta->datos_venta();
    $cl_cliente->setCodigo($cl_venta->getCliente());
    $a_clientes = $cl_cliente->datos_cliente();
    foreach ($a_clientes as $value) {
        $cl_entidad->setRuc($value['ruc']);
        $cl_entidad->setRazon_social($value['razon_social']);
        $cl_entidad->setDireccion($value['direccion']);
    }
} else {
    header('Location: ver_ventas.php');
}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="es" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
    <!--<![endif]-->

    <head>
        <meta charset="utf-8" />
        <title>Detalle de Cobros de Facturas | SEGEBUCO SAC</title>
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
                    <li><a href="ver_ventas.php">Ventas</a></li>
                    <li class="active">Detalle Cobros</li>
                </ol>
                <!-- end breadcrumb -->
                <!-- begin page-header -->
                <h1 class="page-header"><a href="ver_ventas.php?periodo=<?php echo $cl_venta->getPeriodo()?>">Ver Ventas </a> - Detalle de cobros <small>matenimiento ventas</small></h1>
                <!-- end page-header -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-inverse">
                            <div class="panel-heading">
                                <h4 class="panel-title">Datos Documento</h4>
                            </div>
                            <div class="panel-body">
                                <form class="form-horizontal" id="frm_detalle">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Cliente</label>
                                        <div class="col-md-6">
                                            <span class="form-control"><?php echo $cl_entidad->getRazon_social() ?></span>
                                        </div>
                                        <div class="col-md-3">
                                            <span class="form-control text-center"><?php echo $cl_entidad->getRuc() ?></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Documento</label>
                                        <div class="col-md-4">
                                            <span class="form-control"><?php echo $cl_venta->getTido() . ' | ' . $cl_varios->zerofill($cl_venta->getSerie(), 3) . ' - ' . $cl_varios->zerofill($cl_venta->getNumero(), 7); ?></span>
                                        </div>
                                        <label class="col-md-2 control-label">Fecha</label>
                                        <div class="col-md-3">
                                            <span class="form-control text-center"><?php echo $cl_venta->getFecha_factura() ?></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Monto</label>
                                        <div class="col-md-2">
                                            <span class="form-control text-right"><?php echo number_format($cl_venta->getTotal(), 2)?></span>
                                        </div>
                                        <div class="col-md-2">
                                            <span class="form-control text-center"><?php echo $cl_venta->getMoneda()?></span>
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
                                <a href="#modal-agregar-pago" class="btn btn-success btn-sm" data-toggle="modal"><i class="fa fa-dollar"></i> Agregar Pago</a>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive11">
                                    <table id="data-table" class="table table-striped table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Fecha</th>
                                                <th>Banco</th>
                                                <th>Moneda</th>
                                                <th>Tipo Cambio</th>
                                                <th>Monto</th>
                                                <th>Monto ME</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $a_cobros = $cl_cobro->ver_cobros();
                                            $suma_cobro = 0;
                                            foreach ($a_cobros as $value) {
                                                $monto_ex = $value['monto'] / $value['tc'];
                                                $suma_cobro = $suma_cobro + $monto_ex;
                                                if ($value['moneda'] == 1) {
                                                    $moneda = 'S/ ';
                                                } else {
                                                    $moneda = 'US$';
                                                }
                                                ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $value['codigo']?></td>
                                                    <td class="text-center"><?php echo $value['fecha']?></td>
                                                    <td><?php echo $value['nbanco']?></td>
                                                    <td class="text-center"><?php echo $moneda ?></td>
                                                    <td class="text-right"><?php echo $value['tc']?></td>
                                                    <td class="text-right"><?php echo number_format($value['monto'], 2)?></td>
                                                    <td class="text-right"><?php echo number_format($monto_ex, 2)?></td>
                                                    <td class="text-center">
                                                        <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-navicon"></i></a>
                                                        <a href="#modal-agregar-pago" class="btn btn-success btn-sm" data-toggle="modal"><i class="fa fa-dollar"></i></a>
                                                        <a href="ver_detalle_cliente.php?codigo=10469932091" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            $diferencia = $cl_venta->getTotal() - $suma_cobro;
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td class="text-right" colspan="6">SUMA PAGADO</td>
                                                <td class="text-right"><?php echo number_format($suma_cobro, 2)?></td>
                                                <td class="text-center"></td>
                                            </tr>
                                            <tr>
                                                <td class="text-right" colspan="6">MONTO TOTAL</td>
                                                <td class="text-right"><?php echo number_format($cl_venta->getTotal(), 2)?></td>
                                                <td class="text-center"></td>
                                            </tr>
                                            <tr>
                                                <td class="text-right" colspan="6">DIFERENCIA</td>
                                                <td class="text-right"><?php echo number_format($diferencia, 2)?></td>
                                                <td class="text-center"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal modal-message fade" id="modal-agregar-pago">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">Pagar Factura ---  <?php echo $cl_venta->getTido() . ' | ' . $cl_varios->zerofill($cl_venta->getSerie(), 3) . ' - ' . $cl_varios->zerofill($cl_venta->getNumero(), 7); ?></h4>
                            </div>
                            <form class="form-horizontal" id="frm_reg_pago_venta" method="POST" action="procesos/reg_cobro_venta.php">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Seleccionar Banco</label>
                                        <div class="col-md-8">
                                            <select class="form-control" name="select_banco" id="select_banco">
                                                <?php
                                                $a_bancos = $cl_banco->ver_bancos();
                                                foreach ($a_bancos as $value) {
                                                    ?>
                                                    <option value="<?php echo $value['codigo'] ?>"> <?php echo $value['nombre'] ?> </option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Fecha</label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control text-center" maxlength="10" name="input_fecha" id="input_fecha" value="<?php echo date('d/m/Y') ?>" required="true"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Moneda</label>
                                        <div class="col-md-5">
                                            <select class="form-control" name="select_moneda" id="select_moneda" onchange="validar_moneda()">
                                                <?php
                                                $cl_detalle->setTabla(5);
                                                $a_moneda = $cl_detalle->v_detalle();
                                                foreach ($a_moneda as $value) {
                                                    ?>
                                                    <option value="<?php echo $value['id'] ?>"><?php echo $value['descripcion'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <label class="col-md-2 control-label">Tipo Cambio</label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control  text-right" name="input_tc" id="input_tc" maxlength="5" value="1.000"  required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Monto</label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control text-right" maxlength="8" name="input_mcobro" id="input_mcobro" required="true"/>
                                        </div>
                                    </div>
                                    <input type="hidden" name="hidden_venta" value="<?php echo $cl_venta->getCodigo()?>" />
                                    <input type="hidden" name="hidden_periodo" value="<?php echo $cl_venta->getPeriodo()?>" />
                                    

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
        <script src="assets/js/table-manage-responsive.demo.min.js"></script>
        <script src="assets/js/apps.min.js"></script>
        <!-- ================== END PAGE LEVEL JS ================== -->
        <script>
                                                $(document).ready(function () {
                                                    App.init();
                                                    TableManageResponsive.init();
                                                });
        </script>
    </body>

    <!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:23:54 GMT -->
</html>

