<?php

session_start();
require '../class/cl_ingresos.php';
require '../class/cl_detalle_ingreso_material.php';
require '../class/cl_detalle_ingreso_herramienta.php';
require '../class/cl_detalle_ingreso_cilindro.php';
require '../class/cl_varios.php';
$cl_varios = new cl_varios();
$cl_ingresos = new cl_ingresos();
$cl_ingreso_material = new cl_detalle_ingreso_material();
$cl_ingreso_herramienta = new cl_detalle_ingreso_herramienta();
$cl_ingreso_cilindro = new cl_detalle_ingreso_cilindro();

$cl_ingresos->setAlmacen($_SESSION['almacen']);
$cl_ingresos->setPeriodo(filter_input(INPUT_POST, 'input_periodo'));
$cl_ingresos->setCodigo($cl_ingresos->obtener_id());
$cl_ingresos->setTipo_documento(filter_input(INPUT_POST, 'select_documento'));
$cl_ingresos->setSerie(filter_input(INPUT_POST, 'input_serie'));
$cl_ingresos->setNumero(filter_input(INPUT_POST, 'input_numero'));
$cl_ingresos->setProveedor(filter_input(INPUT_POST, 'input_ruc_proveedor'));
$cl_ingresos->setFecha($cl_varios->fecha_web_mysql(filter_input(INPUT_POST, 'input_fecha')));
$cl_ingresos->setMoneda(filter_input(INPUT_POST, 'select_moneda'));
$cl_ingresos->setTc(filter_input(INPUT_POST, 'input_tc'));
$cl_ingresos->setTotal($_SESSION['suma_ingreso']);

$grabar_ingreso = $cl_ingresos->insertar();

if ($grabar_ingreso) {
    if (isset($_SESSION['ingreso_material'])) {
        $a_ingreso_materiales = $_SESSION['ingreso_material'];
        foreach ($a_ingreso_materiales as $fila) {
            foreach ($fila as $value) {
                $cl_ingreso_material->setCantidad($value['cantidad']);
                $cl_ingreso_material->setCosto($value['costo']);
                $cl_ingreso_material->setMarca($value['marca']);
                $cl_ingreso_material->setMaterial($value['id']);
                $cl_ingreso_material->setIngreso($cl_ingresos->getCodigo());
                $cl_ingreso_material->setPeriodo($cl_ingresos->getPeriodo());

                $cl_ingreso_material->insertar();
            }
        }
    }

    if (isset($_SESSION['ingreso_herramienta'])) {
        $a_ingreso_herramientas = $_SESSION['ingreso_herramienta'];
        foreach ($a_ingreso_herramientas as $fila) {
            foreach ($fila as $value) {
                $cl_ingreso_herramienta->setCantidad($value['cantidad']);
                $cl_ingreso_herramienta->setCosto($value['costo']);
                $cl_ingreso_herramienta->setTipo($value['tipo']);
                $cl_ingreso_herramienta->setHerramienta($value['id']);
                $cl_ingreso_herramienta->setIngreso($cl_ingresos->getCodigo());
                $cl_ingreso_herramienta->setPeriodo($cl_ingresos->getPeriodo());

                $cl_ingreso_herramienta->insertar();
            }
        }
    }

    if (isset($_SESSION['ingreso_botellas'])) {
        $a_ingreso_cilindros = $_SESSION['ingreso_botellas'];
        foreach ($a_ingreso_cilindros as $fila) {
            foreach ($fila as $value) {
                $cl_ingreso_cilindro->setCilindro($value['id']);
                $cl_ingreso_cilindro->setIngreso($cl_ingresos->getCodigo());
                $cl_ingreso_cilindro->setPeriodo($cl_ingresos->getPeriodo());

                $cl_ingreso_cilindro->insertar();
            }
        }
    }

    unset($_SESSION['ingreso_material']);
    unset($_SESSION['ingreso_botellas']);
    unset($_SESSION['ingreso_herramienta']);

?>
<script>
    window.location.href = "../ver_ingresos.php?periodo=<?php echo $cl_ingresos->getPeriodo()?>";
</script>
    
<?php  
// header("Location: ../ver_ingresos.php");
}