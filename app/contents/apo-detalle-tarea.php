<?php
include '../fixed/cargarSession.php';
$namepage = basename(__FILE__);

require '../../tools/Util.php';
require '../../models/TareaDiaria.php';
require '../../models/TareaColaboradores.php';
include '../../models/EmbarcacionCliente.php';
include '../../models/Colaboradores.php';
include '../../models/Embarcacion.php';
include '../../models/ParametrosOpciones.php';

$Util = new Util();
$Tarea = new TareaDiaria();
$Embarcacion = new Embarcacion();
$Maestro = new Colaboradores();
$Servicio = new ParametrosOpciones();
$Obreros = new TareaColaboradores();

$Tarea->setId(filter_input(INPUT_GET, 'id'));
$Tarea->obtenerDatos();

$Maestro->setId($Tarea->getIdmaestro());
$Maestro->obtenerDatos();

$Embarcacion->setId($Tarea->getIdembarcacion());
$Embarcacion->obtenerDatos();

$Servicio->setId($Tarea->getIdtiposervicio());
$Servicio->obtenerDatos();

$Obreros->setIdtarea($Tarea->getId());
$l_obreros = $Obreros->verFilas();

?>
<!doctype html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>SEGEBUCO</title>
    <meta name="description" content="SEGEBUCO APP - Control de Servicios">
    <meta name="keywords" content="SEGEBUCO APP - Control de Servicios" />
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/img/icon/192x192.png">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="manifest" href="__manifest.json">
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
            Resumen de la Tarea Diaria
        </div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="section mt-2 mb-2">
            <div class="goals">
                <div class="item">
                    <div class="pb-1 mb-2 border-bottom border-2 row">
                        <div class="col-8 col-xxl-11 col-md-10">
                            <label for="" class="fw-bold text-dark">Nombre de la Tarea:</label>
                            <p class="text-body fs-6 ps-1"><?php echo $Tarea->getNombre(); ?></p>
                        </div>
                        <div class="col-xxl-1 col-3 col-md-2">
                            <label for="" class="fw-bold text-dark">Estado:</label>
                            <p class="text-dark fs-6">
                                <?php switch ($Tarea->getEstado()) {
                                    case 0:
                                        echo "En Proceso";
                                        break;
                                    case 1:
                                        echo "Finalizado";
                                        break;
                                    case 2:
                                        echo "Con Cotización";
                                        break;
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                    <div class="row pb-1 mb-2 border-bottom border-2">
                        <div class="col-md-4 row justify-content-between border-end border-2 me-1">
                            <div class="col-5 col-md-7">
                                <label for="" class="fw-bold text-dark">Fecha de Registro:</label>
                            </div>
                            <div class="col-auto">
                                <p class="text-body fs-6"><?php echo $Tarea->getFecharegistro(); ?></p>
                            </div>
                        </div>
                        <div class="col-md-4 row justify-content-between border-end border-2 me-1">
                            <div class="col-5 col-md-7">
                                <label for="" class="fw-bold text-dark">Fecha de Inicio:</label>
                            </div>
                            <div class="col-auto">
                                <p class="text-body fs-6"><?php echo $Tarea->getFechainicio(); ?></p>
                            </div>
                        </div>
                        <div class="col-md-4 row justify-content-between border-end border-2 me-1">
                            <div class="col-5 col-md-7">
                                <label for="" class="fw-bold text-dark">Fecha de Culminación:</label>
                            </div>
                            <div class="col-auto">
                                <p class="text-body fs-6"><?php echo $Tarea->getFechatermino(); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="pb-1 mb-2 border-bottom border-2">
                        <label for="" class="fw-bold text-dark">Tipo de Servicio:</label>
                        <p class="text-body fs-6 ps-1"><?php echo $Servicio->getDescripcion(); ?></p>
                    </div>
                    <div class="pb-1 mb-2 border-bottom border-2">
                        <label for="" class="fw-bold text-dark">Maestro:</label>
                        <p class="text-body fs-6 ps-1"><?php echo $Maestro->getDatos(); ?></p>
                    </div>
                    <div class="pb-1 mb-2 border-bottom border-2">
                        <label for="" class="fw-bold text-dark">Embarcación:</label>
                        <p class="text-body fs-6 ps-1"><?php echo $Embarcacion->getNOmbre(); ?></p>
                    </div>
                    <div class="pb-1 mb-2 border-bottom border-2">
                        <label for="" class="fw-bold text-dark">Motorista:</label>
                        <p class="text-body fs-6 ps-1"><?php echo $Tarea->getMotorista(); ?></p>
                    </div>
                    <div class="pb-1 mb-2 border-bottom border-2">
                        <label for="" class="fw-bold text-dark">Cotizacion:</label>
                        <p class="text-body fs-6 ps-1"><?php ?></p>
                    </div>
                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label for="" class="fw-bold text-dark">Descripción de Actividad:</label>
                            <textarea rows="7" class="form-control ps-1" disabled id="input-descripcion" name="input-descripcion" required><?php echo $Tarea->getDescripcion(); ?> </textarea>
                        </div>
                    </div>
                    <div class="pb-1 mb-2 border-bottom border-2">
                        <label for="" class="fw-bold text-dark">Trabajadores:</label>
                        <ul class="list-group list-group-flush list-group-numbered">
                            <?php foreach ($l_obreros as $fila) { ?>
                                <li class="list-group-item"><?php echo $fila['datos']; ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="text-center">
                        <a href="app-tarea-registro.php?id=<?php echo $Tarea->getId(); ?>" type="button" onclick="" class="btn btn-outline-warning">
                            <ion-icon name="barcode-outline"></ion-icon>
                            Modificar Tarea
                        </a>
                    </div>
                </div>
            </div>
        </div>
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


</body>

</html>