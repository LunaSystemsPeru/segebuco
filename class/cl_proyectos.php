<?php

include 'cl_conectar.php';

class cl_proyectos {

    private $codigo;
    private $anio;
    private $cliente;
    private $sucursal;
    private $fecha;
    private $ingresos;
    private $egresos;
    private $estado;
    private $usuario;

    function __construct() {
        
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getAnio() {
        return $this->anio;
    }

    function getCliente() {
        return $this->cliente;
    }

    function getSucursal() {
        return $this->sucursal;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getIngresos() {
        return $this->ingresos;
    }

    function getEgresos() {
        return $this->egresos;
    }

    function getEstado() {
        return $this->estado;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setAnio($anio) {
        $this->anio = $anio;
    }

    function setCliente($cliente) {
        $this->cliente = $cliente;
    }

    function setSucursal($sucursal) {
        $this->sucursal = $sucursal;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function setIngresos($ingresos) {
        $this->ingresos = $ingresos;
    }

    function setEgresos($egresos) {
        $this->egresos = $egresos;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function obtener_id() {
        $id = 2017001;
        global $conn;
        $c_codigo = "select ifnull(max(codigo) + 1, 1) as codigo from proyectos";
        $r_codigo = $conn->query($c_codigo);
        if ($r_codigo->num_rows > 0) {
            while ($fila = $r_codigo->fetch_assoc()) {
                $id = $fila ['codigo'];
            }
        }
        return $id;
    }

    function ver_proyectos() {
        global $conn;
        $query = "select p.codigo, e.nombre_comercial, sc.nombre, concat (e.nombre_comercial, ' - ', sc.nombre) as almacen, p.fecha_inicio, p.ingresos, p.egresos "
                . "from proyectos as p "
                . "inner join clientes as c on c.id = p.cliente "
                . "inner join entidad as e on e.ruc = c.ruc "
                . "inner join sucursal_cliente as sc on sc.cliente = p.cliente and sc.id = p.sucursal "
                . "order by e.nombre_comercial asc, sc.nombre asc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function datos_proyectos() {
        global $conn;
        $query = "select p.codigo, e.nombre_comercial, sc.nombre as sucursal, sc.direccion, p.cliente, p.sucursal, p.fecha_inicio, p.ingresos, p.egresos "
                . "from proyectos as p "
                . "inner join clientes as c on c.id = p.cliente "
                . "inner join entidad as e on e.ruc = c.ruc "
                . "inner join sucursal_cliente as sc on sc.cliente = p.cliente and sc.id = p.sucursal "
                . "where p.codigo = '" . $this->codigo . "'";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function i_proyecto() {
        $grabado = false;
        global $conn;
        $query = "insert into proyectos values ('" . $this->codigo . "', '" . $this->anio . "', '" . $this->cliente . "', '" . $this->sucursal . "', '" . $this->fecha . "', 0.0, 0.0, '1')";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in clientes: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function obtener_proyecto_cliente($orden) {
        global $conn;
        $c_codigo = "SELECT oc . proyecto "
                . "FROM orden_cliente AS oc "
                . "INNER JOIN proyectos AS p ON p.codigo = oc.proyecto "
                . "WHERE oc.codigo =  '" . $orden . "' AND p.cliente = '" . $this->cliente . "' AND sucursal = '" . $this->sucursal . "'";
        echo $c_codigo;
        $r_codigo = $conn->query($c_codigo);
        if ($r_codigo->num_rows > 0) {
            while ($fila = $r_codigo->fetch_assoc()) {
                $id = $fila ['proyecto'];
            }
        }
        return $id;
    }

}
