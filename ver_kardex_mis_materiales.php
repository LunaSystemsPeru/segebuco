<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

require 'class/cl_kardex_material.php';
require 'class/cl_materiales.php';
require 'class/cl_almacen.php';
require 'class/cl_varios.php';
$cl_varios = new cl_varios();
$cl_material = new cl_materiales();
$cl_almacen = new cl_almacen();

$cl_kardex = new cl_kardex_material();
$cl_kardex->setMaterial(filter_input(INPUT_GET, 'material'));
$cl_kardex->setAlmacen(filter_input(INPUT_GET, 'almacen'));

$cl_material->setId($cl_kardex->getMaterial());
$cl_material->obtener_datos();

$cl_almacen->setCodigo($cl_kardex->getAlmacen());
$cl_almacen->datos_almacen();

$singresos = 0;
$segresos = 0;
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="es" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
    <!--<![endif]-->

    <head>
        <meta charset="utf-8" />
        <title>Ver Movimiento Materiales| SEGEBUCO SAC</title>
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

                <!-- end page-header -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-inverse">
                            <div class="panel-heading">
                                <h4 class="panel-title">Mov. de Materiales</h4>
                            </div>
                            <div class="panel-body">
                                <form>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input_codigo">Material</label>
                                        <div class="col-sm-9">
                                            <span class="form-control"><?php echo $cl_material->getId() . ' | ' . $cl_material->getDescripcion()?></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input_codigo">Almacen</label>
                                        <div class="col-sm-9">
                                            <span class="form-control"><?php echo $cl_almacen->getNombre()?></span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="panel panel-inverse">
                            <div class="panel-heading">
                                <h4 class="panel-title">Mov. de Materiales</h4>
                            </div>
                            <div class="panel-body">
                                <table id="data-table123" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Codigo</th>
                                            <th>Fecha</th>
                                            <th>Concepto</th>
                                            <th>Tipo</th>
                                            <th>Documento</th>
                                            <th>Ingreso</th>
                                            <th>S/ C. Ingreso</th>                                            
                                            <th>Egreso</th>
                                            <th>S/ C. Egreso</th>
                                            <th>Saldo</th>
                                            <th>S/ C. Unit.</th>                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $a_kardex = $cl_kardex->ver_kardex();
                                        $saldo = 0;
                                        $stotal = 0;
                                        $nro = 0;
                                        $nsaldo = 0;
                                        foreach ($a_kardex as $value) {
                                            $ingreso = $value['ingresa'];
                                            $cingreso = $value['c_ingreso'];
                                            $egreso = $value['sale'];
                                            $cegreso = $value['c_egreso'];
                                            $saldo = $saldo + $ingreso - $egreso;
                                            $stotal = $stotal + ($cingreso * $ingreso) - ($cegreso * $egreso);
                                            if ($ingreso == 0) {
                                                $vingreso = '-';
                                            } else {
                                                $vingreso = number_format($ingreso, 2);
                                            }
                                            if ($egreso == 0) {
                                                $vegreso = '-';
                                            } else {
                                                $vegreso = number_format($egreso, 2);
                                            }
                                            ?>
                                            <tr class="odd gradeX">
                                                <td class="text-center"><?php echo $nro++ ?></td>
                                                <td class="text-center"><?php echo $value['fecha'] ?></td>
                                                <td><?php echo $value['ruc'] . ' | ' . $value['datos'] ?></td>
                                                <td class="text-center"><?php echo $value['movimiento'] ?></td>
                                                <td class="text-center"><?php echo $value['tido'] . ' | ' . $value['serie'] . ' - ' . $value['numero'] ?></td>
                                                <td class="text-right"><?php echo $vingreso ?></td>
                                                <td class="text-right"><?php echo number_format($cingreso, 4)?></td>
                                                <td class="text-right"><?php echo $vegreso ?></td>
                                                <td class="text-right"><?php echo number_format($cegreso, 4)?></td>
                                                <td class="text-right"><?php echo number_format($saldo, 2) ?></td>
                                                <?php 
                                                if ($saldo < 1) {
							$nsaldo = $stotal ;
	                                        } else {
	                                        	$nsaldo = $stotal / $saldo;
	                                        }
                                                ?>
                                                <td class="text-right"><?php echo number_format($nsaldo, 4) ?></td>                                                
                                            </tr>
                                            <?php
                                            $singresos = $singresos + $ingreso;
                                            $segresos = $segresos + $egreso;
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr class="odd gradeX">
                                            <td class="text-center" colspan="5">Saldos</td>
                                            <td class="text-right"><?php echo number_format($singresos, 2) ?></td>
                                            <td class="text-right"><?php echo '-' ?></td>
                                            <td class="text-right"><?php echo number_format($segresos, 2) ?></td>
                                            <td class="text-right"><?php echo '-' ?></td>
                                            <td class="text-right"><?php echo number_format($saldo, 2) ?></td>
                                            <td class="text-right"><?php echo number_format($nsaldo, 4) ?></td>
                                        </tr>
                                    </tfoot>
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
    <script src="assets/plugins/masked-input/masked-input.min.js"></script>
    <script src="assets/js/apps.min.js"></script>
    <!-- ================== END PAGE LEVEL JS ================== -->
    <script>
        $(document).ready(function () {
            App.init();
            TableManageDefault.init();

            $('#input_fechags').mask('99/99/9999');
            $('#input_fechagd').mask('99/99/9999');

            $("#select_semanap").change(function () {
                var semana = $("#select_semanap").val();
                ver_cliente_planilla(semana);
            });
        });
    </script>

    <script>
        function number_format(amount, decimals) {

            amount += ''; // por si pasan un numero en vez de un string
            amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

            decimals = decimals || 0; // por si la variable no fue fue pasada

            // si no es un numero o es igual a cero retorno el mismo cero
            if (isNaN(amount) || amount === 0)
                return parseFloat(0).toFixed(decimals);

            // si es mayor o menor que cero retorno el valor formateado como numero
            amount = '' + amount.toFixed(decimals);

            var amount_parts = amount.split('.'),
                    regexp = /(\d+)(\d{3})/;

            while (regexp.test(amount_parts[0]))
                amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

            return amount_parts.join('.');
        }
    </script>
</body>

<!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:23:54 GMT -->
</html>

