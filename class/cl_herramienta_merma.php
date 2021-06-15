<?php

include 'cl_conectar.php';

class cl_herramienta_merma {

    private $id_herramienta;
    private $id_almacen;
    private $cactual;
    private $cmerma;
    private $tipo;
    private $fecha;
    private $observacion;

    function __construct() {
        
    }

    function getId_herramienta() {
        return $this->id_herramienta;
    }

    function getId_almacen() {
        return $this->id_almacen;
    }

    function getCactual() {
        return $this->cactual;
    }

    function getCmerma() {
        return $this->cmerma;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getFecha() {
        return $this->fecha;
    }

    function setId_herramienta($id_herramienta) {
        $this->id_herramienta = $id_herramienta;
    }

    function setId_almacen($id_almacen) {
        $this->id_almacen = $id_almacen;
    }

    function setCactual($cactual) {
        $this->cactual = $cactual;
    }

    function setCmerma($cmerma) {
        $this->cmerma = $cmerma;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }
    
    function getObservacion() {
        return $this->observacion;
    }

    function setObservacion($observacion) {
        $this->observacion = $observacion;
    }

    function insertar() {
        $grabado = false;
        global $conn;
        $query = "insert into herramienta_merma "
                . "values ('" . $this->id_herramienta . "', '" . $this->id_almacen . "',  '" . $this->cactual . "', '" . $this->cmerma . "',  '" . $this->fecha . "', "
                . "'" . $this->tipo . "', '" . $this->observacion . "')";
        $resultado = $conn->query($query);
        echo $query;
        if (!$resultado) {
            die('Could not enter data in herramienta_merma: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }
    
    

}
