<?php

include 'cl_conectar.php';

class cl_cilindro {

    private $codigo;
    private $gas;
    private $capacidad;
    private $estado;

    function __construct() {
        
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getGas() {
        return $this->gas;
    }

    function getCapacidad() {
        return $this->capacidad;
    }

    function getEstado() {
        return $this->estado;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setGas($gas) {
        $this->gas = $gas;
    }

    function setCapacidad($capacidad) {
        $this->capacidad = $capacidad;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function insertar() {
        $grabado = false;
        global $conn;
        $query = "insert into cilindros values ('" . $this->codigo . "', '" . $this->gas . "',  '" . $this->capacidad . "', '14',  '1000-01-01', '1000-01-01', 0, 0)";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in cilindros: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function v_cilindros() {
        global $conn;
        $query = "select c.codigo, c.gas, c.capacidad, a.nombre, c.ingresa, c.devuelto, c.estado "
                . "from cilindros as c "
                . "inner join almacen as a on a.codigo = c.ubicacion "
                //. "where c.estado = '" . $this->estado . "'"
                . "order by c.codigo asc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

}
