<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

require 'class/cl_detalle_tabla_general.php';
require 'class/cl_empleado.php';

$cl_detalle = new cl_detalle_tabla_general();
$cl_empleado = new cl_empleado();

if ($_GET['codigo'] != '') {
    $cl_empleado->setCodigo($_GET['codigo']);
    $cl_empleado->obtener_datos();
}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="es" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
    <!--<![endif]-->

    <head>
        <meta charset="utf-8" />
        <title>Registro de Entrega de Epps | SEGEBUCO SAC</title>
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
                    <li><a href="javascript:;">Empleados</a></li>
                    <li class="active">entrega de epps</li>
                </ol>
                <!-- end breadcrumb -->
                <!-- begin page-header -->
                <h1 class="page-header"><a href="ver_empleados_epp.php">Lista Empleados </a> / Entrega de Epps</h1>
                <!-- end page-header -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-inverse">
                            <div class="panel-body">
                                <form class="form-horizontal" enctype="multipart/form-data" id="graba_epp_empleado" action="procesos/reg_entrega_epp.php" method="post">
                                    <div class="col-md-9">
                                        <div class="panel panel-inverse">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">Datos Generales</h4>
                                            </div>
                                            <div class="panel-body">

                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Buscar</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" name="input_buscar" id="input_buscar"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Colaborador</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" readonly="true" name="input_nombres" id="input_nombres" value="<?php echo $cl_empleado->getPaterno() . ' ' . $cl_empleado->getMaterno() . ', ' . $cl_empleado->getNombres()?>" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">DNI</label>
                                                    <div class="col-md-2">
                                                        <input type="text" class="form-control" readonly="true" name="input_dni" id="input_dni" value="<?php echo $cl_empleado->getDni()?>" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Cargo</label>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control" readonly="true" name="input_cargo" id="input_cargo"/>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="input_id_colaborador" id="input_id_colaborador" value="<?php echo $_GET['codigo'] ?>"/>
                                            </div>
                                        </div>
                                        <div class="panel panel-inverse">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">Detalle de Entrega</h4>
                                            </div>
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label" for="fecha_entrega">Fecha Entrega</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" placeholder="dd/mm/aaaa" name="fecha_entrega" id="fecha_entrega" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label" for="lista_epp">EPP</label>
                                                    <div class="col-sm-3">
                                                        <select name="lista_epp" id="lista_epp" class="form-control">
                                                            <?php
                                                            $cl_detalle->setTabla(7);
                                                            $a_estado = $cl_detalle->v_detalle();
                                                            foreach ($a_estado as $value) {
                                                                ?>
                                                                <option value="<?php echo $value['id'] ?>"><?php echo $value['descripcion'] ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <button class="btn btn-info" type="button" id="add_fila">Agregar</button>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label" for="tipo_seguro"></label>
                                                    <div class="col-sm-6">
                                                        <table class="table table-striped" name="detalle" id="detalle">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">Cod.</th>
                                                                    <th class="text-center">Nombre</th>
                                                                    <th>Acciones</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel-footer text-right">
                                                <input name="array_idepp" id="array_idepp" type="hidden" />
                                                <input name="id_empleado" id="id_empleado" value="<?php echo $_GET['codigo'] ?>" type="hidden" />
                                                <input type="submit" id="enviar" name="enviar" onclick="setValores()" class="btn btn-info" />
                                            </div>
                                        </div>
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
        <script src="assets/js/table-manage-default.demo.min.js"></script>
        <script src="assets/plugins/gritter/js/jquery.gritter.js"></script>
        <script src="assets/js/ui-modal-notification.demo.min.js"></script>
        <script src="assets/plugins/masked-input/masked-input.min.js"></script>
        <script src="assets/plugins/bootstrap-validator/bootstrapValidator.min.js"></script>
        <script src="assets/js/apps.min.js"></script>
        <!-- ================== END PAGE LEVEL JS ================== -->
        <script>
                                                    $(document).ready(function () {
                                                        App.init();
                                                        $('#fecha_entrega').mask('99/99/9999');
                                                    });
        </script>

        <script type="text/javascript">
            $(function () {

                //autocomplete
                $("#input_buscar").autocomplete({
                    source: "ajax_post/buscar_empleados.php",
                    minLength: 2,
                    select: function (event, ui) {
                        event.preventDefault();
                        $('#input_id_colaborador').val(ui.item.codigo);
                        $('#input_nombres').val(ui.item.nombres);
                        $('#input_cargo').val(ui.item.cargo);
                        $('#input_dni').val(ui.item.dni);
                        $('#input_jornal_colaborador').val(ui.item.jornal);
                        $('#btn_agregar_planilla').prop('disabled', false)
                        $('#input_buscar').val("");
                    }
                });

            });
        </script>

        <script type="text/javascript">
            var nro_fila = 0;
            var id_epp = new Array();

            $("#add_fila").click(function () {
                id_epp[nro_fila] = $("#lista_epp").val();
                var tds = '<tr>';
                tds += '<td class="text-center">' + $("#lista_epp").val() + '</td>';
                tds += '<td>' + $("#lista_epp option:selected").text() + '</td>';
                tds += '<td><button onclick ="delete_row($(this),' + nro_fila + ')" id="' + nro_fila + '" class="btn btn-info btn-icon icon-lg fa fa-trash"></button></td>';
                tds += '</tr>';
                $("#detalle").append(tds);

                nro_fila++;
            });
            function delete_row(row, idarray)
            {
                row.closest('tr').remove();
                delete id_epp [idarray];
            }

            function setValores() {
                //Lo convierto a objeto
                var jepp = {};
                for (i in id_epp)
                {
                    jepp[i] = id_epp[i];
                }

                var jeppjson = JSON.stringify(jepp);
                //alert (jeppjson.toString());
                document.getElementById("array_idepp").value = jeppjson;
            }

        </script>

    </body>

    <!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:23:54 GMT -->
</html>

