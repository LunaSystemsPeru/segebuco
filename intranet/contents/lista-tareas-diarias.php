<?php
/*
error_reporting(-1);
error_reporting(0);
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
*/
include '../fixed/cargarSession.php';
require '../../models/TareaDiaria.php';
include '../../models/Colaboradores.php';
include '../../models/Embarcacion.php';

$Tarea = new TareaDiaria();
$Maestro = new Colaboradores();
$Embarcacion = new Embarcacion();

$Maestro->setIdcargo(2); //ID del cargo del colaborador 'Maestro'
$Maestro->setEstado(1); //Estado Activo - Incativo
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
                                <h4 class="page-title">Tareas Diarias</h4>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Flota</a></li>
                                    <li class="breadcrumb-item active">Tareas Diarias</li>
                                </ol>
                            </div><!--end col-->
                            <div class="col-3">
                                <input type="text" id="datos" class="form-control" placeholder="Busqueda por Maestro o Embarcación ..." oninput="mostrar_lista()">
                            </div>
                            <div class="col-auto align-self-center">
                                <button class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#filtro-busqueda">
                                    <i data-feather="filter" class="align-self-center fa-bars-filter"></i> Filtrar Datos
                                </button>
                            </div><!--end col-->
                        </div><!--end row-->
                    </div><!--end page-title-box-->
                </div><!--end col-->
            </div><!--end row-->
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
                                    <tbody id="list-tarea-diaria">
                                    <?php foreach ($Tarea->verTareas() as $clave => $fila) {
                                        switch ($fila['estado']) {
                                            case 0:
                                                $estado = '<span class="badge badge-warning">En Proceso</span>';
                                                $opcion = '';
                                                break;
                                            case 1:
                                                $estado = '<span class="badge badge-blue">Pendiente</span>';
                                                $opcion = '<a onclick="idcotizacion(' . $fila['id'] . ')" class="btn btn-info btn-sm" data-toggle="modal" data-target="#cotizacion"><i class="fa fa-money-check"></i></a>';
                                                break;
                                            case 2:
                                                $estado = '<span class="badge badge-success">Cotizado</span>';
                                                $opcion = '';
                                                break;
                                        }
                                        $fecha = str_split($fila['fecha_registro'], 10);
                                        ?>
                                        <tr>
                                            <th scope="row"><?php echo $clave + 1 ?></th>
                                            <td class="text-center"><?php echo $fecha[0] ?></td>
                                            <td><?php echo $fila['nombre_corto'] ?></td>
                                            <td><?php echo $fila['datos'] ?></td>
                                            <td><?php echo $fila['ncliente'] ?></td>
                                            <td><?php echo $fila['nep'] ?></td>
                                            <td><?php echo $fila['tiposervicio'] ?></td>
                                            <td><?php echo $estado ?></td>
                                            <td class="text-center"><?php echo $opcion ?></td>
                                        </tr>
                                    <?php } ?>
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

    <div class="modal fade" id="filtro-busqueda" tabindex="-1" role="dialog" aria-labelledby="exampleModalDefaultSignup" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title m-0" id="exampleModalDefaultLogin">Filtrar Tareas Diarias</h6>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div><!--end modal-header-->
                <div class="modal-body">
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link" id="nav-datos-tab" data-bs-toggle="tab" data-bs-target="#nav-datos" type="button" role="tab" aria-controls="nav-datos" aria-selected="true">Datos</button>
                        <button class="nav-link active" id="nav-fecha-tab" data-bs-toggle="tab" data-bs-target="#nav-fecha" type="button" role="tab" aria-controls="nav-fecha" aria-selected="true">Fecha</button>
                    </div>
                    <form class="tab-content mt-2" id="nav-tabContent">
                        <div class="tab-pane fade" id="nav-datos" role="tabpanel" aria-labelledby="nav-datos-tab" tabindex="0">
                            <div class="form-group">
                                <label for="maestro" class="form-label">Maestro</label>
                                <div class="input-group">
                                    <select id="maestro" class="form-control">
                                        <option value="" hidden>Seleccione Maestro</option>
                                        <?php foreach ($Maestro->verFilas() as $fila) {
                                            echo '<option value="' . $fila['datos'] . '">' . $fila['datos'] . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="embarcacion" class="form-label">Embarcación</label>
                                <div class="input-group">
                                    <select id="embarcacion" class="form-control">
                                        <option value="" hidden>Seleccionar Embarcación</option>
                                        <?php foreach ($Embarcacion->verFilas() as $fila) {
                                            echo '<option value="' . $fila['nombre'] . '">' . $fila['nombre'] . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show active" id="nav-fecha" role="tabpanel" aria-labelledby="nav-fecha-tab" tabindex="0">
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
                        </div>
                    </form>
                </div><!--end auth-page-->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-soft-primary btn-sm" onclick="mostrar_lista()" data-dismiss="modal">Buscar</button>
                    <button type="button" class="btn btn-soft-secondary btn-sm" onclick="limpiar_seleccion()" data-dismiss="modal">Cancelar</button>
                </div><!--end modal-footer-->
            </div><!--end modal-body-->
        </div><!--end modal-content-->
    </div><!--end modal-dialog-->

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

<!-- App js -->
<script src="../assets/js/app.js"></script>

<script src="../assets/js/tabs.js"></script>

<script>
    function idcotizacion(id) {
        let url = ($("#btn-simple").attr('href'));
        $("#btn-simple").attr('href', url + '?id=' + id)
        // let url = ($("#btn-completa").attr('href'));
        // $("#btn-completa").attr('href',url+'?id='+id)
    }

    function limpiar_seleccion() {
        $('#maestro option[value=""]').attr("selected", false);
        $('#maestro option[value=""]').attr("selected", true);
        $('#embarcacion option[value=""]').attr("selected", false);
        $('#embarcacion option[value=""]').attr("selected", true);
    }

    function mostrar_lista() {
        let maestro = $("#maestro").val();
        let embarcacion = $("#embarcacion").val();
        if (maestro == "" && embarcacion == "") {
            maestro = $("#datos").val();
            embarcacion = $("#datos").val();
        } else {
            limpiar_seleccion();
        }

        let datos = {
            'maestro': maestro,
            'embarcacion': embarcacion,
            'f-inicio': $("#fecha-inicio").val(),
            'f-fin': $("#fecha-final").val(),
        }
        console.log(datos);
        $.ajax({
            data: datos,
            type: "POST",
            url: "../json/ver-lista-tareas-diarias.php",
            success: function (date) {
                $("#list-tarea-diaria").html(date);
            }
        });
    }
</script>

</body>


<!-- Mirrored from mannatthemes.com/dastone/default/horizontal-index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 21 May 2021 20:35:01 GMT -->

</html>