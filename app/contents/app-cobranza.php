<?php
include '../fixed/cargarSession.php';
$namepage = basename(__FILE__);
require '../../models/PrestamoCuota.php';
require '../../tools/Util.php';
$Cuota = new PrestamoCuota();
$Util = new Util();
$a_clientes = $Cuota->verClientesxPagar($_SESSION['usuarioid']);

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
        Cobros a la fecha
    </div>
    <div class="right">
        <a href="app-notifications.html" class="headerButton">
            <ion-icon class="icon" name="notifications-outline"></ion-icon>
            <span class="badge badge-danger">4</span>
        </a>
    </div>
</div>
<!-- * App Header -->

<!-- Extra Header -->
<div class="extraHeader">
    <form class="search-form">
        <div class="form-group searchbox">
            <input type="text" class="form-control">
            <i class="input-icon">
                <ion-icon name="search-outline"></ion-icon>
            </i>
        </div>
    </form>
</div>
<!-- * Extra Header -->


<!-- App Capsule -->
<div id="appCapsule">

    <!-- Transactions -->
    <div class="section mt-2 mb-2">
        <div class="section-title">Clientes x Cobrar</div>
        <div class="transactions">
            <?php
            $item = 1;
            $colorlabel = 'success';
            foreach ($a_clientes as $fila) {
                $deudaactual = $fila['deudaactual'];
                ?>
                <!-- item -->
                <a href="javascript:obtenerDatos(<?php echo $fila['idcliente'] ?>)" class="item">
                    <div class="detail">
                        <div>
                            <strong id="input-datos-prestamo-<?php echo $fila['idcliente'] ?>"><?php echo $fila['datos'] ?></strong>
                            <p>Vcto: <?php echo $Util->fecha_mysql_web($fila['fecha_vcto']) ?></p>
                            <p>Pago minimo: S/ <?php echo $fila['pagominimo'] ?></p>
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
</div>
<!-- * App Capsule -->


<!-- Form Action Sheet -->
<div class="modal fade action-sheet" id="actionSheetForm" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Cobranza</h5>
            </div>
            <div class="modal-body">
                <div class="action-sheet-content">

                    <form method="post" action="../controller/reg-cobranza.php">
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Prestamista</label>
                                <input type="hidden" name="hidden-id-cliente" id="hidden-id-cliente">
                                <input type="text" class="form-control" id="input-datos-cliente" readonly>
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Fecha Pago</label>
                                <input type="date" class="form-control" id="input-fecha-pago" name="input-fecha-pago" value="<?php echo date("Y-m-d") ?>" required>
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <label class="label">Monto a Pagar</label>
                            <div class="input-group">
                                <span class="input-group-text" >S/ </span>
                                <input type="text" class="form-control" placeholder="Enter an amount" value="" id="input-monto-pago" name="input-monto-pago">
                            </div>
                            <div class="input-info" id="label-cuota"></div>
                        </div>

                        <div class="form-group basic">
                            <button type="submit" class="btn btn-primary btn-block btn-lg"
                                    >Agregar Pago
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- * Form Action Sheet -->


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

<script>
    function obtenerDatos(idcliente) {
        var inputidcliente = "input-datos-prestamo-" + idcliente
        var datosCliente = document.getElementById(inputidcliente).innerHTML
        document.getElementById("input-datos-cliente").value = datosCliente
        document.getElementById("hidden-id-cliente").value = idcliente
        //var nombreCliente = $("#input-datos-prestamo-" + idcliente + "\"").html()
        obtenerUsuarios(idcliente)
        var modal = new bootstrap.Modal(document.getElementById('actionSheetForm'))
        modal.toggle()
    }

    async function obtenerUsuarios(idcliente) {
        fetch('../jsonResult/obtenerCuota.php?idcliente=' + idcliente)
            .then(function(response) {
                // Transforma la respuesta. En este caso lo convierte a JSON
                return response.json();
            })
            .then(function(json) {
                // Usamos la información recibida como necesitemos
               // console.log(json);
                document.getElementById("input-monto-pago").value = json.monto_cuota;
            });
    }
</script>

</body>

</html>