<?php
include '../fixed/cargarSession.php';
$namepage = basename(__FILE__);

require '../../tools/Util.php';
require '../../models/TareaDiaria.php';

$Util = new Util();
$Tarea = new TareaDiaria();

$l_tareas = $Tarea->verFilas();


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
        Tareas (Activas)
    </div>
    <div class="right">

        <a href="app-tarea-registro.php" class="headerButton">
            <ion-icon name="add-outline"></ion-icon>
        </a>

    </div>
</div>
<!-- * App Header -->

<!-- Form Action Sheet -->
<div class="modal fade action-sheet" id="actionSheetForm" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Saving Goal</h5>
            </div>
            <div class="modal-body">
                <div class="action-sheet-content">

                    <form>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="account1">Saving Category</label>
                                <select class="form-control custom-select" id="account1">
                                    <option value="0">Lifestyle</option>
                                    <option value="1">Living</option>
                                    <option value="2">Gaming</option>
                                    <option value="3">Mortgage</option>
                                    <option value="4">Travel</option>
                                    <option value="5">Gift</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Title</label>
                                <input type="text" class="form-control" placeholder="Enter a title">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                            <div class="input-info">Minimum $100</div>
                        </div>

                        <div class="form-group basic">
                            <label class="label">Enter Total Amount</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">$</span>
                                <input type="text" class="form-control" placeholder="Enter an amount" value="100">
                            </div>
                            <div class="input-info">Minimum $50</div>
                        </div>

                        <div class="form-group basic">
                            <button type="button" class="btn btn-primary btn-block btn-lg"
                                    data-bs-dismiss="modal">Add Goal
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- * Form Action Sheet -->

<!-- App Capsule -->
<div id="appCapsule">

    <div class="section mt-2 mb-2">

        <div class="goals">
            <?php
            foreach ($l_tareas as $item) {
                ?>
                <!-- item -->
                <div class="item">
                    <a href="app-cliente-detalle.php?id=1">
                        <div class="in">
                            <div>
                                <h4><?php echo $item['nombre_corto'] . " | " . $item['nep']  ." | " . $item['ncliente']?></h4>
                                <p>Fecha Inicio: <?php echo $item['fec_inicio'] ?></p>
                                <p><?php echo $item['tiposervicio'] ?></p>
                                <p><?php echo $item['guia_nro'] ?></p>
                            </div>
                            <!--
                            <div class="price">S/SOLPED</div>
                            -->
                        </div>
                        <!--
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: <?php echo number_format(80, 0) ?>%;" aria-valuenow="<?php echo number_format(80, 0) ?>"
                                 aria-valuemin="0" aria-valuemax="100"><?php echo number_format(80, 0) ?>%
                            </div>
                        </div>
                        -->
                    </a>
                </div>
                <!-- * item -->
                <?php
            }
            ?>


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