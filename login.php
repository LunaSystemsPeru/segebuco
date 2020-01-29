<?php
session_start();

if (isset($_SESSION["usuario"])) {
    header("location:index.php");
}

?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
    <!--<![endif]-->

    <!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/login_v3.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:25:16 GMT -->
    <head><meta http-equiv="Content-Type" content="text/html">
        <meta charset="UTF-8">
        
        
        <title>Login | SEGEBUCO SAC</title>
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />

        <!-- ================== BEGIN BASE CSS STYLE ================== -->
        <link href="fonts.googleapis.com/cssff98.css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <link href="assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
        <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
        <link href="assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
        <link href="assets/css/animate.min.css" rel="stylesheet" />
        <link href="assets/css/style.min.css" rel="stylesheet" />
        <link href="assets/css/style-responsive.min.css" rel="stylesheet" />
        <link href="assets/css/theme/default.css" rel="stylesheet" id="theme" />
        <!-- ================== END BASE CSS STYLE ================== -->

        <!-- ================== BEGIN BASE JS ================== -->
        <script src="assets/plugins/pace/pace.min.js"></script>
        <!-- ================== END BASE JS ================== -->
    </head>
    <body class="pace-top bg-white">
        <!-- begin #page-loader -->
        <div id="page-loader" class="fade in"><span class="spinner"></span></div>
        <!-- end #page-loader -->

        <!-- begin #page-container -->
        <div id="page-container" class="fade">
            <!-- begin login -->
            <div class="login login-with-news-feed">
                <!-- begin news-feed -->
                <div class="news-feed">
                    <div class="news-image">
                        <img src="assets/img/login-bg/bg-7.jpg" data-id="login-cover-image" alt="" />
                    </div>
                    <div class="news-caption">
                        <h4 class="caption-title"><i class="fa fa-diamond text-success"></i> Sistema Web - SEGEBUCO SAC</h4>
                        <p>
                            Sistema de Gestion de Ventas, Compras, Cobranzas, Planillas, Ordenes de Servicios, Cotizaciones, Orden de Trabajos, Cajas y bancos, Almacen.
                        </p>
                    </div>
                </div>
                <!-- end news-feed -->
                <!-- begin right-content -->
                <div class="right-content">
                    <!-- begin login-header -->
                    <div class="login-header">
                        <div class="brand">
                            <span class="logo"></span> Segebuco 
                            <small></small>
                        </div>
                        <div class="icon">
                            <i class="fa fa-sign-in"></i>
                        </div>
                    </div>
                    <!-- end login-header -->
                    <!-- begin login-content -->
                    <div class="login-content">
                        <div class="row">
                            <?php
                            $error = filter_input(INPUT_GET, "error");
                            if ($error == true) {
                                ?>
                                <div class="alert alert-danger fade in m-b-15">
                                    <strong>Error!</strong>
                                    Usuario y/o contraseña no valida, intente de nuevo
                                    <span class="close" data-dismiss="alert">&times;</span>
                                </div>
                            <?php } ?>
                        </div>
                        <form action="procesos/login.php" method="POST" class="margin-bottom-0">
                            <div class="form-group m-b-15">
                                <input type="text" class="form-control input-lg" name="input_usuario" placeholder="Usuario" />
                            </div>
                            <div class="form-group m-b-15">
                                <input type="password" class="form-control input-lg" name="input_contrasena" placeholder="Contraseña" />
                            </div>
                            <div class="checkbox m-b-30">
                                <label>
                                    <input type="checkbox" /> Recuerdame
                                </label>
                            </div>
                            <div class="login-buttons">
                                <button type="submit" class="btn btn-success btn-block btn-lg">Ingresar</button>
                            </div>
                            <!--<div class="m-t-20 m-b-40 p-b-40">-->
                            <!--Not a member yet? Click <a href="register_v3.html" class="text-success">here</a> to register.-->
                            <!--</div>-->
                            <hr />
                            <p class="text-center text-inverse">
                                &copy; Powered by Luna Systems Peru - <?php echo date("Y")?>
                            </p>
                        </form>
                    </div>
                    <!-- end login-content -->
                </div>
                <!-- end right-container -->
            </div>
            <!-- end login -->

        </div>
        <!-- end page container -->

        <!-- ================== BEGIN BASE JS ================== -->
        <script src="assets/plugins/jquery/jquery-1.9.1.min.js"></script>
        <script src="assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
        <script src="assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
        <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
        <!--[if lt IE 9]>
                <script src="assets/crossbrowserjs/html5shiv.js"></script>
                <script src="assets/crossbrowserjs/respond.min.js"></script>
                <script src="assets/crossbrowserjs/excanvas.min.js"></script>
        <![endif]-->
        <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
        <script src="assets/plugins/jquery-cookie/jquery.cookie.js"></script>
        <!-- ================== END BASE JS ================== -->

        <!-- ================== BEGIN PAGE LEVEL JS ================== -->
        <script src="assets/js/apps.min.js"></script>
        <!-- ================== END PAGE LEVEL JS ================== -->

        <script>
            $(document).ready(function () {
                App.init();
            });
        </script>
    </body>

    <!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/login_v3.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:25:30 GMT -->
</html>

