<?php
session_start();
require 'class/cl_compra.php';
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
$cl_compra = new cl_compra();

$cl_compra->setCodigo(filter_input(INPUT_GET,'codigo'));

global $conn;
mysqli_set_charset($conn, "utf8");

if (filter_input(INPUT_GET, 'codigo') != '') {
    $cl_planilla->setCodigo(filter_input(INPUT_GET, 'codigo'));
    $cl_gastos->setPlanilla(filter_input(INPUT_GET, 'codigo'));
    $a_datos = $cl_planilla->ver_datos_planilla();
    foreach ($a_datos as $value) {
        $cl_planilla->setSemana($value['semana']);
        $cl_planilla->setAnio($value['anio']);
        $cl_planilla->setCliente($value['nombre_comercial']);
        $cl_planilla->setSucursal($value['sucursal']);
        $cl_planilla->setInicio($value['fecha_inicio']);
        $cl_planilla->setFinal($value['fecha_fin']);
        $cl_planilla->setUsuario($value['nombres']);
        $cl_planilla->setAlimentacion($value['alimentacion']);
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
        <title>Detalle de Pago de Compra | SEGEBUCO SAC</title>
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
                    <li class="active">Detalle Pago de Compra</li>
                </ol>
                <!-- end breadcrumb -->
                <!-- begin page-header -->
                <h1 class="page-header">Detalle de Pago de Compra <small>matenimiento pago</small></h1>
                <!-- end page-header -->

                <div class="row">
                    <div class="col-md-8">
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
                    <div class="col-md-4">
                        <div class="panel panel-inverse">
                            <div class="panel-heading">
                                <div class="panel-heading-btn">
                                    <a href="#modal_gastos" data-toggle="modal" class="btn btn-success btn-xs">Agregar</a>
                                </div>
                                <h4 class="panel-title">Pagos</h4>
                            </div>
                            <div class="panel-body">
                                <table id="tabla_gastos" class="table table-striped table-bordered"  width="100%">
                                    <thead>
                                        <tr>
                                            <th>Id.</th>
                                            <th>Glosa</th>
                                            <th>Monto</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $a_gastos = $cl_gastos->ver_gastos_planilla();
                                        $suma_gastos = 0;
                                        foreach ($a_gastos as $value) {
                                            $suma_gastos = $suma_gastos + $value['monto'];
                                            ?>
                                            <tr class="odd gradeX">
                                                <td class="text-center"><?php echo $value['codigo'] ?></td>
                                                <td><?php echo $value['glosa'] ?></td>
                                                <td class="text-right"><?php echo number_format($value['monto'], 2, '.', ',') ?></td>
                                                <td class="text-center">
                                                    <a href="procesos/del_gasto_planilla.php" class="btn btn-danger btn-sm"><i class="fa fa-close"></i></a>
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

                <div class="modal fade" id="modal_gastos">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">Agregar Gasto</h4>
                            </div>
                            <form class="form-horizontal" id="frm_registrar" method="post" action="procesos/reg_gasto_planilla.php">
                                <div class="modal-body">

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Descripcion</label>
                                        <div class="col-md-8">
                                            <input type="text" name="input_glosa" class="form-control" required="true" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Monto</label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="input_monto" id="input_monto" required/>
                                        </div>
                                    </div>
                                    <input type="hidden" name="input_planilla" value="<?php echo $cl_planilla->getCodigo() ?>"/>
                                </div>
                                <div class="modal-footer">
                                    <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Cerrar</a>
                                    <button type="submit" class="btn btn-sm btn-success">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="modal fade" id="modal_horas">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">Ver y Modificar Horas trabajadas</h4>
                            </div>
                            <form class="form-horizontal" id="frm_registrar" method="post" action="procesos/reg_gasto_planilla.php">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Colaborador</label>
                                        <div class="col-md-8">
                                            <input type="text" name="input_colaborador_horas" id="input_colaborador_horas" class="form-control" readonly="true" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Jueves</label>
                                        <div class="col-md-4">
                                            <input type="number" name="input_ingreso_miercoles" class="form-control" value="08" required="true" />
                                        </div>
                                        <div class="col-md-4">
                                            <input type="number" name="input_salida_miercoles" class="form-control" value="17" required="true" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Viernes</label>
                                        <div class="col-md-4">
                                            <input type="number" name="input_ingreso_miercoles" class="form-control" value="08" required="true" />
                                        </div>
                                        <div class="col-md-4">
                                            <input type="number" name="input_salida_miercoles" class="form-control" value="17" required="true" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Sabado</label>
                                        <div class="col-md-4">
                                            <input type="number" name="input_ingreso_miercoles" class="form-control" value="08" required="true" />
                                        </div>
                                        <div class="col-md-4">
                                            <input type="number" name="input_salida_miercoles" class="form-control" value="17" required="true" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Domingo</label>
                                        <div class="col-md-4">
                                            <input type="number" name="input_ingreso_miercoles" class="form-control" value="0" required="true" />
                                        </div>
                                        <div class="col-md-4">
                                            <input type="number" name="input_salida_miercoles" class="form-control" value="0" required="true" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Lunes</label>
                                        <div class="col-md-4">
                                            <input type="number" name="input_ingreso_miercoles" class="form-control" value="08" required="true" />
                                        </div>
                                        <div class="col-md-4">
                                            <input type="number" name="input_salida_miercoles" class="form-control" value="17" required="true" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Martes</label>
                                        <div class="col-md-4">
                                            <input type="number" name="input_ingreso_miercoles" class="form-control" value="08" required="true" />
                                        </div>
                                        <div class="col-md-4">
                                            <input type="number" name="input_salida_miercoles" class="form-control" value="17" required="true" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Miercoles</label>
                                        <div class="col-md-4">
                                            <input type="number" name="input_ingreso_miercoles" class="form-control" value="08" required="true" />
                                        </div>
                                        <div class="col-md-4">
                                            <input type="number" name="input_salida_miercoles" class="form-control" value="17" required="true" />
                                        </div>
                                    </div>
                                    <input type="hidden" name="input_planilla_horas" value="<?php echo $cl_planilla->getCodigo() ?>"/>
                                    <input type="hidden" name="input_id_colaborador_horas" />

                                    <div class="modal-footer">
                                        <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Cerrar</a>
                                        <button type="submit" class="btn btn-sm btn-success">Guardar</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal_detalle">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title">Detalle Planilla</h4>
                        </div>
                        <form class="form-horizontal" id="frm_registrar" method="post" action="procesos/mod_pago_planilla.php">
                            <div class="modal-body">
                                <div id="resultado"></div>
                                <legend>Datos Generales</legend>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Colaborador</label>
                                    <div class="col-md-10">
                                        <input type="text" name="input_colaborador_pago" id="input_colaborador_pago" class="form-control" readonly />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Dias T.</label>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control text-center" name="input_diast" id="input_diast" readonly/>
                                    </div>
                                    <label class="col-md-2 control-label">Hor 25%.</label>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control text-center" name="input_ext25" id="input_ext25" readonly/>
                                    </div>
                                    <label class="col-md-2 control-label">Hor. 100%.</label>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control text-center" name="input_ext100" id="input_ext100" readonly/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Jornal D.</label>
                                    <div class="col-md-2">
                                        <input type="text" name="input_jornal" id="input_jornal" class="form-control text-right" readonly="true" />
                                    </div>
                                    <label class="col-md-2 control-label">S/ 25%</label>
                                    <div class="col-md-2">
                                        <input type="text" name="input_sext25" id="input_sext25" class="form-control text-right" readonly="true" />
                                    </div>
                                    <label class="col-md-2 control-label">S/ 100%</label>
                                    <div class="col-md-2">
                                        <input type="text" name="input_sext100" id="input_sext100" class="form-control text-right" value="300.00" readonly="true" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Dominical</label>
                                    <div class="col-md-2">
                                        <input type="text" name="input_dominical" id="input_dominical" class="form-control text-right" readonly="true" />
                                    </div>
                                    <label class="col-md-2 control-label">Semana</label>
                                    <div class="col-md-2">
                                        <input type="text" name="input_semana" id="input_semana" class="form-control text-right" value="300.00" readonly="true" />
                                    </div>
                                </div>
                                <legend>Ingresos:</legend>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Alm.</label>
                                    <div class="col-md-2">
                                        <input type="text" name="input_alimentacion" id="input_alimentacion" class="form-control text-right" required="true" />
                                    </div>
                                    <label class="col-md-2 control-label">Mov.</label>
                                    <div class="col-md-2">
                                        <input type="text" name="input_movilidad" id="input_movilidad" class="form-control text-right" required="true" />
                                    </div>
                                </div>
                                <legend>Egresos:</legend>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Adelanto</label>
                                    <div class="col-md-2">
                                        <input type="text" name="input_adelantos" id="input_adelantos" class="form-control text-right" value="0.00" required="true" />
                                    </div>
                                    <label class="col-md-2 control-label">Otros</label>
                                    <div class="col-md-2">
                                        <input type="text" name="input_otros" id="input_otros" class="form-control text-right" value="0.00" required="true" />
                                    </div>
                                </div>
                                <input type="hidden" name="input_planilla_pago" value="<?php echo $cl_planilla->getCodigo() ?>"/>
                                <input type="hidden" name="input_id_colaborador_pago" id="input_id_colaborador_pago" />
                            </div>
                            <div class="modal-footer">
                                <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Cerrar</a>
                                <button type="submit" id="submit_guardar_empleado" class="btn btn-sm btn-success" disabled="true">Guardar</button>
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

