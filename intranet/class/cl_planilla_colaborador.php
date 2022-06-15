<?php

include 'cl_conectar.php';

class cl_planilla_colaborador {

    private $planilla;
    private $colaborador;
    private $dia;
    private $ingreso;
    private $salida;
    private $feriado;

    function __construct() {
        
    }

    function getPlanilla() {
        return $this->planilla;
    }

    function getColaborador() {
        return $this->colaborador;
    }

    function getDia() {
        return $this->dia;
    }

    function getIngreso() {
        return $this->ingreso;
    }

    function getSalida() {
        return $this->salida;
    }

    function setPlanilla($planilla) {
        $this->planilla = $planilla;
    }

    function setColaborador($colaborador) {
        $this->colaborador = $colaborador;
    }

    function setDia($dia) {
        $this->dia = $dia;
    }

    function setIngreso($ingreso) {
        $this->ingreso = $ingreso;
    }

    function setSalida($salida) {
        $this->salida = $salida;
    }

    function getFeriado() {
        return $this->feriado;
    }

    function setFeriado($feriado) {
        $this->feriado = $feriado;
    }

    function i_empleado() {
        $grabado = false;
        global $conn;
        $query = "insert into planilla_colaborador values ('" . $this->planilla . "', '" . $this->colaborador . "',  '" . $this->dia . "', '" . $this->ingreso . "',  '" . $this->salida . "', '" . $this->feriado . "')";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in planilla_colaborador: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function d_empleado() {
        $grabado = false;
        global $conn;
        $query = "delete from planilla_colaborador where planilla = '" . $this->planilla . "' and colaborador = '" . $this->colaborador . "'";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not delete data in planilla_colaborador: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

}
