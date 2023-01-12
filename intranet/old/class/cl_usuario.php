<?php

include 'cl_conectar.php';

class cl_usuario {

    private $usuario;
    private $pass;
    private $almacen;
    private $empleado;
    private $estado;

    function __construct() {
        
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getPass() {
        return $this->pass;
    }

    function getEmpleado() {
        return $this->empleado;
    }

    function getEstado() {
        return $this->estado;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setPass($pass) {
        $this->pass = $pass;
    }

    function setEmpleado($empleado) {
        $this->empleado = $empleado;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function getAlmacen() {
        return $this->almacen;
    }

    function setAlmacen($almacen) {
        $this->almacen = $almacen;
    }

    function modificar() {
        $grabado = false;
        global $conn;
        $query = "update usuarios "
                . "set password = '" . $this->pass . "', almacen = '" . $this->almacen . "' "
                . "where usuario = '" . $this->usuario . "'";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not modify data in usuarios: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function ver_usuarios() {
        global $conn;
        $query = "SELECT
                      u.usuario,
                      CONCAT(
                        c.ape_pat,
                        ' ',
                        c.ape_mat,
                        ' ',
                        c.nombres
                      ) as nombres,
                      a.nombre AS almacen,
                      u.estado
                    FROM
                      usuarios AS u
                    INNER JOIN
                      colaborador AS c ON c.id = u.colaborador
                    INNER JOIN
                      almacen AS a ON a.codigo = u.almacen
                      order by nombres asc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function validar_usuario() {
        $b_validar = false;
        global $conn;
        $query = "select colaborador, almacen "
                . "from usuarios "
                . "where usuario = '" . $this->usuario . "' and password = '" . $this->pass . "'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $b_validar = true;
                $this->almacen = $fila ['almacen'];
                $this->empleado = $fila ['colaborador'];
            }
        } else {
            $b_validar = false;
        }
        return $b_validar;
    }

    function datos_usuario() {
        $b_validar = false;
        global $conn;
        $query = "select * "
                . "from usuarios "
                . "where usuario = '" . $this->usuario . "'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $b_validar = true;
                $this->almacen = $fila ['almacen'];
                $this->empleado = $fila ['colaborador'];
                $this->pass = $fila ['password'];
                $this->estado = $fila ['estado'];
            }
        } else {
            $b_validar = false;
        }
        return $b_validar;
    }

    function insertar() {
        $grabado = false;
        global $conn;
        $query = "insert into usuarios values ('" . $this->usuario . "', '" . $this->empleado . "', '" . $this->almacen . "', '" . $this->pass . "', '1')";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not insert data in usuarios: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

}
