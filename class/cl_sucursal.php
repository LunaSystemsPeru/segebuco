<?php

include 'cl_conectar.php';

class cl_sucursal {

    private $cliente;
    private $codigo;
    private $nombre;
    private $direccion;
    private $contacto;
    private $email;

    function __construct() {
        
    }

    function getCliente() {
        return $this->cliente;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function getContacto() {
        return $this->contacto;
    }

    function getEmail() {
        return $this->email;
    }

    function setCliente($cliente) {
        $this->cliente = $cliente;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    function setContacto($contacto) {
        $this->contacto = $contacto;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function i_sucursal() {
        $grabado = false;
        global $conn;
        $query = "insert into sucursal_cliente values ('" . $this->codigo . "', '" . $this->cliente . "',  '" . $this->nombre . "', '" . $this->direccion . "',  '" . $this->contacto . "', '" . $this->email . "')";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in sucursal_clientes: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function obtener_id() {
        $id = 1;
        global $conn;
        $c_codigo = "select ifnull(max(id) + 1, 1) as codigo from sucursal_cliente where cliente = '" . $this->cliente . "'";
        $resultado = $conn->query($c_codigo);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $id = $fila ['codigo'];
            }
        }
        return $id;
    }

    function cargar_datos() {
        $existe = false;
        global $conn;
        $query = "select * "
                . "from sucursal_cliente "
                . "where cliente = '" . $this->cliente . "' and id = '" . $this->codigo . "'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            $existe = true;
            while ($fila = $resultado->fetch_assoc()) {
                $this->nombre = $fila ['nombre'];
                $this->direccion = $fila ['direccion'];
                $this->contacto = $fila ['contacto'];
                $this->email = $fila ['email'];
            }
        }
        return $existe;
    }

    function ver_sucursales() {
        global $conn;
        $query = "select id, nombre, direccion "
                . "from sucursal_cliente "
                . "where cliente = '" . $this->cliente . "' "
                . "order by nombre asc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function ver_ordenes_cliente() {
        global $conn;
        $query = "select o.codigo, o.fecha, dtgm.atributo as moneda, o.total, o.facturado, o.estado, o.archivo "
                . "from orden_cliente as o "
                . "inner join detalle_tabla_general as dtgm on dtgm.general = 5 and dtgm.id = o.moneda "
                . "where o.cliente = '" . $this->cliente . "' and o.sucursal = '" . $this->codigo . "' and o.estado = '0' "
                . "order by o.codigo asc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function eliminar() {
        $grabado = false;
        global $conn;
        $query = "delete "
                . "from sucursal_cliente "
                . "where cliente = '" . $this->cliente . "' and id = '" . $this->codigo . "'";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not delete data in sucursal_clientes: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function ver_cobros_sucursal() {
        global $conn;
        $query = "select cb.nombre, sum(cv.monto) as total_ingreso, sum(cv.monto * cv.tc) as total_cobros
        from cobro_ventas as cv inner join caja_bancos as cb on cb.codigo = cv.banco 
        inner join ventas as v on v.codigo = cv.codigo and v.periodo = cv.periodo 
        where v.cliente = '" . $this->cliente . "' and v.sucursal = '" . $this->codigo . "' 
        group by cb.codigo";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

}
