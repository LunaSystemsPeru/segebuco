<?php
include '../fixed/cargarSession.php';
$namepage = basename(__FILE__);

require '../../models/Banco.php';
require '../../models/BancoMovimiento.php';
require '../../models/ParametroDetalle.php';
require '../../tools/Util.php';

$Banco = new Banco();
$Movimiento = new BancoMovimiento();
$Detalle = new ParametroDetalle();
$Util = new Util();

$Banco->setId($_SESSION['bancoid']);
$Banco->obtenerDatos();

$Movimiento->setBancoid($Banco->getId());
$cobradoultimo = $Movimiento->cobradoHoy();

$Detalle->setIdparametro(3);
$a_tipo_gastos = $Detalle->verFilas();
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
    <meta name="keywords"
          content="SEGEBUCO APP - Control de Servicios"/>
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
<div class="appHeader bg-primary text-light">
    <!--
    <div class="left">
        <a href="#" class="headerButton" data-bs-toggle="modal" data-bs-target="#sidebarPanel">
            <img src="../assets/img/sample/avatar/avatar1.jpg" alt="image" class="imaged rounded w32">
            <span class="badge badge-danger">10</span>
        </a>
    </div>
    -->
    <div class="pageTitle">
        Caja
    </div>
    <!--
    <div class="right">
        <a href="app-notifications.html" class="headerButton">
            <ion-icon class="icon" name="notifications-outline"></ion-icon>
            <span class="badge badge-danger">8</span>
        </a>
    </div>
    -->
</div>
<!-- * App Header -->


<!-- App Capsule -->
<div id="appCapsule">


    <!-- Wallet -->
    <div class="section full gradientSection">
        <div class="in">
            <h5 class="title mb-2">Efectivo Actual</h5>
            <h1 class="total">S/ <?php echo number_format($Banco->getSaldo(), 2) ?></h1>
            <h4 class="caption">
                    <span class="iconbox text-success">
                        <ion-icon name="trending-up-outline"></ion-icon>
                    </span>
                <?php echo number_format($cobradoultimo) ?>
            </h4>
            <div class="wallet-inline-button mt-5">
                <a href="#" class="item" data-bs-toggle="modal" data-bs-target="#depositActionSheet">
                    <div class="iconbox">
                        <ion-icon name="arrow-up-outline"></ion-icon>
                    </div>
                    <strong>Enviar Capital</strong>
                </a>
                <a href="#" class="item" data-bs-toggle="modal" data-bs-target="#withdrawActionSheet">
                    <div class="iconbox">
                        <ion-icon name="arrow-down-outline"></ion-icon>
                    </div>
                    <strong>Recibir Capital</strong>
                </a>
                <a href="#" class="item" data-bs-toggle="modal" data-bs-target="#sendActionSheet">
                    <div class="iconbox">
                        <ion-icon name="arrow-forward-outline"></ion-icon>
                    </div>
                    <strong>Gastos Varios</strong>
                </a>
            </div>
        </div>
    </div>
    <!-- * Wallet -->

    <!-- Deposit Action Sheet -->
    <div class="modal fade action-sheet" id="depositActionSheet" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Enviar Capital</h5>
                </div>
                <div class="modal-body">
                    <div class="action-sheet-content">
                        <form method="post" action="../controller/reg-banco-movimiento.php">
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label" for="input-sale">Fecha de Envio</label>
                                    <div class="exchange-group small">
                                        <div class="input-col">
                                            <input type="date" class="form-control form-control-lg pe-0"
                                                   id="input-fecha" name="input-fecha" placeholder="0" value="0" maxlength="8">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group basic mb-2">
                                <div class="input-wrapper">
                                    <label class="label" for="input-descripcion">Tipo Envio</label>
                                    <select class="form-control custom-select" id="input-descripcion" name="input-descripcion">
                                        <option value="A CUENTA CTE">a Cuenta CTE</option>
                                        <option value="ENTREGADO EN EFECTIVO">Entrega en Efectivo</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label" for="input-sale">Monto a enviar</label>
                                    <div class="exchange-group small">
                                        <div class="input-col">
                                            <input type="text" class="form-control form-control-lg pe-0"
                                                   id="input-monto" name="input-monto" placeholder="0" value="0" maxlength="8">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-2">
                                <input type="hidden" name="select-tipo" value="14">
                                <input type="hidden" name="input-tipo" value="1">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">enviar Dinero
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- * Deposit Action Sheet-->

    <!-- Withdraw Action Sheet -->
    <div class="modal fade action-sheet" id="withdrawActionSheet" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Recibir Capital</h5>
                </div>
                <div class="modal-body">
                    <div class="action-sheet-content">
                        <form method="post" action="../controller/reg-banco-movimiento.php">

                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label" for="input-sale">Fecha de Envio</label>
                                    <div class="exchange-group small">
                                        <div class="input-col">
                                            <input type="date" class="form-control form-control-lg pe-0"
                                                   id="input-fecha" name="input-fecha" placeholder="0" value="0" maxlength="8">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group basic mb-2">
                                <div class="input-wrapper">
                                    <label class="label" for="input-descripcion">Descripcion</label>
                                    <input type="text" class="form-control" id="input-descripcion" name="input-descripcion"
                                           placeholder="Describa el motivo">
                                    <i class="clear-input">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                </div>
                            </div>

                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label" for="withdrawAmount">Capital Inversion Recibida</label>
                                    <div class="exchange-group small">
                                        <div class="input-col">
                                            <input type="text" class="form-control form-control-lg pe-0"
                                                   id="input-monto" name="input-monto" placeholder="0" value="0" maxlength="8">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-2">
                                <input type="hidden" name="select-tipo" value="14">
                                <input type="hidden" name="input-tipo" value="2">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">Recibir Capital
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- * Withdraw Action Sheet-->

    <!-- Send Action Sheet -->
    <div class="modal fade action-sheet" id="sendActionSheet" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Gastos Varios</h5>
                </div>
                <div class="modal-body">
                    <div class="action-sheet-content">
                        <form method="post" action="../controller/reg-banco-movimiento.php">

                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label" for="input-sale">Fecha de gasto</label>
                                    <div class="exchange-group small">
                                        <div class="input-col">
                                            <input type="date" class="form-control form-control-lg pe-0"
                                                   id="input-fecha" name="input-fecha" placeholder="0" value="0" maxlength="8">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group basic mb-2">
                                <div class="input-wrapper">
                                    <label class="label" for="select-tipo">Tipo de Gasto</label>
                                    <select class="form-select form-select-lg" name="select-tipo" id="select-tipo">
                                        <?php
                                        foreach ($a_tipo_gastos as $fila) {
                                            echo '<option value="' . $fila['iddetalle'] . '" >' . $fila['nombre'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group basic mb-2">
                                <div class="input-wrapper">
                                    <label class="label" for="input-descripcion">Descripcion del Gasto</label>
                                    <input type="text" class="form-control" id="input-descripcion" name="input-descripcion"
                                           placeholder="escriba una pequeña descripcion ">
                                    <i class="clear-input">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                </div>
                            </div>

                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label" for="input-monto">Monto</label>
                                    <div class="exchange-group small">
                                        <div class="input-col">
                                            <input type="text" class="form-control form-control-lg pe-0"
                                                   id="input-monto" name="input-monto" placeholder="0" value="380" maxlength="14">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-2">
                                <input type="hidden" name="input-tipo" value="3">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">Send
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- * Send Action Sheet-->


    <!-- Portfolio -->
    <div class="section mt-4 mb-2">
        <div class="section-heading">
            <h2 class="title">Movimientos de Dinero</h2>
            <a href="app-caja-movimientos.php" class="link">ver Todo</a>
        </div>
        <div class="card">
            <ul class="listview flush transparent no-line image-listview detailed-list mt-1 mb-1">
                <!-- item -->
                <?php
                $a_movimientos = $Movimiento->verMovimientos();
                $labelicon = 'trending-up-outline';
                foreach ($a_movimientos as $fila) {
                    $textocolor = "";
                    $monto = 0;
                    if ($fila['ingresa'] > 0) {
                        $monto = $fila['ingresa'];
                        $labelicon = 'trending-up-outline';
                        $textocolor = 'text-success';
                    } else {
                        $monto = $fila['sale'] * -1;
                        $labelicon = 'trending-down-outline';
                        $textocolor = 'text-danger';
                    }
                    ?>
                    <li>
                        <div class="item">
                            <div class="icon-box <?php echo $textocolor?>">
                                <ion-icon name="<?php echo $labelicon?>"></ion-icon>
                            </div>
                            <div class="in">
                                <div>
                                    <strong><?php echo $Util->fecha_mysql_web_diames($fila['fecha']) . " | " . $fila['tipomov'] ?></strong>
                                    <div class="text-small text-secondary"><?php echo $fila['descripcion'] ?></div>
                                </div>
                                <div class="text-end">
                                    <strong class="<?php echo $textocolor ?>"><?php echo number_format($monto, 0) ?></strong>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php
                } ?>

                <!-- * item -->
            </ul>
        </div>
    </div>
    <!-- Portfolio -->

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
<!-- Apex Charts -->
<script src="../assets/js/plugins/apexcharts/apexcharts.min.js"></script>
<!-- Base Js File -->
<script src="../assets/js/base.js"></script>

<script>

    var sparklineAreaExampleSuccess1 = {
        series: [{
            data: [555, 1222, 777, 888, 555, 888, 999, 1222]
        }],
        chart: {
            type: 'area',
            width: '100%',
            height: 70,
            sparkline: {
                enabled: true
            }
        },
        stroke: {
            width: 2,
        },
        colors: ['#1DCC70'],
        tooltip: {
            enabled: false
        }
    };
    var sparklineAreaExampleSuccess2 = {
        series: [{
            data: [55, 66, 55, 77, 66, 180, 290, 333]
        }],
        chart: {
            type: 'area',
            width: '100%',
            height: 70,
            sparkline: {
                enabled: true
            }
        },
        stroke: {
            width: 2,
        },
        colors: ['#1DCC70'],
        tooltip: {
            enabled: false
        }
    };
    var sparklineAreaExampleDanger1 = {
        series: [{
            data: [2222, 1666, 1444, 1777, 1333, 1111, 777, 666]
        }],
        chart: {
            type: 'area',
            width: '100%',
            height: 70,
            sparkline: {
                enabled: true
            }
        },
        stroke: {
            width: 2,
        },
        colors: ['#FF396F'],
        tooltip: {
            enabled: false
        }
    };
    var sparklineAreaExampleDanger2 = {
        series: [{
            data: [1200, 1444, 2900, 505, 531, 1900, 555, 75]
        }],
        chart: {
            type: 'area',
            width: '100%',
            height: 70,
            sparkline: {
                enabled: true
            }
        },
        stroke: {
            width: 2,
        },
        colors: ['#FF396F'],
        tooltip: {
            enabled: false
        }
    };


    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.chart-sparkline-success-1').forEach(chart => new ApexCharts(chart, sparklineAreaExampleSuccess1).render());
        document.querySelectorAll('.chart-sparkline-success-2').forEach(chart => new ApexCharts(chart, sparklineAreaExampleSuccess2).render());
        document.querySelectorAll('.chart-sparkline-danger-1').forEach(chart => new ApexCharts(chart, sparklineAreaExampleDanger1).render());
        document.querySelectorAll('.chart-sparkline-danger-2').forEach(chart => new ApexCharts(chart, sparklineAreaExampleDanger2).render());

    })

</script>

</body>

</html>