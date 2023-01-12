<?php

require 'cl_conectar.php';

class cl_salida {

    private $codigo;
    private $periodo;
    private $fecha;
    private $tipo_documento;
    private $serie;
    private $numero;
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

    function getProveedor() {
        return $this->proveedor;
    }

    function getAlmacen() {
        return $this->almacen;
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

    function setProveedor($proveedor) {
        $this->proveedor = $proveedor;
    }

    function setAlmacen($almacen) {
        $this->almacen = $almacen;
    }

    
    function ver_retornos() {
        global $conn;
        $query = "select r.periodo, r.id, r.fecha, e.razon_social, td.nombre, td.abreviado, r.serie, r.numero "
                . "from retornos as r "
                . "inner join entidad as e on e.ruc = r.proveedor "
                . "inner join tipo_documento as td on td.id = r.tipo_documento "
                . "order by r.fecha asc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function obtener_id() {
        $id = 1;
        global $conn;
        $query = "select ifnull(max(id) + 1, 1) as codigo from retornos where periodo = '" . $this->periodo . "'";
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
        $query = "insert into retornos values ('" . $this->codigo . "', '" . $this->periodo . "',  '" . $this->fecha . "', '" . $this->proveedor . "',  '" . $this->tipo_documento . "', "
                . "'" . $this->serie . "', '" . $this->numero . "', '" . $this->almacen . "')";
        $resultado = $conn->query($query);
        echo $query;
        if (!$resultado) {
            die('Could not enter data in retornos: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

}
