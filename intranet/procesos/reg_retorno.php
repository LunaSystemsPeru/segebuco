<?php
session_start();

require '../class/cl_retornos.php';
require '../class/cl_retorno_herramienta.php';
require '../class/cl_varios.php';
$cl_varios = new cl_varios();
$cl_retorno = new cl_retornos();
$cl_retorno_herramienta = new cl_retorno_herramienta();

$cl_retorno->setUsuario($_SESSION['usuario']);
$cl_retorno->setOrigen($_SESSION['almacen']);
$cl_retorno->setDestino(filter_input(INPUT_POST, 'select_destino'));
$cl_retorno->setPeriodo(filter_input(INPUT_POST, 'input_periodo'));
$cl_retorno->setCodigo($cl_retorno->obtener_id());
$cl_retorno->setFecha($cl_varios->fecha_web_mysql(filter_input(INPUT_POST, 'input_fecha')));

$grabar_retorno = $cl_retorno->insertar();

if ($grabar_retorno) {
    if (isset($_SESSION['retorno_herramienta'])) {
        $a_retorno_herramientas = $_SESSION['retorno_herramienta'];
        foreach ($a_retorno_herramientas as $fila) {
            foreach ($fila as $value) {
                $cl_retorno_herramienta->setCantidad($value['cantidad']);
                $cl_retorno_herramienta->setTipo($value['tipo']);
                $cl_retorno_herramienta->setHerramienta($value['id']);
                $cl_retorno_herramienta->setDocumento($value['codigo']);
                $cl_retorno_herramienta->setRetorno($cl_retorno->getCodigo());
                $cl_retorno_herramienta->setPeriodo($cl_retorno->getPeriodo());

                $cl_retorno_herramienta->insertar();
            }
        }
    }

    unset($_SESSION['retorno_herramienta']);
   //session_destroy();

?>
<script>
    window.location.href = "../ver_retornos.php";
</script>
    
<?php 
}