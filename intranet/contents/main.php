<?php
include '../fixed/cargarSession.php';
require '../../models/TareaDiaria.php';
$_SESSION['usuario_id'] = 1;

$Tarea = new TareaDiaria();
?>
<!DOCTYPE html>
<html lang="es">


<!-- Mirrored from mannatthemes.com/dastone/default/horizontal-index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 21 May 2021 20:34:16 GMT -->

<head>
    <meta charset="utf-8" />
    <title>SEGEBUCO SAC | Gestion de Servicios</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Walga Inversiones | Transporte y Alquiler de Gruas" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="../assets/images/favicon.png">

    <!-- App css -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/metisMenu.min.css" rel="stylesheet" type="text/css" />
    <link href="../plugins/daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" />

</head>

<body data-layout="horizontal" class="">

    <!-- Top Bar Start -->
    <?php require '../fixed/top-bar.php' ?>
    <!-- Top Bar End -->
    <div class="page-wrapper">
        <!-- Page Content-->
        <div class="page-content">
            <div class="container-fluid">
                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-title-box">
                            <div class="row">
                                <div class="col">
                                    <h4 class="page-title">Analytics</h4>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">Dastone</a></li>
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Analytics</li>
                                    </ol>
                                </div><!--end col-->
                                <div class="col-auto align-self-center">
                                    <a href="#" class="btn btn-sm btn-outline-primary" id="Dash_Date">
                                        <span class="day-name" id="Day_Name">Today:</span>&nbsp;
                                        <span class="" id="Select_date">Jan 11</span>
                                        <i data-feather="calendar" class="align-self-center icon-xs ml-1"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-outline-primary">
                                        <i data-feather="download" class="align-self-center icon-xs"></i>
                                    </a>
                                </div><!--end col-->
                            </div><!--end row-->
                        </div><!--end page-title-box-->
                    </div><!--end col-->
                </div><!--end row-->
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="h4">Listas de tareas sin Cotizar</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title end breadcrumb -->
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th width="10%">Fecha</th>
                                                <th>Tarea</th>
                                                <th>Maestro</th>
                                                <th>Cliente</th>
                                                <th>Embarcacion</th>
                                                <th width="10%">Tipo de servicio</th>
                                                <th>Estado</th>
                                                <th>Cotizar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($Tarea->verTareas() as $clave => $fila) {
                                                if ($fila['estado'] == 1) {
                                                    $fecha = str_split($fila['fecha_registro'], 10); ?>
                                                    <tr>
                                                        <th scope="row"><?php echo $clave + 1 ?></th>
                                                        <td class="text-center"><?php echo $fecha[0] ?></td>
                                                        <td><?php echo $fila['nombre_corto'] ?></td>
                                                        <td><?php echo $fila['datos'] ?></td>
                                                        <td><?php echo $fila['ncliente'] ?></td>
                                                        <td><?php echo $fila['nep'] ?></td>
                                                        <td><?php echo $fila['tiposervicio'] ?></td>
                                                        <td><span class="badge badge-warning">Pendiente</span></td>
                                                        <td class="text-center">
                                                            <a onclick="idcotizacion(<?php echo $fila['id'] ?>)" class="btn btn-info btn-sm" data-toggle="modal" data-target="#cotizacion"><i class="fa fa-money-check"></i></a>
                                                        </td>
                                                    </tr>
                                            <?php }
                                            } ?>
                                        </tbody>
                                    </table><!--end /table-->
                                </div><!--end /tableresponsive-->
                            </div><!--end card-body-->
                        </div><!--end card-->
                    </div> <!-- end col -->
                </div><!-- row -->
            </div><!-- container -->
        </div>
        <!-- end page content -->
        <div class="modal fade" id="cotizacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalDefaultSignup" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title m-0" id="exampleModalDefaultLogin">Tipo de Cotización</h6>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div><!--end modal-header-->
                    <div class="modal-body">
                        <div class="row my-3 text-center">
                            <div class="col-6">
                                <a href="form-cotizacion.php" class="btn btn-dark" id="btn-simple">Simple</a>
                            </div>
                            <div class="col-6">
                                <a href="cotizacion-compeleta" class="btn btn-dark" id="btn-completa">Completa</a>
                            </div>
                        </div><!--end form-group-->
                    </div><!--end auth-page-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-soft-secondary btn-sm" data-dismiss="modal">Cancelar</button>
                    </div><!--end modal-footer-->
                </div><!--end modal-body-->
            </div><!--end modal-content-->
        </div><!--end modal-dialog-->
    </div>
    <!-- end page-wrapper -->
    <?php
    include('../fixed/footer.php');
    ?>




    <!-- jQuery  -->
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/metismenu.min.js"></script>
    <script src="../assets/js/waves.js"></script>
    <script src="../assets/js/feather.min.js"></script>
    <script src="../assets/js/simplebar.min.js"></script>
    <script src="../assets/js/moment.js"></script>
    <script src="../plugins/daterangepicker/daterangepicker.js"></script>

    <script src="../plugins/apex-charts/apexcharts.min.js"></script>
    <script src="../assets/pages/jquery.analytics_dashboard.init.js"></script>

    <!-- App js -->
    <script src="../assets/js/app.js"></script>

    <script>
        function idcotizacion(id){
            let url = ($("#btn-simple").attr('href'));
            $("#btn-simple").attr('href',url+'?id='+id)
            // let url = ($("#btn-completa").attr('href'));
            // $("#btn-completa").attr('href',url+'?id='+id)
        }
    </script>

</body>


<!-- Mirrored from mannatthemes.com/dastone/default/horizontal-index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 21 May 2021 20:35:01 GMT -->

</html>