<?php

require '../class/cl_venta.php';
require '../class/cl_varios.php';
require '../class/cl_orden_cliente.php';

$cl_venta = new cl_venta();
$cl_varios = new cl_varios();
$cl_orden = new cl_orden_cliente();

$cl_venta->setCliente(filter_input(INPUT_POST, 'cliente'));
$cl_venta->setSucursal(filter_input(INPUT_POST, 'sucursal'));
$cl_venta->setOrden(filter_input(INPUT_POST, 'orden'));

$cl_orden->setCodigo($cl_venta->getOrden());
$cl_orden->setCliente($cl_venta->getCliente());
$cl_orden->validar_orden();
?>

<FORM>
    <div class="form-group">
        <label class="col-md-2 control-label">Descripcion</label>
        <label class="col-md-10 text-muted"><?php echo $cl_orden->getCodigo() . " | " . $cl_orden->getGlosa() ?></label>
    </div>
</FORM>
<table id="tabla_facturas" class="table table-striped table-bordered nowrap" width="100%">
    <thead>
        <tr>
            <!--<th>Codigo</th>-->
            <th>Documento</th>
            <th>Fecha</th>
            <th>Razon Social</th>
            <th>Moneda</th>
            <th>Total</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $a_ventas = $cl_venta->ver_ventas_ordencliente();
        $suma_ventas = 0;
        $suma_total = 0;
        $suma_pagado = 0;
        foreach ($a_ventas as $value) {
            $cl_venta->setEstado($value['estado']);
            $cl_venta->setCodigo($cl_varios->zerofill($value['codigo'], 3));
            $cl_venta->setSerie($cl_varios->zerofill($value['serie'], 3));
            $cl_venta->setNumero($cl_varios->zerofill($value['numero'], 7));
            $cl_venta->setTotal($value['total']);
            $cl_venta->setTc($value['tipo_cambio']);
            $total_soles = $cl_venta->getTotal() * $cl_venta->getTc();
            $suma_ventas = $suma_ventas + $cl_venta->getTotal();
            $suma_total = $suma_total + $total_soles;
            $suma_pagado = $suma_pagado + $value['pagado'];
            if ($cl_venta->getEstado() == 0) {
                $activo = true;
                $cl_venta->setCliente($value['cliente'] . ' | ' . $value['sucursal']);
                $cl_venta->setEstado('<span class="btn btn-warning btn-sm">Pendiente</span>');
                $btn_borrar = '<a href="ver_detalle_cliente.php?codigo=10469932091" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
            }
            if ($cl_venta->getEstado() == 1) {
                $activo = true;
                $cl_venta->setCliente($value['cliente'] . ' | ' . $value['sucursal']);
                $cl_venta->setEstado('<span class="btn btn-success btn-sm">Pagado</span>');
                $btn_borrar = '';
            }
            if ($cl_venta->getEstado() == 2) {
                $activo = false;
                $cl_venta->setCliente('****  ANULADO  ****');
                $cl_venta->setEstado('<span class="btn btn-danger btn-sm">Anulado</span>');
                $btn_borrar = '';
            }
            ?>
            <tr class="odd gradeX">
                <!--<td class="text-center"><?php echo $value['periodo'] . $cl_venta->getCodigo() ?></td></td>-->
                <td class="text-center"><?php echo $value['tido'] . '/ ' . $cl_venta->getSerie() . '-' . $cl_venta->getNumero() ?></td>                                                        
                <td class="text-center"><?php echo $value['fecha_factura'] ?></td>
                <td><?php echo $cl_venta->getCliente() ?></td>
                <td class="text-right"><?php echo $value['moneda'] ?></td>
                <td class="text-right"><?php echo number_format($cl_venta->getTotal(), 2, '.', ','); ?></td>
                <td class="text-center"><?php echo $cl_venta->getEstado() ?></td>
            </tr>
            <?php
        }
        ?>
    <tfoot>
    <td class="text-right" colspan="4">TOTAL</td>
    <td class="text-right"><?php echo number_format($suma_ventas, 2, '.', ',') ?></td>
    <td class="text-center"></td>
    </tfoot>
    </tbody>
</table>
