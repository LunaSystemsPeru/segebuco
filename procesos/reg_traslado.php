<?php
session_start();

require '../class/cl_traslado.php';
require '../class/cl_traslado_material.php';
require '../class/cl_traslado_herramienta.php';
require '../class/cl_traslado_cilindro.php';
require '../class/cl_varios.php';
$cl_varios = new cl_varios();
$cl_traslado = new cl_traslado();
$cl_traslado_material = new cl_traslado_material();
$cl_traslado_herramienta = new cl_traslado_herramienta();
$cl_traslado_cilindro = new cl_traslado_cilindro();

$cl_traslado->setUsuario($_SESSION['usuario']);
$cl_traslado->setOrigen($_SESSION['almacen']);
$cl_traslado->setDestino(filter_input(INPUT_POST, 'select_destino'));
$cl_traslado->setPeriodo(filter_input(INPUT_POST, 'input_periodo'));
$cl_traslado->setCodigo($cl_traslado->obtener_id());
$cl_traslado->setDocumento(filter_input(INPUT_POST, 'select_documento'));
$cl_traslado->setSerie(filter_input(INPUT_POST, 'input_serie'));
$cl_traslado->setNumero(filter_input(INPUT_POST, 'input_numero'));
$cl_traslado->setFecha($cl_varios->fecha_web_mysql(filter_input(INPUT_POST, 'input_fecha')));

$grabar_traslado = $cl_traslado->insertar();

if ($grabar_traslado) {
    if (isset($_SESSION['traslado_material'])) {
        $a_traslado_materiales = $_SESSION['traslado_material'];
        foreach ($a_traslado_materiales as $fila) {
            foreach ($fila as $value) {
                $cl_traslado_material->setCantidad($value['cantidad']);
                $cl_traslado_material->setCosto($value['costo']);
                $cl_traslado_material->setMaterial($value['id']);
                $cl_traslado_material->setTraslado($cl_traslado->getCodigo());
                $cl_traslado_material->setPeriodo($cl_traslado->getPeriodo());

                $cl_traslado_material->insertar();
            }
        }
    }

    if (isset($_SESSION['traslado_herramienta'])) {
        $a_traslado_herramientas = $_SESSION['traslado_herramienta'];
        foreach ($a_traslado_herramientas as $fila) {
            foreach ($fila as $value) {
                $cl_traslado_herramienta->setCantidad($value['cantidad']);
                $cl_traslado_herramienta->setTipo($value['tipo']);
                $cl_traslado_herramienta->setHerramienta($value['id']);
                $cl_traslado_herramienta->setTraslado($cl_traslado->getCodigo());
                $cl_traslado_herramienta->setPeriodo($cl_traslado->getPeriodo());

                $cl_traslado_herramienta->insertar();
            }
        }
    }

    if (isset($_SESSION['traslado_botellas'])) {
        $a_traslado_cilindros = $_SESSION['traslado_botellas'];
        foreach ($a_traslado_cilindros as $fila) {
            foreach ($fila as $value) {
                $cl_traslado_cilindro->setCilindro($value['id']);
                $cl_traslado_cilindro->setTraslado($cl_traslado->getCodigo());
                $cl_traslado_cilindro->setPeriodo($cl_traslado->getPeriodo());

                $cl_traslado_cilindro->insertar();
            }
        }
    }

    unset($_SESSION['traslado_material']);
    unset($_SESSION['traslado_botellas']);
    unset($_SESSION['traslado_herramienta']);
   //session_destroy();

?>
<script>
    window.location.href = "../ver_traslados.php";
</script>
    
<?php 
   // header("Location: ../ver_traslados.php");
}