<?php
$error = filter_input(INPUT_GET, 'error');
$labelerror = '';
if ($error == 1) {
    $labelerror = '<div class="alert alert-dark mb-1" role="alert">
                        Usuario no Existe!
                    </div>';
}
if ($error == 2) {
    $labelerror = '<div class="alert alert-danger mb-1" role="alert">
                        Usuario Bloqueado
                    </div>';
}
if ($error == 3) {
    $labelerror = '<div class="alert alert-warning mb-1" role="alert">
                        No ha iniciado sesion
                    </div>';
}
if ($error == 4) {
    $labelerror = '<div class="alert alert-danger mb-1" role="alert">
                        Contraseña Incorrecta, intente de nuevo
                    </div>';
}
if ($error == 5) {
    $labelerror = '<div class="alert alert-warning mb-1" role="alert">
                        No ha iniciado sesion
                    </div>';
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
    <meta name="keywords" content="SEGEBUCO APP - Control de Servicio"/>
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
<div class="appHeader no-border transparent position-absolute">
    <!--
    <div class="left">
        <a href="#" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    -->
    <div class="pageTitle"></div>
    <div class="right">
    </div>
</div>
<!-- * App Header -->

<!-- App Capsule -->
<div id="appCapsule">
    <div class="section mt-2 text-center">
        <img src="../../public/imgs/logo_segebuco.png" width="40%">
    </div>

    <div class="section mt-2 text-center">
        <h1>Acceder</h1>
        <h4>por favor coloca tus datos de acceso</h4>
        <?php echo $labelerror  ?>
    </div>


    <div class="section mb-5 p-2">

        <form action="../controller/login.php" method="post">
            <div class="card">
                <div class="card-body pb-1">
                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label" for="input-usuario">Usuario</label>
                            <input type="text" class="form-control" id="input-usuario" name="input-usuario" placeholder="Usuario de acceso">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label" for="input-password">Contraseña</label>
                            <input type="password" class="form-control" id="input-password" name="input-password" autocomplete="off"
                                   placeholder="Contraseña">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>
                </div>
            </div>

            <!--
            <div class="form-links mt-2">
                <div>
                    <a href="app-register.html">Register Now</a>
                </div>
                <div><a href="app-forgot-password.html" class="text-muted">Forgot Password?</a></div>
            </div>
            -->

            <div class="form-button-group  transparent">
                <button type="submit" class="btn btn-primary btn-block btn-lg">Ingresar</button>
            </div>

        </form>
    </div>

</div>
<!-- * App Capsule -->


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