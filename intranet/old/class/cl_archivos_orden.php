<?php

include 'cl_conectar.php';

class cl_archivos_orden {

    private $id_orden;
    private $id_archivo;
    private $descripcion;
    private $archivo;

    function __construct() {
        
    }

    function getId_orden() {
        return $this->id_orden;
    }

    function getId_archivo() {
        return $this->id_archivo;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getArchivo() {
        return $this->archivo;
    }

    function setId_orden($id_orden) {
        $this->id_orden = $id_orden;
    }

    function setId_archivo($id_archivo) {
        $this->id_archivo = $id_archivo;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setArchivo($archivo) {
        $this->archivo = $archivo;
    }

    function obtener_id() {
        $id = 1;
        global $conn;
        $query = "select ifnull(max(id_archivo) + 1, 1) as codigo "
                . "from archivos_ointerna "
                . "where id_orden = '" . $this->id_orden . "'";
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
        $query = "insert into archivos_ointerna values ('" . $this->id_orden . "', '" . $this->id_archivo . "', '" . $this->descripcion . "', '" . $this->archivo . "')";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in archivos_ointerna: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function ver_archivos() {
        global $conn;
        $query = "select * "
                . "from archivos_ointerna "
                . "where id_orden = '" . $this->id_orden . "'";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

}
