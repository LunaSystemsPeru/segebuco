<?php

require 'cl_conectar.php';

class cl_entrega_epp {

    private $codigo;
    private $colaborador;
    private $epp;
    private $entrega;
    private $devolucion;
    private $estado;

    function __construct() {
        
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getColaborador() {
        return $this->colaborador;
    }

    function getEpp() {
        return $this->epp;
    }

    function getEntrega() {
        return $this->entrega;
    }

    function getDevolucion() {
        return $this->devolucion;
    }

    function getEstado() {
        return $this->estado;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setColaborador($colaborador) {
        $this->colaborador = $colaborador;
    }

    function setEpp($epp) {
        $this->epp = $epp;
    }

    function setEntrega($entrega) {
        $this->entrega = $entrega;
    }

    function setDevolucion($devolucion) {
        $this->devolucion = $devolucion;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function ver_entregados() {
        global $conn;
        $query = "select e.codigo, dtg.descripcion as epp, e.entrega, e.devolucion, e.estado, date_add(e.entrega, interval dtg.atributo day) as retorno, e.epp as cepp "
                . "from entrega_epp as e "
                . "inner join detalle_tabla_general as dtg on dtg.general = 7 and dtg.id = e.epp "
                . "where e.colaborador = '" . $this->colaborador . "' and e.estado like '" . $this->estado . "%' ";
        //echo $query;
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function resumen_cambios() {
        global $conn;
        $query = "select count(e.epp) as cantidad, dtg.descripcion as epp "
                . "from entrega_epp as e "
                . "inner join detalle_tabla_general as dtg on dtg.general = 7 and dtg.id = e.epp "
                . "where e.estado = 0 and date_add(e.entrega, interval dtg.atributo day) <= CURRENT_DATE() "
                . "group by e.epp "
                . "order by dtg.descripcion asc ";
        //echo $query;
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function cambios_detallados() {
        global $conn;
        $query = "select cl.id, cl.nombres, cl.ape_pat, cl.ape_mat, dtg.descripcion as epp, date_add(e.entrega, interval dtg.atributo day) as fecha_cambio "
                . "from entrega_epp as e "
                . "inner join colaborador as cl on cl.id = e.colaborador "
                . "inner join detalle_tabla_general as dtg on dtg.general = 7 and dtg.id = e.epp "
                . "where e.estado = 0 and date_add(e.entrega, interval dtg.atributo day) <= CURRENT_DATE() "
                . "order by date_add(e.entrega, interval dtg.atributo day) desc";
        //echo $query;
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function insertar() {
        $grabado = false;
        global $conn;
        $query = "insert into entrega_epp values ('" . $this->codigo . "', '" . $this->colaborador . "', '" . $this->epp . "', '" . $this->entrega . "', '2001-01-01', '0')";
        //echo $query;
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in entrega_epp: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function obtener_id() {
        $id = 1;
        global $conn;
        $c_codigo = "select ifnull(max(codigo) + 1, 1) as codigo "
                . "from entrega_epp "
                . "where colaborador = '" . $this->colaborador . "'";
        //echo $c_codigo;
        $resultado = $conn->query($c_codigo);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $id = $fila ['codigo'];
            }
        }
        return $id;
    }

    function eliminar() {
        $grabado = false;
        global $conn;
        $query = "delete from entrega_epp "
                . "where codigo = '" . $this->codigo . "' and epp = '" . $this->epp . "' and colaborador = '" . $this->colaborador . "'";
        //echo $query;
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not delete data from entrega_epp: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function devolver() {
        $grabado = false;
        global $conn;
        $query = "update entrega_epp set estado = '1', devolucion = '" . $this->devolucion . "' "
                . "where codigo = '" . $this->codigo . "' and epp = '" . $this->epp . "' and colaborador = '" . $this->colaborador . "'";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not delete data from entrega_epp: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function devolver_mismo_epp() {
        $grabado = false;
        global $conn;
        $query = "update entrega_epp set estado = '1', devolucion = '" . $this->devolucion . "' "
                . "where epp = '" . $this->epp . "' and colaborador = '" . $this->colaborador . "' and estado = '0' ";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not delete data from entrega_epp: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function datos_entrega() {
        global $conn;
        $query = "select e.codigo, dtg.descripcion as epp, e.entrega, e.devolucion, e.estado, date_add(e.entrega, interval dtg.atributo day) as retorno, e.epp as cepp "
                . "from entrega_epp as e "
                . "inner join detalle_tabla_general as dtg on dtg.general = 7 and dtg.id = e.epp "
                . "where e.codigo = '" . $this->codigo . "' and e.epp = '" . $this->epp . "' and e.colaborador = '" . $this->colaborador . "'";
        //echo $query;
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

}
