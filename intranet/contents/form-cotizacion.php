<?php
include '../../models/ParametrosOpciones.php';
$Moneda = new ParametrosOpciones();
$Moneda->setIdparametro(4); //ID de tipo moneda
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
                                    <h4 class="page-title">Registrar Cotizacion</h4>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">Servicios</a></li>
                                        <li class="breadcrumb-item active">Cotizacion</li>
                                    </ol>
                                </div><!--end col-->
                            </div><!--end row-->
                        </div><!--end page-title-box-->
                    </div><!--end col-->
                </div><!--end row-->
                <!-- end page title end breadcrumb -->
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <p class="card-title">Datos Generales de la cotizacion</p>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="nro">Nro. de Cotización</label>
                                                <input type="number" class="form-control" id="nro" placeholder="5195591672" min="0">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="fecha-cotizacion">Fecha de Cotización</label>
                                                <input type="date" class="form-control" id="fecha-cotizacion" placeholder="fecha-cotizacion">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="id-moneda">Tipo de Moneda</label>
                                                <select class="form-control" name="id-moneda" id="id-moneda">
                                                <?php
                                                    foreach ($Moneda->verFilas() as $fila){
                                                        echo "<option value=".$fila['id'].">".$fila['descripcion']." | ".$fila['valor1']."</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="apellidosynombres">Area Trabajo</label>
                                                <input type="text" class="form-control" id="apellidosynombres" placeholder="Apellidos y Nombres">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="apellidosynombres">Cliente</label>
                                                <input type="text" class="form-control" id="apellidosynombres" placeholder="Apellidos y Nombres">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label" for="apellidosynombres">Descripcion del Servicio</label>
                                                <input type="text" class="form-control" id="apellidosynombres" placeholder="Apellidos y Nombres">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div><!--end card-body-->
                            <div class="card-header">
                                <p class="card-title">Datos de la Actividad</p>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label" for="apellidosynombres">Actividad</label>
                                                <textarea class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label" for="apellidosynombres">Sol Pedido</label>
                                                <input type="text" class="form-control" id="apellidosynombres" placeholder="Apellidos y Nombres">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="mb-3">
                                                <label class="form-label" for="apellidosynombres">Posicion</label>
                                                <input type="text" class="form-control" id="apellidosynombres" placeholder="Apellidos y Nombres">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label" for="apellidosynombres">Precio SIN IGV</label>
                                                <input type="text" class="form-control" id="apellidosynombres" placeholder="Apellidos y Nombres">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label" for="apellidosynombres">Dias Servicio</label>
                                                <input type="number" class="form-control" id="apellidosynombres" value="1" placeholder="Apellidos y Nombres">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div><!--end card-body-->
                            <div class="card-header">
                                <p class="card-title">Detalle de Insumos Utilizados</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="input-descripcion">Buscar Insumo</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label" for="select-unidad">Unidad Medida</label>
                                            <select class="custom-select" aria-label="Default select example" id="select-unidad">
                                                <option>UND</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label" for="input-precio-sinigv">Cost Unit s/IGV</label>
                                            <input type="number" class="form-control text-right" id="input-precio-sinigv" placeholder="0.00" value="0.00000" onkeyup="obtenerTotal()">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label" for="input-precio-total">Cantidad</label>
                                            <input type="number" value="1" class="form-control text-right" id="input-precio-total" placeholder="1">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label" for="input-precio-total"> Accion</label>
                                            <button class="btn btn-success"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="col-auto align-self-center">
                                    <a href="#" class="btn btn-sm btn-soft-primary">
                                        <i data-feather="plus" class="fas fa-plus mr-2"></i>
                                        Guardar Cotizacion
                                    </a>
                                </div><!--end col-->
                            </div>
                        </div><!--end card-->
                    </div> <!-- end col -->
                </div> <!-- end row -->
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