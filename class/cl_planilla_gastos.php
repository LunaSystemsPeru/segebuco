<?php

include 'cl_conectar.php';

class cl_planilla_gastos {

    private $codigo;
    private $planilla;
    private $glosa;
    private $monto;

    function __construct() {
        
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getPlanilla() {
        return $this->planilla;
    }

    function getGlosa() {
        return $this->glosa;
    }

    function getMonto() {
        return $this->monto;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setPlanilla($planilla) {
        $this->planilla = $planilla;
    }

    function setGlosa($glosa) {
        $this->glosa = $glosa;
    }

    function setMonto($monto) {
        $this->monto = $monto;
    }

    function i_gastos() {
        $grabado = false;
        global $conn;
        $query = "insert into planilla_gastos values ('" . $this->planilla . "', '" . $this->codigo . "', '" . $this->glosa . "', '" . $this->monto . "')";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in planilla_gastos: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function obtener_id() {
        $id = 1;
        global $conn;
        $c_codigo = "select ifnull(max(codigo) + 1, 1) as codigo from planilla_gastos where planilla = '" . $this->planilla . "'";
        $r_codigo = $conn->query($c_codigo);
        if ($r_codigo->num_rows > 0) {
            while ($fila = $r_codigo->fetch_assoc()) {
                $id = $fila ['codigo'];
            }
        }
        return $id;
    }

    function ver_gastos_planilla() {
        global $conn;
        $query = "select codigo, glosa, monto from planilla_gastos where planilla = '" . $this->planilla . "'";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

}
