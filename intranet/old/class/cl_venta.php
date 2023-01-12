<?php

include 'cl_conectar.php';

class cl_venta {

    private $codigo;
    private $periodo;
    private $cliente;
    private $sucursal;
    private $fecha_factura;
    private $fecha_cobro;
    private $orden;
    private $aceptacion;
    private $moneda;
    private $tc;
    private $total;
    private $estado;
    private $glosa;
    private $tido;
    private $serie;
    private $numero;
    private $porcentaje;

    function __construct() {
        
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getPeriodo() {
        return $this->periodo;
    }

    function getCliente() {
        return $this->cliente;
    }

    function getSucursal() {
        return $this->sucursal;
    }

    function getFecha_factura() {
        return $this->fecha_factura;
    }

    function getFecha_cobro() {
        return $this->fecha_cobro;
    }

    function getOrden() {
        return $this->orden;
    }

    function getMoneda() {
        return $this->moneda;
    }

    function getTc() {
        return $this->tc;
    }

    function getTotal() {
        return $this->total;
    }

    function getEstado() {
        return $this->estado;
    }

    function getGlosa() {
        return $this->glosa;
    }

    function getTido() {
        return $this->tido;
    }

    function getSerie() {
        return $this->serie;
    }

    function getNumero() {
        return $this->numero;
    }

    function getPorcentaje() {
        return $this->porcentaje;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setPeriodo($periodo) {
        $this->periodo = $periodo;
    }

    function setCliente($cliente) {
        $this->cliente = $cliente;
    }

    function setSucursal($sucursal) {
        $this->sucursal = $sucursal;
    }

    function setFecha_factura($fecha_factura) {
        $this->fecha_factura = $fecha_factura;
    }

    function setFecha_cobro($fecha_cobro) {
        $this->fecha_cobro = $fecha_cobro;
    }

    function setOrden($orden) {
        $this->orden = $orden;
    }

    function setMoneda($moneda) {
        $this->moneda = $moneda;
    }

    function setTc($tc) {
        $this->tc = $tc;
    }

    function setTotal($total) {
        $this->total = $total;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setGlosa($glosa) {
        $this->glosa = $glosa;
    }

    function setTido($tido) {
        $this->tido = $tido;
    }

    function setSerie($serie) {
        $this->serie = $serie;
    }

    function setNumero($numero) {
        $this->numero = $numero;
    }

    function setPorcentaje($porcentaje) {
        $this->porcentaje = $porcentaje;
    }

    function getAceptacion() {
        return $this->aceptacion;
    }

    function setAceptacion($aceptacion) {
        $this->aceptacion = $aceptacion;
    }

    function i_venta() {
        $grabado = false;
        global $conn;
        $query = "insert into ventas values ('" . $this->codigo . "', '" . $this->periodo . "',  '" . $this->cliente . "', '" . $this->sucursal . "',  '" . $this->fecha_factura . "', "
                . "'" . $this->fecha_cobro . "', '" . $this->orden . "', '" . $this->aceptacion . "', '" . $this->moneda . "', '" . $this->tc . "', '" . $this->total . "', '0', '" . $this->estado . "', '" . $this->glosa . "', "
                . "'" . $this->porcentaje . "', '" . $this->tido . "', '" . $this->serie . "', '" . $this->numero . "')";
        $resultado = $conn->query($query);
        //echo $query;
        if (!$resultado) {
            die('Could not enter data in ventas: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function obtener_id() {
        $id = 1;
        global $conn;
        $c_codigo = "select ifnull(max(codigo) + 1, 1) as codigo from ventas where periodo = '" . $this->periodo . "'";
        //echo $c_codigo;
        $resultado = $conn->query($c_codigo);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $id = $fila ['codigo'];
            }
        }
        return $id;
    }

    function ver_ventas() {
        global $conn;
        $query = "select v.codigo, v.periodo, v.fecha_factura,  v.serie, v.numero, v.total, v.pagado, v.estado, v.tipo_documento, td.abreviado as tido, td.sunat, dtgm.atributo as moneda,v.moneda as id_moneda, v.tipo_cambio, e.ruc as ruc_cliente, e.razon_social as cliente, sc.nombre as sucursal, v.orden_cliente "
                . "from ventas as v "
                . "inner join tipo_documento as td on td.id = v.tipo_documento "
                . "inner join detalle_tabla_general as dtgm on dtgm.general = 5 and dtgm.id = v.moneda "
                . "inner join clientes as c on c.id = v.cliente "
                . "inner join entidad as e on e.ruc = c.ruc "
                . "inner join sucursal_cliente as sc on sc.cliente = v.cliente and sc.id = v.sucursal "
                . "where v.periodo = '" . $this->periodo . "' "
                . "order by v.numero asc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }
    
    function ver_ventas_ordencliente() {
        global $conn;
        $query = "select v.codigo, v.periodo, v.fecha_factura,  v.serie, v.numero, v.total, v.pagado, v.estado, td.abreviado as tido, dtgm.atributo as moneda, v.tipo_cambio, e.razon_social as cliente, sc.nombre as sucursal, v.orden_cliente "
                . "from ventas as v "
                . "inner join tipo_documento as td on td.id = v.tipo_documento "
                . "inner join detalle_tabla_general as dtgm on dtgm.general = 5 and dtgm.id = v.moneda "
                . "inner join clientes as c on c.id = v.cliente "
                . "inner join entidad as e on e.ruc = c.ruc "
                . "inner join sucursal_cliente as sc on sc.cliente = v.cliente and sc.id = v.sucursal "
                . "where v.cliente = '" . $this->cliente . "' and v.sucursal = '".$this->sucursal."' and v.orden_cliente = '".$this->orden."' "
                . "order by v.numero asc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }
    
    function resumen_cobranza() {
        global $conn;
        $query = "SELECT
                  COUNT(*) AS nro_docs,
                  SUM(v.total) AS suma_total,
                  DATEDIFF(
                    CURDATE(),
                    MIN(v.fecha_factura)) AS dias,
                    v.moneda AS id_moneda,
                    dtgm.atributo AS moneda,
                    e.razon_social AS cliente,
                    sc.nombre AS sucursal
                  FROM
                    ventas AS v
                  INNER JOIN
                    tipo_documento AS td ON td.id = v.tipo_documento
                  INNER JOIN
                    detalle_tabla_general AS dtgm ON dtgm.general = 5 AND dtgm.id = v.moneda
                  INNER JOIN
                    clientes AS c ON c.id = v.cliente
                  INNER JOIN
                    entidad AS e ON e.ruc = c.ruc
                  INNER JOIN
                    sucursal_cliente AS sc ON sc.cliente = v.cliente AND sc.id = v.sucursal
                  WHERE
                    v.estado = '0'
                  GROUP BY
                    v.cliente,
                    v.sucursal,
                    v.moneda
                  ORDER BY
                    v.cliente ASC";
        echo $query;
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }
    
    function ver_cobranzas() {
        global $conn;
        $query = "select v.codigo, v.periodo, v.fecha_factura, v.serie, v.numero, v.total, v.pagado, v.estado, td.abreviado as tido, dtgm.atributo as moneda, v.tipo_cambio, v.moneda as id_moneda, e.razon_social as cliente, sc.nombre as sucursal, v.orden_cliente "
                . "from ventas as v "
                . "inner join tipo_documento as td on td.id = v.tipo_documento "
                . "inner join detalle_tabla_general as dtgm on dtgm.general = 5 and dtgm.id = v.moneda "
                . "inner join clientes as c on c.id = v.cliente "
                . "inner join entidad as e on e.ruc = c.ruc "
                . "inner join sucursal_cliente as sc on sc.cliente = v.cliente and sc.id = v.sucursal "
                . "where v.estado = '0' "
                . "order by v.numero asc";
        //echo $query;
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function datos_venta() {
        global $conn;
        $query = "select v.codigo, v.periodo, v.fecha_factura,  v.serie, v.numero, v.total, v.estado, v.cliente, v.glosa, v.porcentaje_orden, td.abreviado as tido, v.moneda, v.tipo_cambio, v.orden_cliente "
                . "from ventas as v "
                . "inner join tipo_documento as td on td.id = v.tipo_documento "
                . "inner join detalle_tabla_general as dtgm on dtgm.general = 5 and dtgm.id = v.moneda "
                . "inner join clientes as c on c.id = v.cliente "
                . "inner join entidad as e on e.ruc = c.ruc "
                . "where v.periodo = '" . $this->periodo . "' and v.codigo = '" . $this->codigo . "'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $this->cliente = $fila['cliente'];
                $this->orden = $fila['orden_cliente'];
                $this->serie = $fila['serie'];
                $this->numero = $fila['numero'];
                $this->total = $fila['total'];
                $this->tido = $fila['tido'];
                $this->glosa = $fila['glosa'];
                $this->moneda = $fila['moneda'];
                $this->porcentaje = $fila['porcentaje_orden'];
                $this->fecha_factura = $fila['fecha_factura'];
            }
        }
    }

    function ver_ventas_periodo() {
        global $conn;
        $query = "SELECT periodo, SUM( tipo_cambio * total ) AS total FROM  `ventas` WHERE year(fecha_factura) = year(now())  GROUP BY periodo ";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function ver_ventas_sucursal() {
        global $conn;
        $query = "select v.codigo, v.periodo, v.fecha_factura,  v.serie, v.numero, v.total, v.estado, td.abreviado as tido, dtgm.atributo as moneda, v.tipo_cambio, e.razon_social as cliente, v.orden_cliente "
                . "from ventas as v "
                . "inner join tipo_documento as td on td.id = v.tipo_documento "
                . "inner join detalle_tabla_general as dtgm on dtgm.general = 5 and dtgm.id = v.moneda "
                . "inner join clientes as c on c.id = v.cliente "
                . "inner join entidad as e on e.ruc = c.ruc "
                . "where v.cliente = '" . $this->cliente . "' and v.sucursal = '" . $this->sucursal . "' "
                . "order by v.numero asc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function ver_periodos() {
        global $conn;
        $query = "select distinct periodo from ventas where periodo < '" . $this->periodo . "' order by periodo desc";
        //echo $query;
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function ver_suma_proyectos() {
        global $conn;
        $query = "select v.codigo, v.periodo, v.fecha_factura,  v.serie, v.numero, v.total, v.estado, td.abreviado as tido, dtgm.atributo as moneda, v.tipo_cambio, e.razon_social as cliente, v.orden_cliente "
                . "from ventas as v "
                . "inner join tipo_documento as td on td.id = v.tipo_documento "
                . "inner join detalle_tabla_general as dtgm on dtgm.general = 5 and dtgm.id = v.moneda "
                . "inner join clientes as c on c.id = v.cliente "
                . "inner join entidad as e on e.ruc = c.ruc "
                . "where v.periodo = '" . $this->periodo . "' "
                . "order by v.numero asc";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function ver_monto_periodo() {
        global $conn;
        $query = "SELECT SUM( tipo_cambio * total ) AS total "
                . "FROM  ventas "
                . "where periodo = '" . $this->periodo . "' "
                . "GROUP BY periodo";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }
    
    function ver_monto_anual() {
        global $conn;
        $query = "SELECT SUM( tipo_cambio * total ) AS total "
                . "FROM  ventas "
                . "where year(fecha_factura) = year(now()) ";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

    function eliminar_venta($idventa) {
        $grabado = false;
        global $conn;
        $query = "delete from ventas where concat(periodo, codigo) = '".$idventa."'";
        $resultado = $conn->query($query);
        //echo $query;
        if (!$resultado) {
            die('Could not delete data in ventas: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

}
