<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

require 'class/cl_detalle_tabla_general.php';
require 'class/cl_tabla_general.php';

$cl_detalle = new cl_detalle_tabla_general();
$cl_tabla = new cl_tabla_general();

if (filter_input(INPUT_GET, 'codigo') != '') {

    $cl_tabla->setId(filter_input(INPUT_GET, 'codigo'));
    $cl_detalle->setTabla($cl_tabla->getId());
    $a_tabla = $cl_tabla->v_datos_tabla();
    foreach ($a_tabla as $value) {
        $cl_tabla->setId($value['id']);
        $cl_tabla->setNombre($value['nombre']);
    }
} else {
    header('Location: ver_tabla_general.php');
}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="es" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
    <!--<![endif]-->

    <head>
        <meta charset="utf-8" />
        <title>Detalle de Tabla General | SEGEBUCO SAC</title>
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
                    <li><a href="javascript:;">Tabla General</a></li>
                    <li class="active">ver detalle tabla general</li>
                </ol>
                <!-- end breadcrumb -->
                <!-- begin page-header -->
                <h1 class="page-header">Detalle Tabla General <small>matenimiento tabla general</small></h1>
                <!-- end page-header -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-inverse">
                            <div class="panel-heading">
                                <h4 class="panel-title">Datos Generales</h4>
                            </div>
                            <div class="panel-body">
                                <form class="form-horizontal" id="frm_detalle">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">CODIGO</label>
                                        <div class="col-md-8">
                                            <span class="form-control"><?php echo $cl_tabla->getId() ?></span>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">DESCRIPCION</label>
                                        <div class="col-md-8">
                                            <span class="form-control" ><?php echo $cl_tabla->getNombre() ?></span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="panel panel-inverse">
                            <div class="panel-heading">
                                <a href="#modal-registrar" class="btn btn-info btn-sm"  data-toggle="modal">Agregar Registro</a>

                                <div class="modal fade" id="modal-registrar">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form class="form-horizontal" id="frm_editar" method="post" action="procesos/reg_detalle_tabla_general.php">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title">Agregar Registro</h4>
                                                </div>
                                                <div class="modal-body">

                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Padre</label>
                                                        <div class="col-md-5">
                                                            <input type="text" class="form-control" value="<?php echo $cl_tabla->getNombre() ?>" readonly="true"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Codigo</label>
                                                        <div class="col-md-5">
                                                            <input type="text" class="form-control" readonly="true"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Descripcion</label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" name="input_descripcion" required/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Parametro</label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" name="input_parametro" required/>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="input_padre" value="<?php echo $cl_tabla->getId() ?>" />
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Cerrar</a>
                                                    <button type="submit" class="btn btn-sm btn-success">Guardar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <table id="data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Id.</th>
                                            <th>Descripcion</th>
                                            <th>Parametro</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $a_detalle = $cl_detalle->v_detalle();
                                        foreach ($a_detalle as $value) {
                                            ?>
                                            <tr class="odd gradeX">
                                                <td class="text-center"><?php echo $value['id'] ?></td>
                                                <td><?php echo $value['descripcion'] ?></td>
                                                <td class="text-center"><?php echo $value['atributo'] ?></td>
                                                <td class="text-center">
                                                    <button type=button onclick="obtener_formulario('<?php echo $value['id'] ?>', '<?php echo $cl_tabla->getId() ?>')" class="btn btn-info btn-sm">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                </td>
                                            </tr> 
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>

                                <div class="modal fade" id="modal-editar">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form class="form-horizontal" id="frm_editar" method="post" action="procesos/mod_detalle_tabla_general.php">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title">Modificar Registro</h4>
                                                </div>
                                                <div class="modal-body" id="resultado">

                                                </div>
                                                <div class="modal-footer">
                                                    <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Cerrar</a>
                                                    <button type="submit" class="btn btn-sm btn-success">Guardar</button>
                                                </div>
                                            </form>
                                        </div>
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
        <script src="assets/plugins/gritter/js/jquery.gritter.js"></script>
        <script src="assets/js/ui-modal-notification.demo.min.js"></script>
        <script src="assets/js/apps.min.js"></script>
        <!-- ================== END PAGE LEVEL JS ================== -->
        <script>
                                                        $(document).ready(function () {
                                                            App.init();
                                                            TableManageDefault.init();
                                                        });
        </script>

        <script>

            function obtener_formulario(id_detalle, id_tabla) {
                var parametros = {
                    "id": id_detalle,
                    "tabla": id_tabla
                };
                $.ajax({
                    data: parametros,
                    url: 'modal_php/m_mod_detalle_tabla.php',
                    type: 'POST',
                    //dataType: 'json',
                    beforeSend: function ()
                    {
                        $("#resultado").val('CARGANDO DATOS');
                    },
                    success: function (response)
                    {
                        $("#modal-editar").modal("toggle");
                        $("#resultado").html(response);
                    },
                    error: function ()
                    {
                        alert('Ocurrio un error en el servidor ..');
                        $("#resultado").val('ERROR AL CARGAR DATOS');
                    }
                });
            }
        </script>
    </body>

    <!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:23:54 GMT -->
</html>

