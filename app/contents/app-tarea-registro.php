<?php
include '../fixed/cargarSession.php';
$namepage = basename(__FILE__);

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
                        <input type="datetime-local" hidden id="input-registro" name="input-registro" value="<?php echo date("Y-m-d"); ?>">
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="text4">Tipo Servicio:</label>
                                <select class="form-select">
                                    <option>EMERGENCIA</option>
                                    <option>CON SOLPED</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="embarcacion">E/P:</label>
                                <input type="text" class="form-control" id="input-embarcacion" required>
                                <input type="text" hidden id="id-embarcacion" name="id-embarcacion">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="input-supervisor">Motorista</label>
                                <input type="text" class="form-control" id="input-supervisor" name="input-supervisor" required>
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="input-descripcion">Tareas:</label>
                                <textarea class="form-control" id="input-descripcion" rows="5" name="input-descripcion" required></textarea>
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="input-inicio">fecha Inicio</label>
                                <input type="datetime-local" class="form-control" id="input-inicio" name="input-inicio" autocomplete="off" required>
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>

                        <div class="form-group basic mb-2">
                            <div class="input-wrapper">
                                <label class="label" for="input-fin">Fecha Fin</label>
                                <input type="datetime-local" class="form-control" id="input-fin" name="input-fin" autocomplete="off" required>
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="input-direccion">Lugar Trabajo</label>
                                <input type="text" class="form-control" id="input-direccion" name="input-direccion">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Trabajadores</label>

                                <div class="input-list">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="tc1" value="Trabajador 1">
                                        <label class="form-check-label" for="tc1">TRABAJADOR 1</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="tc2" value="Trabajador 2">
                                        <label class="form-check-label" for="tc2">TRABAJADOR 2</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="tc3" value="Trabajador 3">
                                        <label class="form-check-label" for="tc3">TRABAJADOR 3</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <button type="button" onclick="registrar()" class="btn btn-outline-warning">
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

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function registrar() {
            let trabajadores = [];

            $("input[type=checkbox]:checked").each(function() {
                trabajadores.push(this.value);
            });

            let datos = {
                'input-registro': $('#input-registro').val(),
                'input-embarcacion': $('#input-embarcacion').val(),
                'input-supervisor': $('#input-supervisor').val(),
                'input-tareas': $('#input-descripcion').val(),
                'input-inicio': $('#input-inicio').val(),
                'input-fin': $('#input-fin').val(),
                'input-direccion': $('#input-direccion').val(),
                'input-trabajadores': JSON.stringify(trabajadores)
            };

            $.post('../controller/registrar-tareas.php', datos, function(data) {
                alert(data);
                let result = JSON.parse(data);
                window.location.href = '../contents/app-tarea-registro.php';
            });
        }

        function calcularCuota() {}
    </script>
</body>

</html>