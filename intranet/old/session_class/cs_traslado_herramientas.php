<?php

class cs_traslado_herramientas {

    private $id;
    private $descripcion;
    private $tipo;
    private $cantidad;
    private $array_herramienta = array();

    function __construct() {
        
    }

    function getId() {
        return $this->id;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getCantidad() {
        return $this->cantidad;
    }

    function getArray_herramienta() {
        return $this->array_herramienta;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }


    function setArray_herramienta($array_herramienta) {
        $this->array_herramienta = $array_herramienta;
    }
    
    function insertar() {
        $fila = array();
        $fila['id'] = $this->id;
        $fila['descripcion'] = $this->descripcion;
        $fila['tipo'] = $this->tipo;
        $fila['cantidad'] = $this->cantidad;
        $_SESSION['traslado_herramienta'][$this->id] = array();
        array_push($_SESSION['traslado_herramienta'][$this->id], $fila);
    }

    function d_herramienta($item) {
        unset($_SESSION['traslado_herramienta'][$item]);
    }

}
