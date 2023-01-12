<?php

require 'cl_conectar.php';

class cl_detalle_despacho_material {

    private $iddespacho;
    private $anio;
    private $idmaterial;
    private $cantidad;
    private $costo;

    function __construct() {
        
    }

    function getIddespacho() {
        return $this->iddespacho;
    }

    function getAnio() {
        return $this->anio;
    }

    function getIdmaterial() {
        return $this->idmaterial;
    }

    function getCantidad() {
        return $this->cantidad;
    }

    function getCosto() {
        return $this->costo;
    }

    function setIddespacho($iddespacho) {
        $this->iddespacho = $iddespacho;
    }

    function setAnio($anio) {
        $this->anio = $anio;
    }

    function setIdmaterial($idmaterial) {
        $this->idmaterial = $idmaterial;
    }

    function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    function setCosto($costo) {
        $this->costo = $costo;
    }

    function insertar() {
        $grabado = false;
        global $conn;
        $query = "insert into detalle_despacho_material values ('" . $this->iddespacho . "', '" . $this->anio . "',  '" . $this->idmaterial . "', '" . $this->cantidad . "',  '" . $this->costo . "')";
        echo $query;
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in detalle_despacho_material: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function eliminar() {
        $grabado = false;
        global $conn;
        $query = "delete from detalle_despacho_material where concat(anio, id_despacho) = '" . $this->iddespacho . "' ";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not delete data in despacho_material: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }
    
    function ver_detalle_colaborador($id_orden_interna) {
        global $conn;
        $query = "select di.fecha, c.ape_pat, c.ape_mat, c.nombres, di.anio, di.id_despacho, ddi.cantidad, ddi.costo, m.descripcion, m.precio_compra "
                . "from despacho_material as di "
                . "inner join detalle_despacho_material as ddi on ddi.id_despacho = di.id_despacho and ddi.anio = di.anio "
                . "inner join material as m on m.idMaterial = ddi.id_material "
                . "inner join colaborador as c on c.id = di.id_colaborador "
                . "where di.id_orden_interna = '" . $id_orden_interna . "' ";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

}
