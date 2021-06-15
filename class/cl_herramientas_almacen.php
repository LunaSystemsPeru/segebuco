<?php

include 'cl_conectar.php';

class cl_herramientas_almacen {

    private $codigo;
    private $almacen;
    private $cactual;
    private $f_ingreso;
    private $estado;

    function __construct() {
        
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getAlmacen() {
        return $this->almacen;
    }

    function getCactual() {
        return $this->cactual;
    }

    function getEstado() {
        return $this->estado;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setAlmacen($almacen) {
        $this->almacen = $almacen;
    }

    function setCactual($cactual) {
        $this->cactual = $cactual;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function getF_ingreso() {
        return $this->f_ingreso;
    }

    function setF_ingreso($f_ingreso) {
        $this->f_ingreso = $f_ingreso;
    }

    function ver_herramientas() {
        global $conn;
        $query = "select ha.herramienta, h.ctotal, ha.cactual, ha.estado, concat (h.descripcion, ' | ', h.marca, ' | ', h.modelo, ' | ', h.serie) as descripcion, h.tipo, h.precio "
                . "from herramienta_almacen as ha "
                . "inner join herramientas as h on h.idherramientas = ha.herramienta "
                . "where ha.almacen = '" . $this->almacen . "'";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function obtener_datos() {
        global $conn;
        $c_codigo = "select * from herramienta_almacen "
                . "where herramienta = '" . $this->codigo . "' and almacen = '" . $this->almacen . "'";
        $resultado = $conn->query($c_codigo);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $this->cactual = $fila ['cactual'];
                $this->f_ingreso = $fila ['fingreso'];
                $this->estado = $fila ['estado'];
            }
        }
    }

}
