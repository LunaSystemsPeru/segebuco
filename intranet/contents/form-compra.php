<?php

?>
<!DOCTYPE html>
<html lang="es">


<!-- Mirrored from mannatthemes.com/dastone/default/horizontal-index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 21 May 2021 20:34:16 GMT -->
<head>
    <meta charset="utf-8"/>
    <title>SEGEBUCO SAC | Gestion de Servicios</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Walga Inversiones | Transporte y Alquiler de Gruas" name="description"/>
    <meta content="" name="author"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>

    <!-- App favicon -->
    <link rel="shortcut icon" href="../assets/images/favicon.png">

    <!-- App css -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/css/metisMenu.min.css" rel="stylesheet" type="text/css"/>
    <link href="../plugins/daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css"/>

    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/base/jquery-ui.css" type="text/css" media="all"/>

</head>

<body data-layout="horizontal" class="">

<!-- Top Bar Start -->
<?php require '../fixed/top-bar.php' ?>
<!-- Top Bar End -->
<div class="page-wrapper">
    <!-- Page Content-->
    <div class="page-content">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <div class="row">
                            <div class="col">
                                <h4 class="page-title">Registrar Comprobante de Venta</h4>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Ventas</a></li>
                                    <li class="breadcrumb-item active">Facturacion</li>
                                </ol>
                            </div><!--end col-->
                        </div><!--end row-->
                    </div><!--end page-title-box-->
                </div><!--end col-->
            </div><!--end row-->
            <!-- end page title end breadcrumb -->
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Añadir Items </h4>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="input-descripcion">Descripcion del Servicio</label>
                                            <textarea class="form-control" rows="3" id="input-descripcion"><?php echo strtoupper($concepto) ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label" for="select-unidad">Unidad Medida</label>
                                            <select class="form-control" aria-label="Default select example" id="select-unidad">
                                                <?php
                                                $Parametro->setParametroId(6);
                                                $array_medidas = $Parametro->verFilas();
                                                foreach ($array_medidas as $fila) {
                                                    echo '<option value="' . $fila['id'] . '">' . $fila['descripcion'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label" for="input-precio-sinigv">Precio Unit s/IGV</label>
                                            <input type="number" class="form-control text-right" id="input-precio-sinigv"
                                                   placeholder="0.00" value="<?php echo number_format($monto / 1.18, 2) ?>" onkeyup="obtenerTotal()">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label" for="input-precio-total">Precio Unit c/IGV</label>
                                            <input type="number" value="<?php echo number_format($monto, 2) ?>" class="form-control text-right" id="input-precio-total"
                                                   placeholder="0.00" onkeyup="obtenerBase()">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div><!--end card-body-->
                        <div class="card-footer">
                            <div class="col-auto align-self-center">
                                <button onclick="agregarServicio()" class="btn btn-sm btn-soft-primary">
                                    <i data-feather="plus" class="fas fa-plus mr-2"></i>
                                    Agregar Servicio a la lista
                                </button>
                            </div><!--end col-->
                        </div>
                    </div><!--end card-->

                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Lista de Servicios del Comprobante</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped mb-0">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Servicio</th>
                                    <th>Und. Med</th>
                                    <th>P.Unit. +IGV</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody id="contenido-detalle">

                                </tbody>
                            </table><!--end /table-->
                        </div><!--end card-body-->
                    </div>
                </div> <!-- end col -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Detalle del Comprobante de Venta</h4>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="mb-3">
                                            <label class="form-label" for="input-fecha">Fecha Comprobante</label>
                                            <input type="hidden" value="<?php echo $contratoid ?>" id="hidden-idcontrato">
                                            <input type="date" class="form-control" id="input-fecha" value="<?php echo date("Y-m-d") ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="mb-3">
                                            <label class="form-label" for="select-comprobante">Tipo Comprobante</label>
                                            <select class="form-control" id="select-comprobante">
                                                <option value="3">BOLETA</option>
                                                <option <?php echo($Contrato->getComprobanteid() == 4 ? "selected" : "") ?> value="4">FACTURA</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="input_datos_cliente">Buscar Cliente</label>
                                            <input type="text" class="form-control" id="input_datos_cliente"
                                                   placeholder="Escriba razon social o ruc" value="<?php echo $Entidad->getRazonsocial() ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="input_documento_cliente">Nro Documento Cliente</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" id="input_documento_cliente"
                                                       placeholder="ingrese DNI o RUC" maxlength="11" value="<?php echo $Entidad->getNrodocumento() ?>">
                                                <input type="hidden" id="hidden-idcliente" value="<?php echo $clienteid ?>">
                                                <button class="btn btn-secondary" type="button" onclick="obtenerDatosDocumento()"><i class="fa fa-plus"></i> Buscar Datos</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="select-detraccion">Tipo Detraccion</label>
                                            <select class="form-control" aria-label="Default select example" id="select-detraccion">
                                                <?php
                                                $Parametro->setParametroId(7);
                                                $array_medidas = $Parametro->verFilas();
                                                foreach ($array_medidas as $fila) {
                                                    echo '<option value="' . $fila['id'] . '">' . $fila['descripcion'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="select-forma-pago">Forma de Pago</label>
                                            <div class="input-group">
                                                <select class="form-control" id="select-forma-pago" onchange="validarCredito()">
                                                    <?php
                                                    $Parametro->setParametroId(9);
                                                    $arrayFormaPago = $Parametro->verFilas();
                                                    foreach ($arrayFormaPago as $item) {
                                                        echo '<option value="' . $item['id'] . '">' . $item['descripcion'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                                <button class="btn btn-info" type="button" id="button-credito" onclick="abrirModalCredito()" disabled>Agregar Cuotas</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="exampleModalSignup" tabindex="-1" role="dialog" aria-labelledby="exampleModalDefaultSignup" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="modal-title m-0" id="exampleModalDefaultLogin">Cuotas de Credito</h6>
                                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                                </div><!--end modal-header-->
                                                <div class="modal-body">
                                                    <form class="form-horizontal auth-form">
                                                        <div class="form-group row">
                                                            <div class="col-lg-5">
                                                                <label for="serie">Fecha Vencimiento</label>
                                                                <div class="input-group mb-3">
                                                                    <input type="date" class="form-control text-center" id="input-fecha-cuota" value="<?php echo date("Y-m-d") ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-5">
                                                                <label for="numero">Monto Cuota</label>
                                                                <div class="input-group mb-3">
                                                                    <input type="number" class="form-control text-right" id="input-monto-cuota" placeholder="0">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <button class="btn btn-success btn-sm mt-3" type="button" onclick="agregarCuotas()"><i class="ti ti-plus"></i> Add</button>
                                                            </div>
                                                        </div><!--end form-group-->

                                                    </form><!--end form-->
                                                    <div>
                                                        <table class="table mb-0 table-centered">
                                                            <thead>
                                                            <tr>
                                                                <th>Item</th>
                                                                <th>Fecha</th>
                                                                <th>Monto</th>
                                                                <th class="text-right">Action</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody id="contenido-cuotas">
                                                            </tbody>
                                                        </table><!--end /table-->
                                                    </div>
                                                    <form class="form-horizontal auth-form">
                                                        <div class="form-group row">
                                                            <div class="col-lg-4">
                                                                <label for="serie">Total Credito</label>
                                                                <div class="input-group mb-3">
                                                                    <input type="text" class="form-control text-right" id="input-total-credito" value=".00" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <label for="numero">Acumulado Cuotas</label>
                                                                <div class="input-group mb-3">
                                                                    <input type="text" class="form-control text-right" id="input-acumulado-credito" value=".00" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <label for="numero">Pendiente Cuotas</label>
                                                                <div class="input-group mb-3">
                                                                    <input type="text" class="form-control text-right" id="input-pendiente-credito" value=".00" readonly>
                                                                </div>
                                                            </div>
                                                        </div><!--end form-group-->
                                                    </form><!--end form-->
                                                </div><!--end modal-body-->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                                                </div><!--end modal-footer-->
                                            </div><!--end modal-content-->
                                        </div><!--end modal-dialog-->
                                    </div><!--end modal-->
                                </div>
                                <div class="row">
                                    <div class="col-md-12 align-content-center">
                                        <div class="media mb-auto">
                                            <div class="media-body ">
                                                <p class="col-form-label mb-0">Total a cobrar </p>
                                                <h6 class="font-24" id="input-total-venta">.00</h6>
                                            </div><!--end media body-->
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div><!--end card-body-->
                        <div class="card-footer">
                            <div class="col-auto align-self-center">
                                <button onclick="finalizarVenta()" type="button" class="btn btn-sm btn-soft-primary" id="btn-grabar">
                                    <i data-feather="save" class="fas fa-save mr-2"></i>
                                    Generar Comprobante
                                </button>
                            </div><!--end col-->
                        </div>
                    </div><!--end card-->
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div><!-- container -->
    </div>
    <!-- end page content -->
</div>
<!-- end page-wrapper -->
<?php
include('../fixed/footer.php');
?>


<!-- jQuery  -->
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/metismenu.min.js"></script>
<script src="../assets/js/waves.js"></script>
<script src="../assets/js/feather.min.js"></script>
<script src="../assets/js/simplebar.min.js"></script>
<script src="../assets/js/moment.js"></script>
<script src="../plugins/daterangepicker/daterangepicker.js"></script>

<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"
        integrity="sha256-6XMVI0zB8cRzfZjqKcD01PBsAy3FlDASrlC8SxCpInY="
        crossorigin="anonymous"></script>

<!-- App js -->
<script src="../assets/js/app.js"></script>
<script>
    var arrayservicios = new Array();
    var totalventa = 0;
    var arrayCuotas = new Array();
    var totalcuotas = 0;
    var totalCredito = 0;

    //buscar clientes
    $("#input_datos_cliente").autocomplete({
        source: "../../inputAjax/obtenerJsonEntidades.php",
        minLength: 3,
        select: function (event, ui) {
            event.preventDefault();
            $("#input_datos_cliente").val(ui.item.razonsocial);
            $("#input_emisor_id").val(ui.item.id);
            $("#input_documento_cliente").val(ui.item.documento);
            $("#hidden-idcliente").val(ui.item.id);
            $("#input_documento_cliente").focus();
        }
    });

    //calcular monto sin igv
    function obtenerBase() {
        var montoTotal = $("#input-precio-total").val();
        var montoBase = montoTotal / 1.18;
        $("#input-precio-sinigv").val(montoBase.toFixed(2))
    }

    //calcular monto total
    function obtenerTotal() {
        var montoBase = $("#input-precio-sinigv").val();
        var montoTotal = montoBase * 1.18;
        $("#input-precio-total").val(montoTotal.toFixed(2))
    }

    //añadir servicio a un array
    function agregarServicio() {
        let item = (arrayservicios.length + 1);
        let descripcion = $("#input-descripcion").val();
        let preciototal = $("#input-precio-total").val();
        let unidadid = $("#select-unidad").val();
        let unidad_nombre = $("#select-unidad").find('option:selected').text();

        if (descripcion.length < 10) {
            alert("Falta descripcion del servicio")
            $("#input-descripcion").focus()
            return false;
        }

        if (preciototal < 1) {
            alert("No ha especificado precio del servicio")
            $("#input-precio-total").focus()
            return false
        }

        // se cargam los items en el array
        arrayservicios.push({"id": item, "descripcion": descripcion, "precio": preciototal, "unidadid": unidadid, "unidadnombre": unidad_nombre})
        mostrarItems()
        limpiarCampos()
    }

    function eliminarItem(item) {
        arrayservicios.forEach(function (car, index, object) {
            if (car.id == item) {
                object.splice(index, 1);
            }
        });

        mostrarItems();
    }

    function mostrarItems() {
        $("#contenido-detalle").html("");
        totalventa = 0
        var items = 1;
        for (var i = 0; i < arrayservicios.length; i++) {
            var totalitem = parseFloat(arrayservicios[i].precio);
            totalventa = totalventa + totalitem;

            $("#contenido-detalle").append('<tr>' +
                '<td class="text-center">' + items + '</td>' +
                '<td>' + arrayservicios[i].descripcion + '</td>' +
                '<td class="text-center">' + arrayservicios[i].unidadnombre + '</td>' +
                '<td class="text-end">' + totalitem.toFixed(2) + '</td>' +
                '<td class="text-end">' +
                '<a href="#"><i class="las la-pen text-secondary font-16"></i></a>' +
                '<a href="#"><i class="las la-trash-alt text-secondary font-16"></i></a>' +
                '</td>' +
                '</tr>');

            items++;
        }

        $("#input-total-venta").html(totalventa.toFixed(2))
    }

    function limpiarCampos() {
        $("#input-descripcion").val("");
        $("#input-precio-total").val("");
        $("#input-precio-sinigv").val("");
        $("#input-descripcion").focus()
    }

    function validarDocumentoComprobante() {
        let comprobanteid = $("#select-comprobante").val()
        var clienteid = $("#hidden-idcliente").val();
        let clientedocumento = $("#input_documento_cliente").val()
        if (totalventa == 0) {
            alert("Debe ingresar al menos un servicio, monto debe ser mayor a 0")
            return false
        }

        if (comprobanteid == 4) {
            //si factura cliente debe ser diferente a 0 o digitos debe ser 11
            if (clienteid == 0) {
                alert("Debe seleccionar un cliente, si no esta registrado escriba el numero de documento (DNI o RUC) y luego clic en buscar Datos")
                return false
            }

            if (clientedocumento.length != 11) {
                alert("Para emitir una factura cliente debe ser una empresa")
                return false
            }
        }

        if (comprobanteid == 3) {
            if (totalventa > 700) {
                if (clientedocumento.length <8) {
                    alert("Cliente debe ser documentado ")
                    return false
                }
            }
            //si boleta es menor a 700 puede ser 0 sino debe ser dni
        }
    }


    function obtenerDatosDocumento() {
        var nrodocumento = $("#input_documento_cliente").val();
        alert("Cargando Datos...\n espere un momento por favor");
        var arraypost = {nrodocumento: nrodocumento};
        $.post("../controller/registra-entidad.php", arraypost, function (data) {
            //console.log(data);
            var jsonresultado = JSON.parse(data);
            if (jsonresultado.success == "error") {
                alert("Error en el dni o ruc");
                return false;
            }
            if (jsonresultado.id > 0) {
                $("#hidden-idcliente").val(jsonresultado.id)
                $("#input_datos_cliente").val(jsonresultado.datos);
            }
        })
            .fail(function (data) {
                alert(data);
            });
    }

    function obtenerPorcentajeDetraccion(id) {
        let porcentaje = 0
        $.ajax({
            url: '../../inputAjax/obtenerDetraccion.php?id=' + id,
            headers: {"Accept": "application/json"},
            async: false,
            dataType: 'json',
            success: function (json) {
                //console.log(json)
                porcentaje = parseFloat(json.porcentaje)
            }
        });
        return porcentaje
    }

    function validarCredito() {
        let idcredito = $("#select-forma-pago").val();
        if (idcredito == 21) {
            //bloquear boton
            $("#button-credito").prop("disabled", true)
        } else {
            //habilitar boton
            $("#button-credito").prop("disabled", false)
        }
    }

    function abrirModalCredito() {
        let iddetraccion = $("#select-detraccion").val()
        let porcentaje = obtenerPorcentajeDetraccion(iddetraccion)
        totalCredito = totalventa - ((porcentaje / 100) * totalventa);
        $("#input-total-credito").val(totalCredito.toFixed(2))
        $("#exampleModalSignup").modal("toggle")
    }

    function agregarCuotas() {
        var ifecha = $("#input-fecha-cuota")
        var icuota = $("#input-monto-cuota")
        var idtem = arrayCuotas.length

        if (icuota.val() < 1) {
            alert("Debes ingresar monto mayor a 0 y menor o igual a " + totalCredito)
            return false
        }
        let sumaCredito = totalcuotas + parseFloat(icuota.val())
        //console.log(sumaCredito)
        if (sumaCredito > totalCredito) {
            alert("Revisar Monto no debe ser mayor a " + totalCredito)
            return false
        }
        arrayCuotas.push({"item": idtem, "fecha": ifecha.val(), "cuota": icuota.val()})
        icuota.val("")
        mostrarCuotas()
    }

    function obtenermontoCredito() {

    }

    function mostrarCuotas() {
        var items = 1;
        $("#contenido-cuotas").html("")
        totalcuotas = 0

        for (var i = 0; i < arrayCuotas.length; i++) {
            var cuotaitem = parseFloat(arrayCuotas[i].cuota);
            totalcuotas = totalcuotas + cuotaitem;

            $("#contenido-cuotas").append('<tr>' +
                '<td>' + items + '</td>' +
                '<td class="text-center">' + arrayCuotas[i].fecha + '</td>' +
                '<td class="text-right">' + cuotaitem + '</td>' +
                '<td class="text-right">' +
                '<button type="button" class="btn btn-warning btn-sm"><i class="ti ti-trash"></i></button>' +
                '</td>' +
                '</tr>');

            items++;
        }
        let pendientecredito = totalCredito - totalcuotas
        $("#input-pendiente-credito").val(pendientecredito.toFixed(2))
        $("#input-acumulado-credito").val(totalcuotas.toFixed(2))
    }

    function finalizarVenta() {
        validarDocumentoComprobante()

        $("#btn-grabar").prop("disabled", true);

        //enviar datos
        var arraypost = {
            inputFecha: $("#input-fecha").val(),
            inputTido: $("#select-comprobante").val(),
            inputClienteId: $("#hidden-idcliente").val(),
            inputContrato: $("#hidden-idcontrato").val(),
            inputMonto: totalventa,
            inputDetraccion: $("#select-detraccion").val(),
            arrayServicios: JSON.stringify(arrayservicios),
            arrayCuotas: JSON.stringify(arrayCuotas)
        };

       // console.log(arraypost)


        $.post("../controller/registra-venta.php", arraypost, function (data) {
             alert(data);
            var jsonresultado = JSON.parse(data);
            //si todo correcto enviar a imprimir ticket
            if (jsonresultado.id > 0) {
                alert("venta Registrada");
                location.href = "reporte-documento-venta.php?ventaid=" + jsonresultado.id;
            } else {
                alert("error al registrar venta" + data)
            }
        });
    }


</script>
</body>


<!-- Mirrored from mannatthemes.com/dastone/default/horizontal-index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 21 May 2021 20:35:01 GMT -->
</html>
