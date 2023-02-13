<?php
require_once '../fixed/cargarSession.php';
require '../../models/Parametro.php';
require '../../models/ParametroValor.php';
$Parametro = new Parametro();
$Valor = new ParametroValor();
$Valor->setParametroId(1);
if (filter_input(INPUT_GET, 'tipo', FILTER_SANITIZE_NUMBER_INT)) {
    $Valor->setParametroId(filter_input(INPUT_GET, 'tipo', FILTER_SANITIZE_NUMBER_INT));
}

$Parametro->setId($Valor->getParametroId());
$Parametro->obtenerDatos();
?>
<!DOCTYPE html>
<html lang="es">

<!-- Mirrored from mannatthemes.com/dastone/default/horizontal-index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 21 May 2021 20:34:16 GMT -->
<head>
    <meta charset="utf-8"/>
    <title>SEGEBUCO SAC | Gestion de Servicios</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Walga Inversiones | Transporte y Alquiler de Gruas" name="description"/>
    <meta content="" name="author"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>

    <!-- App favicon -->
    <link rel="shortcut icon" href="../assets/images/favicon.png">

    <!-- App css -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/css/metisMenu.min.css" rel="stylesheet" type="text/css"/>
    <link href="../plugins/daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css"/>

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
                                <h4 class="page-title">Lista de Parametros</h4>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Configuracion</a></li>
                                    <li class="breadcrumb-item active">Parametros</li>
                                </ol>
                            </div><!--end col-->
                            <div class="col-auto align-self-center">
                                <button type="button" class="btn btn-sm btn-soft-primary" data-toggle="modal" data-target="#exampleModalSignup">
                                    <i data-feather="plus" class="fas fa-plus mr-2"></i>
                                    Agregar <?php echo $Parametro->getDescripcion() ?>
                                </button>
                                <!--start signup-->
                                <div class="modal fade" id="exampleModalSignup" tabindex="-1" role="dialog" aria-labelledby="exampleModalDefaultSignup" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title m-0" id="exampleModalDefaultLogin">Registrar Valor de Parametros</h6>
                                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                            </div><!--end modal-header-->
                                            <div class="modal-body">
                                                <form class="form-horizontal auth-form" method="post" action="../controller/registra-parametro-valor.php">
                                                    <div class="auth-page">
                                                        <div class="auth-card">
                                                            <div class="">
                                                                <div class="px-3">
                                                                    <div class="form-group">
                                                                        <label for="serie">Parametro Afecto</label>
                                                                        <div class="input-group mb-3">
                                                                            <input type="text" class="form-control" id="input-parametro" value="<?php echo $Parametro->getDescripcion() ?>" readonly>
                                                                            <input type="hidden" name="input-parametro-id" value="<?php echo $Parametro->getId()?>">
                                                                        </div>
                                                                    </div><!--end form-group-->
                                                                    <div class="form-group">
                                                                        <label for="numero">Descripcion</label>
                                                                        <div class="input-group mb-3">
                                                                            <input type="text" class="form-control" name="input-descripcion" placeholder="Descripcion">
                                                                        </div>
                                                                    </div><!--end form-group-->
                                                                    <div class="form-group">
                                                                        <label for="numero">Valor 1</label>
                                                                        <div class="input-group mb-3">
                                                                            <input type="text" class="form-control" name="input-valor1" placeholder="Valor 1">
                                                                        </div>
                                                                    </div><!--end form-group-->
                                                                    <div class="form-group">
                                                                        <label for="numero">Valor 2</label>
                                                                        <div class="input-group mb-3">
                                                                            <input type="text" class="form-control" name="input-valor2" placeholder="Valor 2">
                                                                        </div>
                                                                    </div><!--end form-group-->
                                                                </div><!--end /div-->
                                                            </div><!--end card-body-->
                                                        </div><!--end card-->
                                                    </div><!--end auth-page-->
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-soft-primary btn-sm">Guardar</button>
                                                        <button type="button" class="btn btn-soft-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                                                    </div><!--end modal-footer-->
                                                </form><!--end form-->
                                            </div><!--end modal-body-->

                                        </div><!--end modal-content-->
                                    </div><!--end modal-dialog-->
                                </div><!--end modal-->
                            </div><!--end col-->
                        </div><!--end row-->
                    </div><!--end page-title-box-->
                </div><!--end col-->
            </div><!--end row-->
            <!-- end page title end breadcrumb -->
            <div class="row justify-content-center">

                <div class="col-lg-5">
                    <div class="card">
                    </div><!--end card-header-->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Descripcion</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $array_parametros = $Parametro->verFilas();
                                $item = 1;
                                foreach ($array_parametros as $fila) {
                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo $item ?></th>
                                        <td><?php echo $fila['descripcion'] ?></td>
                                        <td>
                                            <a href="lista-parametros.php?tipo=<?php echo $fila['id'] ?>" class="btn btn-info btn-sm"><i class="ti ti-eye"></i></a>
                                        </td>
                                    </tr>
                                    <?php
                                    $item++;
                                }
                                ?>

                                </tbody>
                            </table><!--end /table-->
                        </div><!--end /tableresponsive-->
                    </div><!--end card-body-->
                </div><!--end card-->
                <div class="col-lg-7">
                    <div class="card">
                    </div><!--end card-header-->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Descripcion</th>
                                    <th>Valor1</th>
                                    <th>Valor2</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $array_valores = $Valor->verFilas();
                                $itemvalor = 1;
                                foreach ($array_valores as $filavalor) {
                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo $itemvalor ?></th>
                                        <td><?php echo $filavalor['descripcion'] ?></td>
                                        <td><?php echo $filavalor['valor1'] ?></td>
                                        <td><?php echo $filavalor['valor2'] ?></td>
                                        <td>
                                            <a href="<?php echo $filavalor['id']?>" class="btn btn-info btn-sm"><i class="ti ti-pencil"></i></a>
                                        </td>
                                    </tr>
                                    <?php
                                    $itemvalor++;
                                }
                                ?>
                                </tbody>
                            </table><!--end /table-->
                        </div><!--end /tableresponsive-->
                    </div><!--end card-body-->
                </div><!--end card-->

            </div> <!-- end col -->
        </div> <!-- end row -->

    </div><!--end row-->


</div><!-- container -->
</div>
<!-- end page content -->
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
