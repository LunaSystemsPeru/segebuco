<?php

include 'cl_conectar.php';

class cl_cobro_venta {

    private $venta;
    private $periodo;
    private $codigo;
    private $fecha;
    private $banco;
    private $moneda;
    private $tc;
    private $monto;

    function __construct() {
        
    }

    function getVenta() {
        return $this->venta;
    }

    function getPeriodo() {
        return $this->periodo;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getBanco() {
        return $this->banco;
    }

    function getMoneda() {
        return $this->moneda;
    }

    function getTc() {
        return $this->tc;
    }

    function getMonto() {
        return $this->monto;
    }

    function setVenta($venta) {
        $this->venta = $venta;
    }

    function setPeriodo($periodo) {
        $this->periodo = $periodo;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function setBanco($banco) {
        $this->banco = $banco;
    }

    function setMoneda($moneda) {
        $this->moneda = $moneda;
    }

    function setTc($tc) {
        $this->tc = $tc;
    }

    function setMonto($monto) {
        $this->monto = $monto;
    }

    function ver_cobros() {
        global $conn;
        $query = "select cv.codigo, cv.fecha, cv.moneda, cv.monto, cv.tc, b.nombre as nbanco "
                . "from cobro_ventas as cv "
                . "inner join caja_bancos as b on b.codigo = cv.banco "
                . "where cv.periodo = '" . $this->periodo . "' and cv.venta = '" . $this->venta . "'";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function obtener_id() {
        $id = 1;
        global $conn;
        $query = "select ifnull(max(codigo) + 1, 1) as codigo "
                . "from cobro_ventas "
                . "where periodo = '" . $this->periodo . "' and venta = '" . $this->venta . "'";
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
        $query = "insert into cobro_ventas "
                . "values ('" . $this->codigo . "', '" . $this->periodo . "', '" . $this->venta . "', '" . $this->moneda . "', '" . $this->tc . "', '" . $this->monto . "', '" . $this->fecha . "', '" . $this->banco . "')";
        $resultado = $conn->query($query);
       //echo $query;
        if (!$resultado) {
            die('Could not enter data in cobro_ventas: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

}
