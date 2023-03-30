<?php
include '../../models/EmbarcacionCliente.php';
include '../../models/ParametrosOpciones.php';

$Cliente = new EmbarcacionCliente();
$Moneda = new ParametrosOpciones();

$idTarea = filter_input(INPUT_GET, 'id'); //id de tarea-diaria
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
                                    <input type="text" hidden value="<?php echo $idTarea ?>" id="id-tarea">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="id-usuario">Usuario Responsable</label>
                                                <input type="text" class="form-control" id="id-usuario" placeholder="Responsable ..." disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="nro">Nro. de Cotización</label>
                                                <input type="number" class="form-control" id="nro" placeholder="5195591672" min="0">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label" for="fecha-cotizacion">Fecha de Cotización</label>
                                                <input type="date" class="form-control" id="fecha-cotizacion" placeholder="fecha-cotizacion">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="nro-solped">Nro Solped</label>
                                                <input type="number" class="form-control" id="nro-solped" placeholder="2131849" min="0">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label" for="id-moneda">Tipo de Moneda</label>
                                                <select class="form-control" name="id-moneda" id="id-moneda">
                                                    <option hidden>Seleccionar tipo de moneda ...</option>
                                                    <?php
                                                    foreach ($Moneda->verFilas() as $fila) {
                                                        echo "<option value=" . $fila['id'] . ">" . $fila['descripcion'] . " | " . $fila['valor1'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="monto">Monto de Cotizacion</label>
                                                <input type="number" class="form-control" id="monto" placeholder="00.00" min="0">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="id-cliente">Cliente</label>
                                                <select class="form-control" name="id-cliente" id="id-cliente" onchange="ClienteEmbarcacion();">
                                                    <option hidden>Seleccionar Cliente ...</option>
                                                    <?php
                                                    foreach ($Cliente->verFilas() as $fila) {
                                                        echo "<option value=" . $fila['id'] . ">" . $fila['nombre_corto'] . " | " . $fila['razon_social'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="id-embarcacion">Embarcación</label>
                                                <select class="form-control" name="id-embarcacion" id="id-embarcacion" onchange="EmbarcacionTarea();">
                                                    <option hidden>Seleccionar Cliente Primero </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label" for="descripcion-cotizacion">Descripcion de la Cotización</label>
                                                <input type="text" class="form-control" id="descripcion-cotizacion" placeholder="Descripción corta de la cotización...">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div><!--end card-body-->
                            <div class="card-header">
                                <p class="card-title">Datos de la tarea</p>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label" for="tarea-diaria">Nombre de la Tarea</label>
                                                <select name="tarea-diaria" id="tarea-diaria" class="form-control" onchange="infoTarea()">
                                                    <option hidden>Seleccionar Embarcacion Primero </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="maestro">Maestro</label>
                                                <input type="text" class="form-control" id="maestro" placeholder="Maestro ..." disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label" for="descripcion-tarea">Descripcion</label>
                                                <textarea id="descripcion-tarea" name="descripcion-tarea" class="form-control" rows="1" disabled></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div><!--end card-body-->
                            <div class="card-footer">
                                <div class="col-auto align-self-center">
                                    <button id="btn-registrar" class="btn btn-sm btn-soft-primary">
                                        <i data-feather="plus" class="fas fa-plus mr-2"></i>
                                        Guardar Cotizacion
                                    </button>
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
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- App js -->
    <script src="../assets/js/app.js"></script>
    <script>
        let texth = $("#descripcion-tarea").height();
        $(document).ready(function() {
            let id = $("#id-tarea").val();
            if (id != "") {
                $.post("../json/info-tarea-diaria.php", {
                    'id-tarea': id
                }, function(data) {
                    // alert(data);
                    let resuldata = JSON.parse(data);
                    $("#id-cliente option[value=" + resuldata.id_cliente + "]").attr("selected", true);
                    ClienteEmbarcacion(resuldata.id_embarcacion);
                    EmbarcacionTarea(resuldata.id_tarea, resuldata.id_embarcacion);
                    $("#maestro").val(resuldata.maestro);
                    $("#descripcion-tarea").val(resuldata.descripcion);
                    $("#descripcion-tarea").height((resuldata.descripcion.split('\n').length * texth) + 'px');
                });
            }
        });

        function ClienteEmbarcacion(id = null) {
            let datos = {
                "id": $("#id-cliente").val(),
                "select": id
            };

            $.ajax({
                data: datos,
                type: "POST",
                url: "../json/ver-cliente-embarcacion.php",
                success: function(date) {
                    $("#id-embarcacion").html(date);
                }
            });
            limpiarInfoTarea();
            EmbarcacionTarea();
        }

        function EmbarcacionTarea(id = null, idem = null) {
            let datos = {
                "id-embarcacion": (idem != null) ? idem : $("#id-embarcacion").val(),
                "select": id
            }
            $.ajax({
                data: datos,
                type: "POST",
                url: "../json/ver-tarea-diaria.php",
                success: function(data) {
                    $("#tarea-diaria").html(data);
                }
            });
            limpiarInfoTarea();
        }

        function infoTarea() {
            let datos = {
                'id-tarea': $("#tarea-diaria").val()
            }
            $.post("../json/info-tarea-diaria.php", datos, function(data) {
                let resuldata = JSON.parse(data);
                $("#maestro").val(resuldata.maestro);
                $("#descripcion-tarea").val(resuldata.descripcion);
                $("#descripcion-tarea").height((resuldata.descripcion.split('\n').length * texth) + 'px');
            });
        }

        function limpiarInfoTarea() {
            $("#maestro").val("Maestro ...");
            $("#descripcion-tarea").val("");
            $("#descripcion-tarea").height(texth + 'px');
        }
        $("#btn-registrar").click(function() {
            let datos = {
                "nro": $("#nro").val(),
                "fecha-cotizacion": $("#fecha-cotizacion").val(),
                // "id-usuario" : $("#id-usuario").val(),
                "id-moneda": $("#id-moneda").val(),
                "monto": $("#monto").val(),
                "nro-solped": $("#nro-solped").val(),
                "id-cliente": $("#id-cliente").val(),
                "descripcion": $("#descripcion-cotizacion").val(),
                "id-embarcacion": $("#id-embarcacion").val(),
                "tarea-diaria": $("#tarea-diaria").val(),
            }
            //validación de campos vacios
            for (let item in datos) {
                console.log(item);
                if (item == "") {
                    alert("Datos incompletos");
                    return;
                }
            }
            console.log(datos);
            $.post("../controller/registrar-cotizacion.php", datos, function(data) {
                // alert(data);
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
                                window.location.href = 'lista-cotizaciones.php';
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
        });
    </script>

</body>


<!-- Mirrored from mannatthemes.com/dastone/default/horizontal-index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 21 May 2021 20:35:01 GMT -->

</html>