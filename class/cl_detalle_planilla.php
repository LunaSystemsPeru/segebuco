<?php

include 'cl_conectar.php';

class cl_detalle_planilla {

    private $planilla;
    private $colaborador;
    private $jornal;
    private $h_normal;
    private $h_25;
    private $h_100;
    private $i_alimentacion;
    private $i_gastos;
    private $d_adelanto;
    private $d_otros;

    function __construct() {
        
    }

    function getPlanilla() {
        return $this->planilla;
    }

    function getColaborador() {
        return $this->colaborador;
    }

    function getH_normal() {
        return $this->h_normal;
    }

    function getH_25() {
        return $this->h_25;
    }

    function getH_100() {
        return $this->h_100;
    }

    function getI_alimentacion() {
        return $this->i_alimentacion;
    }

    function getI_gastos() {
        return $this->i_gastos;
    }

    function getD_adelanto() {
        return $this->d_adelanto;
    }

    function getD_otros() {
        return $this->d_otros;
    }

    function getJornal() {
        return $this->jornal;
    }

    function setJornal($jornal) {
        $this->jornal = $jornal;
    }

    function setPlanilla($planilla) {
        $this->planilla = $planilla;
    }

    function setColaborador($colaborador) {
        $this->colaborador = $colaborador;
    }

    function setH_normal($h_normal) {
        $this->h_normal = $h_normal;
    }

    function setH_25($h_25) {
        $this->h_25 = $h_25;
    }

    function setH_100($h_100) {
        $this->h_100 = $h_100;
    }

    function setI_alimentacion($i_alimentacion) {
        $this->i_alimentacion = $i_alimentacion;
    }

    function setI_gastos($i_gastos) {
        $this->i_gastos = $i_gastos;
    }

    function setD_adelanto($d_adelanto) {
        $this->d_adelanto = $d_adelanto;
    }

    function setD_otros($d_otros) {
        $this->d_otros = $d_otros;
    }

    function i_detalle() {
        $grabado = false;
        global $conn;
        $query = "insert into detalle_planilla values ('" . $this->planilla . "', '" . $this->colaborador . "',  '" . $this->jornal . "','" . $this->h_normal . "', '" . $this->h_25 . "',  '" . $this->h_100 . "', '" . $this->i_alimentacion . "', '0', '0', '0')";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in detalle_planilla: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function u_pago_colaborador() {
        $grabado = false;
        global $conn;
        $query = "update detalle_planilla "
                . "set i_alimentacion = '" . $this->i_alimentacion . "', i_gastos = '" . $this->i_gastos . "', d_adelanto = '" . $this->d_adelanto . "', d_otros = '" . $this->d_otros . "' "
                . "where planilla = '" . $this->planilla . "' and colaborador =  '" . $this->colaborador . "'";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not update data in detalle_planilla: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function v_colaboradores() {
        global $conn;
        $query = "select p.colaborador, c.dni, concat (c.ape_pat, ' ',c.ape_mat,' ', c.nombres) as nombres, p.horas_normal, p.horas_25, p.horas_100, dtgc.descripcion as cargo "
                . "from detalle_planilla as p "
                . "inner join colaborador as c on c.id = p.colaborador "
                . "inner join detalle_tabla_general as dtgc on dtgc.general = 1 and dtgc.id = c.cargo "
                . "where p.planilla = '" . $this->planilla . "' order by nombres asc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function v_colaboradores_pago() {
        global $conn;
        $query = "select p.colaborador, c.dni, concat (c.ape_pat, ' ',c.ape_mat,' ', c.nombres) as nombres, c.categoria, p.jornal as jornal_dia, p.i_alimentacion, p.i_gastos, p.d_adelanto, p.d_otros, p.horas_normal, p.horas_25, p.horas_100, dtgc.descripcion as cargo "
                . "from detalle_planilla as p "
                . "inner join colaborador as c on c.id = p.colaborador "
                . "inner join detalle_tabla_general as dtgc on dtgc.general = 1 and dtgc.id = c.cargo "
                . "where p.planilla = '" . $this->planilla . "' order by nombres asc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function v_colaboradores_planilla_general($codigo) {
        global $conn;
        $query = "select e.razon_social, e.nombre_comercial, sc.nombre as sucursal, pl.cliente as id_cliente, pl.sucursal as id_sucursal, p.colaborador, c.dni, concat (c.ape_pat, ' ',c.ape_mat,' ', c.nombres) as nombres, c.categoria, p.jornal as jornal_dia, p.i_alimentacion, p.i_gastos, p.d_adelanto, p.d_otros, p.horas_normal, p.horas_25, p.horas_100, dtgc.descripcion as cargo "
                . "from detalle_planilla as p "
                . "inner join planilla as pl on pl.codigo = p.planilla "
                . "inner join clientes as cl on cl.id = pl.cliente "
                . "inner join entidad as e on e.ruc = cl.ruc "
                . "inner join sucursal_cliente as sc on sc.cliente = pl.cliente and sc.id = pl.sucursal "
                . "inner join colaborador as c on c.id = p.colaborador "
                . "inner join detalle_tabla_general as dtgc on dtgc.general = 1 and dtgc.id = c.cargo "
                . "where concat (pl.anio, lpad(pl.semana, 3, 0)) = '" . $codigo . "' ";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function v_detalle_pago() {
        global $conn;
        $query = "select p.colaborador, c.dni, concat (c.ape_pat, ' ',c.ape_mat,' ', c.nombres) as nombres, c.categoria, p.jornal as jornal_dia, p.i_alimentacion, p.i_gastos, p.d_adelanto, p.d_otros, p.horas_normal, p.horas_25, p.horas_100, dtgc.descripcion as cargo "
                . "from detalle_planilla as p "
                . "inner join colaborador as c on c.id = p.colaborador "
                . "inner join detalle_tabla_general as dtgc on dtgc.general = 1 and dtgc.id = c.cargo "
                . "where p.planilla = '" . $this->planilla . "' and p.colaborador = '" . $this->colaborador . "'";
        //echo $query;
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function d_colaborador() {
        $grabado = false;
        global $conn;
        $query = "delete from detalle_planilla where planilla = '" . $this->planilla . "' and colaborador = '" . $this->colaborador . "'";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not delete data in detalle_planilla: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

}
