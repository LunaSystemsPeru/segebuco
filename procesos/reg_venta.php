<?php

require '../class/cl_venta.php';
require '../class/cl_venta_amarre.php';
require '../class/cl_proyectos.php';
require '../class/cl_orden_cliente.php';
require '../class/cl_varios.php';

$cl_venta = new cl_venta();
$cl_varios = new cl_varios();
$cl_orden = new cl_orden_cliente();
$cl_proyecto = new cl_proyectos();
$cl_amarre = new cl_venta_amarre();

$cl_venta->setPeriodo(filter_input(INPUT_POST, 'input_periodo'));
$cl_venta->setEstado(filter_input(INPUT_POST, 'hidden_estado'));
$cl_venta->setFecha_factura(filter_input(INPUT_POST, 'input_fecha'));
$cl_venta->setFecha_factura($cl_varios->fecha_web_mysql($cl_venta->getFecha_factura()));
$cl_venta->setFecha_cobro('2070-01-01');
$cl_venta->setGlosa(strtoupper(filter_input(INPUT_POST, 'input_glosa')));
$cl_venta->setMoneda(filter_input(INPUT_POST, 'select_moneda'));
$cl_venta->setTc(filter_input(INPUT_POST, 'input_tc'));
$cl_venta->setOrden(filter_input(INPUT_POST, 'select_orden'));
$cl_venta->setAceptacion(filter_input(INPUT_POST, 'input_aceptacion'));
$cl_venta->setCliente(filter_input(INPUT_POST, 'select_cliente'));
$cl_venta->setSucursal(filter_input(INPUT_POST, 'select_sucursal'));
$cl_venta->setPorcentaje(filter_input(INPUT_POST, 'input_porcentaje'));
$cl_venta->setTido(filter_input(INPUT_POST, 'select_documento'));
$cl_venta->setSerie(filter_input(INPUT_POST, 'input_serie'));
$cl_venta->setNumero(filter_input(INPUT_POST, 'input_numero'));
$cl_venta->setTotal(filter_input(INPUT_POST, 'hidden_total'));
$cl_venta->setCodigo($cl_venta->obtener_id());

if ($cl_venta->getOrden() != '-') {

//modificar orden
    $cl_orden->setCodigo($cl_venta->getOrden());
    $cl_orden->setFacturado($cl_venta->getPorcentaje());
    $a_orden = $cl_orden->datos_orden();
    foreach ($a_orden as $value) {
        $facturado = $value['facturado'];
    }
    if ($cl_orden->getFacturado() + $facturado == 100) {
        $cl_orden->setEstado(1);
    } else {
        $cl_orden->setEstado(0);
    }
//    $cl_orden->u_porcentaje_orden();
}
$registrado = $cl_venta->i_venta();

if ($cl_venta->getTido() == 14) {
    $cl_amarre->setIdVenta($cl_venta->getCodigo());
    $cl_amarre->setPeriodo($cl_venta->getPeriodo());
    $cl_amarre->setIdTido(filter_input(INPUT_POST, 'select_documento_amarre'));
    $cl_amarre->setFecha(filter_input(INPUT_POST, 'input_fecha_amarre'));
    $cl_amarre->setSerie(filter_input(INPUT_POST, 'input_serie_amarre'));
    $cl_amarre->setNumero(filter_input(INPUT_POST, 'input_numero_amarre'));

    $cl_amarre->insertar();
}

if ($registrado) {
    header ("Location: ../ver_ventas.php?periodo=".$cl_venta->getPeriodo());
    //echo "<center>La Factura ha sido registrada correctamente<br/>(por favor espere unos segundos hasta que direccione a la pagina de facturacion)</center>";
    ?>
    <script type="text/javascript">
      //  window.location.href = '../ver_ventas.php?periodo='<?php echo $cl_venta->getPeriodo() ?>;
    </script>
    <?php
}
?>
