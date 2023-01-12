<?php

include ('cl_conectar.php');

class cl_materiales {

    private $id;
    private $descripcion;
    private $precio;
    private $tipo;
    private $unidad;
    private $imagen;
    private $estado;

    function __construct() {
        
    }

    function getId() {
        return $this->id;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getPrecio() {
        return $this->precio;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getUnidad() {
        return $this->unidad;
    }

    function getImagen() {
        return $this->imagen;
    }

    function getEstado() {
        return $this->estado;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setPrecio($precio) {
        $this->precio = $precio;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setUnidad($unidad) {
        $this->unidad = $unidad;
    }

    function setImagen($imagen) {
        $this->imagen = $imagen;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function ver_materiales() {
        global $conn;
        $query = "select idmaterial, descripcion, precio_compra, estado, imagen, und_medida "
                . "from material";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function ver_datos_materiales() {
        global $conn;
        $query = "select idmaterial, descripcion, precio_compra, estado, imagen, und_medida "
                . "from material where idmaterial = '" . $this->id . "'";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }
    
    function obtener_datos() {
        global $conn;
        $c_codigo = "select * from material where idmaterial = '" . $this->id . "'";
        $resultado = $conn->query($c_codigo);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $this->descripcion = $fila ['descripcion'];
                $this->precio = $fila ['precio_compra'];                
            }
        }
    }

    function i_material() {
        $grabado = false;
        global $conn;
        $query = "insert into material values ('" . $this->id . "', '" . $this->descripcion . "',  '" . $this->precio . "',  '" . $this->estado . "', '" . $this->unidad . "', '" . $this->tipo . "', '" . $this->imagen . "')";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in material: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }
    
     function obtener_id() {
        $id = 1;
        global $conn;
        $c_codigo = "select ifnull(max(idmaterial) + 1, 1) as codigo from material";
        echo $c_codigo;
        $resultado = $conn->query($c_codigo);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $id = $fila ['codigo'];
            }
        }
        return $id;
    }

    function u_material() {
        $grabado = false;
        global $conn;
        $query = "update material "
                . "set descripcion = '" . $this->descripcion . "', und_medida = '" . $this->unidad . "', imagen = '" . $this->imagen . "' "
                . "where idmaterial = '" . $this->id . "'";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not update data in material: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

}
