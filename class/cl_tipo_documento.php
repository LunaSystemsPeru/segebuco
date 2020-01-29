<?php

include 'cl_conectar.php';

class cl_tipo_documento {

    private $codigo;
    private $nombre;
    private $corto;
    private $serie;
    private $numero;
    private $sunat;

    function __construct() {
        
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getCorto() {
        return $this->corto;
    }

    function getSerie() {
        return $this->serie;
    }

    function getNumero() {
        return $this->numero;
    }

    function getSunat() {
        return $this->sunat;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setCorto($corto) {
        $this->corto = $corto;
    }

    function setSerie($serie) {
        $this->serie = $serie;
    }

    function setNumero($numero) {
        $this->numero = $numero;
    }

    function setSunat($sunat) {
        $this->sunat = $sunat;
    }

    function obtener_codigo() {
        $id = 1;
        global $conn;
        $c_codigo = "select ifnull(max(id) + 1, 1) as codigo from tipo_documento";
        $resultado = $conn->query($c_codigo);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $id = $fila ['codigo'];
            }
        }
        return $id;
    }
    
    function i_documento() {
        $grabado = false;
        global $conn;
        $query = "insert into tipo_documento values ('" . $this->codigo . "', '" . $this->nombre . "',  '" . $this->corto . "', '" . $this->serie . "',  '" . $this->numero . "', '" . $this->sunat . "')";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in tipo_documento: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }
    
    function ver_documentos() {
        global $conn;
        $query = "select id, nombre "
                . "from tipo_documento "
                . "order by nombre asc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

}
