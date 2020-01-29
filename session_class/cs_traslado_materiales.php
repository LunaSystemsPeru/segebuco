<?php

class cs_traslado_materiales {

    private $id;
    private $descripcion;
    private $cantidad;
    private $costo;
    private $array_material = array();

    function __construct() {
        
    }

    function getId() {
        return $this->id;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getCosto() {
        return $this->costo;
    }

    function getCantidad() {
        return $this->cantidad;
    }

    function getArray_material() {
        return $this->array_material;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setCosto($costo) {
        $this->costo = $costo;
    }

    function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }


    function setArray_material($array_material) {
        $this->array_material = $array_material;
    }
    
    function insertar() {
        $fila = array();
        $fila['id'] = $this->id;
        $fila['descripcion'] = $this->descripcion;
        $fila['costo'] = $this->costo;
        $fila['cantidad'] = $this->cantidad;
        $_SESSION['traslado_material'][$this->id] = array();
        array_push($_SESSION['traslado_material'][$this->id], $fila);
    }

    function d_material($item) {
        unset($_SESSION['traslado_material'][$item]);
    }

}
