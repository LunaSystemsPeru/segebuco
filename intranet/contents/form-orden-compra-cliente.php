<?php
include '../../models/EmbarcacionCliente.php';
include '../../models/ParametrosOpciones.php';

$Cliente = new EmbarcacionCliente();
$Moneda = new ParametrosOpciones();

$Moneda->setIdparametro(4); //ID de tipo de monede
?>
<!DOCTYPE html>
<html lang="es">


<!-- Mirrored from mannatthemes.com/dastone/default/horizontal-index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 21 May 2021 20:34:16 GMT -->

<head>
    <style>
        .select2 {
            width: calc(100% - 94.275px) !important;
            height: 36px !important;
        }

        .select2-container--default .select2-selection--single {
            border: 1px solid #e3ebf6 !important;
            height: 36px !important;
        }

        .select2-results__option {
            color: black;
        }
    </style>
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

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
                                    <h4 class="page-title">Registrar Orden de Compra de Servicio</h4>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">Servicios</a></li>
                                        <li class="breadcrumb-item active">Ordenes de Compra Cliente</li>
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
                                <p class="card-title">Datos Orden de Servicio</p>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="nro-orden">Numero de Orden</label>
                                                <input type="number" class="form-control" id="nro-orden" placeholder="450039757" min="0">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="fecha-orden">Fecha</label>
                                                <input type="date" class="form-control" id="fecha-orden">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="mb-3">
                                                <label class="form-label" style="display: block !important;" for="cliente">Cliente</label>
                                                <!-- <input type="text" class="form-control" id="buscar-cliente" placeholder="Cliente ...">
                                                <input type="text" hidden id="cliente-id"> -->
                                                <select name="cliente" class="form-select" id="id-cliente">
                                                    <option></option>
                                                    <?php
                                                    foreach ($Cliente->verFilas() as $fila){
                                                        echo "<option value=".$fila['id'].">".$fila['nombre_corto']." | ".$fila['razon_social']."</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <!-- <div class="col mb-3 d-flex align-items-end">
                                                <button class="btn btn-blue "><i class="fa fa-plus"></i> Nuevo Cliente</button>
                                            </div> -->
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="moneda">Tipo de Moneda</label>
                                                <select class="form-control" name="moneda" id="id-moneda">
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
                                                <label class="form-label" for="monto">Monto</label>
                                                <input type="number" class="form-control" id="monto" placeholder="00.00" min="0">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label" for="nombre-corto">Nombre del Servicio</label>
                                                <input type="text" class="form-control" id="nombre-corto" placeholder="Nombre corto ...">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div><!--end card-body-->
                            <div class="card-footer">
                                <div class="col-auto align-self-center">
                                    <button class="btn btn-sm btn-soft-primary" id="btn-registrar">
                                        <i data-feather="plus" class="fas fa-plus mr-2"></i>
                                        Guardar Cotizacion
                                    </button>
                                </div><!--end col-->
                            </div>
                        </div><!--end card-->
                    </div> <!-- end col -->
                </div> <!-- end row -->
            </div><!-- container -->
            <!-- Button trigger modal -->
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

    <!-- CDN -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- App js -->
    <script src="../assets/js/app.js"></script>

    <script>
        $('#id-cliente').select2({
            placeholder: "Seleccionar Cliente"
        });

        $('#btn-registrar').click(function(){
            let datos = {
                'nro-orden': $('#nro-orden').val(),
                'fecha-orden': $('#fecha-orden').val(),
                'id-cliente': $('#id-cliente').val(),
                'id-moneda': $('#id-moneda').val(),
                'monto' : $('#monto').val(),
                'nombre-corto' : $('#nombre-corto').val(),
            };
            console.log(datos);
            $.post('../controller/registrar-orden-servicio-cliente.php',datos,function(data){
                alert(data);
                let resultdata = JSON.parse(data);
                if (resultdata) {
                if (resultdata.success) {
                    Swal.fire({
                        title: 'Tarea Registrado',
                        text: '',
                        type: 'success',
                        icon: 'success',
                        confirmButtonText: 'Ok',
                    }).then((result) => {
                        if (result.value) {
                            window.location.href = '../contents/lista-ordenes-compras-clientes.php';
                        }
                    });
                }
            } else {
                alert(data);
            }
            });
        });
    </script>

</body>


<!-- Mirrored from mannatthemes.com/dastone/default/horizontal-index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 21 May 2021 20:35:01 GMT -->

</html>