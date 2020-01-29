<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

require 'class/cl_entrega_epp.php';
require 'class/cl_varios.php';
require 'class/cl_empleado.php';

$cl_entrega = new cl_entrega_epp();
$cl_varios = new cl_varios();
$cl_empleado = new cl_empleado();

$cl_empleado->setCodigo($_GET['codigo']);
$cl_empleado->obtener_datos();
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="es" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
    <!--<![endif]-->

    <head>
        <meta charset="utf-8" />
        <title>Entrega de Epps | SEGEBUCO SAC</title>
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
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="ver_empleados.php">Empleados</a></li>
                    <li class="active">entrega de epps</li>
                </ol>
                <!-- end breadcrumb -->
                <!-- begin page-header -->
                <h1 class="page-header"><a href="ver_empleados_epp.php">Lista Empleados </a> / Entrega de Epps <small>a <?php echo $cl_empleado->getNombres() . ' ' . $cl_empleado->getPaterno() . ' ' . $cl_empleado->getMaterno() ?></small></h1>
                <!-- end page-header -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-inverse">
                            <div class="panel-heading">
                                <div class="panel-heading-btn">
                                    <select class="form-control" id="select_periodo" name="select_periodo">
                                        <option value="-" >Seleccionar Estado</option>
                                        <option value="0">En Uso</option>
                                        <option value="1">Devueltos</option>
                                        <option value="2">TODOS</option>
                                    </select>
                                </div>
                                <a href="reg_entrega_epp.php?codigo=<?php echo $_GET['codigo'] ?>" class="btn btn-info btn-sm" >Entregar EPPs</a>
                            </div>

                            <div class="panel-body">
                                <table id="table_epps" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Cod. Entrega.</th>
                                            <th>Nombre EPP</th>
                                            <th>Fecha Entrega</th>
                                            <th>Fecha Cambio Aprox.</th>
                                            <th>Fecha Cambio Real.</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $cl_entrega->setColaborador(filter_input(INPUT_GET, 'codigo'));
                                        $fecha_actual = strtotime(date("Y-m-d"));
                                        if (filter_input(INPUT_GET, 'estado') == '') {
                                            $cl_entrega->setEstado(0);
                                            //$cl_entrega->setEstado(filter_input(INPUT_GET, 'estado'));
                                        }
                                        if (filter_input(INPUT_GET, 'estado') == '2') {
                                            $cl_entrega->setEstado("");
                                        }
                                        if (filter_input(INPUT_GET, 'estado') == '1') {
                                            $cl_entrega->setEstado(1);
                                        }
                                        if (filter_input(INPUT_GET, 'estado') == '0') {
                                            $cl_entrega->setEstado(0);
                                        }
                                        $a_entregados = $cl_entrega->ver_entregados();

                                        foreach ($a_entregados as $value) {
                                            if ($value['estado'] == 0) {
                                                $fecha_retorno = strtotime($value['retorno']);
                                                if ($fecha_retorno > $fecha_actual) {
                                                    $estado = '<span class="btn btn-success btn-sm">EN USO</span>';
                                                }
                                                if ($fecha_retorno <= $fecha_actual) {
                                                    $estado = '<span class="btn btn-warning btn-sm">PARA CAMBIAR</span>';
                                                }
                                                $fecha_cambio = $value['retorno'];
                                                $fecha_devolucion = '-';
                                            }
                                            if ($value['estado'] == 1) {
                                                $estado = '<span class="btn btn-danger btn-sm">DEVUELTO</span>';
                                                $fecha_devolucion = $value['devolucion'];
                                                $fecha_cambio = '-';
                                            }
                                            ?>
                                            <tr class="odd gradeX">
                                                <td class="text-center"><?php echo $value['codigo'] ?></td>
                                                <td><?php echo $value['epp'] ?></td>
                                                <td class="text-center"><?php echo $value['entrega'] ?></td>
                                                <td class="text-center"><?php echo $fecha_cambio ?></td>
                                                <td class="text-center"><?php echo $fecha_devolucion ?></td>
                                                <td class="text-center">
                                                    <?php echo $estado ?>
                                                </td>
                                                <td class="text-center">
                                                    <button onclick="ver_nota_salida('<?php echo $value['codigo'] ?>', '<?php echo $_GET['codigo'] ?>')" class="btn btn-success btn-icon icon-lg fa fa-file-text-o"></button>
                                                    <?php
                                                    if ($value['estado'] == 0) {
                                                        ?>
                                                        <button onclick="DevolverEPP('<?php echo $value['codigo'] ?>', '<?php echo $value['cepp'] ?>', '<?php echo $_GET['codigo'] ?>')" data-target="#devolver_epp" data-toggle="modal" class="btn btn-white btn-icon icon-lg fa fa-undo"></button>
                                                        <button onclick="confirmar('procesos/del_entrega_epp.php?empleado=<?php echo $_GET['codigo'] ?>&epp=<?php echo $value['cepp'] ?>&codigo=<?php echo $value['codigo'] ?>');
                                                                        return false;" class="btn btn-warning btn-icon icon-lg fa fa-trash"></button>
                                                            <?php } ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            </div>

                            <!--Default Bootstrap Modal-->
                            <!--===================================================-->
                            <div class="modal" id="devolver_epp" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div name="contenido_devuelve_epp" class="modal-content contenido_devuelve_epp" id="contenido_devuelve_epp">

                                    </div>
                                </div>
                            </div>
                            <!--===================================================-->
                            <!--End Default Bootstrap Modal-->

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
        <script src="assets/js/apps.min.js"></script>
        <!-- ================== END PAGE LEVEL JS ================== -->
        <script>
                                                            $(document).ready(function () {
                                                                App.init();
                                                                TableManageDefault.init();

                                                                var table = $('#table_epps').DataTable();

                                                                table.order([3, 'desc']).draw();
                                                            });

                                                            $("#select_periodo").change(function () {
                                                                var periodo = $("#select_periodo").val();
                                                                console.log(periodo);
                                                                window.location = "ver_entrega_epp.php?codigo=<?php echo $_GET['codigo'] ?>&estado=" + periodo;
                                                            });
        </script>

        <script language="JavaScript">
            function confirmar(url) {
                if (!confirm("¿Está seguro de que desea eliminar el registro?")) {
                    return false;
                } else {
                    document.location = url;
                    return true;
                }
            }
        </script> 

        <script type="text/javascript">
            function ver_nota_salida(entrega, empleado) {
                document.location.href = "reportes/pdf_nota_salida_epp.php?entrega=" + entrega + "&empleado=" + empleado;
            }

            function DevolverEPP(entrega, epp, empleado) {
                var parametros = {
                    "id_entrega": entrega,
                    "id_epp": epp,
                    "id_empleado": empleado
                };
                $.ajax({
                    data: parametros,
                    url: 'modal_php/m_devolver_epp.php',
                    type: 'post',
                    beforeSend: function () {
                        $("#contenido_devuelve_epp").html("Procesando, espere por favor...");
                    },
                    success: function (response) {
                        $("#contenido_devuelve_epp").html(response);
                    }
                });
            }
        </script>

    </body>

    <!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:23:54 GMT -->
</html>

