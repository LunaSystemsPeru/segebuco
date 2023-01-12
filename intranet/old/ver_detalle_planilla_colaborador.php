<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

require 'class/cl_planilla.php';
require 'class/cl_detalle_planilla.php';
require 'class/cl_planilla_gastos.php';
require 'class/cl_varios.php';
$cl_planilla = new cl_planilla();
$cl_varios = new cl_varios();
$cl_detalle = new cl_detalle_planilla();
$cl_gastos = new cl_planilla_gastos();
global $conn;
mysqli_set_charset($conn, "utf8");

if (filter_input(INPUT_GET, 'codigo') != '') {
    $codigo = filter_input(INPUT_GET, 'codigo');
    $suma_gastos = 0;
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
                    <li><a href="ver_planillas.php?semana=<?php echo $cl_planilla->getAnio() . $cl_varios->zerofill($cl_planilla->getSemana(), 3) ?>">Planilla</a></li>
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
                                <h4 class="panel-title">Detalle de Planilla de <?php echo $cl_planilla->getCliente() . ' - ' . $cl_planilla->getSucursal() ?></h4>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table id="data-table" class="table table-striped table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Id.</th>
                                                <th>Empresa.</th>
                                                <th>Sucursal.</th>
                                                <th>Apellidos y Nombres</th>
                                                <th>Cargo</th>
                                                <th>Jornal</th>
                                                <th>D. T.</th>
                                                <th>H. Ex. 25%</th>
                                                <th>H. Ex. 100%</th>
                                                <th>Ingresos</th>
                                                <th>Descuentos</th>
                                                <th>Sueldo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $cl_detalle->setPlanilla($cl_planilla->getCodigo());
                                            $a_colaborador = $cl_detalle->v_colaboradores_planilla_general($codigo);
                                            $contador = 1;
                                            $suma_sueldos = 0;
                                            foreach ($a_colaborador as $value) {
                                                $categoria = $value['categoria'];
                                                $jornal = $value['jornal_dia'];
                                                $diast = $value['horas_normal'] / 8;
                                                $s_horas25 = $jornal / 8 * $value['horas_25'] * 1.25;
                                                $s_horas100 = $jornal / 8 * $value['horas_100'] * 2;
                                                $s_alimentacion = $value['i_alimentacion'];
                                                $s_gastos = $value['i_gastos'];
                                                $s_adelanto = $value['d_adelanto'];
                                                $s_otros = $value['d_otros'];
                                                $s_diast = $jornal * $diast;
//                                            if ($categoria == 2) {
//                                                if ($diast == 6) {
//                                                    $dominical = $jornal;
//                                                } else {
//                                                    $dominical = 0;
//                                                }
//                                            } else {
                                                if ($diast == 6) {
                                                    $dominical = $jornal;
                                                } else {
                                                    $dominical = $jornal / 6 * $diast;
                                                }
                                                //}
                                                //$dominical = $jornal / 6 * $diast;
                                                $sueldo_semana = round($s_diast + $dominical + $s_horas25 + $s_horas100 + $s_alimentacion + $s_gastos - $s_adelanto - $s_otros);
                                                $suma_sueldos = $suma_sueldos + $sueldo_semana;
                                                $suma_ingresos = $s_alimentacion + $s_gastos;
                                                $suma_descuento = $s_adelanto + $s_otros;
                                                ?>
                                                <tr class="odd gradeX">
                                                    <td class="text-center"><?php echo $contador; ?></td>
                                                    <td class="text-center"><?php echo $value['razon_social']; ?></td>
                                                    <td class="text-center"><?php echo $value['sucursal']; ?></td>
                                                    <!--<td class="text-center"><?php echo $value['dni']; ?></td>-->
                                                    <td><?php echo $value['nombres']; ?></td>
                                                    <td class="text-center"><?php echo $value['cargo']; ?></td>
                                                    <td class="text-right"><?php echo number_format($jornal, 2, '.', ',') ?></td>
                                                    <td class="text-center"><?php echo $value['horas_normal'] / 8; ?></td>
                                                    <td class="text-center"><?php echo $value['horas_25']; ?></td>
                                                    <td class="text-center"><?php echo $value['horas_100']; ?></td>
                                                    <td class="text-center"><?php echo number_format($suma_ingresos, 2); ?></td>
                                                    <td class="text-center"><?php echo number_format($suma_descuento, 2); ?></td>
                                                    <td class="text-right"><?php echo number_format($sueldo_semana, 2, '.', ',') ?></td>

                                                </tr>
                                                <?php
                                                $contador++;
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr class="odd gradeX">
                                                <td class="text-right" colspan="11">Gastos</td>
                                                <td class="text-right"><?php echo number_format($suma_gastos, 2, '.', ',') ?></td>
                                            </tr>

                                            <tr class="odd gradeX">
                                                <td class="text-right" colspan="11">Total</td>
                                                <td class="text-right"><?php echo number_format($suma_sueldos + $suma_gastos, 2, '.', ',') ?></td>
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
    <script src="assets/js/table-manage-responsive.demo.min.js"></script>
    <script src="assets/js/apps.min.js"></script>
    <!-- ================== END PAGE LEVEL JS ================== -->
    <script>
                                                            $(document).ready(function () {
                                                                App.init();
                                                                TableManageResponsive.init();
                                                            });
    </script>
    <script>
        function cargar_datos_planilla(planilla, empleado) {
            var idplanilla = planilla;
            var idempleado = empleado;
            $.ajax({
                //data: parametros,
                url: 'ajax_post/ver_datos_planilla_colaborador.php?idplanilla=' + idplanilla + '&idempleado=' + idempleado,
                type: 'get',
                beforeSend: function () {
                    $("#resultado").html("Procesando, espere por favor...");
                    $("#input_jornal").val("");
                    $("#input_colaborador_pago").val("");
                    $("#input_diast").val("");
                    $("#input_dominical").val("");
                    $("#input_ext25").val("");
                    $("#input_ext100").val("");
                    $("#input_sext25").val("");
                    $("#input_sext100").val("");
                    $("#input_alimentacion").val("");
                    $("#input_movilidad").val("");
                    $("#input_adelantos").val("");
                    $("#input_otros").val("");
                    $("#input_semana").val("");
                    $("#submit_guardar_empleado").prop('disabled', true);
                },
                success: function (response) {
                    $("#resultado").html("");
                    var json = response;
                    console.log(json);
                    var json_datos = JSON.parse(json);
                    //console.log(json_datos[0].jornal);
                    var jornal = json_datos[0].jornal;
                    var categoria = json_datos[0].categoria;
                    var diast = json_datos[0].diast;
                    var ext25 = json_datos[0].ext25;
                    var ext100 = json_datos[0].ext100;
                    var s_horas25 = jornal / 8 * ext25 * 1.25;
                    var s_horas100 = jornal / 8 * ext100 * 2;
                    var s_alimentacion = Number(json_datos[0].i_alimentacion);
                    var s_gastos = Number(json_datos[0].i_gastos);
                    var s_adelanto = Number(json_datos[0].d_adelanto);
                    var s_otros = Number(json_datos[0].d_otros);
                    var s_diast = jornal * diast;
                    var dominical = 0.0;
                    if (diast === 6) {
                        dominical = parseFloat(jornal);
                    } else {
                        dominical = 0.00;
                    }
                    var sueldo_semana = parseFloat(s_diast + dominical + s_horas25 + s_horas100 + s_alimentacion + s_gastos - s_adelanto - s_otros);
                    console.log(sueldo_semana);
                    //console.log(json_datos[0].idcolaborador);
                    $("#input_id_colaborador_pago").val(json_datos[0].idcolaborador);
                    $("#input_jornal").val(jornal);
                    $("#input_colaborador_pago").val(json_datos[0].empleado);
                    $("#input_diast").val(diast);
                    $("#input_dominical").val(dominical.toFixed(2));
                    $("#input_ext25").val(ext25);
                    $("#input_ext100").val(ext100);
                    $("#input_sext25").val(s_horas25.toFixed(2));
                    $("#input_sext100").val(s_horas100.toFixed(2));
                    $("#input_alimentacion").val(s_alimentacion.toFixed(2));
                    $("#input_movilidad").val(s_gastos.toFixed(2));
                    $("#input_adelantos").val(s_adelanto.toFixed(2));
                    $("#input_otros").val(s_otros.toFixed(2));
                    $("#input_semana").val(Math.round(sueldo_semana).toFixed(2));
                    $("#submit_guardar_empleado").prop('disabled', false);
                }
            });
        }
    </script>
</body>

<!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:23:54 GMT -->
</html>

