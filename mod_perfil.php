<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}
require 'class/cl_empleado.php';
require 'class/cl_usuario.php';
require 'class/cl_almacen.php';

$cl_empleado = new cl_empleado();
$cl_almacen = new cl_almacen();
$cl_usuario = new cl_usuario();
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="es" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
    <!--<![endif]-->

    <head><meta http-equiv="Content-Type" content="text/html; charset=euc-jp">
        
        <title>Modificar Perfil Usuario | SEGEBUCO SAC</title>
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
        <link href="assets/plugins/bootstrap-validator/bootstrapValidator.min.css" rel="stylesheet" />
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

            <?php
            $cl_almacen->setCodigo($_SESSION['almacen']);
            $cl_empleado->setCodigo($_SESSION['empleado']);
            $cl_usuario->setUsuario($_SESSION['usuario']);

            $cl_empleado->obtener_datos();
            $cl_almacen->datos_almacen();
            $cl_usuario->datos_usuario();
            ?>
            <!-- begin #sidebar -->
            <?php include 'includes/sidebar.php'; ?>
            <!-- end #sidebar -->

            <!-- begin #content -->
            <div id="content" class="content">
                <!-- begin breadcrumb -->
                <ol class="breadcrumb pull-right">
                    <li><a href="javascript:;">Inicio</a></li>
                    <li><a href="javascript:;">Perfil</a></li>
                    <li class="active">modificar usuario</li>
                </ol>
                <!-- end breadcrumb -->
                <!-- begin page-header -->
                <h1 class="page-header">Modificar Perfil<small>matenimiento usuario</small></h1>
                <!-- end page-header -->

                <div class="profile-container">
                    <!-- begin profile-section -->
                    <div class="profile-section">
                        <!-- begin profile-left -->
                        <div class="profile-left">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="image_preview" >
                                        <img id="previewing" src="upload/colaboradores/<?php echo strtoupper($cl_empleado->getImagen()) ?>" style="width: 100%"/>
                                    </div>
                                </div>
                            </div>
                            <!-- begin profile-image -->
                            <!--                            <div class="profile-image">
                                                            <img src="upload/colaboradores/78.jpg" />
                                                            <i class="fa fa-user hide"></i>
                                                        </div>-->
                            <!-- end profile-image -->
                            <!--<div class="m-b-10">-->
                                <!--<a href="mod_empleado.php?codigo=<?php echo $_SESSION['empleado'] ?>" class="btn btn-warning btn-block btn-sm">Cambiar Imagen</a>-->
                            <!--</div>-->
                            <!-- begin profile-highlight -->
                            <!--<div class="profile-highlight">-->
    <!--                            <h4><i class="fa fa-cog"></i> Only My Contacts</h4>
                                <div class="checkbox m-b-5 m-t-0">
                                    <label><input type="checkbox" /> Show my timezone</label>
                                </div>
                                <div class="checkbox m-b-0">
                                    <label><input type="checkbox" /> Show i have 14 contacts</label>
                                </div>
                            </div>-->
                            <!-- end profile-highlight -->
                        </div>
                        <!-- end profile-left -->
                        <!-- begin profile-right -->
                        <div class="profile-right">
                            <form class="form-horizontal" id="frm_detalle" method="post" action="procesos/mod_usuario.php">
                            <!-- begin profile-info -->
                            <div class="profile-info">
                                <!-- begin table -->
                                <div class="table-responsive">
                                    <table class="table table-profile">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>
                                        <h4><?php echo ucwords(strtolower($cl_empleado->getNombres() . ' ' . $cl_empleado->getPaterno() . ' ' . $cl_empleado->getMaterno())) ?><small>Asistente Administrativo</small></h4>
                                        </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="highlight">
                                                <td class="field">Usuario</td>
                                                <td><?php echo $_SESSION['usuario'] ?></td>
                                            </tr>
                                            <tr class="divider">
                                                <td colspan="2"></td>
                                            </tr>
                                            <tr class="field">
                                                <td class="field">DNI</td>
                                                <td><?php echo $cl_empleado->getDni() ?></td>
                                            </tr>
                                            <tr class="field">
                                                <td class="field">Direccion</td>
                                                <td><?php echo $cl_empleado->getDireccion() ?></td>
                                            </tr>
                                            <tr class="field">
                                                <td class="field">email</td>
                                                <td><?php echo $cl_empleado->getEmail() ?></td>
                                            </tr>
                                            <tr>
                                                <td class="field">Celular</td>
                                                <td><i class="fa fa-mobile fa-lg m-r-5"></i> <?php echo $cl_empleado->getTelefono() ?> </td>
                                            </tr>
                                            <tr class="divider">
                                                <td colspan="2"></td>
                                            </tr>
                                            <tr class="highlight">
                                                <td class="field">Almacen</td>
                                                <td>
                                                    <select name="select_almacen" id="select_almacen" class="form-control">
                                                        <?php
                                                        $a_almacen_destino = $cl_almacen->ver_almacenes();
                                                        foreach ($a_almacen_destino as $value) {
                                                            if ($value['codigo'] == $cl_usuario->getAlmacen()) {
                                                                $seleccion = "selected='selected'";
                                                            } else {
                                                                $seleccion = "";
                                                            }
                                                            ?>
                                                            <option value="<?php echo $value['codigo'] ?>"  <?php echo $seleccion ?>><?php echo $value['nombre'] ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr class="highlight">
                                                <td class="field">Contraseña</td>
                                                <td>
                                                    <input type="password" class="form-control" name="input_contra" value="<?php echo $cl_usuario->getPass() ?>"/>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- end table -->
                            </div>
                            <div>
                                <div class="panel-footer text-right" >
                                    <input type="hidden" name="input_usuario" value="<?php echo $_SESSION['usuario']?>" />
                                    <button type="submit" class="btn btn-success">Guardar Modificacion </button>
                                </div>
                            </div>
                            <!-- end profile-info -->
                            </form>
                        </div>
                        <!-- end profile-right -->
                    </div>
                    <!-- end profile-section -->
                </div>
            </div>
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
        <!--[if lt IE 9]>
                <script src="assets/crossbrowserjs/html5shiv.js"></script>
                <script src="assets/crossbrowserjs/respond.min.js"></script>
                <script src="assets/crossbrowserjs/excanvas.min.js"></script>
        <![endif]-->
        <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
        <script src="assets/plugins/jquery-cookie/jquery.cookie.js"></script>
        <script src="assets/plugins/masked-input/masked-input.min.js"></script>
        <script src="assets/plugins/bootstrap-validator/bootstrapValidator.min.js"></script>
        <!-- ================== END BASE JS ================== -->

        <!-- ================== BEGIN PAGE LEVEL JS ================== -->
        <script src="assets/js/table-manage-default.demo.min.js"></script>
        <script src="assets/js/apps.min.js"></script>
        <!-- ================== END PAGE LEVEL JS ================== -->
        <script>
            $(document).ready(function () {
                App.init();
                TableManageDefault.init();
            });
        </script>

        <script language="javascript">
            $(document).ready(function () {
                $('#input_descripcion').focus();

                var faIcon = {
                    valid: 'fa fa-check-circle fa-lg text-success',
                    invalid: 'fa fa-times-circle fa-lg',
                    validating: 'fa fa-refresh'
                };



                // FORM VALIDATION ON TABS
                // =================================================================
                $('#frm_planilla').bootstrapValidator({
                    message: 'This value is not valid',
                    excluded: ':disabled',
                    feedbackIcons: faIcon,
                    fields: {
                        input_precio: {
                            validators: {
                                numeric: {
                                    message: 'The value can contain only number and point'
                                }
                            }
                        }
                    }
                }).on('status.field.bv', function (e, data) {
                    var $form = $(e.target),
                            validator = data.bv,
                            $tabPane = data.element.parents('.tab-pane'),
                            tabId = $tabPane.attr('id');

                    if (tabId) {
                        var $icon = $('a[href="#' + tabId + '"][data-toggle="tab"]').parent().find('i');

                        // Add custom class to tab containing the field
                        if (data.status == validator.STATUS_INVALID) {
                            $icon.removeClass(faIcon.valid).addClass(faIcon.invalid);
                        } else if (data.status == validator.STATUS_VALID) {
                            var isValidTab = validator.isValidContainer($tabPane);
                            $icon.removeClass(faIcon.valid).addClass(isValidTab ? faIcon.valid : faIcon.invalid);
                        }
                    }
                });

            });

            $(document).ready(function (e) {
                // Function to preview image after validation
                $(function () {
                    $("#file").change(function () {
                        $("#message").empty(); // To remove the previous error message
                        var file = this.files[0];
                        var imagefile = file.type;
                        var match = ["image/jpeg", "image/png", "image/jpg"];
                        if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2])))
                        {
                            $('#previewing').attr('src', 'noimage.png');
                            $("#message").html("<p id='error'>Please Select A valid Image File</p>" + "<h4>Nota</h4>" + "<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
                            return false;
                        }
                        else
                        {
                            var reader = new FileReader();
                            reader.onload = imageIsLoaded;
                            reader.readAsDataURL(this.files[0]);
                        }
                    });
                });

                function imageIsLoaded(e) {
                    $("#file").css("color", "green");
                    $('#image_preview').css("display", "block");
                    $('#previewing').attr('src', e.target.result);
                    $('#previewing').attr('width', '280px');
                    //$('#previewing').attr('height', '300px');
                }
            });
        </script>
    </body>

    <!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:23:54 GMT -->
</html>

