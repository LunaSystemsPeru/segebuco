<?php

class cs_ajuste_materiales {

    private $id;
    private $descripcion;
    private $marca;
    private $csistema;
    private $cencontrado;
    private $costo;

    function __construct() {
        
    }

    function getId() {
        return $this->id;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getMarca() {
        return $this->marca;
    }

    function getCsistema() {
        return $this->csistema;
    }

    function getCencontrado() {
        return $this->cencontrado;
    }

    function getCosto() {
        return $this->costo;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setMarca($marca) {
        $this->marca = $marca;
    }

    function setCsistema($csistema) {
        $this->csistema = $csistema;
    }

    function setCencontrado($cencontrado) {
        $this->cencontrado = $cencontrado;
    }

    function setCosto($costo) {
        $this->costo = $costo;
    }

    function i_material() {
        $fila = array();
        $fila['id'] = $this->id;
        $fila['descripcion'] = $this->descripcion;
        $fila['marca'] = $this->marca;
        $fila['cencontrado'] = $this->cencontrado;
        $fila['csistema'] = $this->csistema;
        $fila['costo'] = $this->costo;
        $_SESSION['ajuste_material'][$this->id] = array();
        array_push($_SESSION['ajuste_material'][$this->id], $fila);
    }

    function d_material($item) {
        unset($_SESSION['ajuste_material'][$item]);
    }

}
