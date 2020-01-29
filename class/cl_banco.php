<?php

require 'cl_conectar.php';

class cl_banco {

    private $codigo;
    private $nombre;
    private $cuenta;
    private $monto;
    private $moneda;
    private $estado;

    function __construct() {
        
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getCuenta() {
        return $this->cuenta;
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

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setCuenta($cuenta) {
        $this->cuenta = $cuenta;
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

    function ver_bancos() {
        global $conn;
        $query = "select cb.codigo, cb.nombre, dtgm.descripcion as nmoneda, dtgm.atributo as moneda, cb.monto_disponible, cb.nro_cuenta, cb.estado "
                . "from caja_bancos as cb "
                . "inner join detalle_tabla_general as dtgm on dtgm.general = 5 and dtgm.id = cb.moneda "
                . "order by cb.nombre asc";
        $r_codigo = $conn->query($query);
        $fila = $r_codigo->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function obtener_id() {
        global $conn;
        $query = "select ifnull(max(codigo) + 1, 1) as codigo from caja_bancos";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $this->codigo = $fila ['codigo'];
            }
        }
    }

    function insertar() {
        $grabado = false;
        global $conn;
        $query = "insert into caja_bancos values ('" . $this->codigo . "', '" . $this->nombre . "', '" . $this->monto . "', '" . $this->cuenta . "','" . $this->moneda . "','" . $this->estado . "')";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in caja_bancos: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }
    
    function obtener_datos() {
        $existe = false;
        global $conn;
        $query = "select * "
                . "from caja_bancos "
                . "where codigo = '".$this->codigo."'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            $existe = true;
            while ($fila = $resultado->fetch_assoc()) {
                $this->nombre = $fila ['nombre'];
                $this->monto = $fila ['monto_disponible'];
                $this->cuenta = $fila ['nro_cuenta'];
                $this->moneda = $fila ['moneda'];
                $this->estado = $fila ['estado'];
            }
        }
        return $existe;
    }

}
