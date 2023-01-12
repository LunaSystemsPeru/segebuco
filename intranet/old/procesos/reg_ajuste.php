<?php

session_start();
require '../class/cl_ajuste.php';
require '../class/cl_ajuste_materiales.php';
require '../class/cl_varios.php';

$cl_varios = new cl_varios();
$cl_ajuste = new cl_ajuste();
$cl_detalle  =new cl_ajuste_materiales();

$cl_ajuste->setFecha(date("Y-m-d"));
$cl_ajuste->setAnio(date("Y"));
$cl_ajuste->obtener_id();
$cl_ajuste->setIdAlmacen($_SESSION['almacen']);
$cl_ajuste->setIdUsuario($_SESSION['usuario']);
$cl_ajuste->obtener_total_sistema();

$grabar_ajuste = $cl_ajuste->insertar();

if ($grabar_ajuste) {
    if (isset($_SESSION['ajuste_material'])) {
        $a_ajuste_materiales = $_SESSION['ajuste_material'];
        foreach ($a_ajuste_materiales as $fila) {
            foreach ($fila as $value) {
                $cl_detalle->setCencontrado($value['cencontrado']);
                $cl_detalle->setCsistema($value['csistema']);
                $cl_detalle->setCosto($value['costo']);
                $cl_detalle->setIdMaterial($value['id']);
                $cl_detalle->setIdAjuste($cl_ajuste->getIdAjuste());
                $cl_detalle->setAnio($cl_ajuste->getAnio());

                $cl_detalle->insertar();
            }
        }
    }

    unset($_SESSION['ajuste_material']);

?>
<script>
    window.location.href = "../ver_ajuste_materiales.php";
</script>
    
<?php  
// header("Location: ../ver_ingresos.php");
}