<?php
include '../fixed/cargarSession.php';
$namepage = basename(__FILE__);
require '../../models/Prestamo.php';
require '../../models/Cliente.php';
require '../../tools/Util.php';

$Prestamo = new Prestamo();
$Cliente = new Cliente();
$Util = new Util();

$Prestamo->setClienteid(filter_input(INPUT_GET, 'idcliente'));

$Cliente->setId($Prestamo->getClienteid());
$Cliente->obtenerDatos();

$a_prestamos = $Prestamo->verSoloCuotasPrestamosActivos();
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
        Resumen de Cuotas
    </div>
    <div class="right">
        <!--
        <a href="#" class="headerButton" data-bs-toggle="modal" data-bs-target="#actionSheetForm">
            <ion-icon name="add-outline"></ion-icon>
        </a>
        -->
    </div>
</div>
<!-- * App Header -->

<!-- App Capsule -->
<div id="appCapsule">

    <div class="section mt-2 mb-2">
        <ul class="listview flush transparent simple-listview no-space mt-3">
            <li>
                <strong>Solicitante</strong>
                <span><?php echo $Cliente->getDatos() ?></span>
            </li>
        </ul>
    </div>


    <div class="section mt-2 mb-2">

        <div class="goals">
            <?php
            $item = 1;
            $saldo = 0;
            $totalprestamos = 0;
            $totalcuotas = 0;
            $totalporpagar = 0;
            $contarporpagar = 0;
            $contarpagados = 0;
            $alerta = "";
            foreach ($a_prestamos as $fila) {
                //echo $fila['fecha_pago'];
                $fechadepago = "-";

                if ($fila['fecha_pago'] !== $fila['fecha_vcto'] && $fila['fecha_pago'] != '1000-01-01') {
                    $alerta = '<label class="badge badge-warning">Pago Destiempo</label>';
                } else {
                    $alerta = '';
                }
                $fechadepago = '<p class="p-0 text-success"><ion-icon name="checkmark-circle"></ion-icon>' . " Pagado el: " . $Util->fecha_mysql_web($fila['fecha_pago']) . "</p>";

                if ($fila['fecha_pago'] == '1000-01-01') {
                    $fechadepago = '<span class="badge badge-warning">Pendiente de pago</span>';
                    //comparar fecha vencimiento
                    $fechaactual = date("Y-m-d");
                    $fechaprestamo = $fila['fecha_vcto'];
                    if ($Util->fechaEsMayor($fechaactual, $fechaprestamo)) {
                        //cuota vencinda
                        $fechadepago .= '<span class="badge badge-danger">cuota vencida</span>';
                    }
                }

                $monto = $fila['monto'];
                if ($fila['fecha_pago'] != '1000-01-01') {
                    $saldo = $saldo + $monto;
                }
                $cuota = 0;
                $acuenta = ($fila['monto'] * -1) - $fila['acuenta'];

                if ($fila['acuenta'] < ($fila['monto'] * -1)) {
                    $contarporpagar++;
                    $totalporpagar += $acuenta;
                }

                //$ += $fila['acuenta'];

                if ($fila['acuenta'] == 0) {
                    $acuenta = 0;
                }




                if ($acuenta > 0) {
                    $fechadepago = '<p class="p-0 text-warning"><ion-icon name="alert"></ion-icon>' . " A cuenta por pagar: " . number_format($acuenta) . "</p>";
                }

                $deuda = 0;
                if ($monto < 0) {
                    $totalcuotas += $monto;
                    $cuota = $monto;
                    $deuda = "";
                } else {
                    $totalprestamos += $monto;
                    $cuota = "";
                    $deuda = $monto;
                }
                $saldo = $saldo + $acuenta;

                ?>
                <!-- item -->
                <div class="item">
                    <div class="in">
                        <div>
                            <h4>fecha Vcto: <?php echo $Util->fecha_mysql_web($fila['fecha_vcto']) ?></h4>
                            <?php echo $fechadepago ?>
                            <p class="p-0 m-0">-> <?php echo "S/ " . number_format($fila['montoprestamo'], 2) . " entregado el " . $Util->fecha_mysql_web($fila['fecha_solicitud']) ?></p>
                        </div>
                        <div class="price"><?php echo number_format($fila['monto'], 0) ?></div>
                    </div>
                </div>
                <!-- * item -->

                <?php
                $item++;
            }
            ?>
        </div>

    </div>

    <div class="section mt-2 mb-2">
        <ul class="listview flush transparent simple-listview no-space mt-3">
            <li>
                <strong>Nro de Cuotas por Pagar</strong>
                <span class="text-info"><?php echo $contarporpagar ?></span>
            </li>
            <li>
                <strong>Total Deuda</strong>
                <span><?php echo number_format($totalporpagar, 2) ?></span>
            </li>
            <li>
                <strong>Total Pagado </strong>
                <span><?php echo number_format(($totalcuotas * -1) - $totalporpagar, 2) ?></span>
            </li>
            <li>
                <strong>Total a Pagar</strong>
                <span><?php echo number_format($totalcuotas * -1, 2) ?></span>
            </li>
        </ul>
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