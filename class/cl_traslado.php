<?php

require 'cl_conectar.php';

class cl_traslado {

    private $codigo;
    private $periodo;
    private $fecha;
    private $documento;
    private $serie;
    private $numero;
    private $usuario;
    private $origen;
    private $destino;

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

    function getDocumento() {
        return $this->documento;
    }

    function getSerie() {
        return $this->serie;
    }

    function getNumero() {
        return $this->numero;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getOrigen() {
        return $this->origen;
    }

    function getDestino() {
        return $this->destino;
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

    function setDocumento($documento) {
        $this->documento = $documento;
    }

    function setSerie($serie) {
        $this->serie = $serie;
    }

    function setNumero($numero) {
        $this->numero = $numero;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setOrigen($origen) {
        $this->origen = $origen;
    }

    function setDestino($destino) {
        $this->destino = $destino;
    }
    
    function ver_traslados() {
        global $conn;
        $query = "select t.periodo, t.codigo, t.fecha, td.nombre, td.abreviado, t.serie, t.numero, t.usuario, ao.nombre as origen, ad.nombre as destino "
                . "from traslado as t "
                . "inner join tipo_documento as td on td.id = t.documento "
                . "inner join almacen as ao on ao.codigo = t.origen "
                . "inner join almacen as ad on ad.codigo = t.destino "                
                . "where t.periodo = '" . $this->periodo . "' and (t.origen = '".$_SESSION['almacen']."' or t.destino = '".$_SESSION['almacen']."')"
                . "order by t.fecha asc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function obtener_id() {
        $id = 1;
        global $conn;
        $query = "select ifnull(max(codigo) + 1, 1) as codigo from traslado where periodo = '" . $this->periodo . "'";
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
        $query = "insert into traslado values ('" . $this->codigo . "', '" . $this->periodo . "',  '" . $this->fecha . "', '" . $this->origen . "',  '" . $this->destino . "', "
                . "'" . $this->documento . "', '" . $this->serie . "', '" . $this->numero . "', '" . $this->usuario . "', '1')";
        $resultado = $conn->query($query);
        echo $query;
        if (!$resultado) {
            die('Could not enter data in traslado: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }
    
    function ver_periodo() {
        global $conn;
        $query = "SELECT periodo FROM  traslado GROUP BY periodo order by periodo desc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }
}
