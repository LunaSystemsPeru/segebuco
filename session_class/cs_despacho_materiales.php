<?php

class cs_despacho_materiales {

    private $id;
    private $descripcion;
    private $marca;
    private $cantidad;
    private $costo;

    function __construct() {
        
    }

    function getId() {
        return $this->id;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getCantidad() {
        return $this->cantidad;
    }

    function getCosto() {
        return $this->costo;
    }

    function getMarca() {
        return $this->marca;
    }

    function setMarca($marca) {
        $this->marca = $marca;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    function setCosto($costo) {
        $this->costo = $costo;
    }

    function i_material() {
        $fila = array();
        $fila['id'] = $this->id;
        $fila['descripcion'] = $this->descripcion;
        $fila['marca'] = $this->marca;
        $fila['cantidad'] = $this->cantidad;
        $fila['costo'] = $this->costo;
        $_SESSION['despacho_material'][$this->id] = array();
        array_push($_SESSION['despacho_material'][$this->id], $fila);
    }

    function d_material($item) {
        unset($_SESSION['despacho_material'][$item]);
    }

}
