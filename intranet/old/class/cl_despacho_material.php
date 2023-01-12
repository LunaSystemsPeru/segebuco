<?php

require 'cl_conectar.php';

class cl_despacho_material {

    private $iddespacho;
    private $anio;
    private $idcolaborador;
    private $fecha;
    private $idordeninterna;
    private $idalmacen;

    function __construct() {
        
    }
    
    function getIddespacho() {
        return $this->iddespacho;
    }

    function getAnio() {
        return $this->anio;
    }

    function getIdcolaborador() {
        return $this->idcolaborador;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getIdordeninterna() {
        return $this->idordeninterna;
    }

    function getIdalmacen() {
        return $this->idalmacen;
    }

    function setIddespacho($iddespacho) {
        $this->iddespacho = $iddespacho;
    }

    function setAnio($anio) {
        $this->anio = $anio;
    }

    function setIdcolaborador($idcolaborador) {
        $this->idcolaborador = $idcolaborador;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function setIdordeninterna($idordeninterna) {
        $this->idordeninterna = $idordeninterna;
    }

    function setIdalmacen($idalmacen) {
        $this->idalmacen = $idalmacen;
    }
    
    function obtener_id() {
        $id = 1;
        global $conn;
        $query = "select ifnull(max(id_despacho) + 1, 1) as codigo from despacho_material where anio = '" . $this->anio . "'";
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
        $query = "insert into despacho_material values ('" . $this->iddespacho . "', '" . $this->anio . "',  '" . $this->fecha . "', '" . $this->idcolaborador . "',  '" . $this->idordeninterna . "', '" . $this->idalmacen . "')";
        echo $query;
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in despacho_material: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }
    
    function ver_despachos() {
        global $conn;
        $query = "select dm.anio, dm.id_despacho, dm.fecha, cl.nombres, cl.ape_pat, cl.ape_mat, ct.descripcion as dcotizacion "
                . "from despacho_material as dm "
                . "inner join colaborador as cl on cl.id = dm.id_colaborador "
                . "inner join orden_interna as oi on oi.id_orden = dm.id_orden_interna "
                . "inner join cotizaciones as ct on ct.codigo = oi.id_cotizacion ";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }
    
    function ver_periodo() {
        global $conn;
        $query = "SELECT anio FROM  despacho_material GROUP BY anio order by anio desc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }
    
    function eliminar() {
        $grabado = false;
        global $conn;
        $query = "delete from despacho_material where concat(anio, id_despacho) = '" . $this->iddespacho . "'";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not delete data in despacho_material: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }
    
    

}
