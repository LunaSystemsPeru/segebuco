<?php
session_start();
require '../class/cl_despacho_material.php';
require '../class/cl_detalle_despacho_material.php';
require '../class/cl_varios.php';
$cl_varios = new cl_varios();
$cl_despacho = new cl_despacho_material();
$cl_despacho_material = new cl_detalle_despacho_material();

$cl_despacho->setIdalmacen($_SESSION['almacen']);
$cl_despacho->setAnio(date('Y'));
$cl_despacho->setIddespacho($cl_despacho->obtener_id());
$cl_despacho->setIdcolaborador(filter_input(INPUT_POST, 'input_id_colaborador'));
$cl_despacho->setIdordeninterna(filter_input(INPUT_POST, 'input_id_servicio'));
$cl_despacho->setFecha($cl_varios->fecha_web_mysql(filter_input(INPUT_POST, 'input_fecha')));

$grabar_ingreso = $cl_despacho->insertar();

if ($grabar_ingreso) {
    if (isset($_SESSION['despacho_material'])) {
        $a_ingreso_materiales = $_SESSION['despacho_material'];
        foreach ($a_ingreso_materiales as $fila) {
            foreach ($fila as $value) {
                $cl_despacho_material->setCantidad($value['cantidad']);
                $cl_despacho_material->setCosto($value['costo']);
                $cl_despacho_material->setIdmaterial($value['id']);
                $cl_despacho_material->setIddespacho($cl_despacho->getIddespacho());
                $cl_despacho_material->setAnio($cl_despacho->getAnio());

                $cl_despacho_material->insertar();
            }
        }
    }

    
    unset($_SESSION['despacho_material']);

?>
<script>
    window.location.href = "../ver_despacho_materiales.php";
</script>
    
<?php  
// header("Location: ../ver_ingresos.php");
}