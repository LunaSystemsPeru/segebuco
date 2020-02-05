<?php

include 'cl_conectar.php';

class cl_pago_compra
{
    private $id_movimiento;
    private $id_compra;

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

    /**
     * @return mixed
     */
    public function getIdCompra()
    {
        return $this->id_compra;
    }

    /**
     * @param mixed $id_compra
     */
    public function setIdCompra($id_compra)
    {
        $this->id_compra = $id_compra;
    }

    function insertar() {
        $grabado = false;
        global $conn;
        $query = "INSERT INTO pago_compras 
                    VALUES ('$this->id_movimiento',
                            '$this->id_compra');";
        $resultado = $conn->query($query);
        echo $query;
        if (!$resultado) {
            die('Could not enter data in pago_compras: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function ver_pagos() {
        global $conn;
        $query = "SELECT 
                  mc.movimiento, mc.fecha, cb.nombre, mc.egreso
                FROM
                  pago_compras AS pc 
                  INNER JOIN movimiento_bancos AS mc 
                    ON pc.id_movimiento = mc.movimiento 
                    INNER JOIN caja_bancos AS cb ON mc.banco=cb.codigo
                    WHERE pc.id_compra ='$this->id_compra'";
        // echo $query;
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }
    function eliinar() {
        $grabado = false;
        global $conn;
        $query = "DELETE
                FROM pago_compras
                WHERE id_movimiento = 'id_movimiento'
                    AND id_compra = 'id_compra';";
        $resultado = $conn->query($query);
        echo $query;
        if (!$resultado) {
            die('Could not enter data in pago_compras: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

}