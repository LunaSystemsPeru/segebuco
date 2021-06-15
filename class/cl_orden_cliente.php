<?php

include 'cl_conectar.php';

class cl_orden_cliente {

    private $codigo;
    private $cliente;
    private $sucursal;
    private $glosa;
    private $fecha;
    private $moneda;
    private $estado;
    private $facturado;
    private $monto;
    private $archivo;
    private $anio;

    function __construct() {
        
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getCliente() {
        return $this->cliente;
    }

    function getSucursal() {
        return $this->sucursal;
    }

    function getGlosa() {
        return $this->glosa;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getMoneda() {
        return $this->moneda;
    }

    function getEstado() {
        return $this->estado;
    }

    function getFacturado() {
        return $this->facturado;
    }

    function getMonto() {
        return $this->monto;
    }

    function getArchivo() {
        return $this->archivo;
    }

    function getAnio() {
        return $this->anio;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setCliente($cliente) {
        $this->cliente = $cliente;
    }

    function setSucursal($sucursal) {
        $this->sucursal = $sucursal;
    }

    function setGlosa($glosa) {
        $this->glosa = $glosa;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function setMoneda($moneda) {
        $this->moneda = $moneda;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setFacturado($facturado) {
        $this->facturado = $facturado;
    }

    function setMonto($monto) {
        $this->monto = $monto;
    }

    function setArchivo($archivo) {
        $this->archivo = $archivo;
    }

    function setAnio($anio) {
        $this->anio = $anio;
    }

    function ver_anios_ordenes() {
        global $conn;
        $query = "SELECT distinct(year(fecha)) as anio "
                . "FROM orden_cliente "
                . "where year(fecha) < '" . $this->anio . "' "
                . "order by year(fecha) desc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function ver_total_ordenes() {
        global $conn;
        $query = "select o.codigo, o.fecha, o.glosa, dtgm.atributo as moneda, o.total, o.facturado, o.estado, o.archivo, o.cliente as ocliente, o.sucursal as osucursal, concat (e.razon_social, ' | ', sc.nombre) as cliente "
                . "from orden_cliente as o "
                . "inner join detalle_tabla_general as dtgm on dtgm.general = 5 and dtgm.id = o.moneda "
                . "inner join clientes as c on c.id = o.cliente "
                . "inner join entidad as e on e.ruc = c.ruc "
                . "inner join sucursal_cliente as sc on sc.cliente = o.cliente and sc.id = o.sucursal "
                . "where year(o.fecha) = '" . $this->anio . "' and o.estado like '". $this->estado . "%' ";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }
    
    function ver_ordenes_pendientes() {
        global $conn;
        $query = "select o.codigo, o.fecha, o.glosa, dtgm.atributo as moneda, o.total, o.facturado, o.estado, o.archivo, o.cliente as ocliente, o.sucursal as osucursal, concat (e.razon_social, ' | ', sc.nombre) as cliente "
                . "from orden_cliente as o "
                . "inner join detalle_tabla_general as dtgm on dtgm.general = 5 and dtgm.id = o.moneda "
                . "inner join clientes as c on c.id = o.cliente "
                . "inner join entidad as e on e.ruc = c.ruc "
                . "inner join sucursal_cliente as sc on sc.cliente = o.cliente and sc.id = o.sucursal "
                . "where o.facturado < '100' and o.estado = 0 "
                . "order by o.fecha desc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }
    
    function ver_resumen_ordenes() {
        global $conn;
        $query = "select count(o.codigo)  as cantidad, dtgm.atributo as moneda, sum(o.total) as stotal, avg(o.facturado) as sfacturado, sum(o.total * (1 - (o.facturado/100))) as pendiente, "
                . "o.cliente as ocliente, o.sucursal as osucursal, concat (e.razon_social, ' | ', sc.nombre) as cliente, datediff(curdate(), min(o.fecha)) as dias "
                . "from orden_cliente as o "
                . "inner join detalle_tabla_general as dtgm on dtgm.general = 5 and dtgm.id = o.moneda "
                . "inner join clientes as c on c.id = o.cliente "
                . "inner join entidad as e on e.ruc = c.ruc "
                . "inner join sucursal_cliente as sc on sc.cliente = o.cliente and sc.id = o.sucursal "
                . "where o.facturado < '100' and o.estado = 0 "
                . "group by o.cliente, o.sucursal, o.moneda "
                . "order by o.cliente desc, o.sucursal desc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function datos_orden() {
        global $conn;
        $query = "select o.codigo, o.fecha, o.moneda as id_moneda, dtgm.atributo as moneda, o.total, o.facturado, o.estado, o.glosa, o.archivo "
                . "from orden_cliente as o "
                . "inner join detalle_tabla_general as dtgm on dtgm.general = 5 and dtgm.id = o.moneda "
                . "where o.codigo = '" . $this->codigo . "'";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }
    
    function validar_orden() {
        $b_validar = false;
        global $conn;
        $query = "select codigo, glosa, fecha, total, facturado, estado, archivo "
                . "from orden_cliente "
                . "where codigo = '" . $this->codigo . "' and cliente = '" . $this->cliente . "'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $b_validar = true;
                $this->codigo = $fila ['codigo'];
                $this->glosa = $fila ['glosa'];
            }
        } else {
            $b_validar = false;
        }
        return $b_validar;
    }

    function i_orden() {
        $grabado = false;
        global $conn;
        $query = "insert into orden_cliente values ('" . $this->cliente . "', '" . $this->sucursal . "', '" . $this->codigo . "', '" . $this->glosa . "', '" . $this->fecha . "', '" . $this->moneda . "', '" . $this->monto . "', '0', '0', '" . $this->archivo . "')";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in orden_cliente: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function u_porcentaje_orden() {
        $grabado = false;
        global $conn;
        $query = "update orden_cliente "
                . "set facturado = facturado + '" . $this->facturado . "', estado = '" . $this->estado . "' "
                . "where cliente = '" . $this->cliente . "' and sucursal = '" . $this->sucursal . "' and codigo = '" . $this->codigo . "'";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in orden_cliente: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }
    
    function eliminar_orden($idorden) {
        $grabado = false;
        global $conn;
        $query = "delete from orden_cliente where concat(cliente, sucursal, codigo) = '".$idorden."'";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter delete in orden_cliente: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

}
