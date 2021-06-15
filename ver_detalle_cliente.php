<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

require 'class/cl_cliente.php';
require 'class/cl_entidad.php';
require 'class/cl_sucursal.php';

$cl_cliente = new cl_cliente();
$cl_entidad = new cl_entidad();
$cl_sucursal = new cl_sucursal();

if (filter_input(INPUT_GET, 'codigo') != '') {

    $cl_cliente->setCodigo(filter_input(INPUT_GET, 'codigo'));
    $a_clientes = $cl_cliente->datos_cliente();
    foreach ($a_clientes as $value) {
        $cl_cliente->setCodigo($value['id']);
        $cl_entidad->setRuc($value['ruc']);
        $cl_entidad->setRazon_social($value['razon_social']);
        $cl_entidad->setNombre_comercial($value['nombre_comercial']);
        $cl_entidad->setDireccion($value['direccion']);
        $cl_entidad->setCondicion($value['condicion']);
        $cl_entidad->setEstado($value['estado']);
    }
    $cl_sucursal->setCliente($cl_cliente->getCodigo());
} else {
    header('Location: ver_clientes.php');
}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="es" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
    <!--<![endif]-->

    <head>
        <meta charset="utf-8" />
        <title>Detalle Cliente| SEGEBUCO SAC</title>
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
                    <li><a href="javascript:;">Clientes</a></li>
                    <li class="active">ver detalle cliente</li>
                </ol>
                <!-- end breadcrumb -->
                <!-- begin page-header -->
                <h1 class="page-header">Detalle Cliente <small><?php echo $cl_entidad->getNombre_comercial() ?></small></h1>
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
                                        <div class="col-md-2">
                                            <span class="form-control"><?php echo $cl_cliente->getCodigo() ?></span>
                                        </div>
                                        <label class="col-md-2 control-label">RUC</label>
                                        <div class="col-md-2">
                                            <span class="form-control"><?php echo $cl_entidad->getRuc() ?></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">RAZON SOCIAL</label>
                                        <div class="col-md-8">
                                            <span class="form-control" ><?php echo $cl_entidad->getRazon_social() ?></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">DIRECCION</label>
                                        <div class="col-md-8">
                                            <span class="form-control" ><?php echo $cl_entidad->getDireccion() ?></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">NOMBRE COMERCIAL</label>
                                        <div class="col-md-8">
                                            <span class="form-control" ><?php echo $cl_entidad->getNombre_comercial() ?></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">CONDICION</label>
                                        <div class="col-md-3">
                                            <span class="form-control" ><?php echo $cl_entidad->getCondicion() ?></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">ESTADO</label>
                                        <div class="col-md-3">
                                            <span class="form-control" ><?php echo $cl_entidad->getEstado() ?></span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="panel panel-inverse">
                            <div class="panel-heading">
                                <a href="#modal-registrar" class="btn btn-info btn-sm"  data-toggle="modal">Agregar Sucursal</a>

                                <div class="modal fade" id="modal-registrar">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form class="form-horizontal" id="frm_editar" method="post" action="procesos/reg_sucursal_cliente.php">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title">Agregar Sucursal Cliente</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <fieldset>
                                                        <legend>Datos Generales</legend>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Cliente</label>
                                                            <div class="col-md-5">
                                                                <input type="text" class="form-control" value="<?php echo $cl_entidad->getNombre_comercial() ?>" readonly="true"/>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Nombre</label>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" name="input_nombre" required/>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Direccion</label>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" name="input_direccion" required/>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                    <fieldset>
                                                        <legend>Datos Contacto</legend>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Contacto</label>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" name="input_contacto" required/>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Email</label>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" name="input_email" required/>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                    <input type="hidden" name="input_cliente" value="<?php echo $cl_cliente->getCodigo() ?>" />
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
                                            <th>Nombre</th>
                                            <th>Direccion</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $a_sucursal = $cl_sucursal->ver_sucursales();
                                        foreach ($a_sucursal as $value) {
                                            ?>
                                            <tr class="odd gradeX">
                                                <td class="text-center"><?php echo $value['id'] ?></td>
                                                <td class="text-center"><?php echo $value['nombre'] ?></td>
                                                <td><?php echo $value['direccion'] ?></td>
                                                <td class="text-center">
                                                    <a href="#modal-editar" class="btn btn-info btn-sm" data-toggle="modal"><i class="fa fa-edit"></i></a>
                                                    <button type="button" onclick="eliminar('<?php echo $cl_cliente->getCodigo() ?>', '<?php echo $value['id'] ?>')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
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
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title">Modificar Sucursal</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal" id="frm_editar">
                                                    <fieldset>
                                                        <legend>Datos Generales</legend>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Codigo</label>
                                                            <div class="col-md-5">
                                                                <input type="text" class="form-control" value="1" readonly="true"/>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Nombre</label>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" value="CHIMBOTE" required/>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Direccion</label>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" value="TRAPECIO S - 3" required/>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                    <fieldset>
                                                        <legend>Datos Contacto</legend>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Contacto</label>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" value="LUIS OYANGURENG" required/>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Email</label>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" value="xxx@correo.net" required/>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Cerrar</a>
                                                <a href="javascript:;" class="btn btn-sm btn-success">Modifcar</a>
                                            </div>
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

        <script language="JavaScript">
            function eliminar(cliente, sucursal) {
                if (!confirm("¿Está seguro de que desea eliminar el Documento Seleccionado?")) {
                    return false;
                } else {
                    document.location = "procesos/eliminar_sucursal.php?id_cliente=" + cliente + "&id_sucursal=" + sucursal;
                    return true;
                }
            }
        </script> 
    </body>

    <!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:23:54 GMT -->
</html>

