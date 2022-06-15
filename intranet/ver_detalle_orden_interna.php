<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

require 'class/cl_orden_interna.php';
require 'class/cl_cotizacion.php';
require 'class/cl_archivos_orden.php';
require 'class/cl_detalle_despacho_material.php';

$cl_ointerna = new cl_orden_interna();
$cl_cotizacion = new cl_cotizacion();
$cl_archivo = new cl_archivos_orden();

$cl_ointerna->setCodigo(filter_input(INPUT_GET, 'codigo'));
$cl_ointerna->datos_orden();

$a_datos_orden = $cl_ointerna->datos_orden_mix();
foreach ($a_datos_orden as $value) {
    $ncliente = $value['razon_social'];
    $nsucursal = $value['sucursal'];
    $solicitante = $value['solicitante'];
    $duracion = $value['dias_ejecucion'];
}

$porcentaje = $cl_ointerna->getAvance() / $cl_ointerna->getDias() * 100;
$d_avance = $cl_ointerna->getAvance();
$dias = $cl_ointerna->getDias();

if ($cl_ointerna->getEstado() == '0') {
    $fecha_termino = $cl_ointerna->getFecha_termino_aprox();
    if ($d_avance < $dias) {
        $estado = '<span class="label label-success ">en Produccion</span>';
        $eliminar = '';
    }
    if ($d_avance == $dias) {
        $estado = '<span class="btn btn-warning ">al Limite</span>';
    }
    if ($d_avance > $dias) {
        $estado = '<span class="btn btn-danger ">Fuera de Tiempo</span>';
    }
}
if ($cl_ointerna->getEstado() == '1') {
    $fecha_termino = $cl_ointerna->getFecha_termino_aprox();
    $estado = '<span class="btn btn-inverse btn-sm">Finalizado</span>';
    $porcentaje = 100;
    $d_avance = $dias;
}

$cl_cotizacion->setCodigo($cl_ointerna->getCotizacion());
$cl_cotizacion->datos_cotizacion();

$cl_archivo->setId_orden($cl_ointerna->getCodigo());
$a_archivos = $cl_archivo->ver_archivos();
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="es" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
    <!--<![endif]-->

    <head><meta http-equiv="Content-Type" content="text/html; charset=euc-jp">

        <title>Ver Detalle Orden Intern a| SEGEBUCO SAC</title>
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

            <!-- begin #sidebar -->
            <?php include 'includes/sidebar.php'; ?>
            <!-- end #sidebar -->

            <!-- begin #content -->
            <div id="content" class="content">
                <!-- begin breadcrumb -->
                <ol class="breadcrumb pull-right">
                    <li><a href="javascript:;">Inicio</a></li>
                    <li><a href="javascript:;">Proyectos</a></li>
                    <li class="active">modificar orden interna</li>
                </ol>
                <!-- end breadcrumb -->
                <!-- begin page-header -->
                <h1 class="page-header">Ver Detalle Orden Interna <small>matenimiento orden interna</small></h1>
                <!-- end page-header -->

                <div class="col-lg-8">
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <h4 class="panel-title">Datos Generales</h4>
                        </div>
                        <div class="panel-body">
                            <!-- begin table -->
                            <div class="table-responsive">
                                <table class="table table-profile">
                                    <thead>
                                        <tr>

                                            <th colspan="2">
                                                <h4><?php echo $cl_cotizacion->getDescripcion() ?></h4>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="field">
                                            <td class="field">cliente</td>
                                            <td><?php echo $ncliente ?></td>
                                        </tr>
                                        <tr class="field">
                                            <td class="field">Sucursal</td>
                                            <td><?php echo $nsucursal ?></td>
                                        </tr>
                                        <tr class="divider highlight">
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr class="field">
                                            <td class="field">Solicitante</td>
                                            <td><?php echo $solicitante ?></td>
                                        </tr>
                                        <tr class="field">
                                            <td class="field">Duracion</td>
                                            <td><?php echo $duracion ?></td>
                                        </tr>
                                        <tr>
                                            <td class="field">Fecha Inicio</td>
                                            <td><i class="fa fa-calendar fa-lg m-r-5"></i><?php echo $cl_ointerna->getFinicio() ?></td>
                                        </tr>
                                        <tr>
                                            <td class="field">Fecha Termino Aprox</td>
                                            <td><i class="fa fa-calendar fa-lg m-r-5"></i><?php echo $cl_ointerna->getFecha_termino_aprox() ?></td>
                                        </tr>
                                        <tr class="divider highlight">
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr class="field">
                                            <td class="field">Estado</td>
                                            <td><?php echo $estado ?></td>
                                        </tr>
                                        <tr class="field">
                                            <td class="field">Porcentaje</td>
                                            <td>
                                                <div class="progress progress-thin">
                                                    <?php
                                                    if ($cl_ointerna->getEstado() == '0') {
                                                        if ($porcentaje <= 100) {
                                                            ?>
                                                            <div class="progress-bar progress-bar-info" style="width:<?php echo number_format($porcentaje, 2) ?>%"><?php echo number_format($porcentaje, 2) ?>%</div>
                                                            <?php
                                                        }
                                                        if ($porcentaje > 100) {
                                                            ?>
                                                            <div class="progress-bar progress-bar-danger" style="width:100%">100%</div>
                                                            <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <div class="progress-bar progress-bar-inverse" style="width:<?php echo number_format($porcentaje, 2) ?>%"><?php echo number_format($porcentaje, 2) ?>%</div>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="field">
                                            <td class="field">Observaciones</td>
                                            <td><?php echo $cl_ointerna->getObservaciones() ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- end table -->
                        </div>
                        <!-- end profile-info -->
                    </div>
                    <!-- end profile-section -->
                </div>

                <div class="col-lg-4">
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="#modal_archivo" data-toggle="modal" class="btn btn-success btn-xs">Agregar</a>
                            </div>
                            <h4 class="panel-title">Archivos adjuntos</h4>
                        </div>
                        <div class="panel-body">
                            <table id="tabla_documentos" class="table table-striped table-bordered"  width="100%">
                                <thead>
                                    <tr>
                                        <th>Descripcion</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($a_archivos as $value) {
                                        ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $value['nombre'] ?></td>
                                            <td class="text-center">
                                                <a href="<?php echo "upload/" . $value['id_orden'] . "/" . $value['archivo'] ?>" target="blank" class="btn btn-info btn-xs"><i class="fa fa-download"></i></a>
                                                <a href="" target="blank" class="btn btn-warning btn-xs"><i class="fa fa-close"></i></a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <button onclick="exportTableToExcel('data-table', '<?php echo $cl_ointerna->getCodigo()?>')" class="btn btn-success btn-xs">Generar A. Excel</button>
                            </div>
                            <h4 class="panel-title">Detalle de Consumos</h4>
                        </div>
                        <div class="panel-body">
                            <table id="data-table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Empleado</th>
                                        <th>Cant.</th>
                                        <th>Materia Prima / Insumo</th>
                                        <th>Costo Total</th>
                                        <th>COD. VALE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $cl_despacho_material = new cl_detalle_despacho_material();
                                    $a_despachos = $cl_despacho_material->ver_detalle_colaborador($cl_ointerna->getCodigo());
                                    foreach ($a_despachos as $value) {
                                        ?>
                                        <tr class="odd gradeX">
                                            <td class="text-center"><?php echo $value['fecha'] ?></td>
                                            <td><?php echo $value['ape_pat'] . ' ' . $value['ape_mat'] . ' ' . $value['nombres'] ?></td>
                                            <td class="text-center"><?php echo $value['cantidad'] ?></td>
                                            <td><?php echo $value['descripcion'] ?></td>
                                            <td class="text-right"><?php echo number_format($value['costo'] * $value['cantidad'], 2, '.', ',') ?></td>
                                            <td class="text-center"><?php echo $value['anio'] . $value['id_despacho'] ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            </div>
            <!-- end #content -->

            <div class="modal fade" id="modal_archivo">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title">Agregar Archivo</h4>
                        </div>
                        <form class="form-horizontal" id="frm_registrar" method="post" action="procesos/reg_archivos_ointerna.php" enctype="multipart/form-data">
                            <div class="modal-body">

                                <div class="form-group">
                                    <label class="col-md-2 control-label">Descripcion</label>
                                    <div class="col-md-10">
                                        <input type="text" name="input_descripcion" class="form-control" required="true" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Seleccionar Archivo</label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="file" name="file" id="file" required/>
                                    </div>
                                </div>
                                <input type="hidden" name="input_orden" value="<?php echo $cl_ointerna->getCodigo() ?>"/>
                            </div>
                            <div class="modal-footer">
                                <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Cerrar</a>
                                <button type="submit" class="btn btn-sm btn-success">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
                        } else
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
            
            function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}
        </script>
    </body>

    <!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:23:54 GMT -->
</html>

