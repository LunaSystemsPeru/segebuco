<?php
/*
error_reporting(-1);
error_reporting(0);
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
*/
include '../../models/OrdenServicioCliente.php';
$Servicio = new OrdenServicioCliente();
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
                                    <h4 class="page-title">Clientes | Ordenes de Compra de Servicios</h4>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">Servicios</a></li>
                                        <li class="breadcrumb-item active">Ordenes de Compra Cliente</li>
                                    </ol>
                                </div><!--end col-->
                                <div class="col-auto align-self-center">
                                    <button class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#exampleModalSignup">
                                        <i data-feather="search" class="align-self-center icon-xs"></i> buscar x Fechas
                                    </button>
                                    <!--<a href="form-contrato.php" class="btn btn-sm btn-outline-primary">
                                    <i data-feather="plus" class="align-self-center icon-xs"></i> Agregar Nuevo Contrato
                                </a>-->
                                </div><!--end col-->
                            </div><!--end row-->
                        </div><!--end page-title-box-->
                    </div><!--end col-->
                </div><!--end row-->

                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <a href="form-orden-compra-cliente.php" class="btn btn-sm btn-outline-primary">
                                    <i data-feather="plus" class="align-self-center icon-xs"></i> Agregar Orden de Compra
                                </a>
                                <!--
                            <a href="form-compra-detallada.php" class="btn btn-sm btn-outline-primary">
                                <i data-feather="plus" class="align-self-center icon-xs"></i> Agregar Compra de Insumos
                            </a>
                            -->
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
                                                <th class="text-center">#</th>
                                                <th class="text-center" width="10%">Fecha</th>
                                                <th class="text-center">Nro Orden</th>
                                                <th class="text-center">Cliente</th>
                                                <th class="text-center">Comprador</th>
                                                <th class="text-right" width="7%">Monto</th>
                                                <th class="text-center">Moneda</th>
                                                <th class="text-center">Servicio</th>
                                                <th class="text-center">Cotizacion</th>
                                                <th class="text-center">H.Entrada</th>
                                                <th class="text-center">Estado</th>
                                                <th class="text-center"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($Servicio->verFilas() as $clave => $fila) {
                                                switch ($fila['estado']) {
                                                    case 0:
                                                        $estado = '<label class="badge badge-warning">Pendiente</label>';
                                                        break;
                                                    case 1:
                                                        $estado = '<label class="badge badge-info">Recepcionado</label>';
                                                        break;
                                                    case 2:
                                                        $estado = '<label class="badge badge-success">Aprovado</label>';
                                                        break;
                                                    case 3:
                                                        $estado = '<label class="badge badge-danger">Anulado</label>';
                                                        break;
                                                }
                                            ?>
                                                <tr>
                                                    <th scope="row"><?php echo $clave + 1 ?></th>
                                                    <td class="text-center"><?php echo $fila['fecha'] ?></td>
                                                    <td class="text-center"><?php echo $fila['nro'] ?></td>
                                                    <td><?php echo $fila['cliente'] ?></td>
                                                    <td><?php echo "JESUS AVILA" ?></td>
                                                    <td class="text-right"><?php echo $fila['valor1'] . ' ' . $fila['monto'] ?></td>
                                                    <td class="text-center"><?php echo $fila['valor2'] ?></td>
                                                    <td><?php echo $fila['nombre'] ?></td>
                                                    <td class="text-center"><label class="badge badge-dark">-</label></td>
                                                    <td class="text-center"><?php echo "-----" ?></td>
                                                    <td class="text-center"><?php echo $estado ?></td>
                                                    <td class="text-center">
                                                        <a href="detalle-contrato.php?id=1" class="btn btn-info btn-sm"><i class="ti ti-eye"></i></a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <th scope="row"><?php echo "2" ?></th>
                                                <td class="text-center"><?php echo "2022-11-16" ?></td>
                                                <td class="text-center"><?php echo "450039757" ?></td>
                                                <td><?php echo "PESQUERA HAYDUK S.A." ?></td>
                                                <td><?php echo "JESUS AVILA" ?></td>
                                                <td class="text-right"><?php echo "S/ 4,248.00" ?></td>
                                                <td class="text-center"><?php echo "PEN" ?></td>
                                                <td><?php echo "E/P SAN ANTONIO III - MANT TUBERIAS DE AGUA Y DESAGUE" ?></td>
                                                <td class="text-center">2022-11404</td>
                                                <td class="text-center"><?php echo "-----" ?></td>
                                                <td class="text-center"><label class="badge badge-danger">Rechazado</label></td>
                                                <td class="text-center">
                                                    <a href="detalle-contrato.php?id=1" class="btn btn-info btn-sm"><i class="ti ti-eye"></i></a>
                                                </td>
                                            </tr>
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

        <div class="modal fade" id="exampleModalSignup" tabindex="-1" role="dialog" aria-labelledby="exampleModalDefaultSignup" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title m-0" id="exampleModalDefaultLogin">Buscar Servicios entre Fechas</h6>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div><!--end modal-header-->
                    <form class="form-horizontal auth-form" action="lista-contratos.php" method="get">
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="form-label" for="input-documento">Fecha Inicio</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" id="fecha-inicio" name="fecha_inicio">
                                </div>
                            </div><!--end form-group-->
                            <div class="form-group">
                                <label class="form-label" for="input-documento">Fecha Final</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" id="fecha-final" name="fecha_final" value="<?php echo date("Y-m-d") ?>">
                                </div>
                            </div><!--end form-group-->
                        </div><!--end auth-page-->
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-soft-primary btn-sm">Buscar</button>
                            <button type="button" class="btn btn-soft-secondary btn-sm" data-dismiss="modal">Cancelar</button>
                        </div><!--end modal-footer-->
                    </form><!--end form-->
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

    <!-- App js -->
    <script src="../assets/js/app.js"></script>

</body>


<!-- Mirrored from mannatthemes.com/dastone/default/horizontal-index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 21 May 2021 20:35:01 GMT -->

</html>