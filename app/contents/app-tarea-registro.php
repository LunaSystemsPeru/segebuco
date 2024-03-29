<?php
include '../fixed/cargarSession.php';
include '../../models/EmbarcacionCliente.php';
include '../../models/Colaboradores.php';
include '../../models/Embarcacion.php';
include '../../models/ParametrosOpciones.php';
include '../../models/TareaDiaria.php';
include '../../models/TareaColaboradores.php';

$namepage = basename(__FILE__);
$Cliente = new EmbarcacionCliente();
$Embarcacion = new Embarcacion();
$Maestro = new Colaboradores();
$Trabajador = new Colaboradores();
$Obrero = new TareaColaboradores();
$Servicio = new ParametrosOpciones();
$Tarea = new TareaDiaria();

$arr = array();

$Tarea->setId(filter_input(INPUT_GET, 'id'));
if ($Tarea->getId()) {
    $Tarea->obtenerDatos();

    $Obrero->setIdtarea($Tarea->getId());
    $l_obrero = $Obrero->verFilas();
    foreach ($l_obrero as $fila) {
        $arr[] = $fila['id'];
    }
}

$Maestro->setEstado(1); //Estado 1 activo , 0 inactivo
$l_maestro = $Maestro->verFilas();
$Trabajador->setEstado(1); //Estado 1 activo , 0 inactivo
$l_trabajador = $Trabajador->verObreros();
$l_cliente = $Cliente->verFilas();
$l_embarcacion = $Embarcacion->verFilas();
$Servicio->setIdparametro(2); //tipo de servicio a mostrar de acuerdo a la tabla parametros
$l_servicio = $Servicio->verFilas();

?>
<!doctype html>
<html lang="es">

<head>
    <style>
        .select2 {
            width: calc(100% - 94.275px) !important;
            height: 36px !important;
        }

        .select2-container--default .select2-selection--single {
            border: none !important;
            height: 36px !important;
        }

        .select2-results__option {
            color: black;
        }
    </style>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>SEGEBUCO</title>
    <meta name="description" content="SEGEBUCO APP - Control de Servicios">
    <meta name="keywords" content="SEGEBUCO APP - Control de Servicios"/>
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/img/icon/192x192.png">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="manifest" href="__manifest.json">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
</head>

<body>

<!-- loader -->
<div id="loader">
    <img src="../assets/img/loading-icon.png" alt="icon" class="loading-icon">
</div>
<!-- * loader -->

<!-- App Header -->
<div class="appHeader">
    <div class="left">
        <a href="#" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">
        Registrar Tarea Diaria
    </div>

</div>
<!-- * App Header -->


<!-- App Capsule -->
<div id="appCapsule">

    <!-- Transactions -->
    <div class="section mt-2 mb-2">
        <div class="card">
            <div class="card-body">
                <form id="formulario" novalidate>
                    <input type="hidden" id="hidden-id-tarea" value="<?php echo $Tarea->getId(); ?>">
                    <input type="hidden" id="hidden-estado" value="<?php echo ($Tarea->getId()) ? $Tarea->getEstado() : '0'; ?>">
                    <!--
                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label fw-bold" for="text4">Tipo Servicio:</label>
                            <select class="form-select" id="select-servicio" name="select-servicio">
                                <?php foreach ($l_servicio as $fila) { ?>
                                    <option value="<?php echo $fila['id']; ?>"><?php echo $fila['descripcion']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    -->

                    <div class="form-group basic">
                        <div class="input-group">
                            <label class="label w-100 pb-1 fw-bold" for="select-embarcacion">E/P:</label>
                            <select name="select-embarcacion" id="select-embarcacion">
                                <option></option>
                                <?php foreach ($l_embarcacion as $fila) { ?>
                                    <option value="<?php echo $fila['id']; ?>"><?php echo $fila['nombre']; ?></option>
                                <?php } ?>
                            </select>
                            <button class="btn btn-outline-dark" type="button" data-bs-toggle="modal" data-bs-target="#modalEmbarcacion" data-bs-whatever="@mdo" id="btnemb">+ Nuevo</button>
                        </div>
                    </div>

                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label fw-bold" for="select-maestro">MAESTRO</label>
                            <select class="form-select" name="select-maestro" id="select-maestro">
                                <?php foreach ($l_maestro as $fila) { ?>
                                    <option value="<?php echo $fila['id']; ?>"><?php echo $fila['datos']; ?></option>
                                <?php } ?>
                            </select>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label fw-bold" for="input-motorista">Motorista</label>
                            <input type="text" class="form-control" id="input-motorista" name="input-motorista" value="<?php echo $Tarea->getMotorista(); ?>" placeholder="Nombre y Apellidos Motorista" required>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label fw-bold" for="input-tarea">Nombre de la tarea</label>
                            <input type="text" class="form-control" id="input-tarea" name="input-tarea" value="<?php echo $Tarea->getNombre(); ?>" placeholder="Nombre corto de la actividad" required>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label fw-bold" for="input-descripcion">Actividad/Trabajo/Sistema:</label>
                            <textarea class="form-control" id="input-descripcion" rows="5" name="input-descripcion" required placeholder="Descripcion detallada de la actividad, pasos"><?php echo $Tarea->getDescripcion(); ?></textarea>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label fw-bold" for="input-inicio">fecha Inicio</label>
                            <input type="datetime-local" class="form-control" id="input-inicio" name="input-inicio" value="<?php echo ($Tarea->getFechainicio() ? $Tarea->getFechainicio() : "")  ?>" autocomplete="off" required>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group basic mb-2">
                        <div class="input-wrapper">
                            <label class="label fw-bold" for="input-fin">Fecha Fin</label>
                            <input type="datetime-local" class="form-control" id="input-fin" name="input-fin" value="<?php echo $Tarea->getFechatermino(); ?>" autocomplete="off" required>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label fw-bold">Trabajadores</label>
                            <div class="input-list">
                                <?php foreach ($l_trabajador as $fila) { ?>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" <?php echo (in_array($fila['id'], $arr)) ? "checked" : ""; ?> id="<?php echo 't' . $fila['id']; ?>" value="<?php echo $fila['id']; ?>">
                                        <label class="form-check-label" for="<?php echo 't' . $fila['id']; ?>"><?php echo $fila['datos']; ?></label>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>


                    <div class="form-group basic mb-2">
                        <div class="input-wrapper">
                            <label class="label fw-bold" for="input-fin">Estado</label>
                            <select class="form-select" name="select-estado" id="select-estado" onchange="verificaEstado()">
                                <option value="1">FINALIZADO</option>
                                <option value="0">EN PROCESO</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group basic mb-2">
                        <div class="input-wrapper">
                            <label class="label fw-bold" for="customRange1">% Avance</label>
                            <input type="range" class="form-range" id="customRange1" value="100" oninput="this.nextElementSibling.value = this.value">
                            <output id="output-ranger">100</output>
                        </div>
                    </div>

                    <!--
                    escribir nro de guia
                    -->
                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label fw-bold" for="input-inicio">Nro de Guia</label>
                            <input type="text" class="form-control" id="input-guia" name="input-guia" value="<?php echo $Tarea->getGuia(); ?>" autocomplete="off" placeholder="Serie-Numero de Guia">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <!-- <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label" for="input-nr-cotizacion">Nro. Cotizacion</label> -->
                    <input type="datetime-local" hidden id="input-nr-cotizacion" name="input-nr-cotizacion" value="<?php echo 1; ?>">
                    <!-- <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div> -->
                </form>
                <div class="modal fade" id="modalEmbarcacion" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title">AGREGAR EMBARCACIÓN</h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="mb-3">
                                        <label for="input-nombre" class="col-form-label">Nombre:</label>
                                        <input type="text" class="form-control" id="input-nombre" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="select-cliente" class="col-form-label">Cliente:</label>
                                        <select class="form-select" name="select-cliente" id="select-cliente">
                                            <?php foreach ($l_cliente as $fila) { ?>
                                                <option value="<?php echo $fila['id']; ?>"><?php echo $fila['nombre_corto'] . ' | ' . $fila['razon_social']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Canselar</button>
                                <button type="button" class="btn btn-primary" onclick="registrarEmbarcacion()">Registrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <button type="button" id="btn-accion" onclick="registrar()" class="btn btn-outline-warning">
                    <ion-icon name="barcode-outline"></ion-icon>
                    Guardar Tarea
                </button>
            </div>
        </div>
    </div>

    <!-- * Transactions -->
</div>

<div id="toast-11" class="toast-box toast-center">
    <div class="in">
        <ion-icon name="alert-outline" class="text-danger" id="icon-color-message"></ion-icon>
        <div class="text" id="div-message">
            Success Message
        </div>
    </div>
    <button type="button" class="btn btn-sm btn-text-light close-button">CLOSE</button>
</div>
<!-- * App Capsule -->


<!-- App Bottom Menu -->
<?php
include '../fixed/bottom-menu.php';
?>
<!-- * App Bottom Menu -->


<!-- ========= JS Files =========  -->
<!-- Bootstrap -->
<script src="../assets/js/lib/bootstrap.bundle.min.js"></script>
<!-- Ionicons -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<!-- Splide -->
<script src="../assets/js/plugins/splide/splide.min.js"></script>
<!-- Base Js File -->
<script src="../assets/js/base.js"></script>
<!-- Jquery -->
<script src="../assets/js/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    if ("<?php echo $Tarea->getId() ?>") {
        $("#select-servicio option[value='<?php echo $Tarea->getIdTiposervicio() ?>']").attr("selected", true);
        $("#select-embarcacion option[value='<?php echo $Tarea->getIdembarcacion() ?>']").attr("selected", true);
        $("#select-mestro option[value='<?php echo $Tarea->getIdmaestro() ?>']").attr("selected", true);
        $("#btn-accion").html("<ion-icon name=barcode-outline></ion-icon> Actualizar Tarea");
    }

    $("#select-embarcacion").select2({
        placeholder: "Seleccionar Embarcación"
    });

    function registrar() {
        let trabajadores = [];

        $("input[type=checkbox]:checked").each(function () {
            trabajadores.push({
                'id': this.value
            });
        });

        let datos = {
            'hidden-id-tarea': $("#hidden-id-tarea").val(),
            'hidden-estado': $("#hidden-estado").val(),
            'select-servicio': $('#select-servicio').val(),
            'select-embarcacion': $('#select-embarcacion').val(),
            'input-motorista': $('#input-motorista').val(),
            'select-maestro': $('#select-maestro').val(),
            'input-nombre': $('#input-tarea').val(),
            'input-descripcion': $('#input-descripcion').val(),
            'input-inicio': $('#input-inicio').val(),
            'input-fin': $('#input-fin').val(),
            'input-nr-cotizacion': $('#input-nr-cotizacion').val(),
            'input-trabajadores': JSON.stringify(trabajadores),
            'select-estado' : $('#select-estado').val(),
            'input-porcentaje' : $('#customRange1').val()
            'input-guia' : $('#input-guia').val()
        };

        $.post('../controller/registrar-tareas.php', datos, function (data) {
            // alert(data);
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
                            window.location.href = '../contents/app-tareas.php';
                        }
                    });
                }
            } else {
                alert(data);
            }
        });
    }

    function registrarEmbarcacion() {
        let nombre = $("#input-nombre").val();
        if (nombre == "") {
            alert("Ingresar nombre de la embarcación");
            return;
        }
        let datos = {
            'input-nombre': nombre,
            'select-cliente': $("#select-cliente").val()
        }
        $.post('../controller/registrar-embarcacion.php', datos, function (data) {
            // alert(data);
            let resultdata = JSON.parse(data);
            if (resultdata) {
                if (resultdata.success) {
                    Swal.fire({
                        title: 'Embarcación Registrado',
                        text: '',
                        type: 'success',
                        icon: 'success',
                        confirmButtonText: 'Ok',
                        timer: 2500,
                        timerProgressBar: true
                    });
                    $("#select-embarcacion").append("<option value='" + resultdata.id + "' >" + resultdata.nombre + "</option>");
                    $("#select-embarcacion option[value=" + resultdata.id + "]").attr("selected", true);
                }
            } else {
                alert(data);
            }
        })
        $("#input-nombre").val("");
        $("#modalEmbarcacion").modal("toggle")
        console.log(datos);
    }

    function verificaEstado () {
        var selectEstado = document.getElementById('select-estado').value
        if (selectEstado === '1') {
            document.getElementById('customRange1').value = 100
            document.getElementById('output-ranger').value = 100
        } else {
            document.getElementById('customRange1').value = 30
            document.getElementById('output-ranger').value = 30
        }
    }
</script>
</body>

</html>