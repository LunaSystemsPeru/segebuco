<?php

require 'cl_conectar.php';

class cl_retorno_herramienta {

    private $retorno;
    private $periodo;
    private $herramienta;
    private $tipo;
    private $cantidad;
    private $documento;

    function __construct() {
        
    }

    function getRetorno() {
        return $this->retonro;
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
    
    function getDocumento() {
        return $this->documento;
    }

    function setRetorno($retorno) {
        $this->retorno = $retorno;
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
    
    function setDocumento($documento) {
        $this->documento = $documento;
    }

    function insertar() {
        $grabado = false;
        global $conn;
        $query = "insert into detalle_retorno_herramientas "
                . "values ('" . $this->retorno . "', '" . $this->periodo . "',  '" . $this->herramienta . "', '" . $this->tipo . "',  '" . $this->cantidad . "',  '" . $this->documento . "')";
        echo $query . "<br>";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in detalle_retorno_herramientas: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

}
