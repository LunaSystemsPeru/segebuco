<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

require 'class/cl_cotizacion.php';
$cl_cotizacion = new cl_cotizacion();
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="es" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
    <!--<![endif]-->

    <head>
        <meta charset="utf-8" />
        <title>Ver Cotizaciones | SEGEBUCO SAC</title>
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
                    <li class="active">Cotizaciones</li>
                </ol>
                <!-- end breadcrumb -->
                <!-- begin page-header -->
                <h1 class="page-header">Cotizaciones <small>matenimiento operaciones</small></h1>
                <!-- end page-header -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-inverse">
                            <div class="panel-heading">
                                <a href="reg_cotizacion.php" class="btn btn-info btn-sm" >Nueva Cotizacion</a>
                            </div>
                            <div class="panel-body">
                                <table id="data-table" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th width="10%">Id.</th>
                                            <th width="15%">Cliente</th>
                                            <th width="45%">Descripcion</th>
                                            <th width="5%">sin IGV</th>
                                            <th width="10%">Estado</th>
                                            <th width="15%">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $a_cotizaciones = $cl_cotizacion->ver_cotizaciones();
                                        foreach ($a_cotizaciones as $value) {
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
                                            if ($value['estado'] == 0) {
                                                $notas = ''; 
                                                $aprobar = '';
                                                $estado = '<span class="btn btn-xs btn-inverse">No Aprobado</span>';
                                            }
                                            if ($value['estado'] == 1) {
                                                 $notas = ' | OS: ' . $value['notas']; 
                                                $estado = '<span class="btn btn-xs btn-success">Aprobado</span>';
                                                $aprobar = '';
                                            }
                                            if ($value['estado'] == 2) {
                                                 $notas = ''; 
                                                $estado = '<span class="btn btn-xs btn-warning">Pre-Aprobado</span>';
                                                $aprobar = '<a href="#m_aprobar_cotizacion" data-toggle="modal" onclick="a_cotizacion('.$value['codigo'].')" class="btn btn-link btn-sm"><i class="fa fa-check"></i> A</a>';;
                                            }
                                            ?>
                                            <tr class="odd gradeX">
                                                <td class="text-center"><a href="<?php echo 'upload/'. $value['ccliente'] . '/' . $value['csucursal'].'/cotizacion/'.$value['archivo']?>" target="_blank"><?php echo $value['codigo']?></a></td>
                                                <td><?php echo $value['razon_social'] . ' | ' . $value['sucursal']?></td>
                                                <td><?php echo $value['descripcion'] . ' - ' . $servicio . $notas?></td>
                                                <td class="text-right"><?php echo $value['moneda'] . ' ' . number_format($value['monto'], 2)?></td>
                                                <td class="text-center"><?php echo $estado?></td>
                                                <td class="text-center">
                                                    <!--<a href="<?php echo 'upload/'. $value['ccliente'] . '/' . $value['csucursal'].'/cotizacion/'.$value['archivo']?>" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-print"></i></a>-->
                                                    <a href="reg_email_cotizacion.php?codigo=<?php echo $value['codigo']?>" class="btn btn-info btn-sm" title="Enviar EMAIL"><i class="fa fa-envelope"></i></a>
                                                    <?php 
                                                    if ($value['estado'] == 0) {
                                                        ?>
                                                    <a href="#m_preaprobar_cotizacion" data-toggle="modal" onclick="prea_cotizacion('<?php echo $value['codigo'] ?>')" class="btn btn-warning btn-sm" title="Pre-Aprobar Cotizacion | Orden Interna"><i class="fa fa-thumbs-up"></i></a>
                                                    <?php 
                                                    }
                                                    ?>
                                                    <?php 
                                                    if ($value['estado'] == 2) {
                                                        ?>
                                                    <a href="#m_aprobar_cotizacion" data-toggle="modal" onclick="a_cotizacion('<?php echo $value['codigo'] ?>')" class="btn btn-primary btn-sm" title="Asociar a Orden de Servicio | Aprobar"><i class="fa fa-check"></i></a>
                                                    <?php 
                                                    }
                                                    ?>
                                                    <?php 
                                                    if ($value['estado'] == 0) {
                                                    ?>
                                                        <button onclick="confirmar('procesos/del_cotizacion.php?codigo=<?php echo $value['codigo']?>')" class="btn btn-danger btn-sm" title="Eliminar Cotizacion"><i class="fa fa-trash"></i></button>
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
                    <div class="modal modal fade" id="m_preaprobar_cotizacion" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
                        <div class="modal-dialog">
                            <div name="contenido_preaprueba" class="modal-content contenido_preaprueba" id="contenido_preaprueba">
        
                            </div>
                        </div>
                    </div>
                    <!--===================================================-->
                    <!--End Default Bootstrap Modal-->
                    
                    <!--Default Bootstrap Modal-->
                    <!--===================================================-->
                    <div class="modal modal fade" id="m_aprobar_cotizacion" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
                        <div class="modal-dialog">
                            <div name="contenido_aprueba" class="modal-content contenido_aprueba" id="contenido_aprueba">
        
                            </div>
                        </div>
                    </div>
                    <!--===================================================-->
                    <!--End Default Bootstrap Modal-->
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

                table.order([0, 'desc']).draw();
            });
        </script>
        
        <script language="JavaScript">
            function confirmar(url) {
                if (!confirm("¿Está seguro de que desea eliminar la cotizacion?")) {
                    return false;
                }
                else {
                    document.location = url;
                    return true;
                }
            }
        </script> 
        
        <script>
            function a_cotizacion(cotizacion) {
                var parametros = {
                    "id_cotizacion": cotizacion
                };
                $.ajax({
                    data: parametros,
                    url: 'modal_php/m_acotizacion.php',
                    type: 'post',
                    beforeSend: function () {
                        $("#contenido_aprueba").html("Procesando, espere por favor...");
                    },
                    success: function (response) {
                        $("#contenido_aprueba").html(response);
                    }
                });
            }
            
            function prea_cotizacion(cotizacion) {
                var parametros = {
                    "id_cotizacion": cotizacion
                };
                $.ajax({
                    data: parametros,
                    url: 'modal_php/m_preacotizacion.php',
                    type: 'post',
                    beforeSend: function () {
                        $("#contenido_preaprueba").html("Procesando, espere por favor...");
                    },
                    success: function (response) {
                        $("#contenido_preaprueba").html(response);
                    }
                });
            }
        </script>
    </body>

    <!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:23:54 GMT -->
</html>

