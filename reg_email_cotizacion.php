<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

require 'class/cl_cotizacion.php';
$cl_cotizacion = new cl_cotizacion();

$cl_cotizacion->setCodigo(filter_input(INPUT_GET, 'codigo'));
$a_datos = $cl_cotizacion->datos_cotizacion_mix();

foreach ($a_datos as $value) {
    $c_description = $value['descripcion'];
    $c_cliente = $value['razon_social'];
    $c_sucursal = $value['sucursal'];
    $ccliente = $value["ccliente"];
    $csucursal = $value["csucursal"];
    $c_archivo = $value['archivo'];
}

function quitar_tildes($cadena) {
$no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
$permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
$texto = str_replace($no_permitidas, $permitidas ,$cadena);
return $texto;
}

//$asunto = htmlspecialchars($c_description . ' | ' . $c_sucursal);
$asunto = quitar_tildes(htmlspecialchars($c_description) . ' | ' . $c_sucursal);

?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="es" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
<!--<![endif]-->

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <title>Enviar Cotizacion por email | SEGEBUCO SAC</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />

    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="assets/css/animate.min.css" rel="stylesheet" />
    <link href="assets/css/style.min.css" rel="stylesheet" />
    <link href="assets/css/style-responsive.min.css" rel="stylesheet" />
    <link href="assets/css/theme/default.css" rel="stylesheet" id="theme" />
    <!-- ================== END BASE CSS STYLE ================== -->

    <!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
    <link href="assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
    <link href="assets/plugins/jquery-tag-it/css/jquery.tagit.css" rel="stylesheet" />
    <!-- ================== END PAGE LEVEL STYLE ================== -->

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="assets/plugins/pace/pace.min.js"></script>
    <!-- ================== END BASE JS ================== -->
</head>
<body>
    <!-- begin #page-loader -->
    <div id="page-loader" class="fade in">
        <span class="spinner">
        </span>
    </div>
    <!-- end #page-loader -->

    <!-- begin #page-container -->
    <div id="page-container" class="page-container fade page-sidebar-fixed page-header-fixed">
        <!-- begin #header -->
        <?php include 'includes/header.php'; ?>
        <!-- end #header -->

        <!-- begin #sidebar -->
        <?php include 'includes/sidebar.php'; ?>
        <!-- end #sidebar -->

        <!-- begin #content -->
        <!-- begin #content -->
        <div id="content" class="content content-full-width">
            <!-- begin vertical-box -->
            <div class="vertical-box">
                <!-- begin vertical-box-column -->
                <div class="vertical-box-column">
                    <!-- begin wrapper -->
                    <div class="wrapper">
                        <div class="p-30 bg-white">
                            <!-- begin email form -->
                            <form action="procesos/reg_email_cotizacion.php" method="POST" name="email_to_form" class="form-horizontal">
                                <!--<label class="control-label">Buscar Correos:</label>
                                <div class="m-b-5">
                                    <input type="text" class="form-control" name="input_buscar" />
                                </div>-->
                                <!-- begin email to -->
                                <label class="control-label">Para (separar con comas):</label>
                                <div class="m-b-12">
                                    <input type="text" class="form-control" name="input_correo" />
                                </div>
                                <label class="control-label">Con Copia:</label>
                                <div class="m-b-15">
                                    <input type="text" class="form-control" value="clarrivierec@gmail.com" readonly="true"/>
                                </div>
                                <!-- end email to -->
                                <!-- begin email subject -->
                                <label class="control-label">Asunto:</label>
                                <div class="m-b-15">
                                    <input type="text" class="form-control" value="<?php echo $asunto ?>" name="input_asunto" />
                                </div>
                                <!-- end email subject -->
                                <!-- begin email content -->
                                <label class="control-label">Mensaje:</label>
                                <div class="m-b-15">
                                    <textarea class="textarea form-control" rows="20" name="input_mensaje">
Estimados Señores:
<?php echo $c_cliente ?>            
Presente.- 

Por medio de la presente es muy grato dirigirme a Usted para presentarle como adjunto, nuestra propuesta economica, por "SERVICIOS DE <?php echo $c_description ?>" de acuerdo a lo solicitado.

Adjuntamos nuestra cotizacion para la PLANTA <?php echo $c_sucursal ?>          
En espera de su pronta orden para poder atenderles quedamos de Ud.

Atentamente

Lizbet G. Bernabe Mendoza 
Asistente de Proyectos - Ventas
SEGEBUCO SAC

c: --
e: --

                                    </textarea>
                                </div>
                                <label class="control-label">Archivo:</label>
                                <div class="m-b-15">
                                    <p><?php echo $c_archivo ?></p>
                                    <input type="hidden" name="input_archivo" value="<?php echo $c_archivo ?>" />
                                    <input type="hidden" name="input_ccliente" value="<?php echo $ccliente ?>" />
                                    <input type="hidden" name="input_ccsucursal" value="<?php echo $csucursal ?>" />
                                </div>
                                <!-- end email content -->
                                <button type="submit" class="btn btn-primary p-l-40 p-r-40">Enviar</button>
                            </form>
                            <!-- end email form -->
                        </div>
                    </div>
                    <!-- end wrapper -->
                </div>
                <!-- end vertical-box-column -->
            </div>
            <!-- end vertical-box -->
        </div>
        <!-- end #content -->
        <!-- end #content -->

        <!-- begin scroll to top btn -->
        <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
        <!-- end scroll to top btn -->
    </div>
    <!-- end page container -->

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="assets/plugins/jquery/jquery-1.9.1.min.js"></script>
    <script src="assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
    <script src="assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="assets/plugins/jquery-cookie/jquery.cookie.js"></script>
    <!-- ================== END BASE JS ================== -->

    <!-- ================== BEGIN PAGE LEVEL JS ================== -->
    <script src="assets/plugins/jquery-tag-it/js/tag-it.min.js"></script>
    <script src="assets/plugins/bootstrap-wysihtml5/lib/js/wysihtml5-0.3.0.js"></script>
    <script src="assets/plugins/bootstrap-wysihtml5/src/bootstrap-wysihtml5.js"></script>
    <script src="assets/js/email-compose.demo.min.js"></script>
    <script src="assets/js/apps.min.js"></script>
    <!-- ================== END PAGE LEVEL JS ================== -->
    <script>
        $(document).ready(function () {
            App.init();
            EmailCompose.init();
        });
    </script>
</body>

<!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:23:54 GMT -->
</html>

