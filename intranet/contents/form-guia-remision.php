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
                                    <h4 class="page-title">Registrar Guia de Remision</h4>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">Ventas</a></li>
                                        <li class="breadcrumb-item active">Guia de Remision</li>
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
                                <p class="card-title">Datos de la Guia</p>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="documento">Doc.</label>
                                                <input type="text" class="form-control" id="documento" placeholder="Guia de Remision">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="mb-3">
                                                <label class="form-label" for="serie">Serie</label>
                                                <input type="text" class="form-control" id="serie">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="mb-3">
                                                <label class="form-label" for="nro">Numero</label>
                                                <input type="text" class="form-control" id="nro">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="fecha-emision">Fecha</label>
                                                <input type="date" class="form-control" id="fecha-emision" value="<?php echo date("Y-m-d") ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- id de sede -->
                                    <input type="text" hidden id="id-sede" value="1"">
                                    <div class=" row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label" for="direccion">Direcciòn</label>
                                            <input type="text" class="form-control" id="direccion">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label" for="ubigeo">Ubigeo</label>
                                            <input type="text" class="form-control" id="ubigeo">
                                        </div>
                                    </div>
                            </div>
                            </form>
                        </div><!--end card-body-->
                    </div><!--end card-->
                    <div class="panel panel-default"></div>
                    <div class="card">
                        <div class="card-header">
                            <p class="card-title">Datos del Destino</p>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label" for="direcciondestino">Direcciòn</label>
                                            <input type="text" class="form-control" id="direccion-destino">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="mb-3">
                                            <label class="form-label" for="ubigeodestino">Ubigeo</label>
                                            <input type="text" class="form-control" id="ubigeo-destino">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div><!--end card-body-->
                    </div><!--end card-->
                    <div class="card">
                        <div class="card-header">
                            <p class="card-title">Datos del Transporte</p>
                        </div>
                        <div class="card-body">
                            <form>
                                <!-- id vehiculo -->
                                <input type="text" hidden id="id-vehiculo" value="1">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label" for="placa">Placa del Vehiculo</label>
                                            <input type="text" class="form-control" id="placa">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="mb-3">
                                            <label class="form-label" for="marca">Marca</label>
                                            <input type="text" class="form-control" id="marca">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label" for="modelo">Modelo</label>
                                            <input type="text" class="form-control" id="modelo">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div><!--end card-body-->
                    </div><!--end card-->
                    <div class="card">
                        <div class="card-header">
                            <p class="card-title">Agregar items a la guia</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="input-descripcion">Buscar items</label>
                                        <input type="text" class="form-control" id="input-descripcion">
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
                                        <label class="form-label" for="cantidad">Cantidad</label>
                                        <input type="number" value="1" class="form-control text-right" id="cantidad" placeholder="1">
                                    </div>
                                </div>
                            </div>
                        </div><!--end card-body-->
                        <div class="card-footer">
                            <div class="col-auto align-self-center">
                                <a href="#" class="btn btn-sm btn-soft-primary">
                                    <i data-feather="plus" class="fas fa-plus mr-2"></i>
                                    Agregar item
                                </a>
                            </div><!--end col-->
                        </div><!--end card-footer-->
                    </div><!--end card-->
                    <div class="card">
                        <div class="card-header">
                            <p class="card-title">Lista de Items</p>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>Cant.</td>
                                        <td>Und. MEd.</td>
                                        <td>Descripcion</td>
                                        <td>Costo</td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>12</td>
                                        <td>m</td>
                                        <td>Descripcion de item</td>
                                        <td>S/ 00.00</td>
                                        <td class="text-center"><a href="" class=" btn btn-danger"><i class="fa fa-trash"></i></a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <div class="col-auto align-self-center">
                                <button class="btn btn-sm btn-soft-primary" id="btnregistrar">
                                    <i data-feather="save" class="fas fa-save"></i>
                                    Guardar Guia de Remision
                                </button>
                            </div><!--end col-->
                        </div><!--end card-body-->
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
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- App js -->
    <script src="../assets/js/app.js"></script>

    <script>
        $('#btnregistrar').click(function() {
            let datos = {
                'fecha-emision': $('#fechaemision').val(),
                'serie': $('#serie').val(),
                'nro': $('#nro').val(),
                'ubigeo-destino': $('#ubigeodestino').val(),
                'direccion-destino': $('#direcciondestino').val(),
                'id-sede': $('#id-sede').val(),
                'id-vehiculo': $('#id-vehiculo').val()
            }
            $.post("../controller/registrar-guia-remision.php", datos, function(data) {
                alert(data);
                let resultdata = JSON.parse(data);
                if (resultdata) {
                    if (resultdata.success) {
                        Swal.fire({
                            title: "Guia de Remision Registrado",
                            icon: 'success',
                            type: 'success',
                            confirmButtonText: 'Ok'
                        }).then((result) => {
                            if (result.value) {
                                window.location.href = 'lista-guia-remision.php';
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: data
                        });
                    }
                }
            });
            console.log(datos);
        });
    </script>

</body>


<!-- Mirrored from mannatthemes.com/dastone/default/horizontal-index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 21 May 2021 20:35:01 GMT -->

</html>