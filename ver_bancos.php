<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

require 'class/cl_banco.php';
require 'class/cl_detalle_tabla_general.php';
$cl_detalle = new cl_detalle_tabla_general();
$cl_banco = new cl_banco();


?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="es" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
    <!--<![endif]-->

    <head>
        <meta charset="utf-8" />
        <title>Ver Bancos | SEGEBUCO SAC</title>
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
                    <li><a href="javascript:;">Cajas y Bancos</a></li>
                    <li class="active">ver Bancos</li>
                </ol>
                <!-- end breadcrumb -->
                <!-- begin page-header -->
                <h1 class="page-header">Cajas y Bancos <small>matenimiento bancos</small></h1>
                <!-- end page-header -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-inverse">
                            <div class="panel-heading">
                                <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-agregar"><i class="fa fa-money"></i> Agregar Banco</button>
                            </div>
                            <div class="panel-body">
                                <table id="data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Codigo</th>
                                            <th>Nombre</th>
                                            <th>Moneda</th>
                                            <th>Monto</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $a_banco = $cl_banco->ver_bancos();
                                        foreach ($a_banco as $value) {
                                            ?>
                                            <tr class="odd gradeX">
                                                <td class="text-center"><?php echo $value['codigo'] ?></td>
                                                <td><?php echo $value['nombre']. ' - ' . $value['nro_cuenta']  ?></td>
                                                <td><?php echo $value['moneda'] . ' - ' . $value['nmoneda'] ?></td>
                                                <td class="text-right"><?php echo number_format($value['monto_disponible'],2) ?></td>
                                                <td class="text-center"><?php echo $value['estado'] ?></td>
                                                <td class="text-center">
                                                    <a href="#modal-modificar-entidad" class="btn btn-info btn-sm" data-toggle="modal" onclick="cargar_datos_entidad('<?php echo $value['ruc']?>')" title="Modificar"><i class="fa fa-edit"></i></a>
                                                    <a href="ver_movimiento_bancos.php?banco=<?php echo $value['codigo'] ?>" class="btn btn-danger btn-sm" title="Ver Movimientos Banco"><i class="fa fa-desktop"></i></a>
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

                <div class="modal modal-message fade" id="modal-modificar-entidad">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">Modificar Entidad - Proveedor</h4>
                            </div>
                            <form class="form-horizontal" id="frm_mod_entidad" method="POST" action="procesos/mod_entidad.php">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="input_nombre">Nombre</label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" id="input_nombre" name="input_nombre" required/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="input_cuenta">Nro de Cuenta</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" id="input_cuenta" name="input_cuenta" required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="select_moneda">Moneda</label>
                                        <div class="col-md-6">
                                            <select class="form-control" name="select_moneda" id="select_moneda">
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
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="input_inicial" >Monto Inicial</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" id="input_inicial" name="input_inicial" required value="0" />
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Cerrar</a>
                                    <input type="submit" class="btn btn-sm btn-success" name="button_submit" value="Guardar "/>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="modal modal-message fade" id="modal-agregar">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">Agregar Banco</h4>
                            </div>
                            <form class="form-horizontal" id="frm_banco" method="POST" action="procesos/reg_banco.php">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="input_nombre">Nombre</label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" id="input_nombre" name="input_nombre" required/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="input_cuenta">Nro de Cuenta</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" id="input_cuenta" name="input_cuenta" required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="select_moneda">Moneda</label>
                                        <div class="col-md-6">
                                            <select class="form-control" name="select_moneda" id="select_moneda">
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
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="input_inicial" >Monto Inicial</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" id="input_inicial" name="input_inicial" required value="0" />
                                        </div>
                                    </div>
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
        <script src="assets/js/table-manage-default.demo.min.js"></script>
        <script src="assets/js/apps.min.js"></script>
        <!-- ================== END PAGE LEVEL JS ================== -->
        <script>
            $(document).ready(function () {
                App.init();
                TableManageDefault.init();
                var table = $('#data-table').DataTable();

                table.order([1, 'asc']).draw();
            });

            function cargar_datos_entidad(ruc) {
                var ruc = ruc;
                $.ajax({
                    //data: parametros,
                    url: 'ajax_post/ver_datos_entidad.php?ruc=' + ruc,
                    type: 'get',
                    beforeSend: function () {
                        $("#resultado").html("Procesando, espere por favor...");
                        $("#button_submit").prop('disabled', true);
                    },
                    success: function (response) {
                        $("#resultado").html("");
                        var json = response;
                        console.log(json);
                        var json_datos = JSON.parse(json);
                        $("#input_ruc").val(json_datos[0].ruc);
                        $("#input_razon").val(json_datos[0].razon_social);
                        $("#input_estado").val(json_datos[0].estado);
                        $("#input_condicion").val(json_datos[0].condicion);
                        $("#input_direccion").val(json_datos[0].direccion);
                        $("#input_comercial").val(json_datos[0].nombre_comercial);
                        $("#button_submit").prop('disabled', false);
                        $("#input_comercial").focus();
                    }
                });
            }
        </script>
    </body>

    <!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:23:54 GMT -->
</html>

