<?php

require 'cl_conectar.php';

class cl_gastos{
    private $id_movimiento;

    /**
     * @return mixed
     */
    public function getIdMovimiento()
    {
        return $this->id_movimiento;
    }

    /**
     * @param mixed $id_movimiento
     */
    public function setIdMovimiento($id_movimiento)
    {
        $this->id_movimiento = $id_movimiento;
    }

    function ver() {
        global $conn;
        $query = "SELECT mb.*,cb.nombre FROM gastos AS g INNER JOIN movimiento_bancos AS mb ON g.id_movimiento = mb.movimiento INNER JOIN caja_bancos AS cb ON mb.banco =cb.codigo";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function insertar() {
        $grabado = false;
        global $conn;
        $query = "INSERT INTO gastos 
                    VALUES ('$this->id_movimiento');";
        $resultado = $conn->query($query);
        //echo $query;
        if (!$resultado) {
            die('Could not enter data in movimiento_bancos: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function eliminar() {
        $grabado = false;
        global $conn;
        $query = "DELETE
                    FROM gastos
                    WHERE id_movimiento = '$this->id_movimiento';";
        $resultado = $conn->query($query);
        echo $query;
        if (!$resultado) {
            die('Could not enter data in movimiento_bancos: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

}