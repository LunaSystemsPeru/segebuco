<?php

require 'cl_conectar.php';

class cl_devolucion {

    private $periodo;
    private $id;
    private $id_proveedor;
    private $id_documento;
    private $serie;
    private $numero;
    private $fecha;
    private $id_usuario;
    private $id_almacen;

    function __construct() {
        
    }

    function getPeriodo() {
        return $this->periodo;
    }

    function getId() {
        return $this->id;
    }

    function getId_proveedor() {
        return $this->id_proveedor;
    }

    function getId_documento() {
        return $this->id_documento;
    }

    function getSerie() {
        return $this->serie;
    }

    function getNumero() {
        return $this->numero;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getId_usuario() {
        return $this->id_usuario;
    }

    function getId_almacen() {
        return $this->id_almacen;
    }

    function setPeriodo($periodo) {
        $this->periodo = $periodo;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setId_proveedor($id_proveedor) {
        $this->id_proveedor = $id_proveedor;
    }

    function setId_documento($id_documento) {
        $this->id_documento = $id_documento;
    }

    function setSerie($serie) {
        $this->serie = $serie;
    }

    function setNumero($numero) {
        $this->numero = $numero;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function setId_usuario($id_usuario) {
        $this->id_usuario = $id_usuario;
    }

    function setId_almacen($id_almacen) {
        $this->id_almacen = $id_almacen;
    }

    function ver_devoluciones() {
        global $conn;
        $query = "select d.periodo, d.id, d.fecha, e.razon_social, td.nombre, td.abreviado, d.serie, d.numero, a.nombre as almacen "
                . "from devoluciones as d "
                . "inner join entidad as e on e.ruc = d.empresa "
                . "inner join tipo_documento as td on td.id = d.tipo_documento "
                . "inner join almacen as a on a.codigo = d.almacen "
                . "where d.periodo = '" . $this->periodo . "' "
                . "order by d.fecha asc";
        echo $query;
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function ver_periodo() {
        global $conn;
        $query = "SELECT periodo FROM  devoluciones GROUP BY periodo order by periodo desc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function obtener_id() {
        global $conn;
        $query = "select ifnull(max(id) + 1, 1) as codigo "
                . "from devoluciones "
                . "where periodo = '" . $this->periodo . "'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $this->id = $fila ['codigo'];
            }
        }
    }

    function insertar() {
        $grabado = false;
        global $conn;
        $query = "insert into devoluciones values ('" . $this->id . "', '" . $this->periodo . "',  '" . $this->fecha . "', '" . $this->id_proveedor . "',  '" . $this->id_documento . "', "
                . "'" . $this->serie . "', '" . $this->numero . "', '" . $this->id_almacen . "', '" . $this->id_usuario . "')";
        $resultado = $conn->query($query);
        echo $query;
        if (!$resultado) {
            die('Could not enter data in devoluciones: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function eliminar() {
        $grabado = false;
        global $conn;
        $query = "delete from devoluciones "
                . "where periodo = '" . $this->periodo . "' and id = '" . $this->id . "'";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not delete data in devoluciones: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

}
