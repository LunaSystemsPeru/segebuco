<?php

require (cl_conectar . php);

class cl_orden_proveedor {

    private $anio;
    private $id;
    private $id_proveedor;
    private $fecha;
    private $glosa;
    private $id_moneda;
    private $total;
    private $pagado;
    private $estado;

    function __construct() {
        
    }

    function getAnio() {
        return $this->anio;
    }

    function getId() {
        return $this->id;
    }

    function getId_proveedor() {
        return $this->id_proveedor;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getGlosa() {
        return $this->glosa;
    }

    function getId_moneda() {
        return $this->id_moneda;
    }

    function getTotal() {
        return $this->total;
    }

    function getPagado() {
        return $this->pagado;
    }

    function getEstado() {
        return $this->estado;
    }

    function setAnio($anio) {
        $this->anio = $anio;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setId_proveedor($id_proveedor) {
        $this->id_proveedor = $id_proveedor;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function setGlosa($glosa) {
        $this->glosa = $glosa;
    }

    function setId_moneda($id_moneda) {
        $this->id_moneda = $id_moneda;
    }

    function setTotal($total) {
        $this->total = $total;
    }

    function setPagado($pagado) {
        $this->pagado = $pagado;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

}
