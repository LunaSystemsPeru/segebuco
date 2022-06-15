<?php

require 'cl_conectar.php';

class cl_caja_chica {

    private $codigo;
    private $empleado;
    private $monto;
    private $moneda;
    private $estado;

    function __construct() {
        
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getEmpleado() {
        return $this->empleado;
    }

    function getMonto() {
        return $this->monto;
    }

    function getMoneda() {
        return $this->moneda;
    }

    function getEstado() {
        return $this->estado;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setEmpleado($empleado) {
        $this->empleado = $empleado;
    }

    function setMonto($monto) {
        $this->monto = $monto;
    }

    function setMoneda($moneda) {
        $this->moneda = $moneda;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function ver_caja() {
        global $conn;
        $query = "select cc.codigo, concat (c.ape_pat, ' ', c.ape_mat, ' ' ,c.nombres) as empleado, dtgm.descripcion as nmoneda, dtgm.atributo as moneda, cc.monto_disponible, cc.estado "
                . "from caja_chica as cc "
                . "inner join colaborador as c on c.id = cc.colaborador "
                . "inner join detalle_tabla_general as dtgm on dtgm.general = 5 and dtgm.id = cc.moneda ";
        $r_codigo = $conn->query($query);
        $fila = $r_codigo->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

}
