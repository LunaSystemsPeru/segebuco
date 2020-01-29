<?php

class cs_ingreso_botellas {

    private $id;
    private $descripcion;

    function __construct() {
        
    }
    
    function getId() {
        return $this->id;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    
    function i_botella() {
        $fila = array();
        $fila['id'] = $this->id;
        $fila['descripcion'] = $this->descripcion;
        $_SESSION['ingreso_botellas'][$this->id] = array();
        array_push($_SESSION['ingreso_botellas'][$this->id], $fila);
    }

    function d_botella($item) {
        unset($_SESSION['ingreso_botellas'][$item]);
    }

}
