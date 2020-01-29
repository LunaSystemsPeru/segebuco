<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

require 'class/cl_orden_interna.php';
$cl_orden = new cl_orden_interna();
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="es" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
    <!--<![endif]-->

    <head>
        <meta charset="utf-8" />
        <title>Ver Servicios Internos | SEGEBUCO SAC</title>
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
                    <li><a href="javascript:;">Operaciones</a></li>
                    <li class="active">Servicios | Ordenes Internas</li>
                </ol>
                <!-- end breadcrumb -->
                <!-- begin page-header -->
                <h1 class="page-header">Servicios | Ordenes Internas <small>matenimiento operaciones</small></h1>
                <!-- end page-header -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-inverse">
                            <div class="panel-body">
                                <table id="data-table" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th width="5%">Id.</th>
                                            <th width="17%">Cliente</th>
                                            <th width="33%">Descripcion</th>
                                            <th width="8%">Fecha Inicio</th>
                                            <th width="8%">Fecha Termino</th>
                                            <th width="10%">Progreso</th>
                                            <th width="7%">Estado</th>
                                            <th width="12%">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $a_ordenes = $cl_orden->ver_ordenes();
                                        foreach ($a_ordenes as $value) {
                                            if ($value['tipo_servicio'] == 1) {
                                                $servicio = 'A TODO COSTO';
                                            }
                                            if ($value['tipo_servicio'] == 2) {
                                                $servicio = 'POR ALQUILER DE TRANSPORTE';
                                            }
                                            if ($value['tipo_servicio'] == 3) {
                                                $servicio = 'POR COMPRA DE CHATARRA';
                                            }
                                            if ($value['tipo_servicio'] == 4) {
                                                $servicio = 'POR SOLO MANO DE OBRA';
                                            }
                                            if ($value['tipo_servicio'] == 5) {
                                                $servicio = 'POR MANO DE OBRA + CONSUMIBLES';
                                            }
                                            if ($value['tipo_servicio'] == 6) {
                                                $servicio = 'POR TRASLADO DE MERCADERIA';
                                            }
                                            
                                            $dias = $value['dias'];
                                            $d_avance = $value['d_avance'];
                                            $porcentaje = $d_avance / $dias * 100;
                                            
                                            
                                            if ($value['estado'] == '0') {
                                                $fecha_termino = $value['aprox_termino'];
                                                if ($d_avance < $dias) {
                                                    $estado = '<span class="btn btn-success btn-sm">en Produccion</span>';
                                                    $eliminar = '';
                                                }
                                                if ($d_avance == $dias) {
                                                    $estado = '<span class="btn btn-warning btn-sm">al Limite</span>';
                                                }
                                                if ($d_avance > $dias) {
                                                    $estado = '<span class="btn btn-danger btn-sm">Fuera de Tiempo</span>';
                                                }
                                            } 
                                            if ($value['estado'] == '1') {
                                                $fecha_termino = $value['fecha_termino'];
                                                $estado = '<span class="btn btn-inverse btn-sm">Finalizado</span>';
                                                $porcentaje = 100;
                                                $d_avance = $dias;
                                            } 
                                            
                                            ?>
                                            <tr class="odd gradeX">
                                                <td class="text-center"><?php echo $value['id_orden']?></td>
                                                <td><?php echo $value['razon_social'] . ' | ' . $value['sucursal']?></td>
                                                <td><?php echo $value['descripcion'] . ' | ' . $servicio . ' | Cot. Nro: ' . $value['codigo'] . ' | ' . $d_avance . ' de ' . $dias . ' dias'?></td>
                                                <td class="text-right"><?php echo $value['fecha_inicio']?></td>
                                                <td class="text-right"><?php echo $fecha_termino?></td>
                                                <td>
                                                    <div class="progress progress-thin">
                                                        <?php 
                                                        if ($value['estado'] == '0') {
                                                            if ($porcentaje <= 100) {
                                                        ?>
                                                            <div class="progress-bar progress-bar-info" style="width:<?php echo number_format($porcentaje, 2)?>%"><?php echo number_format($porcentaje, 2)?>%</div>
                                                        <?php 
                                                            }
                                                            if ($porcentaje > 100) {
                                                                ?>
                                                                <div class="progress-bar progress-bar-danger" style="width:100%">100%</div>
                                                        <?php
                                                            }
                                                        } else {
                                                        ?>
                                                            <div class="progress-bar progress-bar-inverse" style="width:<?php echo number_format($porcentaje, 2)?>%"><?php echo number_format($porcentaje, 2)?>%</div>
                                                        <?php 
                                                        } 
                                                        ?>
                                                      </div>
                                                </td>
                                                <td class="text-center"><?php echo $estado?></td>
                                                <td class="text-center">
                                                    <a href="ver_detalle_orden_interna.php?codigo=<?php echo $value['id_orden']?>" class="btn btn-info btn-sm" title="Ver Detalles de Servicio"><i class="fa fa-warning"></i></a>
                                                    <?php 
                                                    if ($value['estado'] == 0) {
                                                        ?>
                                                    <a href="#m_finalizar" data-toggle="modal" onclick="finalizar('<?php echo $value['id_orden'] ?>', '<?php echo $value['codigo']?>')" class="btn btn-warning btn-sm" title="Terminar Servicio"><i class="fa fa-thumbs-up"></i></a>
                                                    <?php 
                                                    }
                                                    ?>
                                                    
                                                    <?php 
                                                    if ($value['estado'] == '0') {
                                                    ?>
                                                        <button onclick="confirmar('procesos/del_orden_interna.php?codigo=<?php echo $value['id_orden']?>')" class="btn btn-danger btn-sm" title="Eliminar | Cancelar Servicio"><i class="fa fa-trash"></i></button>
                                                    <?php 
                                                    }
                                                    ?>
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
                    
                    <!--Default Bootstrap Modal-->
                    <!--===================================================-->
                    <div class="modal modal fade" id="m_finalizar" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
                        <div class="modal-dialog">
                            <div name="contenido_finalizar" class="modal-content contenido_finalizar" id="contenido_finalizar">
        
                            </div>
                        </div>
                    </div>
                    <!--===================================================-->
                    <!--End Default Bootstrap Modal-->
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

                table.order([4, 'desc']).draw();
            });
        </script>
        
        <script language="JavaScript">
            function confirmar(url) {
                if (!confirm("¿Está seguro de que desea eliminar la orden interna?")) {
                    return false;
                }
                else {
                    document.location = url;
                    return true;
                }
            }
            
            function finalizar(orden, cotizacion) {
                var parametros = {
                    "id_orden": orden, 
                    "id_cotizacion": cotizacion
                };
                $.ajax({
                    data: parametros,
                    url: 'modal_php/m_fin_orden.php',
                    type: 'post',
                    beforeSend: function () {
                        $("#contenido_finalizar").html("Procesando, espere por favor...");
                    },
                    success: function (response) {
                        $("#contenido_finalizar").html(response);
                    }
                });
            }
        </script> 
        
    </body>

    <!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:23:54 GMT -->
</html>

