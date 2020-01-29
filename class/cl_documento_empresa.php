<?php

class cl_documento_empresa {

    private $documento;
    private $serie;
    private $numero;

    function __construct() {
        
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

    function setDocumento($documento) {
        $this->documento = $documento;
    }

    function setSerie($serie) {
        $this->serie = $serie;
    }

    function setNumero($numero) {
        $this->numero = $numero;
    }

    function ver_documentos() {
        global $conn;
        $query = "select d.id, d.nombre, de.serie, de.numero "
                . "from documento_empresa as de "
                . "inner join tipo_documento as d on d.id = de.documento "
                . "order by nombre asc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }
}
