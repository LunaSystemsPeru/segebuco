<?php

include 'cl_conectar.php';

class cl_cliente {

    private $codigo;
    private $ruc;
    private $ultima_facturacion;
    private $total_facturado;
    private $pendiente_cobro;

    function __construct() {
        
    }

    function getRuc() {
        return $this->ruc;
    }

    function getUltima_facturacion() {
        return $this->ultima_facturacion;
    }

    function getTotal_facturado() {
        return $this->total_facturado;
    }

    function getPendiente_cobro() {
        return $this->pendiente_cobro;
    }

    function setRuc($ruc) {
        $this->ruc = $ruc;
    }

    function setUltima_facturacion($ultima_facturacion) {
        $this->ultima_facturacion = $ultima_facturacion;
    }

    function setTotal_facturado($total_facturado) {
        $this->total_facturado = $total_facturado;
    }

    function setPendiente_cobro($pendiente_cobro) {
        $this->pendiente_cobro = $pendiente_cobro;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function i_cliente() {
        $grabado = false;
        global $conn;
        $query = "insert into clientes values ('" . $this->codigo . "', '" . $this->ruc . "', 0.0, 0.0, '2000-01-01')";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in clientes: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function obtener_id() {
        $id = 1;
        global $conn;
        $c_codigo = "select ifnull(max(id) + 1, 1) as codigo from clientes";
        $r_codigo = $conn->query($c_codigo);
        if ($r_codigo->num_rows > 0) {
            while ($fila = $r_codigo->fetch_assoc()) {
                $id = $fila ['codigo'];
            }
        }
        return $id;
    }

    function obtener_datos() {
        global $conn;
        $c_codigo = "select * 
        from clientes 
        where id = '".$this->codigo."'";
        $resultado = $conn->query($c_codigo);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $this->ruc = $fila ['ruc'];
            }
        }
    }

    function ver_clientes() {
        global $conn;
        $c_codigo = "select c.id, c.ruc, e.razon_social, e.nombre_comercial, c.total_facturado, c.total_cobranza "
                . "from clientes as c "
                . "inner join entidad as e on e.ruc = c.ruc "
                . "order by e.razon_social asc";
        $r_codigo = $conn->query($c_codigo);
        $fila = $r_codigo->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }
    
    function datos_cliente() {
        global $conn;
        $c_codigo = "select c.id, c.ruc, e.nombre_comercial, e.razon_social, e.direccion, e.condicion, e.estado "
                . "from clientes as c "
                . "inner join entidad as e on e.ruc = c.ruc "
                . "where c.id = '".$this->codigo."'";
        $r_codigo = $conn->query($c_codigo);
        $fila = $r_codigo->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }
    
    
    function ver_clientes_ventas() {
        global $conn;
        $c_codigo = "select c.id, c.ruc, e.razon_social, e.nombre_comercial, c.total_facturado, c.total_cobranza "
                . "from clientes as c "
                . "inner join entidad as e on e.ruc = c.ruc "
                . "where c.total_facturado > 0 "
                . "order by e.razon_social asc ";
        $r_codigo = $conn->query($c_codigo);
        $fila = $r_codigo->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

}
