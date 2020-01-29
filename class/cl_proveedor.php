<?php

require 'cl_conectar.php';

class cl_proveedor {

    private $id;
    private $documento;
    private $razon;
    private $direccion;
    private $nombre_comercial;
    private $ultima_compra;
    private $total_compra;
    private $total_deuda;

    function __construct() {
        
    }

    function getId() {
        return $this->id;
    }

    function getDocumento() {
        return $this->documento;
    }

    function getRazon() {
        return $this->razon;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function getNombre_comercial() {
        return $this->nombre_comercial;
    }

    function getUltima_compra() {
        return $this->ultima_compra;
    }

    function getTotal_compra() {
        return $this->total_compra;
    }

    function getTotal_deuda() {
        return $this->total_deuda;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDocumento($documento) {
        $this->documento = $documento;
    }

    function setRazon($razon) {
        $this->razon = $razon;
    }

    function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    function setNombre_comercial($nombre_comercial) {
        $this->nombre_comercial = $nombre_comercial;
    }

    function setUltima_compra($ultima_compra) {
        $this->ultima_compra = $ultima_compra;
    }

    function setTotal_compra($total_compra) {
        $this->total_compra = $total_compra;
    }

    function setTotal_deuda($total_deuda) {
        $this->total_deuda = $total_deuda;
    }

    function insertar() {
        $grabado = false;
        global $conn;
        $query = "insert into proveedores values ('" . $this->id . "', '" . $this->documento . "',  '" . $this->razon . "',  '" . $this->nombre_comercial . "',  '" . $this->direccion . "',"
                . "  '1000-01-01',  '0', '0')";
        echo $query;
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in proveedores: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

}
