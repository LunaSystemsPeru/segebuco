<?php

class cl_kardex_material{

    private $material;
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

    function getMaterial() {
        return $this->material;
    }

    function getId() {
        return $this->id;
    }

    function setMaterial($material) {
        $this->material= $material;
    }

    function setId($id) {
        $this->id = $id;
    }

    function ver_kardex() {
        global $conn;
        $query = "select k.kardex, k.fecha, k.ruc, k.datos, td.abreviado as tido, k.serie, k.numero, k.ingresa, k.sale, k.c_ingreso, k.c_egreso, k.registro, dtg.descripcion as movimiento "
                . "from kardex_material as k "
                . "inner join  tipo_documento as td on td.id = k.tipo_documento "
                . "inner join detalle_tabla_general as dtg on dtg.general = 8 and dtg.id = k.tipo_movimiento "
                . "where k.material = '" . $this->material. "' and k.almacen = '" . $this->almacen . "' "
                . "ORDER BY k.fecha ASC , k.kardex ASC";
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
                . "where k.herramienta = '" . $this->material. "' "
                . "order by k.fecha asc, k.kardex asc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }
    
    

}
