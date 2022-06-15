<?php

include 'cl_conectar.php';

class cl_orden_interna {

    private $codigo;
    private $cotizacion;
    private $finicio;
    private $ffin;
    private $observaciones;
    private $dias;
    private $estado;
    private $avance;
    private $id_almacen;
    private $paprobado;
    private $fecha_termino_aprox;

    function __construct() {
        
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getCotizacion() {
        return $this->cotizacion;
    }

    function getFinicio() {
        return $this->finicio;
    }

    function getFfin() {
        return $this->ffin;
    }

    function getObservaciones() {
        return $this->observaciones;
    }

    function getDias() {
        return $this->dias;
    }

    function getEstado() {
        return $this->estado;
    }

    function getAvance() {
        return $this->avance;
    }

    function getFecha_termino_aprox() {
        return $this->fecha_termino_aprox;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setCotizacion($cotizacion) {
        $this->cotizacion = $cotizacion;
    }

    function setFinicio($finicio) {
        $this->finicio = $finicio;
    }

    function setFfin($ffin) {
        $this->ffin = $ffin;
    }

    function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }

    function setDias($dias) {
        $this->dias = $dias;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setAvance($avance) {
        $this->avance = $avance;
    }

    function setFecha_termino_aprox($fecha_termino_aprox) {
        $this->fecha_termino_aprox = $fecha_termino_aprox;
    }
    
    function getId_almacen() {
        return $this->id_almacen;
    }

    function setId_almacen($id_almacen) {
        $this->id_almacen = $id_almacen;
    }
    
    function getPaprobado() {
        return $this->paprobado;
    }

    function setPaprobado($paprobado) {
        $this->paprobado = $paprobado;
    }

    function obtener_id() {
        $id = 1;
        global $conn;
        $c_codigo = "select ifnull(max(id_orden) + 1, concat(year(current_date()), '001') ) as codigo "
                . "from orden_interna "
                . "where id_orden like concat(year(CURRENT_DATE()),'%')";
        $resultado = $conn->query($c_codigo);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $id = $fila ['codigo'];
            }
        }
        return $id;
    }

    function datos_orden() {
        global $conn;
        $query = "select *, date_add(fecha_inicio, interval dias day) as aprox_termino, DATEDIFF(current_date(), fecha_inicio) as d_avance from orden_interna "
                . "where id_orden = '" . $this->codigo . "'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $this->cotizacion = $fila ['id_cotizacion'];
                $this->dias = $fila ['dias'];
                $this->finicio = $fila ['fecha_inicio'];
                $this->ffin = $fila ['fecha_termino'];
                $this->observaciones = $fila ['observaciones'];
                $this->estado = $fila ['estado'];
                $this->avance = $fila ['d_avance'];
                $this->fecha_termino_aprox = $fila ['aprox_termino'];
            }
        }
    }

    function i_orden() {
        $grabado = false;
        global $conn;
        $query = "insert into orden_interna "
                . "values ('" . $this->codigo . "', '" . $this->cotizacion . "', '" . $this->dias . "', '" . $this->finicio . "', '1000-01-01', '" . $this->observaciones . "', '".$this->id_almacen."', '".$this->paprobado."', '0')";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in orden_interna: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function e_orden() {
        $grabado = false;
        global $conn;
        $query = "delete from orden_interna where id_orden = '" . $this->codigo . "'";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not delete data from orden_interna: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function ver_ordenes() {
        global $conn;
        $query = "select oi.id_orden, ct.codigo, ct.descripcion, e.razon_social, sc.nombre as sucursal, ct.tipo_servicio, oi.fecha_inicio, oi.fecha_termino, oi.estado, oi.dias, "
                . "date_add(oi.fecha_inicio, interval oi.dias day) as aprox_termino, DATEDIFF(current_date(), oi.fecha_inicio) as d_avance "
                . "from orden_interna as oi  "
                . "inner join cotizaciones as ct on ct.codigo = oi.id_cotizacion "
                . "inner join detalle_tabla_general as dtgm on dtgm.general = 5 and dtgm.id = ct.moneda "
                . "inner join clientes as c on c.id = ct.cliente "
                . "inner join entidad as e on e.ruc = c.ruc "
                . "inner join sucursal_cliente as sc on sc.cliente = ct.cliente and sc.id = ct.sucursal ";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function ver_ordenes_activas() {
        global $conn;
        $query = "select oi.id_orden, ct.codigo, ct.descripcion, e.razon_social, sc.nombre as sucursal, ct.tipo_servicio, oi.fecha_inicio, oi.fecha_termino, oi.estado, oi.dias, "
                . "date_add(oi.fecha_inicio, interval oi.dias day) as aprox_termino, DATEDIFF(current_date(), oi.fecha_inicio) as d_avance "
                . "from orden_interna as oi  "
                . "inner join cotizaciones as ct on ct.codigo = oi.id_cotizacion "
                . "inner join detalle_tabla_general as dtgm on dtgm.general = 5 and dtgm.id = ct.moneda "
                . "inner join clientes as c on c.id = ct.cliente "
                . "inner join entidad as e on e.ruc = c.ruc "
                . "inner join sucursal_cliente as sc on sc.cliente = ct.cliente and sc.id = ct.sucursal "
                . "where oi.estado = 0 "
                . "order by aprox_termino desc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function u_orden() {
        $grabado = false;
        global $conn;
        $query = "update orden_interna "
                . "set fecha_termino = '" . $this->ffin . "', estado = '1', observaciones = '" . $this->observaciones . "' "
                . "where id_orden = '" . $this->codigo . "' ";
        // echo $query;
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in orden_cliente: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function datos_orden_mix() {
        global $conn;
        $query = "select oi.id_orden, ct.codigo, ct.descripcion, ct.monto, oi.fecha_inicio, ct.fecha, e.razon_social, sc.nombre as sucursal, ct.solicitante, ct.tipo_servicio, ct.archivo, ct.cliente as ccliente, ct.sucursal as csucursal, ct.dias_ejecucion, dtgm.atributo as moneda "
                . "from orden_interna as oi  "
                . "inner join cotizaciones as ct on ct.codigo = oi.id_cotizacion "
                . "inner join detalle_tabla_general as dtgm on dtgm.general = 5 and dtgm.id = ct.moneda "
                . "inner join clientes as c on c.id = ct.cliente "
                . "inner join entidad as e on e.ruc = c.ruc "
                . "inner join sucursal_cliente as sc on sc.cliente = ct.cliente and sc.id = ct.sucursal "
                . "where oi.id_orden = '".$this->codigo."'";
        // echo $query;
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

}
