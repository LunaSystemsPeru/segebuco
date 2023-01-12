<?php

require 'cl_conectar.php';

class cl_detalle_ingreso_cilindro {

    private $ingreso;
    private $periodo;
    private $cilindro;

    function __construct() {
        
    }

    function getIngreso() {
        return $this->ingreso;
    }

    function getPeriodo() {
        return $this->periodo;
    }

    function getCilindro() {
        return $this->cilindro;
    }

    function setIngreso($ingreso) {
        $this->ingreso = $ingreso;
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
        $query = "insert into detalle_ingreso_cilindro values ('" . $this->ingreso . "', '" . $this->periodo . "',  '" . $this->cilindro . "')";
        echo $query;
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in detalle_ingreso_cilindro: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

}
