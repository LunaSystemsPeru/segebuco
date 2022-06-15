<?php

class cs_retorno_herramientas {

    private $id;
    private $descripcion;
    private $tipo;
    private $codigo;
    private $cantidad;
    private $documento;
    private $array_herramienta = array();

    function __construct() {
        
    }

    function getId() {
        return $this->id;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getCodigo() {
        return $this->codigo;
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
    
    function getDocumento() {
        return $this->documento;
    }

    function setDocumento($documento) {
        $this->documento = $documento;
    }

    function setId($id) {
        $this->id = $id;
    }
    
    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
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
        $fila['codigo'] = $this->codigo;
        $fila['documento'] = $this->documento;
        $fila['cantidad'] = $this->cantidad;
        $_SESSION['retorno_herramienta'][$this->id] = array();
        array_push($_SESSION['retorno_herramienta'][$this->id], $fila);
    }

    function d_herramienta($item) {
        unset($_SESSION['retorno_herramienta'][$item]);
    }

}
