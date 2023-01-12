<?php

require 'cl_conectar.php';

class cl_devolucion_cilindro {

    private $periodo;
    private $id;
    private $id_cilindro;

    function __construct() {
        
    }

    function getPeriodo() {
        return $this->periodo;
    }

    function getId() {
        return $this->id;
    }

    function getId_cilindro() {
        return $this->id_cilindro;
    }

    function setPeriodo($periodo) {
        $this->periodo = $periodo;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setId_cilindro($id_cilindro) {
        $this->id_cilindro = $id_cilindro;
    }

    function insertar() {
        $grabado = false;
        global $conn;
        $query = "insert into detalle_devolucion_cilindro "
                . "values ('" . $this->id . "', '" . $this->periodo . "',  '" . $this->id_cilindro . "')";
        $resultado = $conn->query($query);
        echo $query;
        if (!$resultado) {
            die('Could not enter data in detalle_devolucion_cilindro: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function eliminar() {
        $grabado = false;
        global $conn;
        $query = "delete from detalle_devolucion_cilindro "
                . "where periodo = '" . $this->periodo . "' and id_devolucion  = '" . $this->id . "'";
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
