<?php

require 'cl_conectar.php';

class cl_traslado_cilindro {

    private $traslado;
    private $periodo;
    private $cilindro;

    function __construct() {
        
    }

    function getTraslado() {
        return $this->traslado;
    }

    function getPeriodo() {
        return $this->periodo;
    }

    function getCilindro() {
        return $this->cilindro;
    }

    function setTraslado($traslado) {
        $this->traslado = $traslado;
    }

    function setPeriodo($periodo) {
        $this->periodo = $periodo;
    }

    function setCilindro($cilindro) {
        $this->cilindro = $cilindro;
    }

    function insertar() {
        $grabado = false;
        global $conn;
        $query = "insert into detalle_traslado_cilindro values ('" . $this->traslado . "', '" . $this->periodo . "',  '" . $this->cilindro . "')";
        echo $query;
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in detalle_traslado_cilindro: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

}
