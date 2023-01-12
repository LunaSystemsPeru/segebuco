<?php

class cl_kardex_herramienta {

    private $herramienta;
    private $almacen;
    private $id;

    function __construct() {
        
    }

    function getAlmacen() {
        return $this->almacen;
    }

    function setAlmacen($almacen) {
        $this->almacen = $almacen;
    }

    function getHerramienta() {
        return $this->herramienta;
    }

    function getId() {
        return $this->id;
    }

    function setHerramienta($herramienta) {
        $this->herramienta = $herramienta;
    }

    function setId($id) {
        $this->id = $id;
    }

    function ver_kardex() {
        global $conn;
        $query = "select k.kardex, k.fecha, k.ruc, k.datos, td.abreviado as tido, k.serie, k.numero, k.ingresa, k.sale, k.registro, dtg.descripcion as movimiento "
                . "from kardex_herramienta as k "
                . "inner join  tipo_documento as td on td.id = k.tipo_documento "
                . "inner join detalle_tabla_general as dtg on dtg.general = 8 and dtg.id = k.tipo_movimiento "
                . "where k.herramienta = '" . $this->herramienta . "' and k.almacen = '" . $this->almacen . "'";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }
    
    function ver_kardex_general() {
        global $conn;
        $query = "select k.kardex, al.nombre, k.fecha, k.ruc, k.datos, td.abreviado as tido, k.serie, k.numero, k.ingresa, k.sale, k.registro, dtg.descripcion as movimiento from kardex_herramienta as k "
                . "inner join almacen as al on al.codigo = k.almacen "
                . "inner join  tipo_documento as td on td.id = k.tipo_documento "
                . "inner join detalle_tabla_general as dtg on dtg.general = 8 and dtg.id = k.tipo_movimiento "
                . "where k.herramienta = '" . $this->herramienta . "' "
                . "order by k.fecha asc, k.kardex asc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }
    
    

}
