<?php

require 'cl_conectar.php';

class cl_cotizacion {

    private $fecha;
    private $numero;
    private $version;
    private $codigo;
    private $descripcion;
    private $moneda;
    private $monto;
    private $incluye_igv;
    private $estado;
    private $cliente;
    private $sucursal;
    private $atencion;
    private $solicitante;
    private $notas;
    private $dias;
    private $forma_pago;
    private $tipo_servicio;
    private $archivo;

    function __construct() {
        
    }

    function getFecha() {
        return $this->fecha;
    }

    function getNumero() {
        return $this->numero;
    }

    function getVersion() {
        return $this->version;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getMoneda() {
        return $this->moneda;
    }

    function getMonto() {
        return $this->monto;
    }

    function getIncluye_igv() {
        return $this->incluye_igv;
    }

    function getEstado() {
        return $this->estado;
    }

    function getCliente() {
        return $this->cliente;
    }

    function getSucursal() {
        return $this->sucursal;
    }

    function getAtencion() {
        return $this->atencion;
    }

    function getSolicitante() {
        return $this->solicitante;
    }

    function getNotas() {
        return $this->notas;
    }

    function getDias() {
        return $this->dias;
    }

    function getForma_pago() {
        return $this->forma_pago;
    }

    function getTipo_servicio() {
        return $this->tipo_servicio;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function setNumero($numero) {
        $this->numero = $numero;
    }

    function setVersion($version) {
        $this->version = $version;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setMoneda($moneda) {
        $this->moneda = $moneda;
    }

    function setMonto($monto) {
        $this->monto = $monto;
    }

    function setIncluye_igv($incluye_igv) {
        $this->incluye_igv = $incluye_igv;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setCliente($cliente) {
        $this->cliente = $cliente;
    }

    function setSucursal($sucursal) {
        $this->sucursal = $sucursal;
    }

    function setAtencion($atencion) {
        $this->atencion = $atencion;
    }

    function setSolicitante($solicitante) {
        $this->solicitante = $solicitante;
    }

    function setNotas($notas) {
        $this->notas = $notas;
    }

    function setDias($dias) {
        $this->dias = $dias;
    }

    function setForma_pago($forma_pago) {
        $this->forma_pago = $forma_pago;
    }

    function setTipo_servicio($tipo_servicio) {
        $this->tipo_servicio = $tipo_servicio;
    }

    function getArchivo() {
        return $this->archivo;
    }

    function setArchivo($archivo) {
        $this->archivo = $archivo;
    }

    function insertar() {
        $grabado = false;
        global $conn;
        $query = "insert into cotizaciones values ('" . $this->codigo . "', '" . $this->numero . "', '" . $this->version . "', '" . $this->fecha . "', '" . $this->cliente . "', " 
                . "'" . $this->sucursal . "', '" . $this->atencion . "', '" . $this->solicitante . "', '" . $this->descripcion . "', '" . $this->notas . "', '" . $this->moneda . "', "
                . "'" . $this->incluye_igv . "', '" . $this->dias . "', '" . $this->forma_pago . "', '" . $this->tipo_servicio . "', '" . $this->monto . "', '" . $this->archivo . "', "
                . "'0')";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in cotizaciones: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }
    
    function aprobar() {
        $grabado = false;
        global $conn;
        $query = "update cotizaciones set estado = '1', notas = '". $this->notas ."' where codigo = '". $this->codigo."'";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not update data in cotizaciones: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }
    
    function pre_aprobar() {
        $grabado = false;
        global $conn;
        $query = "update cotizaciones set estado = '2' where codigo = '". $this->codigo."'";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not update data in cotizaciones: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }
    
    function eliminar() {
        $grabado = false;
        global $conn;
        $query = "delete from cotizaciones where codigo = '". $this->codigo."'";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not delete data in cotizaciones: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function obtener_id() {
        $id = 1;
        global $conn;
        $query = "select ifnull(max(numero) + 1, 1) as codigo from cotizaciones where fecha = '" . $this->fecha . "'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $id = $fila ['codigo'];
            }
        }
        return $id;
    }

    function ver_cotizaciones() {
        global $conn;
        $query = "select ct.codigo, ct.descripcion, ct.monto, e.razon_social, sc.nombre as sucursal, ct.tipo_servicio, ct.notas, ct.archivo, ct.cliente as ccliente, ct.sucursal as csucursal, ct.estado, dtgm.atributo as moneda "
                . "from cotizaciones as ct "
                . "inner join detalle_tabla_general as dtgm on dtgm.general = 5 and dtgm.id = ct.moneda "
                . "inner join clientes as c on c.id = ct.cliente "
                . "inner join entidad as e on e.ruc = c.ruc "
                . "inner join sucursal_cliente as sc on sc.cliente = ct.cliente and sc.id = ct.sucursal ";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }
    
    function resumen_cotizaciones() {
        global $conn;
        $query = "select count(ct.codigo) as total_cotizaciones, e.razon_social, sc.nombre as sucursal, "
                . "(select count(*) from cotizaciones as co where co.cliente = ct.cliente and co.sucursal = ct.sucursal and co.estado in (1,2)) as aprobados, "
                . "(select count(*) from cotizaciones as co where co.cliente = ct.cliente and co.sucursal = ct.sucursal and co.estado = 1) as ordenes, "
                . "(select count(*) from cotizaciones as co where co.cliente = ct.cliente and co.sucursal = ct.sucursal and co.estado = 2) as preaprobado "
                . "from cotizaciones as ct "
                . "inner join detalle_tabla_general as dtgm on dtgm.general = 5 and dtgm.id = ct.moneda "
                . "inner join clientes as c on c.id = ct.cliente "
                . "inner join entidad as e on e.ruc = c.ruc "
                . "inner join sucursal_cliente as sc on sc.cliente = ct.cliente and sc.id = ct.sucursal "
                . "group by ct.cliente, ct.sucursal";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function datos_cotizacion_mix() {
        global $conn;
        $query = "select ct.codigo, ct.descripcion, ct.monto, ct.fecha, e.razon_social, sc.nombre as sucursal, ct.tipo_servicio, ct.archivo, ct.cliente as ccliente, ct.sucursal as csucursal, ct.dias_ejecucion, dtgm.atributo as moneda "
                . "from cotizaciones as ct "
                . "inner join detalle_tabla_general as dtgm on dtgm.general = 5 and dtgm.id = ct.moneda "
                . "inner join clientes as c on c.id = ct.cliente "
                . "inner join entidad as e on e.ruc = c.ruc "
                . "inner join sucursal_cliente as sc on sc.cliente = ct.cliente and sc.id = ct.sucursal "
                . "where codigo = '".$this->codigo."'";
        // echo $query;
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function datos_cotizacion() {
        global $conn;
        $query = "select * from cotizaciones where codigo = '".$this->codigo."'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $this->descripcion = $fila ['descripcion'];
            }
        }
    }

}
