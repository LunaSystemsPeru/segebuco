<?php

require 'cl_conectar.php';

class cl_ingresos {

    private $codigo;
    private $periodo;
    private $fecha;
    private $tipo_documento;
    private $serie;
    private $numero;
    private $total;
    private $moneda;
    private $tc;
    private $proveedor;
    private $almacen;

    function __construct() {
        
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getPeriodo() {
        return $this->periodo;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getTipo_documento() {
        return $this->tipo_documento;
    }

    function getSerie() {
        return $this->serie;
    }

    function getNumero() {
        return $this->numero;
    }

    function getTotal() {
        return $this->total;
    }

    function getMoneda() {
        return $this->moneda;
    }

    function getProveedor() {
        return $this->proveedor;
    }

    function getAlmacen() {
        return $this->almacen;
    }

    function getTc() {
        return $this->tc;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setPeriodo($periodo) {
        $this->periodo = $periodo;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function setTipo_documento($tipo_documento) {
        $this->tipo_documento = $tipo_documento;
    }

    function setSerie($serie) {
        $this->serie = $serie;
    }

    function setNumero($numero) {
        $this->numero = $numero;
    }

    function setTotal($total) {
        $this->total = $total;
    }

    function setMoneda($moneda) {
        $this->moneda = $moneda;
    }

    function setProveedor($proveedor) {
        $this->proveedor = $proveedor;
    }

    function setAlmacen($almacen) {
        $this->almacen = $almacen;
    }

    function setTc($tc) {
        $this->tc = $tc;
    }

    function ver_ingresos() {
        global $conn;
        $query = "select i.periodo, i.id, i.fecha, e.razon_social, td.nombre, td.abreviado, i.serie, i.numero, i.total, i.tc, i.moneda, a.nombre as almacen "
                . "from ingresos as i "
                . "inner join entidad as e on e.ruc = i.proveedor "
                . "inner join tipo_documento as td on td.id = i.tipo_documento "
                . "inner join almacen as a on a.codigo = i.almacen "
                . "where i.periodo = '" . $this->periodo . "' "
                . "order by i.fecha asc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function obtener_id() {
        $id = 1;
        global $conn;
        $query = "select ifnull(max(id) + 1, 1) as codigo from ingresos where periodo = '" . $this->periodo . "'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $id = $fila ['codigo'];
            }
        }
        return $id;
    }

    function insertar() {
        $grabado = false;
        global $conn;
        $query = "insert into ingresos values ('" . $this->codigo . "', '" . $this->periodo . "',  '" . $this->fecha . "', '" . $this->proveedor . "',  '" . $this->tipo_documento . "', "
                . "'" . $this->serie . "', '" . $this->numero . "', '" . $this->total . "', '" . $this->moneda . "', '" . $this->tc . "', '" . $this->almacen . "')";
        $resultado = $conn->query($query);
        echo $query;
        if (!$resultado) {
            die('Could not enter data in ingresos: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }
    
    function eliminar() {
        $grabado = false;
        global $conn;
        $query = "delete from ingresos where concat(periodo, id) = '". $this->codigo ."'";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not delete data in ingresos: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function ver_periodo() {
        global $conn;
        $query = "SELECT periodo FROM  ingresos GROUP BY periodo order by periodo desc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function obtener_datos() {
        global $conn;
        $query = "select i.periodo, i.id, i.fecha, e.razon_social, td.nombre, td.abreviado, i.serie, i.numero, i.total, i.tc, i.moneda, a.nombre as almacen "
                . "from ingresos as i "
                . "inner join entidad as e on e.ruc = i.proveedor "
                . "inner join tipo_documento as td on td.id = i.tipo_documento "
                . "inner join almacen as a on a.codigo = i.almacen "
                . "where concat (i.periodo, i.id) = '" . $this->periodo . $this->codigo . "' "
                . "order by i.fecha asc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

}
