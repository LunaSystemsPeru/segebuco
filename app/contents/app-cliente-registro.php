<?php
include '../fixed/cargarSession.php';
$namepage = basename(__FILE__);
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
        Agregar nuevo cliente
    </div>

</div>
<!-- * App Header -->


<!-- App Capsule -->
<div id="appCapsule">

    <!-- Transactions -->
    <div class="section mt-2 mb-2">
        <div class="card">
            <form method="post" action="../controller/reg-cliente.php">
                <div class="card-body">
                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label" for="input-dni">Nro Documento</label>
                            <input type="text" class="form-control" id="input-dni" name="input-dni" placeholder="Ingrese Nro Documento Identidad" maxlength="10" minlength="8" required>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label" for="input-datos">Apellidos y Nombres</label>
                            <input type="text" class="form-control" id="input-datos" name="input-datos" placeholder="Ingrese Apellidos y Nombres del Solicitante" required minlength="10">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label" for="input-referencia">Referencia</label>
                            <input type="text" class="form-control" id="input-referencia" name="input-referencia" autocomplete="off" required
                                   placeholder="Ingrese como se contacto">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label" for="input-cargo">Referencia Laboral</label>
                            <input type="text" class="form-control" id="input-cargo" name="input-cargo" autocomplete="off"
                                   placeholder="Ingrese en que trabaja" required>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>


                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success">
                        <ion-icon name="save"></ion-icon>
                        Continuar
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- * Transactions -->
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