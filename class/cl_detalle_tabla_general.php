<?php

include 'cl_conectar.php';

class cl_detalle_tabla_general {

    private $tabla;
    private $id;
    private $descripcion;
    private $valor;

    function __construct() {
        
    }

    function getTabla() {
        return $this->tabla;
    }

    function getId() {
        return $this->id;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getValor() {
        return $this->valor;
    }

    function setTabla($tabla) {
        $this->tabla = $tabla;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setValor($valor) {
        $this->valor = $valor;
    }

    function i_detalle() {
        $grabado = false;
        global $conn;
        $query = "insert into detalle_tabla_general values ('" . $this->tabla . "', '" . $this->id . "', '" . $this->descripcion . "', '" . $this->valor . "')";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in detalle_tabla_general: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }
    
    function modificar() {
        $grabado = false;
        global $conn;
        $query = "update detalle_tabla_general "
                . "set descripcion = '" . $this->descripcion . "', atributo = '" . $this->valor . "' "
                . "where general = '" . $this->tabla . "' and id = '" . $this->id . "'";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not update data in detalle_tabla_general: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function v_detalle() {
        global $conn;
        $query = "select * from detalle_tabla_general where general = '" . $this->tabla . "' order by descripcion asc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function datos_detalle() {
        global $conn;
        $query = "select * "
                . "from detalle_tabla_general "
                . "where general = '" . $this->tabla . "' and id = '" . $this->id . "'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $this->descripcion = $fila ['descripcion'];
                $this->valor = $fila ['atributo'];
            }
        }
    }

    function obtener_id() {
        $id = 1;
        global $conn;
        $c_codigo = "select ifnull(max(id) + 1, 1) as codigo from detalle_tabla_general where general = '" . $this->tabla . "'";
        $resultado = $conn->query($c_codigo);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $id = $fila ['codigo'];
            }
        }
        return $id;
    }

}
