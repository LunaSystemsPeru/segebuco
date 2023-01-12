<?php
include '../fixed/cargarSession.php';
$namepage = basename(__FILE__);

require '../../models/Cliente.php';
require '../../models/ParametroDetalle.php';
require '../../models/Prestamo.php';

$Detalle = new ParametroDetalle();

$Detalle->setId(2);
$Detalle->obtenerDatos();

$Cliente = new Cliente();

$Cliente->setId(filter_input(INPUT_GET, 'clienteid'));
$Cliente->obtenerDatos();

$Prestamo = new Prestamo();
$Prestamo->setClienteid($Cliente->getId());

$sumadeuda = 0;
$a_prestamos = $Prestamo->verPrestamosxCliente();
foreach ($a_prestamos as $fila) {
    $sumadeuda += $fila['deudaactual'];
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
        Registrar prestamo
    </div>

</div>
<!-- * App Header -->


<!-- App Capsule -->
<div id="appCapsule">

    <!-- Transactions -->
    <div class="section mt-2 mb-2">
        <div class="card">
            <div class="card-body">
                <form>
                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label" for="text4">Solicitante</label>
                            <input type="text" class="form-control" id="text4" value="<?php echo $Cliente->getDatos() ?>" readonly>
                            <input type="hidden" id="input-cliente-id" value="<?php echo $Cliente->getId() ?>">
                        </div>
                    </div>

                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label" for="input-fecha-prestamo">Fecha </label>
                            <input type="date" class="form-control" id="input-fecha-prestamo" value="<?php echo date("Y-m-d") ?>">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label" for="input-monto-prestamo">Monto Solicitado</label>
                            <input type="text" class="form-control" id="input-monto-prestamo" autocomplete="off" min="1" max="10000"
                                   placeholder="monto a prestar" required>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label" for="input-tasa-interes">% Interes Mensual</label>
                            <input type="text" class="form-control" id="input-tasa-interes" autocomplete="off"
                                   placeholder="ingrese % interes mensual" value="<?php echo number_format($Detalle->getDescripcion() * 100, 3) ?>" required>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group basic mb-2">
                        <div class="input-wrapper">
                            <label class="label" for="input-nro-cuotas">escoja # Cuotas</label>
                            <select class="custom-select" id="input-nro-cuotas" name="input-nro-cuotas">
                                <option value="1">1</option>
                                <option value="6">6</option>
                                <option value="12">12</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group basic mb-2">
                        <div class="input-wrapper">
                            <label class="label" for="input-forma-pago">seleccione forma de Pago</label>
                            <select class="custom-select" id="input-forma-pago" name="input-forma-pago" onchange="calcularInteres()">
                                <?php
                                $Detalle->setIdparametro(4);
                                $a_formapago = $Detalle->verFilas();
                                foreach ($a_formapago as $fila) {
                                    echo '<option value="' . $fila['iddetalle'] . '">' . $fila['nombre'] . '</option>';
                                }
                                ?>
                            </select>
                            <input type="hidden" id="input-dias-pago" value="1">
                            <input type="hidden" id="input-interes-aplicado">
                        </div>
                    </div>

                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label" for="input-fecha-pago">cuando empezara a pagar? </label>
                            <input type="date" class="form-control" id="input-fecha-pago" value="">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>


                </form>
            </div>
            <div class="card-footer text-center">
                <button type="button" onclick="calcularCuota()" class="btn btn-outline-warning">
                    <ion-icon name="barcode-outline"></ion-icon>
                    Calcular Cuotas
                </button>
            </div>
        </div>
    </div>

    <div class="section mt-2 mb-2">
        <div class="card">
            <div class="card-body">
                <div class="form-group basic">
                    <div class="input-wrapper">
                        <label class="label" for="input-monto-cuota">monto x Cuota</label>
                        <input type="text" class="form-control" id="input-monto-cuota" value="0.00" readonly>
                    </div>
                </div>

                <div class="form-group basic">
                    <div class="input-wrapper">
                        <label class="label" for="input-total-pagar">Total a Pagar</label>
                        <input type="text" class="form-control" id="input-total-pagar" value="0.00" readonly>
                        <input type="hidden" id="input-monto-final-pago">
                    </div>
                </div>

                <div class="form-group basic">
                    <div class="input-wrapper">
                        <label class="label" for="input-deuda-actual">Deuda Actual</label>
                        <input type="text" class="form-control" id="input-deuda-actual" value="<?php echo number_format($sumadeuda, 2) ?>" readonly>
                        <input type="hidden" id="hidden-deuda-actual" value="<?php echo $sumadeuda ?>">
                    </div>
                </div>

                <div class="form-group basic">
                    <div><label class="label">Descontar Deuda</label></div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="input-entrega" onchange="obtenerMontoEntrega()" disabled>
                        <label class="form-check-label" for="input-entrega"></label>
                    </div>
                </div>

                <div class="form-group basic">
                    <div class="input-wrapper">
                        <label class="label" for="input-monto-entrega">monto a entregar</label>
                        <input type="text" class="form-control form-control-lg amount" id="input-monto-entrega" value="0.00" readonly>
                    </div>
                </div>

            </div>

            <div class="card-footer text-center">
                <button class="btn btn-success" id="btn-grabar-prestamo" onclick="enviarDatosForm()" disabled>
                    <ion-icon name="checkmark-outline"></ion-icon>
                    Grabar Prestamo
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

<script>
    var itemscuotas = Array();



    function calcularInteres() {
        var idforma = document.getElementById("select-forma-pago").value;
        $.post("../jsonResult/obtenerInteresFormaCuota.php", {idforma: idforma}, function (data) {
            //document.getElementById("#input-tasa-interes").valueparseFloat(data * 100).toFixed(5));
            document.getElementById("input-dias-pago").value = data;
            // console.log(data);
        });
    }

    function calcularCuota() {
        let monto = document.getElementById("input-monto-prestamo").value;
        let nrocuotas = document.getElementById("input-nro-cuotas").value;
        let tasainteres = document.getElementById("input-tasa-interes").value;
        tasainteres = parseFloat(tasainteres / 100);
        let nrodiasperiodo = document.getElementById("input-dias-pago").value;
        let fechapago = document.getElementById("input-fecha-pago").value

        if (!fechapago) {
            abrirAlerta('Indique fecha de inicio de pago')
            return;
        }

        if (!monto) {
            abrirAlerta('Indique el monto')
            return;
        }
        if (!nrocuotas) {
            abrirAlerta('Indique las cuotas');
            return;
        }
        if (!tasainteres) {
            abrirAlerta('Indique la tasa');
            return;
        }
        if (parseInt(nrocuotas) < 1) {
            abrirAlerta('Las cuotas deben ser de 1 en adelante');
            return;
        }

        let montocuota = getValorDeCuotaFija(monto, tasainteres, nrocuotas, nrodiasperiodo);
        document.getElementById("input-monto-cuota").value = parseFloat(montocuota).toFixed(2);
        //document.getElementById("input-total-prestamo").value = parseFloat(monto).toFixed(2);
        document.getElementById("input-total-pagar").value = parseFloat(montocuota * nrocuotas).toFixed(2);
        document.getElementById("input-monto-final-pago").value = parseFloat(montocuota * nrocuotas);
        document.getElementById("input-monto-entrega").value = parseFloat(monto).toFixed(2);


        itemscuotas = getAmortizacion(monto, tasainteres, nrocuotas, nrodiasperiodo);
        document.getElementById('btn-grabar-prestamo').disabled = false
        document.getElementById('input-entrega').disabled = false
        /*
        var tbody = document.getElementById("tbody_1");
        tbody.innerHTML = "";

        for (i = 0; i < itemscuotas.length; i++) {
            item = itemscuotas[i];
            tr = document.createElement("tr");
            for (e = 0; e < item.length; e++) {
                value = item[e];
                // if (e > 0) { value = setMoneda(value); }
                td = document.createElement("td");
                textCell = document.createTextNode(value);
                td.appendChild(textCell);
                tr.appendChild(td);
            }
            tbody.appendChild(tr);
        }
        */
    }


    function getAmortizacion(monto, tasa, cuotas, periodo) {
        var fechainicio = document.getElementById("input-fecha-pago").value
        var dias = document.getElementById("input-dias-pago").value
        var valor_de_cuota = getValorDeCuotaFija(monto, tasa, cuotas, periodo)
        var saldo_al_capital = monto
        var items = new Array()

        var fechatemp = fechainicio
        var fechacuota = ""

        for (i = 0; i < cuotas; i++) {
            interes = saldo_al_capital * getTasa(tasa, periodo);
            abono_al_capital = valor_de_cuota - interes;
            saldo_al_capital -= abono_al_capital;
            numero = i + 1;

            interes = interes.toFixed(2);
            abono_al_capital = abono_al_capital.toFixed(2);
            saldo_al_capital = saldo_al_capital.toFixed(2);
            if (i === 0) {
                fechacuota = fechainicio;
            } else {
                if (parseInt(dias) === 30) {
                    fechacuota = sumaFecha(parseInt(dias) + 1, fechatemp);
                    fechatemp = fechacuota;
                    fechacuota = ultimoDia(fechatemp);
                } else if (parseInt(dias) === 15) {
                    //si dia es mayor a 15 entonces mostrar ultimo dia del mes.
                    var date = new Date(fechatemp);
                    //console.log(date.getDate());
                    if (date.getDate() > 15) {
                        fechacuota = ultimoDia(fechatemp);
                        fechatemp = fechacuota;
                    }
                    fechacuota = sumaFecha(parseInt(dias) + 1, fechatemp);
                } else {
                    fechacuota = sumaFecha(parseInt(dias) + 1, fechatemp);
                }
                fechatemp = fechacuota;
            }

            //fechacuota = sumaFecha((i * dias) + 1, fechainicio);


            item = [numero, fechacuota, interes, abono_al_capital, parseFloat(valor_de_cuota).toFixed(2), saldo_al_capital];
            items.push(item);
        }
        return items;
    }

    function ultimoDia(fecha) {
        var date = new Date(fecha);
        var ultimoDia = new Date(date.getFullYear(), date.getMonth() + 1, 0);
        var anno = ultimoDia.getFullYear();
        var mes = ultimoDia.getMonth() + 1;
        var dia = ultimoDia.getDate();
        mes = (mes < 10) ? ("0" + mes) : mes;
        dia = (dia < 10) ? ("0" + dia) : dia;
        return anno + "-" + mes + "-" + dia;
    }

    sumaFecha = function (d, fecha) {
        fecha = new Date(fecha);
        fecha.setDate(fecha.getDate() + parseInt(d));
        var anno = fecha.getFullYear();
        var mes = fecha.getMonth() + 1;
        var dia = fecha.getDate();
        mes = (mes < 10) ? ("0" + mes) : mes;
        dia = (dia < 10) ? ("0" + dia) : dia;
        var fechaFinal = anno + "-" + mes + "-" + dia;
        return (fechaFinal);
    }


    function getTasa(tasa, periodo) {
        //if (tasa_tipo == ANUAL) { tasa = tasa / 12 }
        //tasa = tasa / 100.0
        //console.log("tasa diaria " + (Math.pow(1+tasa, 12/360)-1));

        periodo = parseInt(periodo);
        if (periodo === 1) {
            tasa = (Math.pow(1 + tasa, 12 / 360) - 1);  // 31.8648001
        }
        if (periodo === 7) {
            tasa = (Math.pow(1 + tasa, 12 / 360 * 7) - 1)
        }
        if (periodo === 15) {
            tasa = (Math.pow(1 + tasa, 12 / 360 * 15) - 1)
        }
        if (periodo === 30) {
        }
        document.getElementById("input-interes-aplicado").value = tasa;
        //        if (periodo === 1) { tasa = tasa / 30.4167 };
        //        if (periodo === 7) { tasa = tasa / 4.34524 };
        /*if (periodo == BIMESTRAL) { tasa = tasa * 2 };
        if (periodo == TRIMESTRAL) { tasa = tasa * 3 };
        if (periodo == CUATRIMESTRAL) { tasa = tasa * 4 };
        if (periodo == SEMESTRAL) { tasa = tasa * 6 };
        if (periodo == ANUAL) { tasa = tasa * 12 };*/
        return tasa;
    }

    function getValorDeCuotaFija(monto, tasa, cuotas, periodo) {
        tasa = getTasa(tasa, periodo);
        let valor = monto * ((tasa * Math.pow(1 + tasa, cuotas)) / (Math.pow(1 + tasa, cuotas) - 1));
        // valor =1 ;
        return valor.toFixed(0);
    }

    function obtenerMontoEntrega() {
        var checkbox = document.getElementById("input-entrega").checked

        var deudaactual = parseFloat(document.getElementById("hidden-deuda-actual").value)
        var montoprestamo = parseFloat(document.getElementById("input-monto-prestamo").value)
        var montoentrega = 0

        if (montoprestamo == null || montoprestamo == "") {
            montoprestamo = 0
            abrirAlerta('no ha ingresado monto a prestar')
            return
        }

        if (montoprestamo < deudaactual) {
            montoprestamo = 0
            abrirAlerta('Monto solicitado es menor a deuda, no se puede descontar, no viable')
            document.getElementById("input-entrega").checked = false
            return
        }

        if (checkbox) {
            montoentrega = montoprestamo - deudaactual;
        } else {
            montoentrega = montoprestamo
        }

        document.getElementById("input-monto-entrega").value = parseFloat(montoentrega).toFixed(2);
    }

    function abrirAlerta(messaje) {
        document.getElementById('div-message').innerHTML = ""
        document.getElementById('div-message').innerHTML = messaje
        toastbox('toast-11')
    }


    function enviarDatosForm() {
        if (itemscuotas.length === 0) {
            abrirAlerta('No ha establecido las cuotas');
            return;
        }

        var arrayform = {
            fecha_solicitud: document.getElementById('input-fecha-prestamo').value,
            nrocuotas: document.getElementById('input-nro-cuotas').value,
            monto_prestamo: document.getElementById('input-monto-prestamo').value,
            tipo_cuota_id: document.getElementById('input-forma-pago').value,
            cliente_id: document.getElementById('input-cliente-id').value,
            tasa_interes: document.getElementById('input-tasa-interes').value,
            monto_final: document.getElementById('input-monto-final-pago').value,
            monto_cuota: document.getElementById('input-monto-cuota').value,
            monto_descuento: document.getElementById('hidden-deuda-actual').value,
            pago_anterior: document.getElementById('input-entrega').checked,
            arrayCuotas: JSON.stringify(itemscuotas)
        };

        const data = new FormData();
        data.append('fecha_solicitud', document.getElementById('input-fecha-prestamo').value);
        data.append('nrocuotas', document.getElementById('input-nro-cuotas').value);
        data.append('monto_prestamo', document.getElementById('input-monto-prestamo').value);
        data.append('tipo_cuota_id', document.getElementById('input-forma-pago').value);
        data.append('cliente_id', document.getElementById('input-cliente-id').value);
        data.append('tasa_interes', document.getElementById('input-tasa-interes').value);
        data.append('monto_final', document.getElementById('input-monto-final-pago').value);
        data.append('monto_cuota', document.getElementById('input-monto-cuota').value);
        data.append('monto_descuento', document.getElementById('hidden-deuda-actual').value);
        data.append('pago_anterior', document.getElementById('input-entrega').checked);
        data.append('arrayCuotas', JSON.stringify(itemscuotas));

        fetch('../controller/reg-prestamo.php', {
            method: 'POST',
            body: data
        })
            .then(function (response) {
                if (response.ok) {
                    return response.text()
                } else {
                    throw "Error en la llamada Ajax";
                }
            })
            .then(function (texto) {
                console.log("respuesta " + texto);
                var json_data = JSON.parse(texto);
                var idprestamo = parseInt(json_data.id);
                if (idprestamo > 0) {
                    window.location.href = "app-prestamos-cuotas.php?idcliente=" + json_data.idcliente;
                } else {
                    alert("error al registrar")
                }
            })
            .catch(function (err) {
                console.log("error " + err);
            });

        /* var json_data = JSON.parse(data);
          var idprestamo = parseInt(json_data.id);
          if (idprestamo > 0) {
              window.location.href = "app-prestamos-cuotas.php?id=" + json_data.idcliente;
          } else {
              alert("error al registrar")
          }
         */
    }
</script>

</body>

</html>