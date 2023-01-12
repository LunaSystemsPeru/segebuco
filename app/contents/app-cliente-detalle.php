<?php
include '../fixed/cargarSession.php';
$namepage = basename(__FILE__);
require '../../models/Cliente.php';
require '../../models/Prestamo.php';
require '../../tools/Util.php';
$Cliente = new Cliente();
$Prestamo = new Prestamo();
$Util = new Util();
$Cliente->setId(filter_input(INPUT_GET, 'id'));
if ($Cliente->getId()) {
    $Cliente->obtenerDatos();
    $Prestamo->setClienteid($Cliente->getId());
} else {
    header("Location: ../app-prestamos.php");
}

?>
<!doctype html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover"/>
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
</head>

<body class="bg-white">

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
        Datos del Cliente
    </div>
    <div class="right">
        <a href="#" class="headerButton" data-bs-toggle="modal" data-bs-target="#DialogBasic">
            <ion-icon name="trash-outline"></ion-icon>
        </a>
    </div>
</div>
<!-- * App Header -->

<!-- Dialog Basic -->
<div class="modal fade dialogbox" id="DialogBasic" data-bs-backdrop="static" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete</h5>
            </div>
            <div class="modal-body">
                Are you sure?
            </div>
            <div class="modal-footer">
                <div class="btn-inline">
                    <a href="#" class="btn btn-text-secondary" data-bs-dismiss="modal">CANCEL</a>
                    <a href="#" class="btn btn-text-primary" data-bs-dismiss="modal">DELETE</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- * Dialog Basic -->

<!-- App Capsule -->
<div id="appCapsule" class="full-height">

    <div class="section mt-2 mb-2">

        <!--
        <div class="listed-detail mt-3">
            <div class="icon-wrapper">
                <div class="iconbox">
                    <ion-icon name="arrow-forward-outline"></ion-icon>
                </div>
            </div>
            <h3 class="text-center mt-2">Payment Sent</h3>
        </div>
        -->

        <ul class="listview flush transparent simple-listview no-space mt-3">
            <li>
                <strong>Datos</strong>
                <span class="text-info"><?php echo $Cliente->getDatos() . $Cliente->getId()?></span>
            </li>
            <li>
                <strong>Referencia</strong>
                <span><?php echo $Cliente->getReferencia() . " - " . $Cliente->getCargo() ?></span>
            </li>
        </ul>


    </div>

    <div class="section mt-2 mb-2">
        <div class="section-title">Prestamos activos</div>
        <?php
        $contarprestamos = 0;
        $sumadeuda = 0;
        $a_prestamos = $Prestamo->verPrestamosxCliente();
        foreach ($a_prestamos as $fila) {
            $contarprestamos++;
            ?>
            <div class="card-block mb-2">
                <div class="card-main">
                    <div class="card-button dropdown">
                        <button type="button" class="btn btn-link btn-icon" data-bs-toggle="dropdown">
                            <ion-icon name="ellipsis-horizontal"></ion-icon>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="#">
                                <ion-icon name="pencil-outline"></ion-icon>
                                Ver Cuotas
                            </a>
                            <a class="dropdown-item" href="#">
                                <ion-icon name="close-outline"></ion-icon>
                                Eliminar
                            </a>
                        </div>
                    </div>
                    <div class="balance">
                        <span class="label">total a Pagar (capital solicitado)</span>
                        <h1 class="title"><?php echo number_format($fila['deudatotal'],2 ) . "     (".number_format($fila['montoprestamo'],2).")"?></h1>
                    </div>
                    <div class="in">
                        <div class="card-number">
                            <span class="label">Deuda del Prestamo</span>
                            <?php echo number_format($fila['deudaactual'],2 )?>
                        </div>
                        <div class="bottom">
                            <div class="card-expiry">
                                <span class="label">Periodo Pago</span>
                                <?php echo $fila['tipocuota'] ?>
                            </div>
                            <div class="card-ccv">
                                <span class="label">Monto Cuota</span>
                                <?php echo "S/ " . number_format($fila['montocuota'],2 ) . " x # " . $fila['nrocuotas'] ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $sumadeuda +=  $fila['deudaactual'];
        }
        ?>
    </div>
    <?php
    if ($contarprestamos > 0) {
        ?>
        <div class="section mt-2 mb-2">
            <a href="app-prestamos-cuotas.php?idcliente=<?php echo $Cliente->getId()?>" class="btn btn-outline-info btn-block btn-lg">ver Resumen Pagos</a>
        </div>
    <?php
    }
    ?>


    <div class="section mt-2 mb-2">
        <ul class="listview flush transparent simple-listview no-space mt-3">
            <li>
                <strong>Total Deuda</strong>
                <span><?php echo number_format($sumadeuda, 2) ?></span>
            </li>
        </ul>


    </div>


    <div class="section mt-2 mb-2">
        <a href="app-prestamo-registro.php?clienteid=<?php echo $Cliente->getId()?>" class="btn btn-success btn-block btn-lg">nuevo Prestamo</a>
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