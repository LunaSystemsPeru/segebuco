<?php

require 'cl_conectar.php';

class cl_traslado_material {

    private $traslado;
    private $periodo;
    private $material;
    private $costo;
    private $cantidad;

    function __construct() {
        
    }

    function getTraslado() {
        return $this->traslado;
    }

    function getPeriodo() {
        return $this->periodo;
    }

    function getMaterial() {
        return $this->material;
    }

    function getCosto() {
        return $this->costo;
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

    function setMaterial($material) {
        $this->material = $material;
    }

    function setCosto($costo) {
        $this->costo = $costo;
    }

    function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    function insertar() {
        $grabado = false;
        global $conn;
        $query = "insert into detalle_traslado_material values ('" . $this->traslado . "', '" . $this->periodo . "',  '" . $this->material . "', '" . $this->cantidad . "',  '" . $this->costo . "')";
        echo $query;
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in detalle_traslado_material: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

}
