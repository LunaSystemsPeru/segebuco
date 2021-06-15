<?php

require 'cl_conectar.php';

class cl_movimiento_caja {

    private $caja;
    private $movimiento;
    private $concepto;
    private $ingresa;
    private $egresa;
    private $fecha;
    private $ccosto;
    private $tabla;
    private $id_tipo_gasto;
    private $ctabla;

    function __construct() {
        
    }

    function getCaja() {
        return $this->caja;
    }

    function getMovimiento() {
        return $this->movimiento;
    }

    function getConcepto() {
        return $this->concepto;
    }

    function getIngresa() {
        return $this->ingresa;
    }

    function getEgresa() {
        return $this->egresa;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getCcosto() {
        return $this->ccosto;
    }

    function setCaja($caja) {
        $this->caja = $caja;
    }

    function setMovimiento($movimiento) {
        $this->movimiento = $movimiento;
    }

    function setConcepto($concepto) {
        $this->concepto = $concepto;
    }

    function setIngresa($ingresa) {
        $this->ingresa = $ingresa;
    }

    function setEgresa($egresa) {
        $this->egresa = $egresa;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function setCcosto($ccosto) {
        $this->ccosto = $ccosto;
    }

    function getTabla() {
        return $this->tabla;
    }

    function getCtabla() {
        return $this->ctabla;
    }

    function setTabla($tabla) {
        $this->tabla = $tabla;
    }

    function setCtabla($ctabla) {
        $this->ctabla = $ctabla;
    }

    function getId_tipo_gasto() {
        return $this->id_tipo_gasto;
    }

    function setId_tipo_gasto($id_tipo_gasto) {
        $this->id_tipo_gasto = $id_tipo_gasto;
    }

    function obtener_id() {
        $id = 1;
        global $conn;
        $query = "select ifnull(max(movimiento) + 1, 1) as codigo from movimiento_caja where caja = '" . $this->caja . "'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $id = $fila ['codigo'];
            }
        }
        return $id;
    }

    function insertar() {
        $grabado = false;
        global $conn;
        $query = "insert into movimiento_caja values ('" . $this->caja . "', '" . $this->movimiento . "',  '" . $this->concepto . "', '" . $this->fecha . "',  '" . $this->ingresa . "', "
                . "'" . $this->egresa . "', '" . $this->ccosto . "', '" . $this->tabla . "', '" . $this->ctabla . "', '" . $this->id_tipo_gasto . "', NOW())";
        $resultado = $conn->query($query);
        echo $query;
        if (!$resultado) {
            die('Could not enter data in movimiento_caja: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function ver_movimientos() {
        global $conn;
        $query = "select caja, movimiento, fecha, concepto, ingreso, egreso, ccosto "
                . "from movimiento_caja "
                . "where caja = '" . $this->caja . "' and year(fecha) = year(current_date()) and month(fecha) = month(current_date()) "
                . "order by fecha asc, movimiento asc";
        //echo $query;
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function ver_movimiento_ccosto () {
        global $conn;
        $query = "SELECT mc.id_tipo_gasto, dtg.descripcion, sum(mc.egreso - mc.ingreso) as total_gastos 
        FROM movimiento_caja as mc 
        inner join detalle_tabla_general as dtg on dtg.general = 10 and dtg.id = mc.id_tipo_gasto 
        WHERE ccosto = '".$this->ccosto."' 
        GROUP by mc.id_tipo_gasto 
        order by dtg.descripcion asc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

}
