<?php

include 'cl_conectar.php';

class cl_cilindros_almacen {

    private $almacen;
    private $cilindro;

    function __construct() {
        
    }

    function getAlmacen() {
        return $this->almacen;
    }

    function getCilindro() {
        return $this->cilindro;
    }

    function setAlmacen($almacen) {
        $this->almacen = $almacen;
    }

    function setCilindro($cilindro) {
        $this->cilindro = $cilindro;
    }

    function v_cilindros() {
        global $conn;
        $query = "select c.codigo, c.gas, c.capacidad, c.ingresa, c.devuelto, c.estado "
                . "from cilindro_almacen as ca "
                . "inner join cilindros as c on c.codigo = ca.cilindro "
                . "where ca.almacen = '" . $this->almacen . "'"
                . "order by codigo asc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

}
