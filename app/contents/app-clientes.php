<?php
require  '../fixed/cargarSession.php';
$namepage = basename(__FILE__);
require '../../models/Cliente.php';
require '../../tools/Util.php';
$Cliente = new Cliente();
$Util = new Util();
$a_clientes = $Cliente->verClientesAPP($_SESSION['usuarioid']);
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
        Clientes
    </div>
    <div class="right">
        <a href="app-notifications.html" class="headerButton">
            <ion-icon class="icon" name="notifications-outline"></ion-icon>
            <span class="badge badge-danger">4</span>
        </a>
    </div>
</div>
<!-- * App Header -->


<!-- App Capsule -->
<div id="appCapsule">

    <!-- Transactions -->
    <div class="section mt-2">
        <div class="section-title">Lista Clientes (se muestra deuda actual)</div>
        <div class="transactions">
            <?php
            $item = 1;
            $fecha_actual = date("Y-m-d");
            $fecha_30dias = $Util->restarDiasFecha($fecha_actual, 2, 30);
            $fecha_60dias = $Util->restarDiasFecha($fecha_actual, 2, 60);
            $colorlabel = 'success';
            foreach ($a_clientes as $fila) {
                $fechapago = $fila['fechaultimopago'];
                $deudaactual = $fila['deudaactual'];
                $labelFechaPago = '<label class="badge badge-success">' . $fechapago . '</label>';
                $fechamayora30dias = $Util->fechaEsMayor($fechapago, $fecha_30dias);
                $fechamayora60dias = $Util->fechaEsMayor($fechapago, $fecha_60dias);
                $fechaentre30y60dias = false;
                if (!$fechamayora30dias && $fechamayora60dias) {
                    $fechaentre30y60dias = true;
                }

                if ($fechapago == '2000-01-01') {
                    $colorlabel = 'dark';
                    $labelFechaPago = '<span class="badge badge-' . $colorlabel . '">NO HIZO PAGOS</span>';
                } else {
                    if ($fechamayora30dias) {
                        $colorlabel = 'success';
                        $labelFechaPago = '<span class="badge badge-' . $colorlabel . '">Puntual</span>';
                    } else if ($fechaentre30y60dias) {
                        $colorlabel = 'warning';
                        $labelFechaPago = '<span class="badge badge-' . $colorlabel . '">Atrasado desde ' . $fechapago . '</span>';
                    } else {
                        $colorlabel = 'danger';
                        $labelFechaPago = '<span class="badge badge-' . $colorlabel . '">Moroso desde ' . $fechapago . '</span>';
                    }
                }

                if ($deudaactual < 1) {
                    $colorlabel = 'info';
                    $labelFechaPago = 'Sin deuda';
                }
                ?>
                <!-- item -->
                <a href="app-cliente-detalle.php?id=<?php echo $fila['idcliente'] ?>" class="item">
                    <div class="detail">
                        <img src="../assets/img/sample/brand/1.jpg" alt="img" class="image-block imaged w48">
                        <div>
                            <strong><?php echo $fila['datos'] ?></strong>
                            <p><?php echo $labelFechaPago ?></p>
                        </div>
                    </div>
                    <div class="right">
                        <div class="price text-<?php echo $colorlabel ?>"><?php echo number_format($deudaactual) ?></div>
                    </div>
                </a>
                <!-- * item -->
                <?php
                $item++;
            }
            ?>

        </div>
    </div>
    <!-- * Transactions -->


    <div class="section mt-2 mb-2">
        <a href="app-cliente-registro.php" class="btn btn-primary btn-block btn-lg">nuevo Solicitante</a>
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