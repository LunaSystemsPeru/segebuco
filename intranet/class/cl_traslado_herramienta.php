<?php

require 'cl_conectar.php';

class cl_traslado_herramienta {

    private $traslado;
    private $periodo;
    private $herramienta;
    private $tipo;
    private $cantidad;

    function __construct() {
        
    }

    function getTraslado() {
        return $this->traslado;
    }

    function getPeriodo() {
        return $this->periodo;
    }

    function getHerramienta() {
        return $this->herramienta;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getCantidad() {
        return $this->cantidad;
    }

    function setTraslado($traslado) {
        $this->traslado = $traslado;
    }

    function setPeriodo($periodo) {
        $this->periodo = $periodo;
    }

    function setHerramienta($herramienta) {
        $this->herramienta = $herramienta;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    function insertar() {
        $grabado = false;
        global $conn;
        $query = "insert into detalle_traslado_herramienta values ('" . $this->traslado . "', '" . $this->periodo . "',  '" . $this->herramienta . "', '" . $this->tipo . "',  '" . $this->cantidad . "', '0')";
        echo $query;
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in detalle_traslado_herramienta: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

}
