<?php

require 'cl_conectar.php';

class cl_detalle_ingreso_material {

    private $ingreso;
    private $periodo;
    private $material;
    private $marca;
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

    function getMaterial() {
        return $this->material;
    }

    function getMarca() {
        return $this->marca;
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

    function setMaterial($material) {
        $this->material = $material;
    }

    function setMarca($marca) {
        $this->marca = $marca;
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
        $query = "insert into detalle_ingreso_material values ('" . $this->ingreso . "', '" . $this->periodo . "',  '" . $this->material . "', '" . $this->marca . "',  '" . $this->cantidad . "', '" . $this->costo . "')";
        echo $query;
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in detalle_ingreso_material: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }
    
    function eliminar() {
        $grabado = false;
        global $conn;
        $query = "delete from detalle_ingreso_material where concat(periodo, ingreso) = '" . $this->ingreso . "'";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not delete data in detalle_ingreso_material: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

}
