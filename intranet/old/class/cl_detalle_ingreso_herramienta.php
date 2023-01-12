<?php

require 'cl_conectar.php';

class cl_detalle_ingreso_herramienta {
    private $ingreso;
    private $periodo;
    private $herramienta;
    private $tipo;
    private $cantidad;
    private $costo;
    
    function __construct() {
        
    }
    function getIngreso() {
        return $this->ingreso;
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

    function getCosto() {
        return $this->costo;
    }

    function setIngreso($ingreso) {
        $this->ingreso = $ingreso;
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

    function setCosto($costo) {
        $this->costo = $costo;
    }

    function insertar() {
        $grabado = false;
        global $conn;
        $query = "insert into detalle_ingreso_herramienta values ('" . $this->ingreso . "', '" . $this->periodo . "',  '" . $this->herramienta . "', '" . $this->tipo . "',  '" . $this->cantidad . "', '" . $this->costo . "', '0')";
        echo $query;
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in detalle_ingreso_herramienta: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }
    
    function eliminar() {
        $grabado = false;
        global $conn;
        $query = "delete from detalle_ingreso_herramienta "
                . "where ingreso = '" . $this->ingreso . "' and periodo = '" . $this->periodo . "' and herramienta = '" . $this->herramienta . "'";
        echo $query;
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in detalle_ingreso_herramienta: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }
}
