<?php

include 'cl_conectar.php';

class cl_almacen {

    private $codigo;
    private $cliente;
    private $sucursal;
    private $nombre;
    private $estado;

    function __construct() {
        
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getCliente() {
        return $this->cliente;
    }

    function getSucursal() {
        return $this->sucursal;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getEstado() {
        return $this->estado;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setCliente($cliente) {
        $this->cliente = $cliente;
    }

    function setSucursal($sucursal) {
        $this->sucursal = $sucursal;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function ver_almacenes() {
        global $conn;
        $query = "select codigo, nombre, estado "
                . "from almacen "
                . "order by nombre asc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function datos_almacen() {
        $existe = false;
        global $conn;
        $query = "select cliente, sucursal, nombre, estado "
                . "from almacen "
                . "where codigo = '" . $this->codigo . "'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $this->cliente = $fila['cliente'];
                $this->sucursal = $fila['sucursal'];
                $this->nombre = $fila['nombre'];
                $existe = true;
            }
        }
        return $existe;
    }

}
