<?php

include 'cl_conectar.php';

class cl_herramientas {

    private $id;
    private $descripcion;
    private $marca;
    private $modelo;
    private $serie;
    private $caracteristicas;
    private $tipo;
    private $und_medida;
    private $precio;
    private $imagen;

    function __construct() {
        
    }

    function getId() {
        return $this->id;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getMarca() {
        return $this->marca;
    }

    function getModelo() {
        return $this->modelo;
    }

    function getSerie() {
        return $this->serie;
    }

    function getCaracteristicas() {
        return $this->caracteristicas;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getUnd_medida() {
        return $this->und_medida;
    }

    function getPrecio() {
        return $this->precio;
    }

    function getImagen() {
        return $this->imagen;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setMarca($marca) {
        $this->marca = $marca;
    }

    function setModelo($modelo) {
        $this->modelo = $modelo;
    }

    function setSerie($serie) {
        $this->serie = $serie;
    }

    function setCaracteristicas($caracteristicas) {
        $this->caracteristicas = $caracteristicas;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setUnd_medida($und_medida) {
        $this->und_medida = $und_medida;
    }

    function setPrecio($precio) {
        $this->precio = $precio;
    }

    function setImagen($imagen) {
        $this->imagen = $imagen;
    }

    function ver_herramientas() {
        global $conn;
        $query = "select idherramientas, concat (descripcion, ' - ', marca, ' - ', modelo, ' - ', serie) as descripcion, precio, tipo, ctotal, estado "
                . "from herramientas";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function insertar() {
        $grabado = false;
        global $conn;
        $query = "insert into herramientas "
                . "values ('" . $this->id . "', '" . $this->descripcion . "',  '" . $this->marca . "', '" . $this->modelo . "', '" . $this->serie . "', '" . $this->und_medida . "', '" . $this->caracteristicas . "', '" . $this->imagen . "', '" . $this->precio . "', '0', '" . $this->tipo . "', '0')";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in herramientas: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function actualizar() {
        $grabado = false;
        global $conn;
        $query = "update herramientas "
                . "set descripcion = '" . $this->descripcion . "', marca = '" . $this->marca . "', modelo = '" . $this->modelo . "', serie = '" . $this->serie . "', caracteristicas = '" . $this->caracteristicas . "', precio = '" . $this->precio . "', tipo = '" . $this->tipo . "' "
                . "where idherramientas = '" . $this->id . "' ";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not update data in herramientas: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function obtener_id() {
        $id = 1;
        global $conn;
        $c_codigo = "select ifnull(max(idherramientas) + 1, 1) as codigo from herramientas";
        $resultado = $conn->query($c_codigo);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $id = $fila ['codigo'];
            }
        }
        return $id;
    }

    function obtener_datos() {
        global $conn;
        $c_codigo = "select * from herramientas where idherramientas = '" . $this->id . "'";
        $resultado = $conn->query($c_codigo);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $this->descripcion = $fila ['descripcion'];
                $this->marca = $fila ['marca'];
                $this->modelo = $fila ['modelo'];
                $this->serie = $fila ['serie'];
                $this->tipo = $fila ['tipo'];
                $this->caracteristicas = $fila ['caracteristicas'];
                $this->precio = $fila ['precio'];
            }
        }
    }

    function ver_ubicaciones() {
        global $conn;
        $query = "select a.nombre, h.cactual, h.fingreso "
                . "from herramienta_almacen as h "
                . "inner join almacen as a on a.codigo = h.almacen "
                . "where h.herramienta = '" . $this->id . "' "
                . "order by a.nombre asc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

}
