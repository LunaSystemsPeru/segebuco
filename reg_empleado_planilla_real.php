<?php 
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="es" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
    <!--<![endif]-->

    <head>
        <meta charset="utf-8" />
        <title>Detalle Planilla | SEGEBUCO SAC</title>
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
        <link href="assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
        <link href="assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
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
            <div id="content" class="content">
                <!-- begin breadcrumb -->
                <ol class="breadcrumb pull-right">
                    <li><a href="javascript:;">Inicio</a></li>
                    <li><a href="javascript:;">Planilla</a></li>
                    <li class="active">Detalle Planilla</li>
                </ol>
                <!-- end breadcrumb -->
                <!-- begin page-header -->
                <h1 class="page-header">Detalle de Planilla <small>matenimiento planilla</small></h1>
                <!-- end page-header -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-inverse">
                            <div class="panel-heading">
                                <h4 class="panel-title">Datos Generales</h4>
                            </div>
                            <div class="panel-body">
                                <form class="form-horizontal" id="frm_detalle">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Colaborador</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" readonly="true" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">DNI</label>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control" readonly="true" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Cargo</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" readonly="true" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Jornal</label>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control" readonly="true" />
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-inverse">
                            <div class="panel-heading">
                                <h4 class="panel-title">Horas Semanales</h4>
                            </div>
                            <div class="panel-body">
                                <table id="data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Dia</th>
                                            <th>Ingreso</th>
                                            <th>Salida</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="odd gradeX">
                                            <td >1</td>
                                            <td >JUEVES</td>
                                            <td class="text-center">
                                                <select class="form-control">
                                                    <option value="00">00:00</option>
                                                    <option value="01">01:00</option>
                                                    <option value="02">02:00</option>
                                                    <option value="03">03:00</option>
                                                    <option value="04">04:00</option>
                                                    <option value="05">05:00</option>
                                                    <option value="06">06:00</option>
                                                    <option value="07">07:00</option>
                                                    <option value="08">08:00</option>
                                                    <option value="09">09:00</option>
                                                    <option value="10">10:00</option>
                                                    <option value="11">11:00</option>
                                                    <option value="12">12:00</option>
                                                    <option value="13">13:00</option>
                                                    <option value="14">14:00</option>
                                                    <option value="15">15:00</option>
                                                    <option value="16">16:00</option>
                                                    <option value="17">17:00</option>
                                                    <option value="18">18:00</option>
                                                    <option value="19">19:00</option>
                                                    <option value="20">20:00</option>
                                                    <option value="21">21:00</option>
                                                    <option value="22">22:00</option>
                                                    <option value="23">23:00</option>
                                                    <option value="24">24:00</option>

                                                </select>
                                            </td>
                                            <td class="text-center">
                                                <select class="form-control">
                                                    <option value="00">00:00</option>
                                                    <option value="01">01:00</option>
                                                    <option value="02">02:00</option>
                                                    <option value="03">03:00</option>
                                                    <option value="04">04:00</option>
                                                    <option value="05">05:00</option>
                                                    <option value="06">06:00</option>
                                                    <option value="07">07:00</option>
                                                    <option value="08">08:00</option>
                                                    <option value="09">09:00</option>
                                                    <option value="10">10:00</option>
                                                    <option value="11">11:00</option>
                                                    <option value="12">12:00</option>
                                                    <option value="13">13:00</option>
                                                    <option value="14">14:00</option>
                                                    <option value="15">15:00</option>
                                                    <option value="16">16:00</option>
                                                    <option value="17">17:00</option>
                                                    <option value="18">18:00</option>
                                                    <option value="19">19:00</option>
                                                    <option value="20">20:00</option>
                                                    <option value="21">21:00</option>
                                                    <option value="22">22:00</option>
                                                    <option value="23">23:00</option>
                                                    <option value="24">24:00</option>

                                                </select>
                                            </td>
                                        </tr>
                                        <tr class="odd gradeX">
                                            <td >2</td>
                                            <td >VIERNES</td>
                                            <td class="text-center">
                                                <select class="form-control">
                                                    <option value="00">00:00</option>
                                                    <option value="01">01:00</option>
                                                    <option value="02">02:00</option>
                                                    <option value="03">03:00</option>
                                                    <option value="04">04:00</option>
                                                    <option value="05">05:00</option>
                                                    <option value="06">06:00</option>
                                                    <option value="07">07:00</option>
                                                    <option value="08">08:00</option>
                                                    <option value="09">09:00</option>
                                                    <option value="10">10:00</option>
                                                    <option value="11">11:00</option>
                                                    <option value="12">12:00</option>
                                                    <option value="13">13:00</option>
                                                    <option value="14">14:00</option>
                                                    <option value="15">15:00</option>
                                                    <option value="16">16:00</option>
                                                    <option value="17">17:00</option>
                                                    <option value="18">18:00</option>
                                                    <option value="19">19:00</option>
                                                    <option value="20">20:00</option>
                                                    <option value="21">21:00</option>
                                                    <option value="22">22:00</option>
                                                    <option value="23">23:00</option>
                                                    <option value="24">24:00</option>

                                                </select>
                                            </td>
                                            <td class="text-center">
                                                <select class="form-control">
                                                    <option value="00">00:00</option>
                                                    <option value="01">01:00</option>
                                                    <option value="02">02:00</option>
                                                    <option value="03">03:00</option>
                                                    <option value="04">04:00</option>
                                                    <option value="05">05:00</option>
                                                    <option value="06">06:00</option>
                                                    <option value="07">07:00</option>
                                                    <option value="08">08:00</option>
                                                    <option value="09">09:00</option>
                                                    <option value="10">10:00</option>
                                                    <option value="11">11:00</option>
                                                    <option value="12">12:00</option>
                                                    <option value="13">13:00</option>
                                                    <option value="14">14:00</option>
                                                    <option value="15">15:00</option>
                                                    <option value="16">16:00</option>
                                                    <option value="17">17:00</option>
                                                    <option value="18">18:00</option>
                                                    <option value="19">19:00</option>
                                                    <option value="20">20:00</option>
                                                    <option value="21">21:00</option>
                                                    <option value="22">22:00</option>
                                                    <option value="23">23:00</option>
                                                    <option value="24">24:00</option>

                                                </select>
                                            </td>
                                        </tr>
                                        <tr class="odd gradeX">
                                            <td >3</td>
                                            <td >SABADO</td>
                                            <td class="text-center">
                                                <select class="form-control">
                                                    <option value="00">00:00</option>
                                                    <option value="01">01:00</option>
                                                    <option value="02">02:00</option>
                                                    <option value="03">03:00</option>
                                                    <option value="04">04:00</option>
                                                    <option value="05">05:00</option>
                                                    <option value="06">06:00</option>
                                                    <option value="07">07:00</option>
                                                    <option value="08">08:00</option>
                                                    <option value="09">09:00</option>
                                                    <option value="10">10:00</option>
                                                    <option value="11">11:00</option>
                                                    <option value="12">12:00</option>
                                                    <option value="13">13:00</option>
                                                    <option value="14">14:00</option>
                                                    <option value="15">15:00</option>
                                                    <option value="16">16:00</option>
                                                    <option value="17">17:00</option>
                                                    <option value="18">18:00</option>
                                                    <option value="19">19:00</option>
                                                    <option value="20">20:00</option>
                                                    <option value="21">21:00</option>
                                                    <option value="22">22:00</option>
                                                    <option value="23">23:00</option>
                                                    <option value="24">24:00</option>

                                                </select>
                                            </td>
                                            <td class="text-center">
                                                <select class="form-control">
                                                    <option value="00">00:00</option>
                                                    <option value="01">01:00</option>
                                                    <option value="02">02:00</option>
                                                    <option value="03">03:00</option>
                                                    <option value="04">04:00</option>
                                                    <option value="05">05:00</option>
                                                    <option value="06">06:00</option>
                                                    <option value="07">07:00</option>
                                                    <option value="08">08:00</option>
                                                    <option value="09">09:00</option>
                                                    <option value="10">10:00</option>
                                                    <option value="11">11:00</option>
                                                    <option value="12">12:00</option>
                                                    <option value="13">13:00</option>
                                                    <option value="14">14:00</option>
                                                    <option value="15">15:00</option>
                                                    <option value="16">16:00</option>
                                                    <option value="17">17:00</option>
                                                    <option value="18">18:00</option>
                                                    <option value="19">19:00</option>
                                                    <option value="20">20:00</option>
                                                    <option value="21">21:00</option>
                                                    <option value="22">22:00</option>
                                                    <option value="23">23:00</option>
                                                    <option value="24">24:00</option>

                                                </select>
                                            </td>
                                        </tr>
                                        <tr class="odd gradeX">
                                            <td >4</td>
                                            <td >DOMINGO</td>
                                            <td class="text-center">
                                                <select class="form-control">
                                                    <option value="00">00:00</option>
                                                    <option value="01">01:00</option>
                                                    <option value="02">02:00</option>
                                                    <option value="03">03:00</option>
                                                    <option value="04">04:00</option>
                                                    <option value="05">05:00</option>
                                                    <option value="06">06:00</option>
                                                    <option value="07">07:00</option>
                                                    <option value="08">08:00</option>
                                                    <option value="09">09:00</option>
                                                    <option value="10">10:00</option>
                                                    <option value="11">11:00</option>
                                                    <option value="12">12:00</option>
                                                    <option value="13">13:00</option>
                                                    <option value="14">14:00</option>
                                                    <option value="15">15:00</option>
                                                    <option value="16">16:00</option>
                                                    <option value="17">17:00</option>
                                                    <option value="18">18:00</option>
                                                    <option value="19">19:00</option>
                                                    <option value="20">20:00</option>
                                                    <option value="21">21:00</option>
                                                    <option value="22">22:00</option>
                                                    <option value="23">23:00</option>
                                                    <option value="24">24:00</option>

                                                </select>
                                            </td>
                                            <td class="text-center">
                                                <select class="form-control">
                                                    <option value="00">00:00</option>
                                                    <option value="01">01:00</option>
                                                    <option value="02">02:00</option>
                                                    <option value="03">03:00</option>
                                                    <option value="04">04:00</option>
                                                    <option value="05">05:00</option>
                                                    <option value="06">06:00</option>
                                                    <option value="07">07:00</option>
                                                    <option value="08">08:00</option>
                                                    <option value="09">09:00</option>
                                                    <option value="10">10:00</option>
                                                    <option value="11">11:00</option>
                                                    <option value="12">12:00</option>
                                                    <option value="13">13:00</option>
                                                    <option value="14">14:00</option>
                                                    <option value="15">15:00</option>
                                                    <option value="16">16:00</option>
                                                    <option value="17">17:00</option>
                                                    <option value="18">18:00</option>
                                                    <option value="19">19:00</option>
                                                    <option value="20">20:00</option>
                                                    <option value="21">21:00</option>
                                                    <option value="22">22:00</option>
                                                    <option value="23">23:00</option>
                                                    <option value="24">24:00</option>

                                                </select>
                                            </td>
                                        </tr>
                                        <tr class="odd gradeX">
                                            <td >5</td>
                                            <td >LUNES</td>
                                            <td class="text-center">
                                                <select class="form-control">
                                                    <option value="00">00:00</option>
                                                    <option value="01">01:00</option>
                                                    <option value="02">02:00</option>
                                                    <option value="03">03:00</option>
                                                    <option value="04">04:00</option>
                                                    <option value="05">05:00</option>
                                                    <option value="06">06:00</option>
                                                    <option value="07">07:00</option>
                                                    <option value="08">08:00</option>
                                                    <option value="09">09:00</option>
                                                    <option value="10">10:00</option>
                                                    <option value="11">11:00</option>
                                                    <option value="12">12:00</option>
                                                    <option value="13">13:00</option>
                                                    <option value="14">14:00</option>
                                                    <option value="15">15:00</option>
                                                    <option value="16">16:00</option>
                                                    <option value="17">17:00</option>
                                                    <option value="18">18:00</option>
                                                    <option value="19">19:00</option>
                                                    <option value="20">20:00</option>
                                                    <option value="21">21:00</option>
                                                    <option value="22">22:00</option>
                                                    <option value="23">23:00</option>
                                                    <option value="24">24:00</option>

                                                </select>
                                            </td>
                                            <td class="text-center">
                                                <select class="form-control">
                                                    <option value="00">00:00</option>
                                                    <option value="01">01:00</option>
                                                    <option value="02">02:00</option>
                                                    <option value="03">03:00</option>
                                                    <option value="04">04:00</option>
                                                    <option value="05">05:00</option>
                                                    <option value="06">06:00</option>
                                                    <option value="07">07:00</option>
                                                    <option value="08">08:00</option>
                                                    <option value="09">09:00</option>
                                                    <option value="10">10:00</option>
                                                    <option value="11">11:00</option>
                                                    <option value="12">12:00</option>
                                                    <option value="13">13:00</option>
                                                    <option value="14">14:00</option>
                                                    <option value="15">15:00</option>
                                                    <option value="16">16:00</option>
                                                    <option value="17">17:00</option>
                                                    <option value="18">18:00</option>
                                                    <option value="19">19:00</option>
                                                    <option value="20">20:00</option>
                                                    <option value="21">21:00</option>
                                                    <option value="22">22:00</option>
                                                    <option value="23">23:00</option>
                                                    <option value="24">24:00</option>

                                                </select>
                                            </td>
                                        </tr>
                                        <tr class="odd gradeX">
                                            <td >6</td>
                                            <td >MARTES</td>
                                            <td class="text-center">
                                                <select class="form-control">
                                                    <option value="00">00:00</option>
                                                    <option value="01">01:00</option>
                                                    <option value="02">02:00</option>
                                                    <option value="03">03:00</option>
                                                    <option value="04">04:00</option>
                                                    <option value="05">05:00</option>
                                                    <option value="06">06:00</option>
                                                    <option value="07">07:00</option>
                                                    <option value="08">08:00</option>
                                                    <option value="09">09:00</option>
                                                    <option value="10">10:00</option>
                                                    <option value="11">11:00</option>
                                                    <option value="12">12:00</option>
                                                    <option value="13">13:00</option>
                                                    <option value="14">14:00</option>
                                                    <option value="15">15:00</option>
                                                    <option value="16">16:00</option>
                                                    <option value="17">17:00</option>
                                                    <option value="18">18:00</option>
                                                    <option value="19">19:00</option>
                                                    <option value="20">20:00</option>
                                                    <option value="21">21:00</option>
                                                    <option value="22">22:00</option>
                                                    <option value="23">23:00</option>
                                                    <option value="24">24:00</option>

                                                </select>
                                            </td>
                                            <td class="text-center">
                                                <select class="form-control">
                                                    <option value="00">00:00</option>
                                                    <option value="01">01:00</option>
                                                    <option value="02">02:00</option>
                                                    <option value="03">03:00</option>
                                                    <option value="04">04:00</option>
                                                    <option value="05">05:00</option>
                                                    <option value="06">06:00</option>
                                                    <option value="07">07:00</option>
                                                    <option value="08">08:00</option>
                                                    <option value="09">09:00</option>
                                                    <option value="10">10:00</option>
                                                    <option value="11">11:00</option>
                                                    <option value="12">12:00</option>
                                                    <option value="13">13:00</option>
                                                    <option value="14">14:00</option>
                                                    <option value="15">15:00</option>
                                                    <option value="16">16:00</option>
                                                    <option value="17">17:00</option>
                                                    <option value="18">18:00</option>
                                                    <option value="19">19:00</option>
                                                    <option value="20">20:00</option>
                                                    <option value="21">21:00</option>
                                                    <option value="22">22:00</option>
                                                    <option value="23">23:00</option>
                                                    <option value="24">24:00</option>

                                                </select>
                                            </td>
                                        </tr>
                                        <tr class="odd gradeX">
                                            <td >6</td>
                                            <td >MIERCOLES</td>
                                            <td class="text-center">
                                                <select class="form-control">
                                                    <option value="00">00:00</option>
                                                    <option value="01">01:00</option>
                                                    <option value="02">02:00</option>
                                                    <option value="03">03:00</option>
                                                    <option value="04">04:00</option>
                                                    <option value="05">05:00</option>
                                                    <option value="06">06:00</option>
                                                    <option value="07">07:00</option>
                                                    <option value="08">08:00</option>
                                                    <option value="09">09:00</option>
                                                    <option value="10">10:00</option>
                                                    <option value="11">11:00</option>
                                                    <option value="12">12:00</option>
                                                    <option value="13">13:00</option>
                                                    <option value="14">14:00</option>
                                                    <option value="15">15:00</option>
                                                    <option value="16">16:00</option>
                                                    <option value="17">17:00</option>
                                                    <option value="18">18:00</option>
                                                    <option value="19">19:00</option>
                                                    <option value="20">20:00</option>
                                                    <option value="21">21:00</option>
                                                    <option value="22">22:00</option>
                                                    <option value="23">23:00</option>
                                                    <option value="24">24:00</option>
                                                </select>
                                            </td>
                                            <td class="text-center">
                                                <select class="form-control">
                                                    <option value="00">00:00</option>
                                                    <option value="01">01:00</option>
                                                    <option value="02">02:00</option>
                                                    <option value="03">03:00</option>
                                                    <option value="04">04:00</option>
                                                    <option value="05">05:00</option>
                                                    <option value="06">06:00</option>
                                                    <option value="07">07:00</option>
                                                    <option value="08">08:00</option>
                                                    <option value="09">09:00</option>
                                                    <option value="10">10:00</option>
                                                    <option value="11">11:00</option>
                                                    <option value="12">12:00</option>
                                                    <option value="13">13:00</option>
                                                    <option value="14">14:00</option>
                                                    <option value="15">15:00</option>
                                                    <option value="16">16:00</option>
                                                    <option value="17">17:00</option>
                                                    <option value="18">18:00</option>
                                                    <option value="19">19:00</option>
                                                    <option value="20">20:00</option>
                                                    <option value="21">21:00</option>
                                                    <option value="22">22:00</option>
                                                    <option value="23">23:00</option>
                                                    <option value="24">24:00</option>

                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="panel-footer text-right" >
                                <button type="submit" class="btn btn-success">Agregar </button>
                            </div>
                        </div>
                    </div>
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
        <script src="assets/plugins/DataTables/media/js/jquery.dataTables.js"></script>
        <script src="assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
        <script src="assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
        <script src="assets/js/table-manage-default.demo.min.js"></script>
        <script src="assets/js/apps.min.js"></script>
        <!-- ================== END PAGE LEVEL JS ================== -->
        <script>
            $(document).ready(function () {
                App.init();
                TableManageDefault.init();
            });
        </script>
    </body>

    <!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:23:54 GMT -->
</html>

