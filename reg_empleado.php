<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

require 'class/cl_detalle_tabla_general.php';
$cl_detalle = new cl_detalle_tabla_general();
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="es" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
    <!--<![endif]-->

    <head>
        <meta charset="utf-8" />
        <title>Agregar Empleado | SEGEBUCO SAC</title>
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />

        <!-- ================== BEGIN BASE CSS STYLE ================== -->
        <link href="assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
        <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
        <link href="assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
        <link href="assets/plugins/bootstrap-validator/bootstrapValidator.min.css" rel="stylesheet" />
        <link href="assets/css/animate.min.css" rel="stylesheet" />
        <link href="assets/css/style.min.css" rel="stylesheet" />
        <link href="assets/css/style-responsive.min.css" rel="stylesheet" />
        <link href="assets/css/theme/default.css" rel="stylesheet" id="theme" />
        <!-- ================== END BASE CSS STYLE ================== -->

        <!-- ================== BEGIN PAGE LEVEL STYLE ================== -->

        <!-- ================== END PAGE LEVEL STYLE ================== -->

        <!-- ================== BEGIN BASE JS ================== -->
        <script src="assets/plugins/pace/pace.min.js"></script>
        <!-- ================== END BASE JS ================== -->
        <script>
            function enviar_dni() {
                var parametros = {
                    "dni": $("#input_dni").val()
                };
                $.ajax({
                    data: parametros,
                    url: 'ajax_post/validar_dni.php',
                    type: 'post',
                    beforeSend: function () {
                        $("#resultado").html("Procesando, espere por favor...");
                    },
                    success: function (response) {
                        var json = JSON.parse(response);
                        var json_dni = json.result;
                        //console.log(json_dni);
                        $("#resultado").html(json_dni.apellidos + " " + json_dni.Nombres);
                        $("#input_nombres").val(json_dni.Nombres);
                        $("#input_paterno").val("");
                        $("#input_materno").val("");
//                        $("#input_nombres").val(json_dni.Nombres);
//                        $("#input_paterno").val(json_dni.ApellidoP);
//                        $("#input_materno").val(json_dni.ApellidoM);
                        $("#input_paterno").focus();
                    }
                });
            }

        </script>
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
            <div id="content" class="content">
                <!-- begin breadcrumb -->
                <ol class="breadcrumb pull-right">
                    <li><a href="javascript:;">Inicio</a></li>
                    <li><a href="javascript:;">Empleados</a></li>
                    <li class="active">Empleados</li>
                </ol>
                <!-- end breadcrumb -->
                <!-- begin page-header -->
                <h1 class="page-header">Empleados <small>matenimiento empleados</small></h1>
                <!-- end page-header -->

                <div class="row">
                    <form class="form-horizontal" enctype="multipart/form-data" id="form_empleado" action="procesos/reg_empleado.php" method="post">
                        <div class="col-md-3">
                            <div class="panel panel-inverse">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Agregar Imagen</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                    <div id="image_preview" >
                                        <img id="previewing" src="images/noimage.png" style="width: 100%"/>
                                    </div>
                                        </div>
                                    </div>
                                    <hr id="line">
                                    <div id="selectImage">
                                        <input class="form-control" type="file" name="file" id="file" required/>
                                    </div>
                                    <div id="message"></div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-9">
                            <div class="panel panel-inverse">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Datos Generales</h4>
                                </div>
                                <div class="panel-body">
                                    <div id="resultado"></div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="input_codigo">Codigo</label>
                                        <div class="col-sm-6">
                                            <input type="text" placeholder="Codigo" name="input_codigo" id="input_codigo" class="form-control" disabled="trues">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="input_dni">DNI</label>
                                        <div class="col-sm-3">
                                            <input type="text" placeholder="Nro DNI" name="input_dni" id="input_dni" maxlength="8" class="form-control" required>
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="button" onclick="enviar_dni()" class="btn btn-info" > Validar DNI</button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="input_nombres">Nombres</label>
                                        <div class="col-sm-5">
                                            <input type="text" placeholder="Nombres" name="input_nombres" id="input_nombres" class="form-control" required >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="input_paterno">Apellido Paterno</label>
                                        <div class="col-sm-5">
                                            <input type="text" placeholder="Apellido Paterno" name="input_paterno" id="input_paterno" class="form-control" required >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="input_materno">Apellido Materno</label>
                                        <div class="col-sm-5">
                                            <input type="text" placeholder="Apellido Materno" name="input_materno" id="input_materno" class="form-control" required >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="input_direccion">Direccion</label>
                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Direccion" name="input_direccion" id="input_direccion" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="input_email">Email</label>
                                        <div class="col-sm-8">
                                            <input type="text" placeholder="E-mail" name="input_email" id="input_email" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="input_nacimiento">Fecha de Nacimiento</label>
                                        <div class="col-sm-3">
                                            <input type="text" id="input_nacimiento" name="input_nacimiento" class="form-control" placeholder="dd/mm/aaaa" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="select_grado">Grado</label>
                                        <div class="col-sm-8">
                                            <select id="select_grado" name="select_grado" class="form-control selectpicker">
                                                <?php
                                                $cl_detalle->setTabla(2);
                                                $a_grado = $cl_detalle->v_detalle();
                                                foreach ($a_grado as $value) {
                                                    ?>
                                                    <option value="<?php echo $value['id'] ?>"><?php echo $value['descripcion'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="input_profesion">Profesion</label>
                                        <div class="col-sm-8">
                                            <input type="text" id="input_profesion" name="input_profesion" class="form-control" placeholder="Profesion" maxlength="50">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="input_telefono">Telefono / Celular</label>
                                        <div class="col-sm-4">
                                            <input type="text" id="input_telefono" name="input_telefono" class="form-control" placeholder="Telefono - Celular" maxlength="9">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="input_celular">Telefono Celular</label>
                                        <div class="col-sm-4">
                                            <input type="text" id="input_celular "name="input_celular" class="form-control" placeholder="Telefono - Celular" maxlength="9">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="select_cargo">Cargo</label>
                                        <div class="col-sm-8">
                                            <select id="select_cargo" name="select_cargo" class="form-control selectpicker">
                                                <?php
                                                $cl_detalle->setTabla(1);
                                                $a_cargo = $cl_detalle->v_detalle();
                                                foreach ($a_cargo as $value) {
                                                    ?>
                                                    <option value="<?php echo $value['id'] ?>"><?php echo $value['descripcion'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="select_categoria">Categoria</label>
                                        <div class="col-sm-8">
                                            <select id="select_categoria" name="select_categoria" class="form-control selectpicker">
                                                <?php
                                                $cl_detalle->setTabla(4);
                                                $a_categoria = $cl_detalle->v_detalle();
                                                foreach ($a_categoria as $value) {
                                                    ?>
                                                    <option value="<?php echo $value['id'] ?>"><?php echo $value['descripcion'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="input_jornal">Jornal Dia</label>
                                        <div class="col-sm-3">
                                            <input type="text" id="input_jornal" name="input_jornal" class="form-control" placeholder="Jornal S/" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="select_civil">Estado Civil</label>
                                        <div class="col-sm-8">
                                            <select id="select_civil" name="select_civil" class="form-control selectpicker" >
                                                <?php
                                                $cl_detalle->setTabla(3);
                                                $a_estado = $cl_detalle->v_detalle();
                                                foreach ($a_estado as $value) {
                                                    ?>
                                                    <option value="<?php echo $value['id'] ?>"><?php echo $value['descripcion'] ?></option>
                                                    <?php
                                                }
                                                ?>															</select>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer text-right" >
                                    <button type="submit" class="btn btn-success">Agregar </button>
                                </div>
                            </div>
                        </div>
                    </form>
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
        <!-- ================== END BASE JS ================== -->

        <!-- ================== BEGIN PAGE LEVEL JS ================== -->
        <script src="assets/plugins/bootstrap-select/bootstrap-select.min.js"></script>
        <script src="assets/js/table-manage-default.demo.min.js"></script>
        <script src="assets/plugins/masked-input/masked-input.min.js"></script>
        <script src="assets/plugins/bootstrap-validator/bootstrapValidator.min.js"></script>
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
                $('#input_nacimiento').mask('99/99/9999');

                var faIcon = {
                    valid: 'fa fa-check-circle fa-lg text-success',
                    invalid: 'fa fa-times-circle fa-lg',
                    validating: 'fa fa-refresh'
                }



                // FORM VALIDATION ON TABS
                // =================================================================
                $('#form_empleado').bootstrapValidator({
                    message: 'This value is not valid',
                    excluded: ':disabled',
                    feedbackIcons: faIcon,
                    fields: {
                        input_email: {
                            validators: {
                                notEmpty: {
                                    message: 'The email address is required and can\'t be empty'
                                },
                                emailAddress: {
                                    message: 'Ingrese correctamente el correo electronico'
                                }
                            }
                        },
                        input_dni: {
                            validators: {
                                notEmpty: {
                                    message: 'The phone number is required and cannot be empty'
                                },
                                digits: {
                                    message: 'The value can contain only digits'
                                }
                            }
                        },
                        input_telefono: {
                            validators: {
                                digits: {
                                    message: 'The value can contain only digits'
                                }
                            }
                        },
                        input_celular: {
                            validators: {
                                digits: {
                                    message: 'The value can contain only digits'
                                }
                            }
                        },
                        input_jornal: {
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
                    $('#previewing').attr('width', '300px');
                    //$('#previewing').attr('height', '300px');
                }
                ;
            });
        </script>

    </body>

    <!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:23:54 GMT -->
</html>

