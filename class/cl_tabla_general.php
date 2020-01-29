<?php

include 'cl_conectar.php';

class cl_tabla_general {

    private $id;
    private $nombre;

    function __construct() {
        
    }

    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function i_tabla() {
        $grabado = false;
        global $conn;
        $query = "insert into tabla_general values ('" . $this->id . "', '" . $this->nombre . "')";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in tabla_general: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function v_tabla() {
        global $conn;
        $query = "select * from tabla_general order by nombre asc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function v_datos_tabla() {
        global $conn;
        $query = "select * from tabla_general where id = '" . $this->id . "'";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

}
