<?php

require 'cl_conectar.php';

class cl_movimiento_banco {

    private $banco;
    private $periodo;
    private $movimiento;
    private $fecha;
    private $concepto;
    private $ingreso;
    private $egreso;

    function __construct() {
        
    }

    function getBanco() {
        return $this->banco;
    }

    function getPeriodo() {
        return $this->periodo;
    }

    function getMovimiento() {
        return $this->movimiento;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getConcepto() {
        return $this->concepto;
    }

    function getIngreso() {
        return $this->ingreso;
    }

    function getEgreso() {
        return $this->egreso;
    }

    function setBanco($banco) {
        $this->banco = $banco;
    }

    function setPeriodo($periodo) {
        $this->periodo = $periodo;
    }

    function setMovimiento($movimiento) {
        $this->movimiento = $movimiento;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function setConcepto($concepto) {
        $this->concepto = $concepto;
    }

    function setIngreso($ingreso) {
        $this->ingreso = $ingreso;
    }

    function setEgreso($egreso) {
        $this->egreso = $egreso;
    }

    function obtener_id() {
        $id = 1;
        global $conn;
        $query = "select ifnull(max(movimiento) + 1, 1) as codigo from movimiento_bancos where banco = '" . $this->banco . "' and periodo = '" . $this->periodo . "'";
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
        $query = "insert into movimiento_bancos values ('" . $this->banco . "', '" . $this->periodo . "', '" . $this->movimiento . "', '" . $this->fecha . "',  '" . $this->concepto . "',  '" . $this->ingreso . "', "
                . "'" . $this->egreso . "', NOW())";
        $resultado = $conn->query($query);
        echo $query;
        if (!$resultado) {
            die('Could not enter data in movimiento_bancos: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function ver_movimientos() {
        global $conn;
        $query = "select banco, movimiento, fecha, concepto, ingreso, egreso "
                . "from movimiento_bancos "
                . "where banco = '" . $this->banco . "' "
                . "order by fecha asc, movimiento asc";
        //echo $query;
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

}
