<?php
require 'class/cl_venta.php';
require 'class/cl_compra.php';
require 'class/cl_cliente.php';
require 'class/cl_varios.php';
require 'class/cl_orden_cliente.php';
require 'class/cl_entrega_epp.php';
require 'class/cl_orden_interna.php';
require 'class/cl_cotizacion.php';

$cl_ointerna = new cl_orden_interna();
$cl_cliente = new cl_cliente();
$cl_orden = new cl_orden_cliente();
$cl_venta = new cl_venta();
$cl_compra = new cl_compra();
$cl_varios = new cl_varios();
$cl_entrega_epp = new cl_entrega_epp();
$cl_cotizacion = new cl_cotizacion();

?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="es" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
	<!--<![endif]-->

	<head>
		<meta charset="utf-8" />
		<title>Resumen Semanal | SEGEBUCO SAC</title>
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

		<!-- ================== BEGIN BASE JS ================== -->
		<script src="assets/plugins/pace/pace.min.js"></script>
		<!-- ================== END BASE JS ================== -->
		
		<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
		<link href="assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
		<link href="assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
		<!-- ================== END PAGE LEVEL STYLE ================== -->

		<!-- ================== BEGIN PAGE CSS STYLE ================== -->
		<link href="assets/plugins/morris/morris.css" rel="stylesheet" />
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
		<div id="page-container" class="page-container fade page-without-sidebar page-without-header">
			<!-- begin #header -->
			<!-- end #header -->
			<?php
			$a_venta_periodo = $cl_venta->ver_ventas_periodo();
			$a_compra_periodo = $cl_compra->ver_compras_periodo();
			$j_venta_periodo = array();
			$j_compra_periodo = array();
			$fila_periodo = array();

			foreach ($a_venta_periodo as $value) {
				$fila_periodo['periodo'] = $value['periodo'];
				$fila_periodo['datos'] = $value['total'];
				array_push($j_venta_periodo, $fila_periodo);
			}

			foreach ($a_compra_periodo as $value) {
				$fila_periodo['periodo'] = $value['periodo'];
				$fila_periodo['datos'] = $value['total'];
				array_push($j_compra_periodo, $fila_periodo);
			}

			$j_ventas_cliente = array();
			$fila_vcliente = array();
			$a_clientes = $cl_cliente->ver_clientes_ventas();
			foreach ($a_clientes as $value) {
				$fila_vcliente['fila'] = $value['nombre_comercial'];
				$fila_vcliente['datos'] = $value['total_facturado'];
				array_push($j_ventas_cliente, $fila_vcliente);
			}
			
			$a_venta_anual = $cl_venta->ver_monto_anual();
			foreach ($a_venta_anual as $value) {
				$vanual = $value['total'];
			}
			
                        $vperiodo = 0;
			$cl_venta->setPeriodo(date('Y') . date('m'));
			$a_venta_eperiodo = $cl_venta->ver_monto_periodo();
			foreach ($a_venta_eperiodo as $value) {
				$vperiodo = $value['total'];
			}
			?>
		   

			<!-- begin #content -->
			<div id="content" class="content">
				<!-- begin breadcrumb -->
				
				<!-- end breadcrumb -->
				<!-- begin page-header -->
				<h1 class="page-header">SEGEBUCO SAC<small>Resumen Semanal - <?php echo date("Y" . "W")?></small></h1>
				<!-- end page-header -->
				<div class="row">
					<!-- begin col-3 -->
					<div class="col-md-3 col-sm-6">
						<div class="widget widget-stats bg-green">
							<div class="stats-icon"><i class="fa fa-desktop"></i></div>
							<div class="stats-info">
								<h4>TOTAL VENTAS</h4>
								<p>S/ <?php echo number_format($vanual, 2)?></p>    
							</div>
							<div class="stats-link">
								<a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
							</div>
						</div>
					</div>
					<!-- end col-3 -->
					<!-- begin col-3 -->
					<div class="col-md-3 col-sm-6">
						<div class="widget widget-stats bg-blue">
							<div class="stats-icon"><i class="fa fa-chain-broken"></i></div>
							<div class="stats-info">
								<h4>VENTAS ESTE MES</h4>
								<p>S/ <?php echo number_format($vperiodo, 2)?></p>  
							</div>
							<div class="stats-link">
								<a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
							</div>
						</div>
					</div>
					<!-- end col-3 -->
					<!-- begin col-3 -->
					<div class="col-md-3 col-sm-6">
						<div class="widget widget-stats bg-purple">
							<div class="stats-icon"><i class="fa fa-users"></i></div>
							<div class="stats-info">
								<h4>UNIQUE VISITORS</h4>
								<p>1,291,922</p>    
							</div>
							<div class="stats-link">
								<a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
							</div>
						</div>
					</div>
					<!-- end col-3 -->
					<!-- begin col-3 -->
					<div class="col-md-3 col-sm-6">
						<div class="widget widget-stats bg-red">
							<div class="stats-icon"><i class="fa fa-clock-o"></i></div>
							<div class="stats-info">
								<h4>% APROBACION</h4>
								<p>63.50%</p>   
							</div>
							<div class="stats-link">
								<a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
							</div>
						</div>
					</div>
					<!-- end col-3 -->
				</div>

				<div class="row">
					<div class="col-md-4">
						<div class="panel panel-inverse" data-sortable-id="morris-chart-3">
							<div class="panel-heading">
								<h4 class="panel-title">Ventas 2019</h4>
							</div>
							<div class="panel-body">
								<h4 class="text-center">Ventas por Periodo</h4>
								<div id="morris-bar-chart-venta" class="height-sm"></div>
							</div>
						</div>
					</div>

					<div class="col-md-4">
						<div class="panel panel-inverse" data-sortable-id="morris-chart-4">
							<div class="panel-heading">
								<h4 class="panel-title">Ventas x Clientes 2019</h4>
							</div>
							<div class="panel-body">
								<h4 class="text-center">Ventas por Clientes </h4>
								<div id="morris-bar-chart-vcliente" class="height-sm"></div>
							</div>
						</div>
					</div>
					
					<div class="col-md-4">
						<div class="panel panel-inverse" data-sortable-id="table-basic-4">
							<div class="panel-heading">
								<h4 class="panel-title">Facturas por Cobrar</h4>
							</div>
							<div class="panel-body">
								<div class="table-responsive">
									<table id="tabla_facturas" class="table table-striped">
										<thead>
											<tr>
												<th>#</th>
												<th>Cliente</th>
												<th>Cant.</th>
												<th>Mon.</th>
												<th>Total</th>
												<th>Dias</th>
											</tr>
										</thead>
										<tbody>
											<?php
												$a_resumen_cobranzas = $cl_venta->resumen_cobranza();
												$suma_total = 0;
												$contar = 1;
												$total_soles = 0;
												$total_dolares = 0;
												foreach ($a_resumen_cobranzas as $value) {
													$cl_venta->setCliente($value['cliente'] . ' | ' . $value['sucursal']);
													if ($value['id_moneda'] == 1) {
														$total_soles = $total_soles + $value['suma_total'];
													}
													if ($value['id_moneda'] == 2) {
														$total_dolares = $total_dolares + $value['suma_total'];
													}
												   ?> 
													<tr>
														<td><?php echo $contar?></td>
														<td><?php echo $cl_venta->getCliente()?></td>
														<td><?php echo $value['nro_docs']?></td>
														<td class="text-center"><?php echo $value['moneda']?></td>
														<td class="text-right"><?php echo number_format($value['suma_total'], 2)?></td>
														<td class="text-center"><?php echo $value['dias']?></td>
													</tr>
											 <?php
											 $contar++;
												}
												?>
											<tfoot>
												<tr>
													<td class="text-right" colspan="3">TOTAL</td>
													<td class="text-right">S/</td>
													<td class="text-right"><?php echo number_format($total_soles, 2, '.', ',') ?></td>
													<td class="text-right"></td>
												<tr>
												<tr>
													<td class="text-right" colspan="3">TOTAL</td>
													<td class="text-right">US$</td>
													<td class="text-right"><?php echo number_format($total_dolares, 2, '.', ',') ?></td>
													<td class="text-right"></td>
												<tr>
											</tfoot>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					
					<div class="col-md-3">
						<div class="panel panel-inverse">
							<div class="panel-heading">
								<h4 class="panel-title">EPP por Cambiar</h4>
							</div>
							<div class="panel-body">
								<div class="table-responsive">
									<table id="tabla_epps" class="table table-striped">
										<thead>
											<tr>
												<th>#</th>
												<th>Descripcion</th>
												<th>Cantidad</th>
											</tr>
										</thead>
										<tbody>
											<?php
												$a_resumen_epp = $cl_entrega_epp->resumen_cambios();
												$contar = 1;
												foreach ($a_resumen_epp as $value) {
												   ?> 
													<tr>
														<td><?php echo $contar?></td>
														<td><?php echo $value['epp']?></td>
														<td class="text-center"><?php echo $value['cantidad']?></td>
													</tr>
											 <?php
											 $contar++;
												}
												?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-md-9">
						<div class="panel panel-inverse">
							<div class="panel-heading">
								<h4 class="panel-title">Servicios Pendientes</h4>
							</div>
							<div class="panel-body">
								<div class="table-responsive">
								<table id="tabla_servicios" class="table table-striped">
									<thead>
										<tr>
											<th width="5%">Id.</th>
											<th width="17%">Cliente</th>
											<th width="45%">Descripcion</th>
											<th width="8%">Fecha Inicio</th>
											<th width="8%">Fecha Termino</th>
											<th width="10%">Progreso</th>
											<th width="7%">Estado</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$a_ordenes = $cl_ointerna->ver_ordenes_activas();
										foreach ($a_ordenes as $value) {
											if ($value['tipo_servicio'] == 1) {
												$servicio = 'A TODO COSTO';
											}
											if ($value['tipo_servicio'] == 2) {
												$servicio = 'POR ALQUILER DE TRANSPORTE';
											}
											if ($value['tipo_servicio'] == 3) {
												$servicio = 'POR COMPRA DE CHATARRA';
											}
											if ($value['tipo_servicio'] == 4) {
												$servicio = 'POR SOLO MANO DE OBRA';
											}
											if ($value['tipo_servicio'] == 5) {
												$servicio = 'POR MANO DE OBRA + CONSUMIBLES';
											}
											if ($value['tipo_servicio'] == 6) {
												$servicio = 'POR TRASLADO DE MERCADERIA';
											}
											
											$dias = $value['dias'];
											$d_avance = $value['d_avance'];
											$porcentaje = $d_avance / $dias * 100;
											
											
											if ($value['estado'] == '0') {
												$fecha_termino = $value['aprox_termino'];
												if ($d_avance < $dias) {
													$estado = '<span class="btn btn-success btn-sm">en Produccion</span>';
													$eliminar = '';
												}
												if ($d_avance == $dias) {
													$estado = '<span class="btn btn-warning btn-sm">al Limite</span>';
												}
												if ($d_avance > $dias) {
													$estado = '<span class="btn btn-danger btn-sm">Fuera de Tiempo</span>';
												}
											} 
											if ($value['estado'] == '1') {
												$fecha_termino = $value['fecha_termino'];
												$estado = '<span class="btn btn-inverse btn-sm">Finalizado</span>';
												$porcentaje = 100;
												$d_avance = $dias;
											} 
											
											?>
											<tr class="odd gradeX">
												<td class="text-center"><?php echo $value['id_orden']?></td>
												<td><?php echo $value['razon_social'] . ' | ' . $value['sucursal']?></td>
												<td><?php echo $value['descripcion'] . ' | ' . $servicio . ' | Cot. Nro: ' . $value['codigo'] . ' | ' . $d_avance . ' de ' . $dias . ' dias'?></td>
												<td class="text-right"><?php echo $value['fecha_inicio']?></td>
												<td class="text-right"><?php echo $fecha_termino?></td>
												<td>
													<div class="progress progress-thin">
														<?php 
														if ($value['estado'] == '0') {
															if ($porcentaje <= 100) {
														?>
															<div class="progress-bar progress-bar-info" style="width:<?php echo number_format($porcentaje, 2)?>%"><?php echo number_format($porcentaje, 2)?>%</div>
														<?php 
															}
															if ($porcentaje > 100) {
																?>
																<div class="progress-bar progress-bar-danger" style="width:100%">100%</div>
														<?php
															}
														} else {
														?>
															<div class="progress-bar progress-bar-inverse" style="width:<?php echo number_format($porcentaje, 2)?>%"><?php echo number_format($porcentaje, 2)?>%</div>
														<?php 
														} 
														?>
													  </div>
												</td>
												<td class="text-center"><?php echo $estado?></td>
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
				</div>
					
				<div class="row">
					<div class="col-md-6">
						<div class="panel panel-inverse">
							<div class="panel-heading">
								<h4 class="panel-title">Resumen Cotizaciones</h4>
							</div>
							<div class="panel-body">
								<div class="table-responsive">
									<table id="tabla_cotizaciones" class="table table-striped">
										<thead>
											<tr>
												<th>#</th>
												<th>Cliente</th>
												<th>TotaL</th>
												<th>Aprob. %</th>
												<th>Aprob.</th>
												<th>Con Orden</th>
												<th>Pend. Orden</th>
											</tr>
										</thead>
										<tbody>
											<?php
												$a_resumen_cotizacion = $cl_cotizacion->resumen_cotizaciones();
												$suma_total = 0;
												$contar = 1;
												$total_cotizaciones = 0;
												$total_aprobados = 0;
												$total_ordenes = 0;
												$total_sinorden = 0;
												foreach ($a_resumen_cotizacion as $value) {
													$cl_cotizacion->setCliente($value['razon_social'] . ' | ' . $value['sucursal']);
													
													$porcentaje_aprobados = $value['aprobados'] / $value['total_cotizaciones'];
													if ($porcentaje_aprobados > 0 ) {
													    $text_aprobado = number_format($porcentaje_aprobados * 100, 2) . ' %';
													} else {
													    $text_aprobado ='-';
													}
													$preaprobado = $value['preaprobado'];
													if ($preaprobado > 0 ) {
													    $text_preaprobado = $value['preaprobado'];
													} else {
													    $text_preaprobado ='-';
													}
													
													$total_cotizaciones = $total_cotizaciones + $value['total_cotizaciones'];
													$total_aprobados = $total_aprobados + $value['aprobados'];
													$total_ordenes = $total_ordenes + $value['ordenes'];
													$total_sinorden = $total_sinorden + $value['preaprobado'];
												   ?> 
													<tr>
														<td class="text-center"><?php echo $contar?></td>
														<td><?php echo $cl_cotizacion->getCliente()?></td>
														<td class="text-center"><?php echo $value['total_cotizaciones']?></td>
														<td class="text-center"><?php echo $text_aprobado?></td>
														<td class="text-center"><?php echo $value['aprobados']?></td>
														<td class="text-center"><?php echo $value['ordenes']?></td>
														<td class="text-center"><?php echo $text_preaprobado?></td>
													</tr>
											 <?php
											 $contar++;
												}
												$porcentaje_total = $total_aprobados / $total_cotizaciones;
												?>
										</tbody>
										<tfoot>
											<tr>
												<td class="text-right" colspan="2"><b>TOTAL</b></td>
												<td class="text-center"><b><?php echo $total_cotizaciones?></b></td>
												<td class="text-center"><b><?php echo number_format($porcentaje_total * 100, 2) . ' %'; ?></b></td>
												<td class="text-center"><b><?php echo $total_aprobados?></b></td>
												<td class="text-center"><b><?php echo $total_ordenes?></b></td>
												<td class="text-center"><b><?php echo $total_sinorden?></b></td>
											<tr>
										</tfoot>
									</table>
								</div>
							</div>
						</div>
					</div>
				
					<div class="col-md-6">
						<div class="panel panel-inverse">
							<div class="panel-heading">
								<h4 class="panel-title">Resumen Ordenes Pendientes</h4>
							</div>
							<div class="panel-body">
								<div class="table-responsive">
									<table id="tabla_ordenes" class="table table-striped">
										<thead>
											<tr>
												<th>#</th>
												<th>Cliente</th>
												<th>Mon</th>
												<th>Cant</th>
												<th>Total</th>
												<th>% Fact.</th>
												<th>Pendiente</th>
												<th>Dias</th>
											</tr>
										</thead>
										<tbody>
											<?php
												$a_resumen_ordenes = $cl_orden->ver_resumen_ordenes();
												$suma_total = 0;
												$contar = 1;
												foreach ($a_resumen_ordenes as $value) {
													$cl_orden->setCliente($value['cliente']);
												   ?> 
													<tr>
														<td class="text-center"><?php echo $contar?></td>
														<td><?php echo $cl_orden->getCliente()?></td>
														<td class="text-center"><?php echo $value['moneda'] ?></td>
														<td class="text-right"><?php echo $value['cantidad'] ?></td>
														<td class="text-right"><?php echo number_format($value['stotal'], 2) ?></td>
														<td class="text-center"><?php echo number_format($value['sfacturado'], 0) . ' %' ?></td>
														<td class="text-right"><?php echo number_format($value['pendiente'], 2) ?></td>
														<td class="text-center"><?php echo $value['dias'] ?></td>
													</tr>
											 <?php
											 $contar++;
												}
												?>
										</tbody>
									</table>
								</div>
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
		
		<script src="assets/plugins/DataTables/media/js/jquery.dataTables.js"></script>
		<script src="assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
		<script src="assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js"></script>

		<!-- ================== BEGIN PAGE LEVEL JS ================== -->
		<script src="assets/plugins/morris/raphael.min.js"></script>
		<script src="assets/plugins/morris/morris.js"></script>
		<script src="assets/js/chart-morris.demo.min.js"></script>
		<script src="assets/js/apps.min.js"></script>
		<!-- ================== END PAGE LEVEL JS ================== -->


		<script>
			$(document).ready(function () {
				App.init();
				MorrisChart.init();
				
			});
			
			

			var MorrisChart = function () {
				"use strict";
				return {
					init: function () {
						Barra_Ventas_Periodo();
						Barra_Ventas_Cliente();
					}
				};
			}();

			var blue = "#348fe2",
					blueLight = "#5da5e8",
					blueDark = "#1993E4",
					aqua = "#49b6d6",
					aquaLight = "#6dc5de",
					aquaDark = "#3a92ab",
					green = "#00acac",
					greenLight = "#33bdbd",
					greenDark = "#008a8a",
					orange = "#f59c1a",
					orangeLight = "#f7b048",
					orangeDark = "#c47d15",
					dark = "#2d353c",
					grey = "#b6c2c9",
					purple = "#727cb6",
					purpleLight = "#8e96c5",
					purpleDark = "#5b6392",
					red = "#ff5b57";

			var Barra_Ventas_Periodo = function () {
				Morris.Bar({
					element: "morris-bar-chart-venta",
					data: <?php print_r(json_encode($j_venta_periodo)) ?>,
					xkey: "periodo",
					ykeys: ["datos"],
					labels: ["Total S/"],
					barRatio: .4,
					xLabelAngle: 35,
					hideHover: "auto",
					resize: true,
					barColors: [blueLight]
				})
			};

			var Barra_Ventas_Cliente = function () {
				Morris.Bar({
					element: "morris-bar-chart-vcliente",
					data: <?php print_r(json_encode($j_ventas_cliente)) ?>,
					xkey: "fila",
					ykeys: ["datos"],
					labels: ["Total S/"],
					barRatio: .1,
					xLabelAngle: 35,
					hideHover: "auto",
					resize: true,
					barColors: [orangeLight]
				})
			};
		</script>
	</body>

	<!-- Mirrored from seantheme.com/color-admin-v1.9/admin/html/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 21 Mar 2016 14:23:54 GMT -->
</html>



